<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace IpoetryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\DomCrawler\Field\InputFormField;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;
use Symfony\Component\HttpFoundation\Session\Storage\MockFileSessionStorage;

use Symfony\Component\Debug\Debug;
use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;
use Symfony\Component\Debug\DebugClassLoader;

use Symfony\Component\Translation;

use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\Csrf\CsrfExtension;
use Symfony\Component\Form\Extension\Csrf\CsrfProvider\SessionCsrfProvider;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\LengthValidator;
use Symfony\Component\Validator\Validation;

use Symfony\Component\VarDumper\VarDumper;
use Symfony\Component\VarDumper\Dumper\HTMLDumper;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Bridge\Twig\Extension\TranslationExtension;

use Doctrine\ORM\Query\ResultSetMapping;

use IpoetryBundle\Form\Type\UserLoginType;
use IpoetryBundle\Entity\UserLogin;

use IpoetryBundle\Controller\Abstracts\LoggingController;
//use AppBundle\Form\Type\User_profileType;

//use Gregwar\CaptchaBundle\Type\CaptchaType;
//use Gregwar\CaptchaBundle\Generator\CaptchaGenerator;
//use Gregwar\CaptchaBundle\Validator\CapchaValidator;
//use Gregwar\Captcha\CaptchaBuilder;
//use Gregwar\Captcha\PhraseBuilder;
//use Gregwar\CaptchaBundle\Generator\ImageFileHandler;

//use IpoetryBundle\Resources\public\images;

/**
 * Description of LoginController
 * @author d.krasavin
 * контроллер для формы логина существующего пользовтеля
 */
class LoginController extends LoggingController {

