<?php

namespace Brix\TemplateBundle\Twig\Extension;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Session\Session;


class BrixImage{

  private $environment;
  private $security;
  private $session;

  public function __construct(\Twig_Environment $environment,SecurityContext $security, Session $session){
    $this->environment = $environment;
    $this->security = $security;
    $this->session = $session;
  }

    public function isAdminMode(){
        return ($this->security->isGranted("ROLE_ADMIN") && $this->session->get('adminmode',false));
    }

  public function render($entity,$field,$width,$height){
    $this->template = $this->environment->loadTemplate( "BrixTemplateBundle:Brix:brix_image.html.twig" );
    $getter = "get".ucfirst($field);
    $admin = $this->isAdminMode();
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
