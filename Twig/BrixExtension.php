<?php

namespace Brix\TemplateBundle\Twig;

use Symfony\Bridge\Twig\TokenParser\FormThemeTokenParser;
use Symfony\Bridge\Twig\Form\TwigRendererInterface;

class BrixExtension extends \Twig_Extension{


  protected $container;

    public function __construct( $container )
    {
        $this->container = $container;
    }


  public function getFunctions(){
    return array(
      'bx_start' => new \Twig_Function_Method($this,'startWidget',array('is_safe'=>array('html'))),
      'bx_end' => new \Twig_Function_Method($this,'endWidget',array('is_safe'=>array('html'))),
      'bx_field' => new \Twig_Function_Method($this,'renderField',array('is_safe'=>array('html'))),
      'bx_image' => new \Twig_Function_Method($this,'renderImage',array('is_safe'=>array('html'))),
      'bx_area' => new \Twig_Function_Method($this,'renderArea',array('is_safe'=>array('html'))),
      'bx_navigation' => new \Twig_Function_Method($this,'renderNavigation',array('is_safe'=>array('html')))
    );
    // return array(
    //     new \Twig_SimpleFunction('bx_field',null,array('node_class'=>'Brix\TemplateBundle\Twig\Node\BrixField', 'is_safe'=> array('html')))
    // );

  }

      public function getName()
    {
        return 'brix';
    }

    public function startWidget( $page )
    {
        return $this->container->get( 'brix.twig.widget' )->start( $page );
    }
    public function endWidget( $page )
    {
        return $this->container->get( 'brix.twig.widget' )->end( $page );
    }

    public function renderField( $entity,$field,$wrap = true )
    {
        return $this->container->get( 'brix.twig.brix_field' )->render( $entity,$field,$wrap );
    }
    public function renderImage( $entity,$field,$width=0,$height=0,$display=true )
    {
        return $this->container->get( 'brix.twig.brix_image' )->render( $entity,$field,$width,$height,$display );
    }
    public function renderArea( $entity,$field )
    {
        return $this->container->get( 'brix.twig.brix_area' )->render( $entity,$field );
    }
    public function renderNavigation( $navigation )
    {
        return $this->container->get( 'brix.twig.brix_navigation' )->render( $navigation );
    }
}