    public function loginAction(Request $request){
        parent::loginAction($request);

        // create the Translator
        //$translator = new Translator('ru');
        // somehow load some translations into it
        //$translator->addLoader('yml', new YamlFileLoader());
        //$translator->addResource(
        //    'yml',
        //    'z:/domains/ipoetry/standard-edition-master/src/IpoetryBundle/Resources/translations/messages.ru.yml',
        //    'ru'
        //);
        VarDumper::dump(array('request_locale'=>$request->getLocale()));//'messages_locale'=> 'z:/domains/ipoetry/standard-edition-master/src/IpoetryBundle/Resources/translations/messages.ru.yml'

        //для тестов
        //?user=44c54155669c3adef054c3c2a32accf7&password=44c54155669c3adef054
	//$retval=$this->get_site_config($this->site_config,'siteconfig');
        //echo 1;
        //$formFactory = Forms::createFormFactoryBuilder()
        //    ->addExtension(new HttpFoundationExtension())
        //    ->getFormFactory();
        //$validator=Validation::createValidatorBuilder()->addMethodMapping('constrains');
        //пытаемся сделать простой валидатор с ограничениями по длинне слова
        $ln=new Assert\Length(array('min'=>3,'max'=>20));
        //var_dump($ln);
        $constraint = new Assert\Collection(array(
            'login' => array(new Assert\NotBlank(),new Assert\Length(array('min'=>3,'max'=>20))),
            'password' => new Assert\NotBlank(),
        ));
        $params['constraints']=$constraint;
        //echo 5;
	//if (!isset($this->config))
        //    $this->config=new config();
        //if ($retval===false) {
        //    $this->config->setDbServerName('localhost');
        //    $this->config->setDbUserName('prokatau_root');
        //    $this->config->setDbUserPassword('Hftg8bp');
        //    $this->config->setDbName('prokatau_rentcar');
        //    $this->config->setSiteUrl('prokatauto-symfony/');
        //}
        //Генерим сессию для страницы
        //session_start();
        if (!$request->hasSession()) {
            $this->session = new Session();
            $this->session->start();
        } else $this->session=$request->getSession();

        //$user_profile_class=new user_profile_class($this->config->getDbServerName(),$this->config->getDbName(),$this->config->getDbUserName(),$this->config->getDbUserPassword(),'mysql');
        //echo print_r($user_profile_class);
        //$this->session = new Session(new MockArraySessionStorage());
        //if ($request->get('user') && $request->get('password') && !($request->get('data_modification'))) {
                //echo $request->get('user') .' '. $request->get('password');
                //echo $_REQUEST['user'].$_REQUEST['password'];
                //var_dump($this->session);
                //получаем опции для капчи
                //$options = $this->container->getParameter('gregwar_captcha.config');
                //echo $this->session->getId();
                //var_dump($options);
                //$generator = $this->container->get('gregwar_captcha.generator');
                //$this->session->set('captchabuilder',new CaptchaBuilder());
                //echo __DIR__;
                //$this->option=$this->captcha_options();
                //$phrasebuilderinterface=new PhraseBuilder;
                //$imagefilehandler=new ImageFileHandler('AppBundle/Resources/images','',1,1);
                //$router = $this->get('router');
                //$this->captchabuilder=new CaptchaBuilder(null,$phrasebuilderinterface);
                //$generator = new CaptchaGenerator($router,$this->captchabuilder,$phrasebuilderinterface,$imagefilehandler);//$this->session->get('captchabuilder')
                //$translator = new Translator('en');
                //$CaptchaType = new CaptchaType($this->session,$generator,$translator,$this->option);
                //echo $this->captchabuilder->getPhrase().' ';
                //$GLOBALS['captchabuilder']=$this->captchabuilder;
                //$Translation=new Translation();
                //echo $CaptchaType->getBlockPrefix();
                //var_dump($generator);
                //var_dump($CaptchaType);    
                //$this->session->setId();
                //$mail_link_activation=$request->get('mail_link_activation');
                //$session_id=$request->cookies->get('PHPSESSID');
                //print_r($mail_link_activation);
                //$user_profile_class->db_store_session_info($mail_link_activation,$session_id);
                //$mail_link_activation_old=$user_profile_class->db_check_mail_link_info('',$request->get('user'),$request->get('password'));
                //echo substr($mail_link_activation_old,-33);
                //echo $mail_link_activation_old;
                //$retval=$user_profile_class->db_get_user_info(substr($mail_link_activation_old,-33));
                //print_r($retval);
                //$action="/login?mail_link_activation=".substr($mail_link_activation_old,-33)."&data_modification=1";
                //$str_tab='<div id="userinfo_level1" class="ul.nav" style="position:relative;left:35%;top:130px !important;width:300px;height:150px;z-index:0"><table border="1" cols="2"><tr><td>Логин:</td><td><input type="text" name="login" value="'.$retval[0].'"/></td></tr><tr><td>Пароль:</td><td><input type="text" name="password" value="'.$retval[1].'"/><br></td></tr><tr><td>Ел. почта:</td><td><input type="text" name="mail_address" value="'.$retval[2].'"/><br></td></tr><tr><td>Имя:</td><td><input type="text" name="name" value="'.$retval[3].'"/><br></td></tr><tr><td>Фамилия:</td><td><input type="text" name="last_name" value="'.$retval[4].'"/><br></tr><tr><td>Дом. адрес:</td><td><input type="text" name="address" value="'.$retval[5].'"/><br></td></tr><tr><td>Возраст:</td><td><input type="text" name="age" value="'.$retval[6].'"/><br></td></tr><tr><td>Стаж:</td><td><input type="text" name="drivers_length" value="'.$retval[7].'"/><br></td></tr><tr><td>Желаемые условия аренды автомобиля:</td><td><textarea name="rent_request" style="width:227px;height:81px;">'.$retval[8].'</textarea><br></td></tr></table></div><div id="captcha" class="ul" style="position:relative;left:40%;top:340px;width:150px;height:30px">Введите код с картинки: <img src="captcha.php?mail_link_activation='.$mail_link_activation.'" width=50 height=30><input name="captcha" size=5 type="text" /><input type="submit" name="_Registering" value="Обновить данные"></div></form>';
                //$defaults = array('login' => $retval[0],'password'=>$retval[1],'captcha'=>null);
                //echo 6;
                //$formoptions['data']['login']=$retval[0];
                //$formoptions['data']['password']=$retval[1];
                //$formoptions['data']['user']=$request->get('user');
                //$formoptions['data']['mail_link_activation_old']=substr($mail_link_activation_old,-33);
                //$formoptions['data']['phrasebuilderinterface']=$phrasebuilderinterface->niceize($generator->getPhrase($this->option));
                $UserLogin=new UserLogin();
                $UserLoginType=new UserLoginType($this->get('router'),$this->session,$request);
                $form =$this->createForm($UserLoginType, $UserLogin);
                $form->handleRequest($request);
                $valid_info='<div></div>';
                $validator = $this->get('validator');
                $errors = $validator->validate($form);
                //if ($form->isValid()) {
                //if (count($errors) == 0) {
                //    $data = $form->getData();
                //    VarDumper::dump(array('loginformdata'=>$data));
                //    $valid_info_style='visibility: visible;';
                //    $valid_info='<div style="background-color:blue;$valid_info_style">Данные введены правильно</div>';
                //}

                /*
                $form = $formFactory->createBuilder('form',$defaults, array('action' => $action,'method' => 'POST'))
                        ->add('login',TextType::class,array('attr' => array('maxlength' => 50,'required' => true)))//array('attr' => array('maxlength' => 50,'required' => true)))
                        ->add('password',TextType::class,array('attr' => array('maxlength' => 20,'required' => true)))
                        ->add('captcha', $CaptchaType,array('attr' => array('required' => true,'disabled' => false)))
                        ->add('Save', SubmitType::class, array('attr'=>array('class'=>'btn btn-lg btn-primary btn-block'),'label' => 'Сохранить'))
                        ->add('user', HiddenType::class,array('data' => $request->get('user')))
                        ->add('data_modification', HiddenType::class,array('data' => 1))
                        ->add('mail_link_activation', HiddenType::class,array('data' => substr($mail_link_activation_old,-33)))
                        ->add('system_captcha', HiddenType::class,array('data' =>$phrasebuilderinterface->niceize($generator->getPhrase($this->option))) )
                        ->getForm();
                */
                //$capchavalidator=new CaptchaValidator($translator,$this->session,)
                //$request->getSession()->set('data_modification', 1);
                //$request->getSession()->set('mail_link_activation', substr($mail_link_activation_old,-33));
        if (isset($form)){
            $html = $this->render('IpoetryBundle:Login:login_form.html.twig',array('form' => $form->createView()));//,'captcha'=>$CaptchaView
        }
        //echo $this->captchabuilder->getPhrase().' ';
        //if($form->isValid()) {
            return $html;            
        //} else {
        //    $errorsRaw = $this->get('validator')->validate($form);
        //    if (count($errorsRaw) > 0) {
        //        $errorsString = (string) $errorsRaw;
        //    }

        //}
        
    }

    public function createAction(){
        $ipoetry_user=new UserLogin();
        $ipoetry_user->SetLogin('test_user');
        $ipoetry_user->SetPassword('test_password');
        $em = $this->getDoctrine()->getManager();
        $em->persist($ipoetry_user);
        $em->flush();
    }
    
    function get_site_config($xmlfile,$attribute) {
        parent::get_site_config($xmlfile,$attribute);
    }
    function captcha_options($key=false,$val=false) {
        parent::captcha_options($key,$val);
    }
}
