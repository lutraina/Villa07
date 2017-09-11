<?php
/**
 * Created by PhpStorm.
 * User: lucianahembert
 * Date: 25/07/2017
 * Time: 01:47
 */

namespace AppBundle\Controller;



use AppBundle\Service\MarkdownTransformer;
use AppBundle\Entity\Genus;
use AppBundle\Entity\GenusNote;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;



class GenusController extends Controller
{
    /**
     * @Route("/genus/new")
     */
    public function newAction()
    {
        $genus = new Genus();
        $genus->setName('Octopus'.rand(1, 100));
        $genus->setSubFamily('Octopodinae');
        $genus->setSpeciesCount(rand(100, 99999));


        $note = new GenusNote();
        $note->setUsername('AquaWeaver');
        $note->setUserAvatarFilename('ryan.jpeg');
        $note->setNote('I counted 8 legs... as they wrapped around me');
        $note->setCreatedAt(new \DateTime('-1 month'));
        $note->setGenus($genus);


        $em = $this->getDoctrine()->getManager();
        $em->persist($genus);
        $em->persist($note);
        $em->flush();

        return new Response('<html><body>Genus created!</body></html>');
    }


	/**
     * @Route("/genus")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();

        dump($em->getRepository('AppBundle:Genus'));

        $genuses = $em->getRepository('AppBundle:Genus')
            ->findAllPublishedOrderedByRecentlyActive();
        return $this->render('genus/list.html.twig', [
            'genuses' => $genuses
        ]);
    }
    
    /**
     * @Route("/genus/{genusName}", name="genus_show")
     */
    public function _showAction($genusName){


        //$funFact = 'testando *three-tenths* of a second : Markdown!';

		$em = $this->getDoctrine()->getManager();
        $genus = $em->getRepository('AppBundle:Genus')
            ->findOneBy(['name' => $genusName]);
            
        if (!$genus) {
            throw $this->createNotFoundException('mssg d\'erreur : genus doesn\t exist !');
        }

        $transformer = $this->get('app.markdown_transformer');

        $funFact = $transformer->parse($genus->getFunFact());

        /*$cache = $this->get('doctrine_cache.providers.my_markdown_cache');
        $key = md5($funFact);
        if ($cache->contains($key)) {
            $funFact = $cache->fetch($key);
        } else {
            sleep(1); // fake how slow this could be
            $funFact = $this->get('markdown.parser')
                ->transform($funFact);
            $cache->save($key, $funFact);
        }*/


            /*return $this->render('genus/show.html.twig', array(
                'name' => $genusName,
                'funFact' => $funFact
            ));*/
            
            
            //TODO LIST : 
            /*$funFact = $this->get('markdown.parser')
                ->transform($funFact);
                */



        $this->get('logger')
            ->info('Showing genus: '.$genusName);
        $recentNotes = $genus->getNotes()
            ->filter(function(GenusNote $note) {
                return $note->getCreatedAt() > new \DateTime('-2 months');
            });


        $recentNotes = $em->getRepository('AppBundle:GenusNote')
            ->findAllRecentNotesForGenus($genus);


        return $this->render('genus/show.html.twig', array(
            'genus' => $genus,
            'recentNoteCount' => count($recentNotes)
        ));
 
                
                
            return $this->render('genus/show.html.twig', array(
                'genus' => $genus,
                'funFact' => $funFact
            ));
 
            


    }

    /**
     * @Route("/genus/{name}/notes", name="genus_show_notes")
     * @Method("GET")
     */
    public function getNotesAction(Genus $genus)
    {

        foreach ($genus->getNotes() as $note) {
            $notes[] = [
                'id' => $note->getId(),
                'username' => $note->getUsername(),
                'avatarUri' => '/images/'.$note->getUserAvatarFilename(),
                'note' => $note->getNote(),
                'date' => $note->getCreatedAt()->format('M d, Y')
            ];
        }

        $data = [
            'notes' => $notes
        ];
        //return new Response(json_encode($data));
        return new JsonResponse($data);
    }

}