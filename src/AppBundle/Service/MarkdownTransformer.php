<?php
/**
 * Created by PhpStorm.
 * User: lhembert
 * Date: 22/08/2017
 * Time: 13:03
 */

namespace AppBundle\Service;

//the parser markdown will parse markdown and eventually catch it

class MarkdownTransformer
{
    private $markdownParser;
    
    public function __construct($markdownParser)
    {
        $this->markdownParser = $markdownParser;
    }

    public function parse($str){

        return $this->markdownParser->transform($str);

        //return strtoupper($str);

    }


}