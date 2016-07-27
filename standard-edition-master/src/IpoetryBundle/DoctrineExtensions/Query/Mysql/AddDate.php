<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace IpoetryBundle\DoctrineExtensions\Query\Mysql;
use Doctrine\ORM\Query\AST\Functions\FunctionNode,
    Doctrine\ORM\Query\Lexer;
use Symfony\Component\VarDumper\VarDumper;
use Symfony\Component\VarDumper\Dumper\HTMLDumper;
/**
 * Description of DateAdd
 *
 * @author d.krasavin
 */
class AddDate extends FunctionNode {
    public $firstDateExpression = null;
    public $intervalExpression = null;
    public $intervalExpressionsign = null;
    
    public $unit = null;
    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        VarDumper::dump(array($parser));
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->firstDateExpression = $parser->FunctionDeclaration();
        $parser->match(Lexer::T_COMMA);
        $parser->match(Lexer::T_IDENTIFIER);

        $this->intervalExpression=$parser->ArithmeticFactor();

        //$parser->match(Lexer::T_MINUS||Lexer::T_PLUS);       
        //$this->intervalExpressionsign=$parser->ArithmeticFactor();
        //$this->intervalExpression = $parser->Literal();
        $parser->match(Lexer::T_IDENTIFIER);
        /* @var $lexer Lexer */
        $lexer = $parser->getLexer();
        $this->unit = $lexer->token['value'];
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
        VarDumper::dump(array($this->firstDateExpression,$this->intervalExpression,$this->unit)); //$this->intervalExpressionsign,
    }
    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        VarDumper::dump(array('ADDDATE(' . $this->firstDateExpression->dispatch($sqlWalker) . ', INTERVAL ' . $this->intervalExpression->dispatch($sqlWalker) . ' ' . $this->unit . ')'));
        return 'ADDDATE(' .
        $this->firstDateExpression->dispatch($sqlWalker) . ', INTERVAL ' .
        $this->intervalExpression->dispatch($sqlWalker) . ' ' . $this->unit .
        ')'; //$this->intervalExpressionsign.
    }
}
