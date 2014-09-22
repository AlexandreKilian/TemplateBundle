<?php

namespace Brix\TemplateBundle\Twig\TokenParser;

use \Twig_Token as Twig_Token;
use \Twig_Error_Syntax as Twig_Error_Syntax;
use \Twig_Node as Twig_Node;
use \Twig_Node_Print as Twig_Node_Print;

use \Twig_Node_Block;
use \Twig_Node_BlockReference;

use Brix\TemplateBundle\Twig\Node\BlockRenderNode as Block_Render_Node;


class BrixBlockTokenParser extends \Twig_TokenParser{
  public function parse(\Twig_Token $token)
      {

        $parser = $this->parser;
        $stream = $parser->getStream();

        $name = $stream->expect(\Twig_Token::NAME_TYPE)->getValue();
        $stream->expect(\Twig_Token::OPERATOR_TYPE, '=');
        $blockname = $parser->getExpressionParser()->parseExpression();

        $name = $stream->expect(\Twig_Token::NAME_TYPE)->getValue();
        $stream->expect(\Twig_Token::OPERATOR_TYPE, '=');
        $page = $parser->getExpressionParser()->parseExpression();

        $stream->expect(\Twig_Token::BLOCK_END_TYPE);



        return new Block_Render_Node($blockname,$page,$token->getLine(),$this->getTag());


          $lineno = $token->getLine();
          $value = $parser->getExpressionParser()->parseExpression();

          $stream = $this->parser->getStream();
          $name = $stream->expect(Twig_Token::NAME_TYPE)->getValue();

          if ($this->parser->hasBlock($name)) {
              throw new Twig_Error_Syntax(sprintf("The block '$name' has already been defined line %d", $this->parser->getBlock($name)->getLine()), $stream->getCurrent()->getLine(), $stream->getFilename());
          }
          $this->parser->setBlock($name, $block = new Twig_Node_Block($name, new Twig_Node(array()), $lineno));
          $this->parser->pushLocalScope();
          $this->parser->pushBlockStack($name);
          //
          if ($stream->nextIf(Twig_Token::BLOCK_END_TYPE)) {
              $body = $this->parser->subparse(array($this, 'decideBlockEnd'), true);
              if ($token = $stream->nextIf(Twig_Token::NAME_TYPE)) {
                  $value = $token->getValue();

                  if ($value != $name) {
                      throw new Twig_Error_Syntax(sprintf("Expected endBrixBlock for BrixBlock '$name' (but %s given)", $value), $stream->getCurrent()->getLine(), $stream->getFilename());
                  }
              }
          } else {
              $body = new Twig_Node(array(
                  new Twig_Node_Print($this->parser->getExpressionParser()->parseExpression(), $lineno),
              ));
          }
          $stream->expect(Twig_Token::BLOCK_END_TYPE);


          $block->setNode('body', $body);
          $this->parser->popBlockStack();
          $this->parser->popLocalScope();



          return new Block_Render_Node($name, $lineno, $this->getTag());
      }

      public function decideBlockEnd(Twig_Token $token)
      {
          return $token->test('endbrixblock');
      }

      public function getTag()
      {
          return 'brixblock';
      }
}
