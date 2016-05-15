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

use SwiftMailer;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use IpoetryBundle\Controller\uRoomController;
/**
 * Description of UserPasswordChangeController
 * контроллер для сброса пароля пользователя
 * @author d.krasavin
 */
class UserPasswordChangeController extends Controller {
    private $session;
    //массив запросов к БД
    private $sql_array=array('get_user_md5pwdchange'=>'CALL get_ipoetry_user_md5pwdchange(:user_md5pwdchange)',
                             'set_user_md5pwdchange_status'=>'CALL set_user_md5pwdchange_status(:user_md5pwdchange,:user_password_is_verified)',
                             'set_user_new_pwd'=>'CALL set_user_new_pwd(:user_md5pwdchange,:user_password)');

    public function userpasswordchangeAction(Request $request){
        //$user_name='Тестовый пользователь';
        //$email='denvkr@yandex.ru';
        //$url_verify_param='5hrtGtdfjy';
        //uRoomController::SendVerificationMail($user_name,$email,$url_verify_param);
        //проверяем ссылку пользователя по результатам пишем в базу
        $code_param=$request->get('code');
        if ($code_param!=null && strlen(utf8_decode($code_param))==32) {
            $stmt = $this->getDoctrine()
                         ->getConnection()
                         ->prepare($this->sql_array['get_user_md5pwdchange']);
            $stmt->bindValue(':user_md5pwdchange',$code_param);
            $stmt->execute();
            $result_userver=$stmt->fetchAll();
            //корректная ссылка, для желающего сменить пароль пользователя
            //пишем в базу новый статус и делаем переход в личный кабинет пользователя
            if ($result_userver[0]['ipoetry_user_md5_pwdchange']==1){
                $stmt=$this->getDoctrine()
                         ->getConnection()
                        ->prepare($this->sql_array['set_user_md5pwdchange_status']);
                $stmt->bindValue(':user_md5pwdchange',$code_param);
                $stmt->bindValue(':user_password_is_verified',1);
                $stmt->execute();
                if (!$request->hasSession()) {
                    $this->session = new Session();
                    $this->session->start();
                } else $this->session=$request->getSession();
                $this->session->set('code',$code_param);
            } else {
                //если ссылка уже неактуальная то шлем редиректом на главную страницу
              //return 0;  
            }
                
        }
        
        $result_userver[0]['ipoetry_user_md5_pwdchange']=(empty($result_userver[0]['ipoetry_user_md5_pwdchange'])) ? 0 : $result_userver[0]['ipoetry_user_md5_pwdchange'];
        VarDumper::dump(array('code='=>$code_param,'result_userver='=>$result_userver[0]['ipoetry_user_md5_pwdchange']));
        $html = $this->render('IpoetryBundle:UserPasswordChange:userpasswordchange.html.twig',array('change_password_form'=>$this->generate_change_password_form($request)->createView(),'form_visibility'=>$result_userver[0]['ipoetry_user_md5_pwdchange']));
        return new Response($html);
    }
    //ajax запрос сохранение нового пароля
    public function changepwdajaxAction(Request $request){
        //по полученном параметрам делаем запрос в базу узнать что такой пользователь существует
        $mas=array();
        if ($request->hasSession()) {
            $this->session=$request->getSession();
            $authorization_parameters=json_decode($request->get('login_json'),true);
            if ($authorization_parameters<>null){
                //в зависимости от типа запроса выполняем логику работы с БД
                if ($authorization_parameters['type']=='change_pwd' && $this->session->has('code')){
                    $mas['change_pwd_send']=$this->ChangepwdAjaxAnswer($authorization_parameters,$request);
                } else
                    $mas['change_pwd_send']=0;
            }
        } else
            $mas['change_pwd_send']=0;
        return new Response(json_encode($mas));        
    }
    
    public function ChangepwdAjaxAnswer($json_array,$request){

        //проверяем статус пользователя на наличие кода верификации для сброса пароля через хранимую процедуру
        $stmt = $this->getDoctrine()
                     ->getConnection()
                     ->prepare($this->sql_array['get_user_md5pwdchange']);
        $stmt->bindValue(':user_md5pwdchange',$this->session->get('code'));
        $stmt->execute();
        $result=$stmt->fetchAll();
        if ($result[0]['ipoetry_user_md5_pwdchange']==0){
            $stmt=$this->getDoctrine()
                     ->getConnection()
                    ->prepare($this->sql_array['set_user_new_pwd']);
            $stmt->bindValue(':user_md5pwdchange',$this->session->get('code'));
            $stmt->bindValue(':user_password',$json_array['password']);
            $stmt->execute();
            return 1;
        } else
            return 0;

    }
    public function generate_change_password_form($request){
        $formFactory = Forms::createFormFactoryBuilder()
            ->addExtension(new HttpFoundationExtension())
            ->getFormFactory();
        $translator = new Translator($request->getLocale());

        $form = $formFactory->createBuilder('form', array('action' => '#','method' => 'POST'))
                ->add('password',TextType::class,array('attr' => array('maxlength' => 20,'required' => true),'label' => $translator->trans('Password')))//array('attr' => array('maxlength' => 50,'required' => true)))
                ->add('Send_password', SubmitType::class, array('attr'=>array('class'=>'btn btn-lg btn-primary btn-block'),'label' => $translator->trans('Accept')))
                ->getForm();
        return $form;
    }
    
}