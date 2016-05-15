<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace IpoetryBundle\DependencyInjection;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Description of Configuration
 *
 * @author d.krasavin
 */
class Configuration implements ConfigurationInterface{
    //put your code here
    public function getConfigTreeBuilder() {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ipoetry');
        $rootNode
        ->children()
        ->scalarNode('UserEmailAuthUrl')->end()
        ->scalarNode('UserPasswordChangeUrl')->end()
        ->end();
        return $treeBuilder;
    }
}