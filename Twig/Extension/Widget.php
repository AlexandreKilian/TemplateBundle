<?php

namespace Brix\TemplateBundle\Twig\Extension;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Session\Session;


class Widget{

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

  public function start($page){
    $this->template = $this->environment->loadTemplate( "BrixTemplateBundle:Brix:start_widget.html.twig" );
    $admin = $this->isAdminMode();
    return $this->template->renderBlock( 'brix_field', array(
      'page'=>$page,
      'admin' => $admin
    ));

  }

  public function end($page){
    $this->template = $this->environment->loadTemplate( "BrixTemplateBundle:Brix:end_widget.html.twig" );
    $admin = $this->isAdminMode();
    return $this->template->renderBlock( 'brix_field', array(
      'page'=>$page,
      'admin' => $admin
    ));

  }
}
