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

use IpoetryBundle\Form\Type\UserLoginType;
use IpoetryBundle\Form\Type\UserSigninType;
use IpoetryBundle\Form\Type\UserRoomType;

use IpoetryBundle\Entity\UserSignin;
use IpoetryBundle\Entity\user;
use IpoetryBundle\Entity\UserRoom;
use IpoetryBundle\Entity\UserLogin;
use IpoetryBundle\Entity\IpoetryUser;
use IpoetryBundle\Entity\IpoetryUserAge;
use IpoetryBundle\Entity\IpoetryUserCity;
use IpoetryBundle\Entity\IpoetryUserPhone;
use IpoetryBundle\Entity\IpoetryUserPhoto;
use IpoetryBundle\Entity\IpoetryUserWebsite;
use IpoetryBundle\Entity\IpoetryUserStatus;
use IpoetryBundle\Entity\IpoetryUserGroup;
use IpoetryBundle\Entity\IpoetryUserBlogPost;
use IpoetryBundle\Entity\IpoetryIpoetry;
use IpoetryBundle\Entity\IpoetryEvent;

use IpoetryBundle\Controller\Abstracts\LoggingController;

/**
 * Description of uRoomController
 * @author d.krasavin
 * контроллер для личного кабинета пользователя
 */
class uRoomController extends LoggingController{
        //массив запросов к БД
        private $sql_array=array('login_action'=>'CALL get_ipoetry_user(?,?)',
                                 'signin_action1'=>'CALL get_ipoetry_user_email(?)',
                                 'signin_action2'=>'INSERT INTO ipoetry_user (user_name,user_password,user_lastname,user_email) VALUES(?,?,?,?)',
                                 'uroom_action1'=>'CALL get_ipoetry_user_room_info(:id)',
                                 'get_auto_increment'=>'SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = :db AND TABLE_NAME = :tbl',
                                 'add_ipoetry_user'=> 'CALL add_ipoetry_user(:ipoetry_user_name,:ipoetry_user_lastname,:ipoetry_user_city,:ipoetry_user_email,:ipoetry_user_password,:ipoetry_user_md5hash,:db_name,:tbl_name)');
                                 
        private $is_cache=false;
        
