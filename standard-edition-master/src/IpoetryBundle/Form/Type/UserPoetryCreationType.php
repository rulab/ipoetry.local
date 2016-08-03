<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace IpoetryBundle\Form\Type;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

//use Symfony\Component\Translation;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\ArrayLoader;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Component\Translation\MessageSelector;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Component\Yaml\Yaml;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\LengthValidator;
use Symfony\Component\Validator\Validation;

use Symfony\Component\VarDumper\VarDumper;
use Symfony\Component\VarDumper\Dumper\HTMLDumper;

use IpoetryBundle\Form\Abstracts\LoggingForms;

/**
 * Description of UserPoetryCreationType
 * форма создания стихотворения
 * @author d.krasavin
 */
class UserPoetryCreationType extends LoggingForms{
    //put your code here
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //$validator=Validation::createValidatorBuilder()->addMethodMapping('constrains');
        //$phrasebuilderinterface=new PhraseBuilder;
        //$imagefilehandler=new ImageFileHandler('AppBundle/Resources/images','',1,1);
        //$router = $this->get('router');
        //$router = $this->c_container;
        //$this->captchabuilder=new CaptchaBuilder('345gfD',$phrasebuilderinterface);
        //$generator = new CaptchaGenerator($router,$this->captchabuilder,$phrasebuilderinterface,$imagefilehandler);//$this->session->get('captchabuilder')
       
        $translator = new Translator($this->request->getLocale(), new MessageSelector());
        $translator->addLoader('yaml',new YamlFileLoader());
        $translator->addResource('yaml',$this->getTranslatorPath($this->request).'/poetrycreation.ru.yml', 'ru_RU','poetrycreation');
        VarDumper::dump(array($translator,$this->request,$translator->trans('PoetryTitle',array(),'poetrycreation')));
        //$CaptchaType = new CaptchaType($this->c_session,$generator,$translator,$this->option);
        //$validator = $this->get('validator');
            //$errors = $validator->validate($CaptchaType);
            //if (count($errors) > 0) {
                /*
                 * Uses a __toString method on the $errors variable which is a
                 * ConstraintViolationList object. This gives us a nice string
                 * for debugging.
                 */
                //$errorsString = (string) $errors;
            //}
        //VarDumper::dump(array('user='=>$request->get('user'),'password'=>$request->get('password')));
        //if ($this->request->get('user') && $this->request->get('password')) {

            $builder
                ->setMethod('POST')
                ->add('poetrytitle',TextType::class,array('attr' => array('maxlength' => 255,'required' => true,'placeholder'=>$translator->trans('PoetryTitle',array(),'poetrycreation')),'label' => false))//array('attr' => array('maxlength' => 50,'required' => true)))
                ->add('poetry',TextareaType::class,array('attr' => array('maxlength' => 4294967296,'required' => true,'placeholder'=>$translator->trans('Write your poetry',array(),'poetrycreation'),'class'=>'big-area'),'label' => false))//array('attr' => array('maxlength' => 50,'required' => true)))'cols'=>"50",'rows'=>"10",
                ->add('poetrytag',TextType::class,array('attr' => array('maxlength' => 20,'required' => false,'placeholder'=>$translator->trans('AddTags',array(),'poetrycreation')),'label' => false))//$translator->trans('AddTags')
                ->add('poetrycomment',TextareaType::class,array('attr' => array('maxlength' => 1024,'required' => true,'placeholder'=>$translator->trans('Comment',array(),'poetrycreation'),'class'=>'big-area'),'label' => false))//array('attr' => array('maxlength' => 50,'required' => true)))'cols'=>"50",'rows'=>"10",
                ->add('Selectfromlist', ChoiceType::class, array(
                        'attr'=>array(
                        'placeholder'=>$translator->trans('Tags',array(),'poetrycreation')),
                    'choices'  => $options['data'],
                    // *this line is important*
                    'choices_as_values' => false,
                    'label'=>false))
                //->add(
                //$builder->create('step1', 'form', array('virtual' => true))
                ->add('addtag', ButtonType::class, array('attr'=>array('class'=>'btn btn-sm btn-primary','style'=>'display:inline;'),'label' => $translator->trans('AddTagBtn',array(),'poetrycreation')))
                ->add('addNewtag', ButtonType::class, array('attr'=>array('class'=>'btn btn-sm btn-primary'),'label' => $translator->trans('AddNewTagBtn',array(),'poetrycreation')))
                //)
                //->add('attachpicture', ButtonType::class, array('attr'=>array('class'=>'btn btn-lg btn-primary btn-block'),'label' => $translator->trans('Attach Picture')))
                ->add('enter', SubmitType::class, array('attr'=>array('class'=>'btn-blue-bg'),'label' => $translator->trans('enter',array(),'poetrycreation')));//btn btn-lg btn-primary btn-block

            $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
                $form_data = $event->getData();
                //$phrase=$this->captchabuilder->getPhrase();
                //VarDumper::dump(array('$phrase='=>$form_data,'$phrase'=>$phrase));
            });

            //VarDumper::dump(array('$generator_phrase='=>$generator->getPhrase($this->option),'CaptchaType'=>$CaptchaType->getName(),'fingerprint'=>$this->captchabuilder->getPhrase()));
        //}
    }

    //public function configureOptions(OptionsResolver $resolver)
    //{
    //    $resolver->setDefaults(array(
    //        'data_class' => 'AppBundle\Entity\UserLogin'
    //    ));
    //}
    public function getName()
    {
        return 'UserPoetryCreation';
    }
    
    public function __construct($c_container=null,$c_session=null,Request $request){
        parent::__construct($c_container,$c_session,$request ); 
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            //'data_class' => 'IpoetryBundle\Entity\IpoetryuserBlogPost',
        ));
    }   
}
