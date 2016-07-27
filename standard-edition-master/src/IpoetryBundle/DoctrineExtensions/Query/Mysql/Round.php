<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace IpoetryBundle\DoctrineExtensions\Query\Mysql;
use Doctrine\ORM\Query\AST\Functions\FunctionNode,
    Doctrine\ORM\Query\Lexer;

/**
 * Description of ROUND
 *
 * @author d.krasavin
 */
class Round extends FunctionNode{

    public $arithmeticExpression1;
    public $arithmeticExpression2;
    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return 'ROUND(' . $sqlWalker->walkSimpleArithmeticExpression(
                $this->arithmeticExpression1
        ) . ','. $sqlWalker->walkSimpleArithmeticExpression(
                $this->arithmeticExpression2
        ) . ')';
    }
    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $lexer = $parser->getLexer();
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        
        $this->arithmeticExpression1 = $parser->SimpleArithmeticExpression();
//var_dump($this->arithmeticExpression1);        
        $parser->match(Lexer::T_COMMA);

        $this->arithmeticExpression2 = $parser->SimpleArithmeticExpression();       
//var_dump($this->arithmeticExpression2);

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
