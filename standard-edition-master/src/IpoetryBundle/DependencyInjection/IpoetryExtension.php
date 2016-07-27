<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace IpoetryBundle\DependencyInjection;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

/**
 * Description of IpoetryExtension
 *
 * @author d.krasavin
 */
class IpoetryExtension extends Extension {
    public function load(array $configs, ContainerBuilder $container) {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        //var_dump($config['UserEmailAuthUrl']);
        //$container->setParameter('ipoetry.UserEmailAuthUrl', $config['UserEmailAuthUrl']);
        
/*
        $loader = new YamlFileLoader(
                    $container,
                    new FileLocator(__DIR__.'/../Resources/config')
        );
        $loader->load('ipoetry_config_dev.yml');
 * 
 */
        foreach (array('UserEmailAuthUrl',
            'UserPasswordChangeUrl',
            'RedirectAfterUnsuccOauthLogin',
            'UserProfileUrl',
            'uprofilenewsfeedlimit',
            'uprofilecommentslimit',
            'userratinglimit',
            'poetryratinglimit',
            'poetrysearchlimit',
            'usersearchlimit',
            'SessionTimeout',
            'userslimit',
            'vkontakte') as $attribute) {
            $container->setParameter('ipoetry.'.$attribute, $config[$attribute]);
        }
    }
    public function getAlias() {
        //parent::getAlias();
        return 'ipoetry';
    }    
}
