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
use Symfony\Component\HttpFoundation\JsonResponse;

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

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
use Symfony\Component\Form\Extension\Core\Type\EmailType;

use SwiftMailer;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

use IpoetryBundle\Controller\Abstracts\LoggingController;
/**
 * Description of IndexController
 *главный контроллер с общей лентой постов и стихов
 * @author d.krasavin
 */
class IndexController extends LoggingController
{
    //массив запросов к БД
    private $sql_array=array('get_daily_poetry_rating'=>'CALL poetry_rating_calc(:poetry)',
                            'get_daily_user_rating'=>'CALL user_rating_calc(:user)',
                            'delete_user_subscriber_action'=>'DELETE FROM ipoetry_user_followed_by WHERE ipoetry_user_followed_by_id=:follow AND ipoetry_user_user_id=:subscriber',
                            );

    public function indexAction(Request $request){
        if ($request->hasSession()) {
            $this->session=$request->getSession();
            varDumper::dump(array('request'=>$request,'session'=>$this->session,'login'=>$this->session->get('login'),'vk_access_token'=>$this->session->get('vk_access_token')));
            $user_short_info=array($this->session->get('user_photo_url'),$this->session->get('user_name'),$this->session->get('user_lastname'));
            $retval=$this->render('IpoetryBundle:Default:index.html.twig',array('user_short_info'=>$user_short_info));
        }
        else
            $retval=$this->render('IpoetryBundle:Default:index.html.twig');
         return $retval;
    }
    public function modalAction(Request $request,$user,$poetry){
        $retval=$this->render('IpoetryBundle::modaldemo.html.twig',array('userid'=>$user,'poetryid'=>$poetry));
        return $retval;
    }
    //распределитель ajax логики
    public function MainAjaxAction (Request $request){
      //по полученном параметрам делаем запрос в базу узнать что такой пользователь существует
        $mas=array();
        $this->request=$request;
        $authorization_parameters=@json_decode($request->getContent(),true);
        Vardumper::dump(array('$request'=>$request->getContent(),'isset_auth_parameter'=>isset($authorization_parameters),'authorization_parameters'=>$authorization_parameters));
        if (isset($authorization_parameters)){
            //проверяем что пришло в сессии
            $this->GetCache($request);
            //в зависимости от типа запроса выполняем логику работы с БД
            if (isset($authorization_parameters['type']))
            switch ($authorization_parameters['type']){
                    case 'get_all_newsfeed':
                                $mas=$this->GetAllNewsFeedAjaxAnswer($authorization_parameters,$request);
                                break;
                    case 'poetrysearch':
                                $mas=$this->PoetrySearchAjaxAnswer($authorization_parameters,$request);
                                break;
                    case 'get_users':
                                $mas=$this->GetUsersAjaxAnswer($authorization_parameters,$request);
                                break;
                    case 'get_cities':
                                $mas=$this->GetCitiesAjaxAnswer($request);
                                break;
                    case 'unsubscribe':
                                $mas=$this->UnsubscribeAjaxAnswer($authorization_parameters,$request);
                                break;
                    case 'close_session':
                                $mas=$this->CloseSessionAjaxAnswer();
                                break;
            }
        } else
            $mas['result']=0;
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
    //распределитель ajax логики
    public function MainRatingsAjaxAction (Request $request){
      //по полученном параметрам делаем запрос в базу узнать что такой пользователь существует
        //$mas=array();
        $this->request=$request;
        $authorization_parameters=@json_decode($request->getContent(),true);
        Vardumper::dump(array('$request'=>$request->getContent(),'isset_auth_parameter'=>isset($authorization_parameters),'authorization_parameters'=>$authorization_parameters,'$authorization_parameters_type'=>$authorization_parameters['type']));
        if (isset($authorization_parameters)){
            //проверяем что пришло в сессии
            $this->GetCache($request);
            //в зависимости от типа запроса выполняем логику работы с БД
            if (isset($authorization_parameters['type']))
                switch ($authorization_parameters['type']){
                        case 'get_usersratings':
                                    $mas=$this->GetUsersRatingsAjaxAnswer($authorization_parameters,$request);
                                    break;
                        case 'get_poetriesratings':
                                    $mas=$this->GetPoetriesRatingsAjaxAnswer($authorization_parameters,$request);
                                    break;

                }
        } else
            $mas['result']=0;
        VarDumper::dump($mas);
        $response = new JsonResponse();
        $response->setData($mas);
        return $response;
        //return new Response(json_encode($mas));  
    }
    //получение общей ленты новостей стихов
    public function GetAllNewsFeedAjaxAnswer($authorization_parameters,$request){
        $this->request=$request;
        //читаем данные по стихотворению по данным в параметрах url
        $stmt='';
        //проверяем что пришло в сессии
        $this->GetCache($request);

        if ($request->hasSession()) {

            VarDumper::dump(array('cache'=>$this->cacheDriver,'user'=>$authorization_parameters['user'],'datapart'=>$authorization_parameters['datapart']));

            $this->session=$request->getSession();
            $unewsfeed = $this->getDoctrine()->getEntityManager();
            if ($this->session->has('login')){
                //получаем кол-во записей
                $query=$unewsfeed->createQuery('SELECT COUNT(ip.poetryId) FROM IpoetryBundle\Entity\IpoetryPoetry ip JOIN ip.ipoetryUserUser usr');
                    
                $userfeedcnt=$query->getResult();
                
                //Если спросили большим значением возвращаем оставшее кол-во записей
                $intervals=ceil($userfeedcnt[0][1]/$this->getParameter('ipoetry.uprofilenewsfeedlimit'));
                if ($authorization_parameters['datapart']>0 && $authorization_parameters['datapart']<=$intervals ){
                    $ostatok=round($userfeedcnt[0][1]/10,0,PHP_ROUND_HALF_UP);
                    $datapart=abs($intervals-$authorization_parameters['datapart'])*$this->getParameter('ipoetry.uprofilenewsfeedlimit');
                    $ostatok_1=$userfeedcnt[0][1]-$datapart;
                    $datapart+=$ostatok_1;
                    //получаем список стихов
                    $query=$unewsfeed->createQuery('SELECT DISTINCT ip.poetryId,usr.userId FROM IpoetryBundle\Entity\IpoetryPoetry ip JOIN ip.ipoetryUserUser usr ORDER BY ip.poetryCreatedAt DESC')
                            ->setFirstResult((($this->getParameter('ipoetry.uprofilenewsfeedlimit')*$authorization_parameters['datapart'])-$this->getParameter('ipoetry.uprofilenewsfeedlimit')))
                            ->setMaxResults($this->getParameter('ipoetry.uprofilenewsfeedlimit'));
                    $userfeedpoetry=$query->getResult();

                    foreach ($userfeedpoetry as $userfeedpoetryitem){
                        $feedlist[]=$this->uNewsFeedEntityAction($request,$userfeedpoetryitem['userId'],$userfeedpoetryitem['userId'],$userfeedpoetryitem['poetryId'],'JSON');
                    }
                    
                    VarDumper::dump(array('$userfeedcnt'=>$userfeedcnt[0][1],
                        'uprofilenewsfeedlimit'=>$this->getParameter('ipoetry.uprofilenewsfeedlimit'),
                        '$userfeedpoetry'=>$userfeedpoetry,
                        'setFirstResult'=>(($this->getParameter('ipoetry.uprofilenewsfeedlimit')*$authorization_parameters['datapart'])-$this->getParameter('ipoetry.uprofilenewsfeedlimit')),
                        'setMaxResults'=>$this->getParameter('ipoetry.uprofilenewsfeedlimit')*$authorization_parameters['datapart'],
                        '$intervals'=>$intervals,
                        'datapart'=>$authorization_parameters['datapart'],
                        '$ostatok'=>$ostatok,
                        'datapart_1'=>abs($intervals-$authorization_parameters['datapart'])*$this->getParameter('ipoetry.uprofilenewsfeedlimit'),
                        '$feedlist'=>$feedlist));
                    
                    return array('result'=>$datapart,
                                 'newsfeed'=>$feedlist,
                                 'unewsfeedcount'=>$userfeedcnt[0][1],
                                 'unewsfeedlist'=>$feedlist);
                } else
                    return array('result'=>false);
            } else {
                //получаем кол-во записей
                $query=$unewsfeed->createQuery('SELECT COUNT(ip.poetryId) FROM IpoetryBundle\Entity\IpoetryPoetry ip JOIN ip.ipoetryUserUser usr');
                    
                $userfeedcnt=$query->getResult();
                
                //Если спросили большим значением возвращаем оставшее кол-во записей
                $intervals=ceil($userfeedcnt[0][1]/$this->getParameter('ipoetry.uprofilenewsfeedlimit'));
                if ($authorization_parameters['datapart']>0 && $authorization_parameters['datapart']<=$intervals ){
                    $ostatok=round($userfeedcnt[0][1]/10,0,PHP_ROUND_HALF_UP);
                    $datapart=abs($intervals-$authorization_parameters['datapart'])*$this->getParameter('ipoetry.uprofilenewsfeedlimit');
                    $ostatok_1=$userfeedcnt[0][1]-$datapart;
                    $datapart+=$ostatok_1;
                    //получаем список стихов
                    $query=$unewsfeed->createQuery('SELECT DISTINCT ip.poetryId,usr.userId FROM IpoetryBundle\Entity\IpoetryPoetry ip JOIN ip.ipoetryUserUser usr')
                            ->setFirstResult((($this->getParameter('ipoetry.uprofilenewsfeedlimit')*$authorization_parameters['datapart'])-$this->getParameter('ipoetry.uprofilenewsfeedlimit')))
                            ->setMaxResults($this->getParameter('ipoetry.uprofilenewsfeedlimit'));
                    $userfeedpoetry=$query->getResult();

                    foreach ($userfeedpoetry as $userfeedpoetryitem){
                        $feedlist[]=$this->uNewsFeedEntityAction($request,$userfeedpoetryitem['userId'],$userfeedpoetryitem['userId'],$userfeedpoetryitem['poetryId'],'JSON');
                    }
                    
                    VarDumper::dump(array('$userfeedcnt'=>$userfeedcnt[0][1],
                        'uprofilenewsfeedlimit'=>$this->getParameter('ipoetry.uprofilenewsfeedlimit'),
                        '$userfeedpoetry'=>$userfeedpoetry,
                        'setFirstResult'=>(($this->getParameter('ipoetry.uprofilenewsfeedlimit')*$authorization_parameters['datapart'])-$this->getParameter('ipoetry.uprofilenewsfeedlimit')),
                        'setMaxResults'=>$this->getParameter('ipoetry.uprofilenewsfeedlimit')*$authorization_parameters['datapart'],
                        '$intervals'=>$intervals,
                        'datapart'=>$authorization_parameters['datapart'],
                        '$ostatok'=>$ostatok,
                        'datapart_1'=>abs($intervals-$authorization_parameters['datapart'])*$this->getParameter('ipoetry.uprofilenewsfeedlimit'),
                        '$feedlist'=>$feedlist));
                    
                    return array('result'=>$datapart,
                                 'newsfeed'=>$feedlist,
                                 'unewsfeedcount'=>$userfeedcnt[0][1],
                                 'unewsfeedlist'=>$feedlist);
                } else
                    return array('result'=>false);
            }
        }        
    }
    // просмотр ленты всех стихов и комментариев
    public function uNewsFeedAllAction(Request $request){
        //количество стихов в своей ленте
        $userfeedcnt=array(0=>array(1=>0));
        //данные по подписчикам и подписантам
        $subscribers=array();
        $followers=array();
        //получаем данные по пользователю для шапки страницы
        $userheaderInfo=$this->UserHeaderInfo($request);
        //получаем данные по пользователю владельцу профайла
        $this->request=$request;
        //получаем перевод всех элементов интерфейса
        $this->GetTranslator($request);
        //директория для хранения временных файлов
        $uploadtmp=$this->request->server->get('DOCUMENT_ROOT').$this->request->server->get('BASE').'/uploadtmp';        
        //проверяем что пришло в сессии
        $this->GetCache($request);

        if ($request->hasSession()) {

            $this->session=$request->getSession();
            //$userentity = $this->getDoctrine()->getManager();
            if ($this->session->has('login') && $this->session->has('login_id')){
            }
        }
        //выбираем рейтинг стихов
        $authorization_parameters=array('period'=>'week');
        $userrating=$this->GetUsersRatingsAjaxAnswer($authorization_parameters,$request);
        if ($userrating['result']<>0){
            $userrating['usersratings']=array_slice($userrating['usersratings'], 0, 1);
        }
        $usersratingcnt=count($userrating['usersratings']);
        VarDumper::dump(array('userrating'=>$userrating));
        $uprofilenewsfeedlimit=$this->getParameter('ipoetry.uprofilenewsfeedlimit');
        return $this->render('IpoetryBundle:Main:unewsfeed_all.html.twig',array('userheaderInfo'=>$userheaderInfo[0],
            //'userprofileowner'=>$userentities[0],
            'uprofilenewsfeedlimit'=>$uprofilenewsfeedlimit,
            'MoreFeeds'=>$this->translator->trans('More comments',array(),'userprofile'),
            //'userfeedcnt'=>$userfeedcnt[0][1],
            //'subscribers'=>$subscribers,
            //'followers'=>$followers,
            'userrating'=>$userrating,
            //'poetryratingcnt'=>$poetryratingcnt
            ));

    }
    // страница поиска стихов и сообщений по темам и названиям
    public function pSearchAction(Request $request){
        return $this->render('IpoetryBundle:Main:psearch.html.twig',array('poetrysearchlimit'=>$this->getParameter('ipoetry.poetrysearchlimit')));
    }
    //выполнение процедуры подсчета рейтинга стихов
    public function DailyPoetryRatingAction(Request $request){
        //записываем данные по рейтингам стихов (ежедневно)
        //допустимо передавать либо id стиха либо значение ALL в случае всех стихов
        $stmt = $this->getDoctrine()
                     ->getConnection()
                     ->prepare($this->sql_array['get_daily_poetry_rating']);
        $stmt->bindValue(':poetry','ALL');
        $stmt->execute();
        //$result=$stmt->fetchAll();
        //if ($result[0]['saved']==1){
            $curdate=getdate();
            return new Response('Дневная статистика за '.  $curdate['mday'].'-'.$curdate['mon'].'-'.$curdate['year'].' сохранена');            
        //}
    }
    //выполнение процедуры подсчета рейтинга стихов
    public function DailyUserRatingAction(Request $request){
        //записываем данные по рейтингам пользователей (ежедневно)
        //допустимо передавать либо id стиха либо значение ALL в случае всех стихов
        $stmt = $this->getDoctrine()
                     ->getConnection()
                     ->prepare($this->sql_array['get_daily_user_rating']);
        $stmt->bindValue(':user','ALL');
        $stmt->execute();
        //$result=$stmt->fetchAll();
        //if ($result[0]['saved']==1){
            $curdate=getdate();
            return new Response('Дневная статистика за '.  $curdate['mday'].'-'.$curdate['mon'].'-'.$curdate['year'].' сохранена');            
        //}
    }
    //страница вывода рейтингов пользователей
    public function UserRatingAction(Request $request){
        //в request может приходить день,месяц,год
        $this->request=$request;
        //читаем данные по стихотворению по данным в параметрах url
        $stmt='';
        //проверяем что пришло в сессии
        $this->GetCache($request);

        if ($request->hasSession()) {

            $this->session=$request->getSession();
            $urating = $this->getDoctrine()->getEntityManager();

            if ($this->session->has('login')) {
                //в зависимости от полученного параметра получаем пользователи и рейтинги 
                $uratingcnt = $urating->getRepository('IpoetryBundle:DailyUserRating')
                    ->getCountRating();  
                //$uratingcnt=$query->getResult();
                /*
                //получаем список пользователей
                $query=$urating->createQuery('SELECT DISTINCT usr.userId,usr.userName,usr.userLastname,usr.userCity,usr.userPhoto FROM IpoetryBundle\Entity\IpoetryUser usr')
                        ->setFirstResult(1)
                        ->setMaxResults($this->getParameter('ipoetry.userratinglimit'));
                */
                if ($uratingcnt[0][1]>0){
                    $uratings=$urating->getRepository('IpoetryBundle:DailyUserRating')
                    ->getLatestRating($this->getParameter('ipoetry.userratinglimit'));
                    VarDumper::dump(array('$uratingcnt'=>$uratingcnt,'$uratings'=>$uratings,'ipoetry.userratinglimit'=>$this->getParameter('ipoetry.userratinglimit')));
                } else
                    $uratings=array();
                return $this->render('IpoetryBundle:Main:urating.html.twig',array('urating'=>$uratings));
            }
        }
    }

    //страница вывода рейтингов пользователей
    public function PoetryRatingAction(Request $request){

        //в request может приходить день,месяц,год
        $this->request=$request;
        //читаем данные по стихотворению по данным в параметрах url
        $stmt='';
        $uploadtmp=$request->server->get('DOCUMENT_ROOT').$request->server->get('BASE').'/uploadtmp';
        //проверяем что пришло в сессии
        $this->GetCache($request);

        if ($request->hasSession()) {

            $this->session=$request->getSession();
            $prating = $this->getDoctrine()->getEntityManager();

            if ($this->session->has('login')) {
                //в зависимости от полученного параметра получаем пользователи и рейтинги 
                $pratingcnt = $prating->getRepository('IpoetryBundle:DailyPoetryRating')
                    ->getCountRating();  

                if ($pratingcnt[0][1]>0){
                    $pratings=$prating->getRepository('IpoetryBundle:DailyPoetryRating')
                    ->getLatestRating($this->getParameter('ipoetry.PoetryRatingLimit'));
                    $cnt=0;
                    foreach($pratings as $pratingsitem) {
                        $poetry=$pratingsitem['poetryId'];
                        $uploadtmpfile=$uploadtmp.'/poetry_rating_'.$poetry.'.jpeg';
                        $urltmpfile=$request->server->get('BASE').'/uploadtmp/poetry_rating_'.$poetry.'.jpeg';
                        //тольков в случае если такого файла нет пишем в него данные из базы
                        
                        if (!file_exists ($uploadtmpfile) && !empty($pratingsitem['ipoetryBackgroundImage'])){
                            $fp=fopen($uploadtmpfile, 'w+');
                            $bytes = @fwrite($fp,stripslashes(stream_get_contents($pratingsitem['ipoetryBackgroundImage'])));
                            if ($bytes === false || $bytes <= 0)
                                throw new NotFoundHttpException();
                            fclose($fp);
                        }
                        $pratings[$cnt]['ipoetryBackgroundImage']='';
                        $pratings[$cnt]['image_url']=$urltmpfile;
                        $cnt++;
                        //VarDumper::dump(array($poetry,$urltmpfile,$uploadtmpfile,$pratingsitem['ipoetryBackgroundImage']));
                    }
                    
                    //VarDumper::dump(array('$pratingcnt'=>$pratingcnt,'$pratings'=>$pratings,'ipoetry.poetryratinglimit'=>$this->getParameter('ipoetry.poetryratinglimit'),'$uploadtmp'=>$uploadtmp));
                } else
                    $pratings=array();
                return $this->render('IpoetryBundle:Main:prating.html.twig',array('prating'=>$pratings));
            }
        }        
        
    }    
    public function PoetrySearchAjaxAnswer($authorization_parameters,$request){
        $this->request=$request;
        //читаем данные по стихотворению по данным в параметрах url
        $stmt='';
        //проверяем что пришло в сессии
        $this->GetCache($request);

        if ($request->hasSession()) {

            VarDumper::dump(array('cache'=>$this->cacheDriver));

            $this->session=$request->getSession();
            $psearchfeed = $this->getDoctrine()->getEntityManager();
            //получаем кол-во записей
            $query=$psearchfeed->createQuery('SELECT COUNT(ip.poetryId) FROM IpoetryBundle\Entity\IpoetryPoetry ip JOIN ip.ipoetryUserUser usr WHERE ip.poetryTitle LIKE ?1');
            $query->setParameter(1,"%".$authorization_parameters['phrase']."%" );
            $psearchfeedcnt=$query->getResult();
                VarDumper::dump(array('$psearchfeedcnt[0][1]'=>$psearchfeedcnt[0][1]));
            //Если спросили большим значением возвращаем оставшее кол-во записей
            $intervals=ceil($psearchfeedcnt[0][1]/$this->getParameter('ipoetry.poetrysearchlimit'));
            if ($authorization_parameters['datapart']>0 && $authorization_parameters['datapart']<=$intervals ){
                $ostatok=round($psearchfeedcnt[0][1]/10,0,PHP_ROUND_HALF_UP);
                $datapart=abs($intervals-$authorization_parameters['datapart'])*$this->getParameter('ipoetry.poetrysearchlimit');
                $ostatok_1=$psearchfeedcnt[0][1]-$datapart;
                $datapart+=$ostatok_1;
                //получаем список стихов
                $query=$psearchfeed->createQuery('SELECT DISTINCT ip.poetryId,usr.userId FROM IpoetryBundle\Entity\IpoetryPoetry ip JOIN ip.ipoetryUserUser usr WHERE ip.poetryTitle LIKE ?1')
                        ->setFirstResult((($this->getParameter('ipoetry.poetrysearchlimit')*$authorization_parameters['datapart'])-$this->getParameter('ipoetry.poetrysearchlimit')))
                        ->setMaxResults($this->getParameter('ipoetry.poetrysearchlimit'))
                        ->setParameter(1,"%".$authorization_parameters['phrase']."%" );
                $psearchfeed=$query->getResult();

                foreach ($psearchfeed as $psearchfeeditem){
                    $psearchfeedlist[]=$this->uNewsFeedEntityAction($request,$psearchfeeditem['userId'],$psearchfeeditem['userId'],$psearchfeeditem['poetryId'],'JSON');
                }
                /*
                VarDumper::dump(array('$userfeedcnt'=>$userfeedcnt[0][1],
                    'uprofilenewsfeedlimit'=>$this->getParameter('ipoetry.uprofilenewsfeedlimit'),
                    '$userfeedpoetry'=>$userfeedpoetry,
                    'setFirstResult'=>(($this->getParameter('ipoetry.uprofilenewsfeedlimit')*$authorization_parameters['datapart'])-$this->getParameter('ipoetry.uprofilenewsfeedlimit')),
                    'setMaxResults'=>$this->getParameter('ipoetry.uprofilenewsfeedlimit')*$authorization_parameters['datapart'],
                    '$intervals'=>$intervals,
                    'datapart'=>$authorization_parameters['datapart'],
                    '$ostatok'=>$ostatok,
                    'datapart_1'=>abs($intervals-$authorization_parameters['datapart'])*$this->getParameter('ipoetry.uprofilenewsfeedlimit'),
                    '$feedlist'=>$feedlist));
                */
                VarDumper::dump(array('psearchfeedlist'=>$psearchfeedlist));
                return array('result'=>1,
                             'psearchfeedlist'=>$psearchfeedlist);
            } else
                return array('result'=>0);
        }
    }
    public function SubscribersAction(Request $request,$user){
        //получаем данные по пользователю для шапки страницы
        $userheaderInfo=$this->UserHeaderInfo($request);
        $this->request=$request;
        $this->GetTranslator($request);
        $userhassubsribers=$this->UserURLInfo($request,$user);
        if (isset($userheaderInfo[0]) && isset($userhassubsribers[0]))
            VarDumper::dump(array($this->translator->trans('Follow',array(),'users'),'$userheaderInfo'=>$userheaderInfo[0],'$userhassubsribers'=>$userhassubsribers[0]));
        //$userheaderInfo=array('userId'=>-1,'userName'=>'undefined','userLastname'=>'undefined','userPhotoUrl'=>'undefined');

        return $this->render('IpoetryBundle:Main:users.html.twig',array('userslimit'=>$this->getParameter('ipoetry.userslimit'),
            'userheaderInfo'=>$userheaderInfo[0],
            'userhassubsribers'=>$userhassubsribers[0],
            'Follow'=>$this->translator->trans('Follow',array(),'users'),
            'Subscribers'=>$this->translator->trans('Subscribers',array(),'users'),
            'Remove Subscriber'=>$this->translator->trans('Remove Subscriber',array(),'users'),
            'More users'=>$this->translator->trans('More users',array(),'users'),
            'Remove Follow'=>$this->translator->trans('Remove Follow',array(),'users')));
    }
    //получение городов для фильтрации
    public function GetCitiesAjaxAnswer($request){
        //user:$scope.usertype,'datapart':$scope.page
        //в request может приходить день,месяц,год
        $this->request=$request;

        //проверяем что пришло в сессии
        $this->GetCache($request);

        $citiesfeed = $this->getDoctrine()->getEntityManager();
        //вытаскиваем города для фильтра
        $query=$citiesfeed->createQuery('SELECT DISTINCT city.cityId,city.cityName FROM IpoetryBundle\Entity\CityReference city');
        $cities=$query->getResult();
        foreach ($cities as $city){
            $cities_bootstrap[]=array('value'=>$city['cityId'],'label'=>$city['cityName']);
        }
        return array('result'=>1,'cities'=>$cities,'cities_bootstrap'=>$cities_bootstrap);
    }
    
    //удаляем подписчика у пользователя
    public function UnsubscribeAjaxAnswer($authorization_parameters,$request){
/*
    "user" => 16
    "unsubscribeuser" => "15"
    "usertype" => "follow"
 * 
    "user" => 16
    "unsubscribeuser" => "15"
    "usertype" => "subscribers"
 * 
 */
        if (strtoupper($authorization_parameters['usertype'])=='FOLLOW') {
            $stmt = $this->getDoctrine()
                        ->getConnection()
                        ->prepare($this->sql_array['delete_user_subscriber_action']);
            $stmt->bindValue(':follow',$authorization_parameters['unsubscribeuser']);
            $stmt->bindValue(':subscriber',$authorization_parameters['user']);
        }
        if (strtoupper($authorization_parameters['usertype'])=='SUBSCRIBERS') {
            $stmt = $this->getDoctrine()
                        ->getConnection()
                        ->prepare($this->sql_array['delete_user_subscriber_action']);
            $stmt->bindValue(':follow',$authorization_parameters['user']);
            $stmt->bindValue(':subscriber',$authorization_parameters['unsubscribeuser']);
        }

        $stmt->execute();
        VarDumper::dump(array($authorization_parameters));
        
        return $this->GetUsersAjaxAnswer($authorization_parameters,$request);
    }
    public function CloseSessionAjaxAnswer(){
        
        if ($this->has('session')){
            $request=new Request();
            $request->setSession($this->get('session'));
            VarDumper::dump(array($request));
            $loggeduser=$this->UserHeaderInfo($request);
            VarDumper::dump(array($loggeduser));            
            if ($loggeduser[0]['userId']==-1) {
                return array('result'=>0);
            } else {
                $this->get('session')->invalidate();
                return array('result'=>1);
            }            
        } else
            return array('result'=>0);
    }
}