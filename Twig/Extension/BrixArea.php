<?php

namespace Brix\TemplateBundle\Twig\Extension;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\SecurityContext;

use Symfony\Component\HttpFoundation\Session\Session;


class BrixArea{

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

  public function render($entity,$field){
    $this->template = $this->environment->loadTemplate( "BrixTemplateBundle:Brix:brix_area.html.twig" );
    $getter = "get".ucfirst($field);
    $admin = $this->isAdminMode();
    $text = $admin?'':$entity->$getter();
    return $this->template->renderBlock( 'brix_field', array(
      'entity'=>$entity,
      'field'=>$field,
      'text' => $text,
      'admin' => $admin
    ));

  }
}
