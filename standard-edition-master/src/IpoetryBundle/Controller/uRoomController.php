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
use IpoetryBundle\Form\Type\UserSigninType;
use IpoetryBundle\Form\Type\UserRoomType;

use IpoetryBundle\Entity\UserSignin;
use IpoetryBundle\Entity\user;
use IpoetryBundle\Entity\UserRoom;
use IpoetryBundle\Entity\UserLogin;

use IpoetryBundle\Controller\Abstracts\LoggingController;

/**
 * Description of uRoomController
 * @author d.krasavin
 * контроллер для личного кабинета пользователя
 */
class uRoomController extends LoggingController{
        //кеширование запросов БД
        public $cacheDriver;
        //массив запросов к БД
        private $sql_array=array('login_action'=>'SELECT concat(user_email,user_password) userpassword FROM ipoetry_user WHERE user_email = ? and user_password=? LIMIT 1',
                                 'signin_action1'=>'SELECT user_email FROM ipoetry_user WHERE user_email = ? LIMIT 1',
                                 'signin_action2'=>'INSERT INTO ipoetry_user (user_name,user_password,user_lastname,user_email) VALUES(?,?,?,?)');
        private $is_cache=false;
        
        public function uroomAction(Request $request){
        parent::loginAction($request);
        //проверяем что пришло в сессии
        $this->GetCache($request);
        VarDumper::dump(array('cache'=>$this->cacheDriver,'$is_cache='=>$this->is_cache));
        if ($request->hasSession())
            $this->session=$request->getSession();
        //выводим форму
        $UserRoom=new UserRoom();
        $UserRoomType=new UserRoomType($this->get('router'),$this->session,$request);
                $form =$this->createForm($UserRoomType, $UserRoom);
                $form->handleRequest($request);
        //стыкуем таблицу ipoetry_user с шаблоном личного кабинета

        $uroom = $this->getDoctrine()
        ->getRepository('IpoetryBundle:UserRoom')
        ->find(1);
        if (!$uroom) {
            throw $this->createNotFoundException('No user found for id 1');
        }
        //return new Response('тут отображается форма с данными о пользователе');
        return $this->render('IpoetryBundle:uRoom:uroom.html.twig',array('form' => $form->createView()));
    }
    //ajax запросы по логированию и регистрации пользователей
    public function uroomajaxAction(Request $request){
        //по полученном параметрам делаем запрос в базу узнать что такой пользователь существует
        $mas=array();

        $authorization_parameters=json_decode($request->get('login_json'),true);
        if ($authorization_parameters<>null){
        //проверяем что пришло в сессии
        $this->GetCache($request);
        //в зависимости от типа запроса выполняем логику работы с БД
        if ($authorization_parameters['type']=='login'){
            $mas['logging']=$this->LoginAjaxAnswer($authorization_parameters,$request);
        } else if ($authorization_parameters['type']=='signin') {
            $mas['logging']=$this->SigninAjaxAnswer($authorization_parameters,$request);
        }
        } else
            $mas['logging']=0;
        //VarDumper::dump(array('sql'=>$this->sql_array,'logging'=>$mas['logging'],'jsonlogin='=>$request->get('jsonlogin'),'cache'=>$this->cacheDriver));
        /*
        $rsm = new ResultSetMapping;
        $rsm->addEntityResult('user', 'u');
        $rsm->addFieldResult('u', 'user_name', 'user_name');
        $rsm->addFieldResult('u', 'user_password', 'user_password');
        $this->em = $this->getDoctrine()->getRepository('user','user');
        
        $query = $this->em->createNativeQuery('SELECT user_name,user_password FROM ipoetry_user WHERE user_name = ? and user_password= ?', $rsm);
        $query->setParameter(1,$request->get('login') );
        $query->setParameter(2,$request->get('password') );
        
        $user = $query->getResult();
        */
        //$mas['ok']=1;
        //$mas['login']=$user[0]['user_name'];
        //$mas['password']=$user[0]['user_password'];
        return new Response(json_encode($mas));
    }

