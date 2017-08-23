<?php
/**
 * Created by PhpStorm.
 * User: lhembert
 * Date: 22/08/2017
 * Time: 13:03
 */

namespace AppBundle\Service;

//the parser markdown will parse markdown and eventually catch it

use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;

class MarkdownTransformer
{
    private $markdownParser;

    public function __construct(MarkdownParserInterface $markdownParser)
    {
        $this->markdownParser = $markdownParser;
    }

    public function parse($str){

        return $this->markdownParser->transformMarkdown($str);

        //return strtoupper($str);

    }


}