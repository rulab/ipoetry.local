<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace IpoetryBundle\Twig;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Component\Translation\TranslatorInterface;
/**
 * Description of AppTranslationExtension
 *
 * @author d.krasavin
 */
class AppTranslationExtension extends TranslationExtension{
    //put your code here
    public function __construct(
            TranslatorInterface $translator, 
            \Twig_NodeVisitorInterface $translationNodeVisitor = null)
    {
        parent::__construct($translator, $translationNodeVisitor);
    }
    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('trans', array($this, 'trans')),
        );
    }
    
    public function trans($id,array $parameters = array(), $domain = null, $locale = null)
    {
        if (null === $locale) {
            $locale = $this->getTranslator()->getLocale();
        }

        if (null === $domain) {
            $domain = 'messages';
        }

        if ('messages' !== $domain 
        && false === $this->translationExists($id, $domain, $locale)) {
            $domain = 'messages';
        }

        return $this->getTranslator()->trans($id, $parameters, $domain, $locale);
    }
    protected function translationExists($id, $domain, $locale)
    {
        return $this->getTranslator()->getCatalogue($locale)->has((string) $id, $domain);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'app_translator';
    }
}