        public function uroomAction(Request $request){
        $stmt='';
        parent::loginAction($request);
        //проверяем что пришло в сессии
        $this->GetCache($request);
        VarDumper::dump(array('cache'=>$this->cacheDriver,'$is_cache='=>$this->is_cache,'request'=>$request,'login='=>$this->session->get('login')));

        if ($request->hasSession()) {
            $this->session=$request->getSession();
            //если есть обновленные поля то обновляем их
            if ($request->request->has('UserRoom')) {
                VarDumper::dump(array('UserRoom'=>$request->request->get('UserRoom')));
                //пишем обновленные данные в базу
                $uroom = $this->getDoctrine()->getManager();
                if ($this->session->has('login')){
                    //получаем связанные таблицы для обновления данных
                    $result=$uroom->getRepository('IpoetryBundle:IpoetryUser')->findOneBy(array('userEmail'=>$this->session->get('login')));
                    $result_age=$uroom->getRepository('IpoetryBundle:IpoetryUserAge')->findOneBy(array('ipoetryUserAgeId'=>$result->getUserId()));
                    $result_city=$uroom->getRepository('IpoetryBundle:IpoetryUserCity')->findOneBy(array('ipoetryCityId'=>$result->getUserId()));
                    $result_website=$uroom->getRepository('IpoetryBundle:IpoetryUserWebsite')->findOneBy(array('ipoetryUserWebsiteId'=>$result->getUserId()));
                    $result_phone=$uroom->getRepository('IpoetryBundle:IpoetryUserPhone')->findOneBy(array('ipoetryUserPhoneId'=>$result->getUserId()));
                    $result_photo=$uroom->getRepository('IpoetryBundle:IpoetryUserPhoto')->findOneBy(array('ipoetryUserPhotoId'=>$result->getUserId()));

                    foreach ($request->request->get('UserRoom') as $UserRoom_key=>$UserRoom_val){
                        if ($UserRoom_key=='username' && $UserRoom_val!=$result->getUserName())
                            $result->SetUserName($UserRoom_val);
                        if ($UserRoom_key=='userlastname' && $UserRoom_val!=$result->getUserLastname())
                            $result->SetUserLastname($UserRoom_val);
                        if ($UserRoom_key=='userpassword' && $UserRoom_val!=$result->getUserPassword())
                            $result->setUserPassword($UserRoom_val);
                        if ($UserRoom_key=='usercity' && $UserRoom_val!=$result->getUserCity()->getCityName()){
                            $result_city->setCityName($UserRoom_val);
                            $result->setUserCity($result_city);
                        }
                        if ($UserRoom_key=='userage' && $UserRoom_val!=$result->getUserAge()->getIpoetryUserAge()){
                            $result_age->setIpoetryUserAge($UserRoom_val);
                            $result->setUserAge($result_age);                   
                        }
                        if ($UserRoom_key=='userwebsite' && $UserRoom_val!=$result->getUserWebsite()->getIpoetryUserWebsite()){
                            $result_website->setIpoetryUserWebsite($UserRoom_val);
                            $result->setUserWebsite($result_website);
                        }
                        if ($UserRoom_key=='userphone' && $UserRoom_val!=$result->getUserPhone()->getIpoetryUserPhone()){
                            $result_phone->setIpoetryUserPhone($UserRoom_val);
                            $result->setUserPhone($result_phone);
                        }
                        if ($UserRoom_key=='userphoto' && $UserRoom_val!=$result->getUserPhoto()->getUserPhotoUrl()){
                            $result_photo->setUserPhotoUrl($UserRoom_val);
                            $result->setUserPhoto($result_photo);
                        }

                    }
                    $uroom->merge($result);
                    VarDumper::dump(array('uroom'=>$uroom,'result'=>$result));
                    $uroom->flush();
                }
            }
        }
        //стыкуем таблицу ipoetry_user с шаблоном личного кабинета
       /* 
        $stmt = $this->getDoctrine()
                     ->getConnection()
                     ->prepare($this->sql_array['uroom_action1']);
        if ($this->session->has('login'))
        $stmt->bindValue(':id',$this->session->get('login'));
        $stmt->execute();
        $result=$stmt->fetchAll();
        */

        $uroom = $this->getDoctrine()->getManager()
        ->getRepository('IpoetryBundle:IpoetryUser');
        if ($this->session->has('login')) {
            $result=$uroom->findOneBy(array('userEmail'=>$this->session->get('login')));
        }
        if (!isset($result)) {
            throw $this->createNotFoundException('No user found for email:'.$this->session->get('login'));
        }
        VarDumper::dump(array('result'=>$result));


        $options['data']['user_name']=$result->getUserName();
        $options['data']['user_lastname']=$result->getUserLastname();
        $options['data']['user_password']=$result->getUserPassword();
        $options['data']['user_email']=$result->getUserEmail();
        $options['data']['user_city']=$result->getUserCity()->getCityName();
        $options['data']['user_age']=$result->getUserAge()->getIpoetryUserAge();
        $options['data']['user_website']=$result->getUserWebsite()->getIpoetryUserWebsite();
        $options['data']['user_phone']=$result->getUserPhone()->getIpoetryUserPhone();
        $options['data']['user_photo']=$result->getUserPhoto()->getUserPhotoUrl();
        //пишем в сессию необходимые данные
        $this->session->set('user_photo_url',$options['data']['user_photo']);
        $this->session->set('user_name',$options['data']['user_name']);
        $this->session->set('user_lastname',$options['data']['user_lastname']);

        
/*
                ->add('username',TextType::class,array('attr' => array('maxlength' => 50,'required' => true,'placeholder'=>$translator->trans('John')),'label' => $translator->trans('Name'),'data'=>$options['data']['user_name']))//array('attr' => array('maxlength' => 50,'required' => true)))
                ->add('userlastname',TextType::class,array('attr' => array('maxlength' => 50,'required' => true,'placeholder'=>$translator->trans('Whatson')),'label' => $translator->trans('LastName'),'data'=>$options['data']['user_lastname']))//array('attr' => array('maxlength' => 50,'required' => true)))
                ->add('userpassword',PasswordType::class,array('attr' => array('maxlength' => 20,'required' => true,'placeholder'=>$translator->trans('Wha37on')),'label' => $translator->trans('Password'),'data'=>$options['data']['user_password']))
                ->add('useremail',EmailType::class,array('attr' => array('maxlength' => 255,'required' => true,'placeholder'=>$translator->trans('JWhatson@mail.ru')),'label' => $translator->trans('email'),'data'=>$options['data']['user_email']))//array('attr' => array('maxlength' => 50,'required' => true)))
                ->add('usercity',TextType::class,array('attr' => array('maxlength' => 255,'required' => true,'placeholder'=>$translator->trans('Москва')),'label' => $translator->trans('City'),'data'=>$options['data']['user_city']))//array('attr' => array('maxlength' => 50,'required' => true)))
                ->add('userage',IntegerType::class,array('attr' => array('maxlength' => 3,'required' => true,'placeholder'=>$translator->trans('30')),'label' => $translator->trans('Age'),'data'=>$options['data']['user_age']))//array('attr' => array('maxlength' => 50,'required' => true)))
                ->add('userwebsite',TextType::class,array('attr' => array('maxlength' => 2083,'required' => true,'placeholder'=>$translator->trans('vk.com/poetryguy87')),'label' => $translator->trans('website'),'data'=>$options['data']['user_website']))//array('attr' => array('maxlength' => 50,'required' => true)))
                ->add('userphone',TextType::class,array('attr' => array('maxlength' => 11,'required' => true,'placeholder'=>$translator->trans('+71019090101')),'label' => $translator->trans('phone number'),'data'=>$options['data']['user_phone']))
*/        
        VarDumper::dump(array('options'=>$options));
        //выводим форму
        $UserRoom=new UserRoom();
        $UserRoomType=new UserRoomType($this->get('router'),$this->session,$request);
                $form =$this->createForm($UserRoomType, $UserRoom, $options);
                $form->handleRequest($request);
        //картинка пользователя по умолчанию, тогда делаем знак вопроса
        if ($options['data']['user_photo']=='undefined')
            $options['data']['user_photo']=$this->getRequest()->getBasePath().'/images/question.jpg';
        //return new Response('тут отображается форма с данными о пользователе');                
        return $this->render('IpoetryBundle:uRoom:uroom.html.twig',array('form' => $form->createView(),'user_photo'=>$options['data']['user_photo']));
    }

