<?php

namespace Brix\TemplateBundle\Twig\Extension;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\SecurityContext;


class BrixNavigation{

  private $environment;
  private $security;

  public function __construct(\Twig_Environment $environment,SecurityContext $security){
    $this->environment = $environment;
    $this->security = $security;
  }

  public function render($navigation){
    $this->template = $this->environment->loadTemplate( "BrixTemplateBundle:Brix:brix_navigation.html.twig" );
    $admin = $this->security->isGranted("ROLE_ADMIN");
    return $this->template->renderBlock( 'brix_field', array(
      'navigation'=>$navigation,
      'admin' => $admin,
    ));

  }
}
