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

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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

//use Gregwar\CaptchaBundle\Type\CaptchaType;
//use Gregwar\CaptchaBundle\Generator\CaptchaGenerator;
//use Gregwar\CaptchaBundle\Validator\CapchaValidator;
//use Gregwar\Captcha\CaptchaBuilder;
//use Gregwar\Captcha\PhraseBuilder;
//use Gregwar\CaptchaBundle\Generator\ImageFileHandler;

/**
 * Description of UserSigninType
 *
 * @author d.krasavin
 * форма авторизации нового пользователя
 */
class UserSigninType extends LoggingForms{

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
       
        $translator = new Translator($this->request->getLocale());
        //$translator = new Translator('ru_RU');
        $translator->addLoader('array', new ArrayLoader());
        $translator->addResource('array', array(
            //'login' => 'имя',
            //'password' => 'пароль',
            //'Save' => 'Сохранить'
            //,'John' => 'Джон'
        ), 'ru_RU');
        //VarDumper::dump(array('$phrase='=>$form_data,'$phrase'=>$phrase));
        
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
        //VarDumper::dump(array('translator='=>$translator->trans('имя')));
        $builder
            ->setMethod('POST')
            ->add('username',TextType::class,array('attr' => array('maxlength' => 50,'required' => true,'placeholder'=>$translator->trans('John')),'label' => $translator->trans('Name')))//array('attr' => array('maxlength' => 50,'required' => true)))
            ->add('userlastname',TextType::class,array('attr' => array('maxlength' => 50,'required' => true,'placeholder'=>$translator->trans('Whatson')),'label' => $translator->trans('LastName')))//array('attr' => array('maxlength' => 50,'required' => true)))
            ->add('useremail',EmailType::class,array('attr' => array('maxlength' => 255,'required' => true,'placeholder'=>$translator->trans('JWhatson@mail.ru')),'label' => $translator->trans('email')))//array('attr' => array('maxlength' => 50,'required' => true)))
            ->add('userpassword',TextType::class,array('attr' => array('maxlength' => 20,'required' => true,'placeholder'=>$translator->trans('Wha37on')),'label' => $translator->trans('Password')))
            ->add('vcode', HiddenType::class,array('data' => ''))
            //->add('captcha', $CaptchaType,array('attr' => array('required' => true,'disabled' => false)))
            ->add('enter', SubmitType::class, array('attr'=>array('class'=>'btn btn-lg btn-primary btn-block'),'label' => $translator->trans('Sign in')));
 
        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
            $form_data = $event->getData();
            //$phrase=$this->captchabuilder->getPhrase();
            //VarDumper::dump(array('$phrase='=>$form_data,'$phrase'=>$phrase));
        });
        
        //VarDumper::dump(array('$generator_phrase='=>$generator->getPhrase($this->option),'CaptchaType'=>$CaptchaType->getName(),'fingerprint'=>$this->captchabuilder->getPhrase()));
    }

    //public function configureOptions(OptionsResolver $resolver)
    //{
    //    $resolver->setDefaults(array(
    //        'data_class' => 'AppBundle\Entity\UserLogin'
    //    ));
    //}

    public function getName()
    {
        return 'signin';
    }
    
    public function __construct($c_container=null,$c_session=null,Request $request){
        parent::__construct($c_container,$c_session,$request ); 
    }
}