    //распределитель ajax запросов по логированию и регистрации пользователей
    public function uroomajaxAction(Request $request){
        //по полученном параметрам делаем запрос в базу узнать что такой пользователь существует
        $mas=array();

        $authorization_parameters=@json_decode($request->get('login_json'),true);
        if (isset($authorization_parameters)){
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
        //VarDumper::dump(array('isset(cacheDriver)='=>isset($this->cacheDriver),'cacheDriver'=>$this->cacheDriver));
        //смотрим если данные в кеше уже есть тогда берем из кеша
        //$this->session->set( 'login_id',16 );
        if (isset($this->cacheDriver)){
            if ($this->cacheDriver->contains($json_array['login'].$json_array['password'])) {
                //использовали кеш
                $this->is_cache=true;
                if ($request->hasSession()) {
                    $this->session=$request->getSession();
                    $this->session->set('is_cache', $this->is_cache);
                    $this->session->set('login',$json_array['login'] );
                    if ($this->cacheDriver->contains('login_id')) {
                        $this->session->set( 'login_id',$this->cacheDriver->fetch('login_id') );                    
                    }
                }
                return 1;
            }
        }

        //без кеша
        $this->is_cache=false;
                if ($request->hasSession()) {
                    $this->session=$request->getSession();
                    $this->session->set('is_cache', $this->is_cache);
                }
        //читаем базу данных
        $stmt = $this->getDoctrine()
                     ->getConnection()
                     ->prepare($this->sql_array['login_action']);
        $stmt->bindParam(1,$json_array['login']);
        $stmt->bindParam(2,$json_array['password']);
        //$stmt->bindresult(3,$result[0]['userpassword']);
        $stmt->execute();
        //$stmt->query('SELECT @userpassword');
        //$stmt->fetchAll();
        $result=$stmt->fetchAll();
        //VarDumper::dump(array('$result='=>$result));

        //если есть что то в базе, то хорошо, будем писать в кеш
        if (isset($result[0]['userpassword'])){

            //VarDumper::dump(array('$result[0][\'userpassword\']'=>$result[0]['userpassword'],' $authorization_parameters[\'login\'].$authorization_parameters[\'password\']'=>$authorization_parameters['login'].$authorization_parameters['password']));
            //кешируем полученную информацию
            if (isset($this->cacheDriver)) {
                $this->cacheDriver->save($json_array['login'].$json_array['password'], 1);
                $this->cacheDriver->save('login_id',$result[0]['user_id']);
                if ($request->hasSession()) {
                    $this->session=$request->getSession();
                    $this->session->set('cacheDriver', $this->cacheDriver);
                }
            }
            //пара логин+пароль совпадает с базой.
            if ($result[0]['userpassword']==$json_array['login'].$json_array['password']) {
                //пишем в сессию данные о пользователе
                $this->session->set('login',$json_array['login']);
                $this->session->set('login_id',$result[0]['user_id']);
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
            $this->session=$request->getSession();
            $this->session->set('is_cache', $this->is_cache);
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
            //в случае захода через вконтакте и другие сети смотрим в сессии access_token если он есть
            if ($result[0]['user_email']==$json_array['signin_useremail']) {
                //тогда мы перенаправляем пользователя в личный кабинет без регистрации
                if ($this->session->has('vk_access_token')){
                    $this->session->set('login',$json_array['signin_useremail']);
                return 1;
                } else
                return 0;
            }
        } else {
            //заводим нового пользователя
            /*
            $stmt = $this->getDoctrine()
                         ->getConnection()
                         ->query($this->sql_array['signin_action2']);
             */
            //генерируем значение md5 для проверки пользователя по email
            $user_md5=parent::GetMd5hash($json_array['signin_username'].$json_array['signin_useremail'].random_int(1,9999));
            VarDumper::dump(array('user_md5='=>$user_md5));
            //заводим нового пользователя через хранимую процедуру
            $stmt = $this->getDoctrine()
                         ->getConnection()
                         ->prepare($this->sql_array['add_ipoetry_user']);
            $stmt->bindValue(':ipoetry_user_name',$json_array['signin_username']);
            $stmt->bindValue(':ipoetry_user_lastname',$json_array['signin_userlastname']);
            if (isset($json_array['signin_usercity']))
                $stmt->bindValue(':ipoetry_user_city',$json_array['signin_usercity']);
            else
                $stmt->bindValue(':ipoetry_user_city','undefined');                
            $stmt->bindValue(':ipoetry_user_email',$json_array['signin_useremail']);
            $stmt->bindValue(':ipoetry_user_password',$json_array['signin_userpassword']);
            $stmt->bindValue(':ipoetry_user_md5hash',$user_md5);
            $stmt->bindValue(':db_name','ipoetry');
            $stmt->bindValue(':tbl_name','ipoetry_user');
            $stmt->execute();
            $result=$stmt->fetchAll();            
            if ($request->hasSession()) {
                $this->session=$request->getSession();
                $this->session->set('login',$json_array['signin_useremail']);
                $this->session->set('login_id',$result[0][user_id]);
                
            }
            //шлем почту пользователю
            //$url_verify_param='5hrtGtdfjy';
            $this->SendVerificationMail($json_array['signin_username'],$json_array['signin_useremail'],$user_md5);
            /*
            //заводим нового пользователя через механизм doctrine
            $uroom = $this->getDoctrine()->getManager();
            //получаем связанные таблицы для обновления данных
            //$result=$uroom->getRepository('IpoetryBundle:IpoetryUser');
            $result=new IpoetryUser();
            $result->setUserName($json_array['signin_username']);
            $result->setUserLastname($json_array['signin_userlastname']);
            $result->setUserEmail($json_array['signin_useremail']);
            $result->setUserPassword($json_array['signin_userpassword']);
            $result->setUserParentId($result_ai[0]['AUTO_INCREMENT']);
            $result->setUserRatingId($result_ai[0]['AUTO_INCREMENT']);
            $result->setUserPostMessageId($result_ai[0]['AUTO_INCREMENT']);
            $result->setUserPoetryId($result_ai[0]['AUTO_INCREMENT']);
            $result->setUserEventId($result_ai[0]['AUTO_INCREMENT']);
            $result->setUserGroupId($result_ai[0]['AUTO_INCREMENT']);
            $result->setUserGroupId($result_ai[0]['AUTO_INCREMENT']);            
            $uroom->persist($result);
            $uroom->flush();
             */
            return 1;
        }
    }
    
    public function SendVerificationMail($user_name=null,$email=null,$url_verify_param=null) {
    $message = \Swift_Message::newInstance()
            ->setSubject('Подтверждение регистрации на сайте iPoetry')
            ->setFrom('ipoetry.rus@gmail.com')
            ->setTo($email)
            ->setBody(
                $this->renderView(
                    'IpoetryBundle:Emails:registration.html.twig',
                    array('name' => $user_name,'url'=>$this->getParameter('ipoetry.UserEmailAuthUrl'),'url_verify_param'=>$url_verify_param)
                ),
                'text/html'
            );
        $this->get('mailer')->send($message);
    }

}