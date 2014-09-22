<?php

namespace Brix\TemplateBundle\Twig\Extension;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\SecurityContext;


class Widget{

  private $environment;
  private $security;

  public function __construct(\Twig_Environment $environment,SecurityContext $security){
    $this->environment = $environment;
    $this->security = $security;
  }

  public function start($widget){
    $this->template = $this->environment->loadTemplate( "BrixTemplateBundle:Brix:start_widget.html.twig" );
    $admin = $this->security->isGranted("ROLE_ADMIN");
    return $this->template->renderBlock( 'brix_field', array(
      'widget'=>$widget,
      'admin' => $admin
    ));

  }

  public function end($widget){
    $this->template = $this->environment->loadTemplate( "BrixTemplateBundle:Brix:end_widget.html.twig" );
    $admin = $this->security->isGranted("ROLE_ADMIN");
    return $this->template->renderBlock( 'brix_field', array(
      'widget'=>$widget,
      'admin' => $admin
    ));

  }
}