    //запрос по логированию пользователя, проверяет существование пользователя
    //пишет в кеш данные
    public function LoginAjaxAnswer($json_array,$request=null){
        $user='';
        $stmt='';

        //проверяем что пришло в сессии
        $this->GetCache($request);

        //VarDumper::dump(array('sql'=>$sql));

        //смотрим если данные в кеше уже есть тогда берем из кеша
        if (isset($this->cacheDriver)){
            if ($this->cacheDriver->contains($json_array['login'].$json_array['password'])) {
                //использовали кеш
                $this->is_cache=true;
                if ($request->hasSession()) {
                    $session=$request->getSession();
                    $session->set('is_cache', $this->is_cache);
                }
                return 1;                
            }
        }

        //без кеша
        $this->is_cache=false;
                if ($request->hasSession()) {
                    $session=$request->getSession();
                    $session->set('is_cache', $this->is_cache);
                }
        //читаем базу данных
        $stmt = $this->getDoctrine()
                     ->getConnection()
                     ->prepare($this->sql_array['login_action']);
        $stmt->bindParam(1,$json_array['login']);
        $stmt->bindParam(2,$json_array['password']);
        $stmt->execute();
        $result=$stmt->fetchAll();

        //VarDumper::dump(array('$result='=>$result));

        //если есть что то в базе, то хорошо, будем писать в кеш
        if (isset($result[0]['userpassword'])){

            //VarDumper::dump(array('$result[0][\'userpassword\']'=>$result[0]['userpassword'],' $authorization_parameters[\'login\'].$authorization_parameters[\'password\']'=>$authorization_parameters['login'].$authorization_parameters['password']));

            //кешируем полученную информацию
            if (isset($this->cacheDriver))
                $this->cacheDriver->save($json_array['login'].$json_array['password'], 1);
                if ($request->hasSession()) {
                    $session=$request->getSession();
                    $session->set('cacheDriver', $this->cacheDriver);
                }

            //пара логин+пароль совпадает с базой.
            if ($result[0]['userpassword']==$json_array['login'].$json_array['password']) {
                return 1;
            }
            //данные в базе отсутствуют
        } else
            return 0;
    }
    
    //запрос по регистрации пользователя, проверяет существование пользователя
    //пишет в кеш данные
    public function SigninAjaxAnswer($json_array,$request=null){
        $user='';
        $sql='';
        $stmt='';
        
        //проверяем что пришло в сессии
        $this->GetCache($request);

        //без кеша
        $this->is_cache=false;
                if ($request->hasSession()) {
                    $session=$request->getSession();
                    $session->set('is_cache', $this->is_cache);
                }

        $stmt = $this->getDoctrine()
                     ->getConnection()
                     ->prepare($this->sql_array['signin_action1']);
        $stmt->bindParam(1,$json_array['signin_useremail']);
        $stmt->execute();
        $result=$stmt->fetchAll();
        
        //VarDumper::dump(array('$result[\'userpassword\']'=>$result));
        if (isset($result[0]['user_email'])){
            //VarDumper::dump(array('$result[0][\'userpassword\']'=>$result[0]['userpassword'],' $authorization_parameters[\'login\'].$authorization_parameters[\'password\']'=>$authorization_parameters['login'].$authorization_parameters['password']));
            //такой email уже существует
            if ($result[0]['user_email']==$json_array['signin_useremail']) {
                return 0;
            }
        } else {
            //заводим нового пользователя
            $stmt = $this->getDoctrine()
                         ->getConnection()
                         ->query($this->sql_array['signin_action2']);
            return 1;
        }
    }
    
    //читаем данные из сессии о кеше
    public function GetCache($request){
        //проверяем что пришло в сессии
        if ($request->hasSession()) {
            $this->session=$request->getSession();
            $this->cacheDriver=$this->session->get('cacheDriver',array());
        if (!isset($this->cacheDriver))
            $this->cacheDriver = new \Doctrine\Common\Cache\ArrayCache();
        }
    }
}