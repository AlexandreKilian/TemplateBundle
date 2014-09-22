<?php

namespace Brix\TemplateBundle\Twig\Extension;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\SecurityContext;


class BrixField{

  private $environment;
  private $security;

  public function __construct(\Twig_Environment $environment,SecurityContext $security){
    $this->environment = $environment;
    $this->security = $security;
  }

  public function render($entity,$field){
    $this->template = $this->environment->loadTemplate( "BrixTemplateBundle:Brix:brix_field.html.twig" );
    $getter = "get".ucfirst($field);
    $admin = $this->security->isGranted("ROLE_ADMIN");
    $text = $admin?'':$entity->$getter();
    return $this->template->renderBlock( 'brix_field', array(
      'entity'=>$entity,
      'field'=>$field,
      'text' => $text,
      'admin' => $admin
    ));

  }
}
