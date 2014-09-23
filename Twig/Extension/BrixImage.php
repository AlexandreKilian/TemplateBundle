<?php

namespace Brix\TemplateBundle\Twig\Extension;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\SecurityContext;


class BrixImage{

  private $environment;
  private $security;

  public function __construct(\Twig_Environment $environment,SecurityContext $security){
    $this->environment = $environment;
    $this->security = $security;
  }

  public function render($entity,$field,$width,$height){
    $this->template = $this->environment->loadTemplate( "BrixTemplateBundle:Brix:brix_image.html.twig" );
    $getter = "get".ucfirst($field);
    $admin = $this->security->isGranted("ROLE_ADMIN");
    $image = $admin?null:$entity->$getter();
    return $this->template->renderBlock( 'brix_field', array(
      'entity'=>$entity,
      'field'=>$field,
      'image' => $image,
      'admin' => $admin,
      'width'=> $width,
      'height'=>$height,
    ));

  }
}
