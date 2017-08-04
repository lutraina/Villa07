<?php
/**
 * Created by PhpStorm.
 * User: lucianahembert
 * Date: 03/08/2017
 * Time: 21:48
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class MainController extends Controller
{
    public function homepageAction(){

        return $this->render('main/homepage.html.twig');
    }
}