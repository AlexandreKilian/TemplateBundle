<?php

namespace Brix\TemplateBundle\Twig\Tags;

use Brix\TemplateBundle\Twig\TokenParser\BrixBlockTokenParser;

class BrixBlock extends \Twig_Extension{

  public function getTokenParsers(){
    return array(new BrixBlockTokenParser());
  }

  public function getName()
    {
        return 'BrixBlock';
    }

}
