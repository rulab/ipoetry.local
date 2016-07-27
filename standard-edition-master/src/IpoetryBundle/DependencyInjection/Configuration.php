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
        ->scalarNode('RedirectAfterUnsuccOauthLogin')->end()
        ->scalarNode('UserProfileUrl')->end()
        ->scalarNode('uprofilenewsfeedlimit')->end()
        ->scalarNode('uprofilecommentslimit')->end()
        ->scalarNode('userratinglimit')->end()
        ->scalarNode('poetryratinglimit')->end()
        ->scalarNode('poetrysearchlimit')->end()
        ->scalarNode('usersearchlimit')->end()
        ->scalarNode('SessionTimeout')->end()
        ->scalarNode('userslimit')->end()  
        ->arrayNode('vkontakte')
            ->children()
                ->scalarNode('target_path_parameter')->end()
                ->scalarNode('type')->end()
                ->scalarNode('client_id')->end()
                ->scalarNode('client_secret')->end()
                ->scalarNode('scope')
                    ->validate()
                        ->ifTrue(function($v) {
                            return empty($v);
                        })
                        ->thenUnset()
                    ->end()
                ->end()
                ->scalarNode('version')->end()
                ->arrayNode('options')
                    ->useAttributeAsKey('name')
                    ->prototype('scalar')->end()
                ->end()
            ->end()
        ->end()
        ->end();
        return $treeBuilder;
    }
}