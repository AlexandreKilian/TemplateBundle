<?php

namespace Brix\TemplateBundle\Twig\Node;


class BlockRenderNode extends \Twig_Node
{
    public function __construct($name, \Twig_Node_Expression $value, $line, $tag = null)
    {

        parent::__construct(array('value' => $value), array('name' => $name), $line, $tag);
    }

    public function compile(\Twig_Compiler $compiler)
    {


    // file_put_contents("/Users/alex/test.txt",$this->getNode("name"));
    

        $compiler
            ->addDebugInfo($this)
            ->write('var_dump(')
            // ->write('die(var_dump($context));$context[\''.$this->getAttribute('name').'\'] = ')
            ->subcompile($this->getNode('value'))
            ->raw(");\n")
        ;
    }
}
