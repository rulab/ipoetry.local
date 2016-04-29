<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace IpoetryBundle\Form\Abstracts;

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

//use Gregwar\CaptchaBundle\Type\CaptchaType;
//use Gregwar\CaptchaBundle\Generator\CaptchaGenerator;
//use Gregwar\CaptchaBundle\Validator\CapchaValidator;
//use Gregwar\Captcha\CaptchaBuilder;
//use Gregwar\Captcha\PhraseBuilder;
//use Gregwar\CaptchaBundle\Generator\ImageFileHandler;

/**
 * Description of LoggingForms
 *
 * @author d.krasavin
 * класс заготовка для форма логгинга пользователя
 */
abstract class LoggingForms extends AbstractType{
    private $option=array();
    private $session;
    private $captchabuilder;
    private $c_container;
    private $c_session;
    public $request;
    const obj_name='form_name';
    //put your code here
   public function buildForm(FormBuilderInterface $builder, array $options)
    {

    }

    //public function configureOptions(OptionsResolver $resolver)
    //{
    //    $resolver->setDefaults(array(
    //        'data_class' => 'AppBundle\Entity\UserLogin'
    //    ));
    //}
    public function getName()
    {
        return $this->obj_name;
    }
    
    public function __construct($c_container=null,$c_session=null,Request $request){
        //$this->c_container = $c_container;
        //$this->c_session=$c_session;
        //$this->option=$this->captcha_options();
        $this->request=$request;
    }
    
    private function captcha_options($key=false,$val=false){
        /*
         * You can define the following configuration options globally or on the CaptchaType itself:
            width: the width of the captcha image (default=120)
            height: the height of the captcha image (default=40)
            disabled: disable globally the CAPTCHAs (can be useful in dev environment), it will still appear but won't be editable and won't be checked
            length: the length of the captcha (number of chars, default 5)
            quality: jpeg quality of captchas (default=30)
            charset: the charset used for code generation (default=abcdefhjkmnprstuvwxyz23456789)
            font: the font to use (default is random among some pre-provided fonts), this should be an absolute path
            keep_value: the value will be the same until the form is posted, even if the page is refreshed (default=true)
            as_file: if set to true an image file will be created instead of embedding to please IE6/7 (default=false)
            as_url: if set to true, a URL will be used in the image tag and will handle captcha generation. This can be used in a multiple-server environment and support IE6/7 (default=false)
            invalid_message: error message displayed when an non-matching code is submitted (default="Bad code value", see the translation section for more information)
            bypass_code: code that will always validate the captcha (default=null)
            whitelist_key: the session key to use for keep the session keys that can be used for captcha storage, when using as_url (default=captcha_whitelist_key)
            reload: adds a link to reload the code
            humanity: number of extra forms that the user can submit after a correct validation, if set to a value different of 0, only 1 over (1+humanity) forms will contain a CAPTCHA (default=0, i.e each form will contain the CAPTCHA)
            distortion: enable or disable the distortion on the image (default=true, enabled)
            max_front_lines, max_behind_lines: the maximum number of lines to draw on top/behind the image. 0 will draw no lines; null will use the default algorithm (the number of lines depends on the size of the image). (default=null)
            background_color: sets the background color, if you want to force it, this should be an array of r,g &b, for instance [255, 255, 255] will force the background to be white
            background_images: Sets custom user defined images as the captcha background (1 image is selected randomly). It is recommended to turn off all the effects on the image (ignore_all_effects). The full paths to the images must be passed.
            interpolation: enable or disable the interpolation on the captcha
            ignore_all_effects: Recommended to use when setting background images, will disable all image effects.
         */
        $option=array ('width'=>'240',
                        'height'=>'80',
                        'disabled'=>true,
                        'length'=>'6',
                        'quality'=>'30',
                        'charset'=>'abcdefghijklmnopqrstuxywz23456789',
                        'font'=>__DIR__ . '/Font/captcha0.ttf',
                        'keep_value'=>true,
                        'as_file'=>false,
                        'invalid_message'=>'Введенный код не совпадает с картинкой.',
                        'bypass_code'=>null,
                        'whitelist_key'=>'captcha_whitelist_key',
                        'max_front_lines'=>null,
                        'max_behind_lines'=>null,
                        'interpolation'=>false,
                        'expiration'=>'5',
                        'reload'=>'',
                        'as_url'=>false,
                        'humanity'=>0,
                        'distortion'=>false,
                        'background_color'=>array(255,255,255),
                        'background_images'=>array('../images/podcatalog2.png','../images/phone_bg.png'),
                        'ignore_all_effects'=>true,
                        'text_color'=>array(0,0,0),
                        'disabled'=>false,
            );
        return $option;
    }

}
