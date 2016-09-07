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
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\ArrayLoader;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Component\Translation\MessageSelector;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Component\Yaml\Yaml;

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
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\EntityManager;
use IpoetryBundle\Form\Type\UserPoetryCreationType;
use IpoetryBundle\Entity\IpoetryUserBlogPost;
use IpoetryBundle\Entity\IpoetryPoetry;
use IpoetryBundle\Entity\IpoetryUser;
use IpoetryBundle\Entity\IpoetryTags;
use IpoetryBundle\Entity\IpoetryUserFollowedBy;
use IpoetryBundle\Entity\PoetryRepostToOwnFeed;
use IpoetryBundle\Entity\IpoetryPoetryUserRepostView;
use IpoetryBundle\Entity\PoetryLike;
use IpoetryBundle\Entity\PoetryDisLike;
use IpoetryBundle\Entity\CommentLike;
use IpoetryBundle\Entity\CommentDisLike;

use IpoetryBundle\CustomClasses\UploadHandler;

use IpoetryBundle\Controller\Abstracts\LoggingController;
/**
 * Description of uProfileControler
 * контролер для "стены пользователя" (посты) и вспомогательных
 * страниц типа создания стихотворения,группы пользователей,события 
 * @author d.krasavin
 */
class uProfileController extends LoggingController {
    //массив запросов к БД
    private $sql_array=array('add_ipoetry_user_post'=>'CALL add_ipoetry_user_post(:ipoetry_user_email,:ipoetry_user_post_title,:ipoetry_user_post,:ipoetry_user_post_text,:ipoetry_user_post_image,:ipoetry_user_post_ext,:ipoetry_user_post_tags,:ipoetry_user_post_tags_text,:ipoetry_comment)',
                            'add_ipoetry_user_message'=>'CALL add_ipoetry_user_message(:ipoetry_user_email,:ipoetry_message,:ipoetry_message_ext)',
                            'add_ipoetry_user_follower'=>'CALL add_ipoetry_user_follower(:ipoetry_user_login,:ipoetry_user_follower)',
                            'del_ipoetry_user_follower'=>'CALL del_ipoetry_user_follower(:ipoetry_user_login,:ipoetry_user_follower)',
                            'del_ipoetry_user_post'=>'CALL del_ipoetry_user_post(:ipoetry_poetry_id)',
                            'add_ipoetry_user_comment'=>'CALL add_ipoetry_user_comment(:ipoetry_user_id,:ipoetry_user_comment_text,:ipoetry_user_comment_ext,:ipoetry_poetry_id,:ipoetry_comment_parent_id)',
                            'add_ipoetry_poem_comment_like'=>'CALL add_ipoetry_poem_comment_like(:ipoetry_user_id,:ipoetry_poem_id,\'UP\')',
                            'add_ipoetry_poem_comment_dislike'=>'CALL add_ipoetry_poem_comment_like(:ipoetry_user_id,:ipoetry_poem_id,\'DOWN\')',
                            'add_ipoetry_poetry_like'=>'CALL add_ipoetry_poetry_like(:ipoetry_user_id,:ipoetry_poetry_id,\'UP\')',
                            'add_ipoetry_poetry_dislike'=>'CALL add_ipoetry_poetry_like(:ipoetry_user_id,:ipoetry_poetry_id,\'DOWN\')',
                            'add_user_status'=>'CALL add_user_status(:ipoetry_user_id,:status_text)');

    public function uProfileAction (Request $request){
        $options=array();
        /*
        $upload_handler = new UploadHandler(array(
        'download_via_php' => true
        ));
         */
        //подготавливаем данные для вывода существующих тегов для стихотворения
        $tagsselectentity = $this->getDoctrine()->getManager();
        $result['tagsselect']=$tagsselectentity->getRepository('IpoetryBundle:IpoetryTags')->findBy(array('moderated'=>0),array('tagsText' => 'ASC'));
        for ($i=0;$i<count($result['tagsselect']);$i++){
            $options['data'][$result['tagsselect'][$i]->getIpoetryTagsTagsId()]=$result['tagsselect'][$i]->getTagsText();//array($key,$value->get('tagstext'));
        }
        VarDumper::dump(array($options,count($result['tagsselect'])));
        //выводим форму
        $IpoetryUserBlogPost=new IpoetryUserBlogPost();
        $UserPoetryCreationType=new UserPoetryCreationType($this->get('router'),$this->session,$request);
        $form =$this->createForm($UserPoetryCreationType, null, $options);
        $form->handleRequest($request);
        
        return $this->render('IpoetryBundle:uRoom:uprofile.html.twig',array('poetry_creation_form' => $form->createView()));
    }
    //создание стихотворения
    public function AddPoemAction (Request $request){
        
        $options=array();
        //получаем данные по пользователю для шапки страницы
        $userheaderInfo=$this->UserHeaderInfo($request);
        $translator = new Translator($request->getLocale(), new MessageSelector());
        $translator->addLoader('yaml',new YamlFileLoader());
        $translator->addResource('yaml',$this->getTranslatorPath($request).'/poetrycreation.ru.yml', 'ru_RU','poetrycreation');

        /*
        $upload_handler = new UploadHandler(array(
        'download_via_php' => true
        ));
         */
        //подготавливаем данные для вывода существующих тегов для стихотворения
        $tagsselectentity = $this->getDoctrine()->getManager();
        $result['tagsselect']=$tagsselectentity->getRepository('IpoetryBundle:IpoetryTags')->findBy(array('moderated'=>0),array('tagsText' => 'ASC'));
        $options['data'][-1]=$translator->trans('Tags',array(),'poetrycreation');
        for ($i=0;$i<count($result['tagsselect']);$i++){
            $options['data'][$result['tagsselect'][$i]->getIpoetryTagsTagsId()]=$result['tagsselect'][$i]->getTagsText();//array($key,$value->get('tagstext'));
        }
        VarDumper::dump(array($request->server->get('DOCUMENT_ROOT'),$translator,$options,count($result['tagsselect'])));
        //выводим форму
        $IpoetryUserBlogPost=new IpoetryUserBlogPost();
        $UserPoetryCreationType=new UserPoetryCreationType($this->get('router'),$this->session,$request);
        $form =$this->createForm($UserPoetryCreationType, null, $options);
        $form->handleRequest($request);
        return $this->render('IpoetryBundle:uRoom:addpoem.html.twig',array('poetry_creation_form' => $form->createView(),'userheaderInfo'=>$userheaderInfo[0],));
    }

    //распределитель ajax логики
    public function uProfileAjaxAction (Request $request){
      //по полученном параметрам делаем запрос в базу узнать что такой пользователь существует
        $mas=array();
        $this->request=$request;
        if ($this->has('session')){
            $this->request->setSession($this->get('session'));
        }
        $authorization_parameters=@json_decode($request->get('login_json'),true);
        Vardumper::dump(array('$request'=>json_decode($request->get('login_json')),'isset_auth_parameter'=>isset($authorization_parameters),'authorization_parameters'=>$authorization_parameters));
        if (isset($authorization_parameters)){
            //проверяем что пришло в сессии
            $this->GetCache($request);
            //в зависимости от типа запроса выполняем логику работы с БД
            if (isset($authorization_parameters['type']))
        switch ($authorization_parameters['type']){
                case 'new_poetry':
                            $mas['result']=$this->NewPoetryAjaxAnswer($authorization_parameters,$request);
                            break;
                case 'new_message':
                            $mas['result']=$this->NewMessageAjaxAnswer($authorization_parameters,$request);
                            break;
                case 'get_user_feed_info':
                            $mas=$this->getUserFeedInfoAjaxAnswer($authorization_parameters,$request);
                            break;
                case 'get_user_own_profile':
                            $mas['result']=$this->GetUserOwnprofileAjaxAnswer($authorization_parameters,$this->request);
                            break;
                case 'get_user_subscribed_status':
                            $mas['result']=$this->GetUserSubscribedStatusAjaxAnswer($authorization_parameters,$request);
                            break;
                case 'add_you_followedby_profileowner':
                            $mas['result']=$this->AddYouFollowedbyProfileowner($authorization_parameters,$request);
                            break;
                case 'del_you_followedby_profileowner':
                            $mas['result']=$this->DelYouFollowedbyProfileowner($authorization_parameters,$request);
                            break;
                case 'get_followers_user_feed_info':
                            $mas=$this->getFollowersUserFeedInfoAjaxAnswer($authorization_parameters,$request);
                            break;
                case 'set_user_session_closed':
                            $mas['result']=$this->setUserSessionClosedAjaxAnswer($authorization_parameters,$request);
                            break;
        }

        } else if ($request->headers->has('content-type')) {
            $mas['result']=$this->FileUploadAjaxAnswer($request,'poetry');
        } else
            $mas['result']=0;
        VarDumper::dump(array($mas));
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
    public function NewPoetryCommentAjaxAction (Request $request){
        //по полученном параметрам делаем запрос в базу узнать что такой пользователь существует
        $mas=array();
        $this->request=$request;
        Vardumper::dump(array('$request'=>$request->getContent()));
        if ($this->request->headers->has('content-type')) {
            $mas['result']=$this->FileUploadAjaxAnswer($this->request,'NEWPOETRYCOMMENT');
        } else
            $mas['result']=0;
        VarDumper::dump($mas);
        $response = new JsonResponse();
        $response->setData($mas);
        return $response;
    }
    //распределитель ajax логики
    public function NewMessageAjaxAction (Request $request){
        //по полученном параметрам делаем запрос в базу узнать что такой пользователь существует
        $mas=array();
        $this->request=$request;
        Vardumper::dump(array('$request'=>$request->getContent()));
        if ($this->request->headers->has('content-type')) {
            $mas['result']=$this->FileUploadAjaxAnswer($this->request,'NEWMESSAGE');
        } else
            $mas['result']=0;
        VarDumper::dump($mas);
        $response = new JsonResponse();
        $response->setData($mas);
        return $response;
    }

    //распределитель ajax логики
    public function uNewsFeedEntityAjaxAction (Request $request){
      //по полученном параметрам делаем запрос в базу узнать что такой пользователь существует
        $mas=array();
        
        $this->request=$request;
        if ($this->has('session')){
            $this->request->setSession($this->get('session'));
        }
        $authorization_parameters=@json_decode($request->getContent(),true);
        Vardumper::dump(array('$request'=>$request->getContent(),'isset_auth_parameter'=>isset($authorization_parameters),'authorization_parameters'=>$authorization_parameters,'$this->request'=>$this->request));
        if (isset($authorization_parameters)){
            //проверяем что пришло в сессии
            $this->GetCache($request);
            //в зависимости от типа запроса выполняем логику работы с БД
            if (isset($authorization_parameters['type']))
                switch ($authorization_parameters['type']){
                        case 'add_poetry_comment':
                                    $mas=$this->AddPoetryCommentAjaxAnswer($authorization_parameters,$request);
                                    break;
                        case 'add_poetry_viewer':
                                    $mas['result']=$this->AddPoetryViewerAjaxAnswer($authorization_parameters,$this->request);
                                    break;                            
                        case 'get_poetry_comments_info':
                                    $mas=$this->GetPoetryCommentsAjaxAnswer($authorization_parameters,$request);
                                    break;
                        case 'poetryreposttoownfeed':
                                $mas['result']=$this->PoetryRepostToOwnFeed($authorization_parameters,$request);
                                break;
                        case 'poetryrepostallowed':
                                $mas['result']=$this->PoetryRepostAllowed($authorization_parameters,$this->request);
                                break;
                        case 'repost_from_feed':
                                    $mas['result']=$this->PoetryRepostToOwnFeed($authorization_parameters,$request);
                                    break;
                        case 'poetrylikerequest':
                                    $mas=$this->PoetryLikeRequest($authorization_parameters,$request,'POETRY');
                                    break;
                        case 'commentlikerequest':
                                    $mas=$this->PoetryLikeRequest($authorization_parameters,$request,'COMMENT');
                                    break;
                        case 'get_user_feed_info':
                                    $mas=$this->getUserFeedInfoAjaxAnswer($authorization_parameters,$request);
                                    break;
                        case 'new_message':
                                    $mas['result']=$this->NewMessageAjaxAnswer($authorization_parameters,$request);
                                    break;
                        case 'del_user_post':
                                    $mas['result']=$this->delUserPostAjaxAnswer($authorization_parameters,$request);
                                    break;
                        case 'del_wall_element':
                                    //Vardumper::dump(array('$request'=>$request,'ServerBag'=>$request->server->all(),'session'=>$this->session));
                                    $mas['result']=$this->jsonFileUpload($authorization_parameters,$this->session,$request->server->all(),'WALLFEED');
                                    break;
                    case 'complain_user_post':
                                $mas['result']=$this->ComplainUserPostAjaxAnswer($authorization_parameters,$this->session,$this->request,'NEWSFEED');
                                break;
                    case 'add_user_status':
                                $mas['result']=$this->addUserStatusAjaxAnswer($authorization_parameters,$this->request);
                                break;
                }
        } else if ($request->headers->has('Content-Type')) {
            if ($request->headers->get('Content-Type')=='text/plain')
                $mas['result']=$this->FileUploadAjaxAnswer($request,'poetrycomment');
        } else
            $mas['result']=0;
        VarDumper::dump($mas);
        $response = new JsonResponse();
        $response->setData($mas);
        return $response;
    }
    //Добавление нового комментария 
    public function AddPoetryCommentAjaxAnswer($authorization_parameters,$request) {
        //заводим новый пост, через хранимую процедуру
        $stmt = $this->getDoctrine()
                     ->getConnection()
                     ->prepare($this->sql_array['add_ipoetry_user_comment']);
        if ($request->hasSession()) {
            $this->session=$request->getSession();
        }
        //распарсиваем пришедший json
        Vardumper::dump(array('session'=>$this->session,'file'=>addslashes(file_get_contents($this->session->get('poetrycomment_body'))),'$authorization_parameters'=>$authorization_parameters,'cnt_auth_params'=>count($authorization_parameters)));
        //return 1;
        $stmt->bindValue(':ipoetry_user_id',$this->session->get('login_id'));
        $stmt->bindValue(':ipoetry_user_comment_text',addslashes(file_get_contents($this->session->get('poetrycomment_body'))));
        $stmt->bindValue(':ipoetry_user_comment_ext',$this->session->get('poetrycomment_resource_ext'));
        $stmt->bindValue(':ipoetry_poetry_id',$authorization_parameters['poetry']);
        if (isset($authorization_parameters['parent']))
            $stmt->bindValue(':ipoetry_comment_parent_id',$authorization_parameters['parent']);            
        else
            $stmt->bindValue(':ipoetry_comment_parent_id',0);
        //$stmt->bindValue(':new_ipoetry_comment_id',$new_ipoetry_comment_id);
        $stmt->execute();
        VarDumper::dump(array($stmt));
        $retval=$stmt->fetch();
        VarDumper::dump(array($retval,$retval['new_poertycomment_id']));
        $stmt=$this->getDoctrine()->resetManager();
        //получаем добавленный комментарий
        $poetryposts = $this->getDoctrine()->getEntityManager();
        //получаем список комментов
        $query=$poetryposts->createQuery('SELECT iub.ipoetryUserBlogPostId,iub.ipoetryUserBlogPostParentId,iub.ipoetryUserBlogPostText,ipu.userName,ipu.userLastname,ipuphoto.userPhotoUrl,iub.ipoetryUserBlogPostCreatedAt,iub.ipoetryUserBlogPostUpdatedAt,ibpr.ipoetryBlogPostRatingValueUp,ibpr.ipoetryBlogPostRatingValueDown FROM IpoetryBundle\Entity\IpoetryUserBlogPost iub JOIN iub.ipoetryBlogPostRating ibpr JOIN iub.ipoetryUserUser ipu JOIN ipu.userPhoto ipuphoto WHERE iub.ipoetryUserBlogPostId=?1');
        $query->setParameter(1,$retval['new_poertycomment_id']);
        $poetrycomment=$query->getResult();
        //в виду того что ангуляр не может переварить формат данных doctrine
        array_walk_recursive($poetrycomment, function (&$item, $key){
            if ($item instanceof \DateTime){
                $item=$item->format('Y-m-d H:i:s');
                VarDumper::dump(array($item));            
            }
        });
        return array('result'=>1,
                     'commentslist'=>$poetrycomment);
    }
    //возвращаем AJAX данные по наличию комментариев стиха пользователя
    //для вывода их под стихом
    public function GetPoetryCommentsAjaxAnswer($authorization_parameters,$request){
        $this->request=$request;
        //читаем данные по стихотворению по данным в параметрах url
        $stmt='';
        $commentslist=array();
        $poetrycommentitem=array();

        //проверяем что пришло в сессии
        $this->GetCache($request);

        if ($request->hasSession()) {

            VarDumper::dump(array('cache'=>$this->cacheDriver,'user'=>$authorization_parameters['user'],'datapart'=>$authorization_parameters['datapart']));

            $this->session=$request->getSession();
            $poetryposts = $this->getDoctrine()->getEntityManager();
            //if ($this->session->has('login') && $this->session->has('login_id')){
                //получаем кол-во записей
                $query=$poetryposts->createQuery('SELECT COUNT(iub.ipoetryUserBlogPostPoetryId) FROM IpoetryBundle\Entity\IpoetryUserBlogPost iub WHERE iub.ipoetryUserBlogPostPoetryId=?1');// usr usr.userId=?1 and 
                $query->setParameter(1,$authorization_parameters['poetry'] );//$this->session->has('login_id')
                $poetrypostscnt=$query->getResult();
                
                //Если спросили большим значением возвращаем оставшее кол-во записей
                $intervals=ceil($poetrypostscnt[0][1]/$this->getParameter('ipoetry.uprofilecommentslimit'));
                if ($poetrypostscnt>0 && $authorization_parameters['datapart']>0 && $authorization_parameters['datapart']<=$intervals ){
                    $ostatok=round($poetrypostscnt[0][1]/10,0,PHP_ROUND_HALF_UP);
                    $datapart=abs($intervals-$authorization_parameters['datapart'])*$this->getParameter('ipoetry.uprofilecommentslimit');
                    $ostatok_1=$poetrypostscnt[0][1]-$datapart;
                    $datapart+=$ostatok_1;
                    //получаем список комментов
                    $query=$poetryposts->createQuery('SELECT ipu.userId,iub.ipoetryUserBlogPostId,iub.ipoetryUserBlogPostParentId,iub.ipoetryUserBlogPostText,ipu.userName,ipu.userLastname,ipuphoto.userPhotoUrl,iub.ipoetryUserBlogPostCreatedAt,iub.ipoetryUserBlogPostUpdatedAt,ibpr.ipoetryBlogPostRatingValueUp,ibpr.ipoetryBlogPostRatingValueDown FROM IpoetryBundle\Entity\IpoetryUserBlogPost iub JOIN iub.ipoetryBlogPostRating ibpr JOIN iub.ipoetryUserUser ipu JOIN ipu.userPhoto ipuphoto WHERE iub.ipoetryUserBlogPostPoetryId=?1')
                        ->setFirstResult((($this->getParameter('ipoetry.uprofilecommentslimit')*$authorization_parameters['datapart'])-$this->getParameter('ipoetry.uprofilecommentslimit')))
                        ->setMaxResults($this->getParameter('ipoetry.uprofilecommentslimit'));
                    $query->setParameter(1,$authorization_parameters['poetry'] );//$this->session->has('login_id')
                    //VarDumper::dump(array('sql'=>$query->getSQL()));
                    $poetrycomment=$query->getResult();
                    foreach ($poetrycomment as $poetrycommentitem){
                        //$commentslist[]=$this->AddPoetryComment($authorization_parameters,$authorization_parameters['user'],$authorization_parameters['poetry'],'JSON');
                        $commentslist[]=array('Commentid'=>$poetrycommentitem['ipoetryUserBlogPostId'],'Commentparentid'=>$poetrycommentitem['ipoetryUserBlogPostParentId'],'CommentText'=>$poetrycommentitem['ipoetryUserBlogPostText'],'UserName'=>$poetrycommentitem['userName'],'UserLastName'=>$poetrycommentitem['userLastname'],'UserPhotoUrl'=>$poetrycommentitem['userPhotoUrl'],'CommentCreatedAt'=>$poetrycommentitem['ipoetryUserBlogPostCreatedAt']->format('Y-m-d H:i:s'),'CommentUpdatedAt'=>$poetrycommentitem['ipoetryUserBlogPostUpdatedAt']->format('Y-m-d H:i:s'),'CommentRatingUp'=>$poetrycommentitem['ipoetryBlogPostRatingValueUp'],'CommentRatingDown'=>$poetrycommentitem['ipoetryBlogPostRatingValueDown']);
                    }
                    //в виду того что ангуляр не может переварить формат данных doctrine

                    array_walk_recursive($poetrycomment, function (&$item, $key){
                        if ($item instanceof \DateTime){
                            $item=$item->format('Y-m-d H:i:s');
                            //VarDumper::dump(array($item));            
                        }
                    });
                    VarDumper::dump(array('$poetrypostscnt'=>$poetrypostscnt[0][1],
                        'uprofilecommentslimit'=>$this->getParameter('ipoetry.uprofilecommentslimit'),
                        '$userfeedpoetry'=>$poetrycomment,
                        'setFirstResult'=>(($this->getParameter('ipoetry.uprofilecommentslimit')*$authorization_parameters['datapart'])-$this->getParameter('ipoetry.uprofilecommentslimit')),
                        'setMaxResults'=>$this->getParameter('ipoetry.uprofilecommentslimit')*$authorization_parameters['datapart'],
                        '$intervals'=>$intervals,
                        'datapart'=>$authorization_parameters['datapart'],
                        '$ostatok'=>$ostatok,
                        'datapart_1'=>abs($intervals-$authorization_parameters['datapart'])*$this->getParameter('ipoetry.uprofilecommentslimit'),
                        '$feedlist'=>$commentslist,
                        'ipoetryUserBlogPostCreatedAt'=>$poetrycommentitem['ipoetryUserBlogPostCreatedAt']->format('Y-m-d H:i:s'),
                        '$poetrycomment'=>$poetrycomment));//->getDate()->getName()
                    
                    return array('result'=>$datapart,
                                 'comments'=>$commentslist,
                                 'commentslist'=>$poetrycomment,
                                 'commentscount'=>$poetrypostscnt[0][1],);
                } else
                    return array('result'=>false);
            //}
        }
    }

    //ответ на введенный пост|стих
    public function NewPoetryAjaxAnswer($authorization_parameters,$request) {
        $poetrytags=null;
        $poetrynewtags=null;
        //проверяем что стих отправил зарегистирированный пользователь
        //array('userId'=>-1,'userName'=>'undefined','userLastname'=>'undefined','userPhotoUrl'=>'undefined')
        $loggeduser=$this->UserHeaderInfo($request);
        //если нет картинки то ставим по умолчанию дефолтную
        if (!$this->session->has('poetry_background_image'))
            if (null !==$this->request->server->get('BASE'))
                $pathpart=$this->request->server->get('BASE');
            else
                $pathpart='';
                
            $this->session->set('poetry_background_image',$this->request->server->get('DOCUMENT_ROOT').$pathpart.'/images/post-bg.jpg');
        if ($loggeduser[0]['userId']==-1 || !$this->session->has('poetry_body') || !$this->session->has('poetry_background_image')) {
            return 0;            
        }
        //заводим новый пост, через хранимую процедуру
        $stmt = $this->getDoctrine()
                     ->getConnection()
                     ->prepare($this->sql_array['add_ipoetry_user_post']);
        if ($request->hasSession()) {
            $this->session=$request->getSession();
        }
        //распарсиваем пришедший json
        $cnt=0;

        if (count($authorization_parameters)>2) {
            foreach ( $authorization_parameters as $auth_par_item_key=>$auth_par_item_val ){
                if ($cnt==2 && $auth_par_item_key>=0)
                    $poetrytags.=$auth_par_item_key;
                if ($cnt>2 && $auth_par_item_key>=0 && $poetrytags==null)
                    $poetrytags.=$auth_par_item_key;
                elseif ($cnt>2 && $auth_par_item_key<>-1 && $poetrytags<>null)
                    $poetrytags.=':'.$auth_par_item_key;                    

                if ($cnt==2 && $auth_par_item_key<0)
                    $poetrynewtags.='(\''.$auth_par_item_val.'\')';
                if ($cnt>2 && $auth_par_item_key<0 && $poetrynewtags==null)
                    $poetrynewtags.='(\''.$auth_par_item_val.'\')';
                else if ($cnt>2 && $auth_par_item_key<0 && $poetrynewtags<>null)
                    $poetrynewtags.=',(\''.$auth_par_item_val.'\')';
                
                $cnt++;
            }
        }
        //Vardumper::dump(array('session'=>$this->session,'conent type'=>$request->headers->get('content-type'),'file'=>addslashes(file_get_contents($this->session->get('poetry_background_image'))),'$authorization_parameters'=>$authorization_parameters,'cnt_auth_params'=>count($authorization_parameters),'$poetrytags'=>$poetrytags,'$poetrynewtags'=>$poetrynewtags));
        //return 1;
        
        $stmt->bindValue(':ipoetry_user_email',$this->session->get('login'));
        $stmt->bindValue(':ipoetry_user_post_title',$authorization_parameters['poetry_title']);
        $stmt->bindValue(':ipoetry_user_post',addslashes(file_get_contents($this->session->get('poetry_body'))));
        $stmt->bindValue(':ipoetry_user_post_text',addslashes(file_get_contents($this->session->get('poetry_body'))));
        $stmt->bindValue(':ipoetry_user_post_image',addslashes(file_get_contents($this->session->get('poetry_background_image'))));
        $stmt->bindValue(':ipoetry_user_post_ext',$this->session->get('poetry_resource_ext'));
        $stmt->bindValue(':ipoetry_user_post_tags',$poetrytags);
        $stmt->bindValue(':ipoetry_user_post_tags_text',$poetrynewtags);
        $stmt->bindValue(':ipoetry_comment',addslashes(file_get_contents($this->session->get('newpoetrycomment_body'))));
        $stmt->execute();

        return 1;
    }
    //собщение в стену профиля пользователя
    public function NewMessageAjaxAnswer($authorization_parameters,$request) {
        if ($request->hasSession()) {
            $this->session=$request->getSession();
        }
        //проверяем что сообщение отправил зарегистирированный пользователь
        $loggeduser=$this->UserHeaderInfo($request);
        //проверяем что только владелец профиля может оставить в нем сообщение
        $profileowner=$this->GetUserOwnprofileAjaxAnswer($authorization_parameters,$request);
        if ($loggeduser[0]['userId']===-1 || !$this->session->has('newmessage_body') || $profileowner===0) {
            return 0;
        }
        //заводим новый пост, через хранимую процедуру
        $stmt = $this->getDoctrine()
                     ->getConnection()
                     ->prepare($this->sql_array['add_ipoetry_user_message']);
        
        $stmt->bindValue(':ipoetry_user_email',$this->session->get('login'));
        $stmt->bindValue(':ipoetry_message',addslashes(file_get_contents($this->session->get('newmessage_body'))));
        $stmt->bindValue(':ipoetry_message_ext',$this->session->get('newmessage_resource_ext'));
        $stmt->execute();

        return 1;
    }

    //возвращаем AJAX данные по наличию стихов/комментариев у пользователя
    //для вывода в его ленте
    public function getUserFeedInfoAjaxAnswer($authorization_parameters,$request){
        //$this->request=$request;
        //читаем данные по стихотворению по данным в параметрах url
        $stmt='';
        $feedlist=array();
        $poetryid=0;
        $userid=0;
        //проверяем что пришло в сессии
        $this->GetCache($this->request);

        if ($this->request->hasSession()) {

            VarDumper::dump(array('cache'=>$this->cacheDriver,'user'=>$authorization_parameters['user'],'datapart'=>$authorization_parameters['datapart']));//,'request_uri'=>$authorization_parameters['url']

            $this->session=$this->request->getSession();
            $unewsfeed = $this->getDoctrine()->getEntityManager();
            if ($this->session->has('login') && $this->session->has('login_id')){
                //смотрим кол-во репостов стихов в свою ленту
                //$query=$unewsfeed->createQuery('SELECT COUNT(pr.poetryId) FROM IpoetryBundle\Entity\IpoetryPoetryUserRepostView pr WHERE pr.userId=?1');
                //$query->setParameter(1,$authorization_parameters['user'] );
                //$userfeedcntrepost=$query->getResult();
                $userfeedcntrepost[0][1]=0;
                //получаем кол-во записей своих стихов в свою ленту
                $query=$unewsfeed->createQuery('SELECT COUNT(pr.poetryId) FROM IpoetryBundle\Entity\IpoetryPoetryUserRepostView pr WHERE pr.userId=?1');
                $query->setParameter(1,$authorization_parameters['user'] );
                $userfeedcnt=$query->getResult();
                VarDumper::dump(array('userfeedcnt'=>$userfeedcnt[0][1]));
                //Если спросили большим значением возвращаем оставшее кол-во записей
                $ufcnt=$userfeedcntrepost[0][1]+$userfeedcnt[0][1];
                $intervals=ceil($ufcnt/$this->getParameter('ipoetry.uprofilenewsfeedlimit'));
                if ($ufcnt>0 && $authorization_parameters['datapart']>0 && $authorization_parameters['datapart']<=$intervals ){
                    $ostatok=round($ufcnt/10,0,PHP_ROUND_HALF_UP);
                    $datapart=abs($intervals-$authorization_parameters['datapart'])*$this->getParameter('ipoetry.uprofilenewsfeedlimit');
                    $ostatok_1=$ufcnt-$datapart;
                    $datapart+=$ostatok_1;
                    //получаем список стихов
                    //Doctrine не имеет поддержки контрукции CASE WHEN из-за этого приходится использовать логику в PHP
                    $query=$unewsfeed->createQuery('SELECT pr.userId,pr.poetryRepostId,pr.poetryId,pr.userPoetryownerId FROM IpoetryBundle\Entity\IpoetryPoetryUserRepostView pr WHERE pr.userId=?1 ORDER BY pr.createdAt DESC')
                            ->setFirstResult((($this->getParameter('ipoetry.uprofilenewsfeedlimit')*$authorization_parameters['datapart'])-$this->getParameter('ipoetry.uprofilenewsfeedlimit')))
                            ->setMaxResults($this->getParameter('ipoetry.uprofilenewsfeedlimit'));
                    $query->setParameter(1,$authorization_parameters['user'] );
                    $userfeedpoetry=$query->getResult();
                    VarDumper::dump(array('$userfeedpoetry'=>$userfeedpoetry));
                    //формируем url ссылку на ленту собственника стиха
                    $urlpart=substr($authorization_parameters['url'],0,(strripos($authorization_parameters['url'] , '/')+1));
                    
                    foreach ($userfeedpoetry as $userfeedpoetryitem){
                        $poetryid=0;
                        $userid=0;
                        if ((string)$userfeedpoetryitem['poetryRepostId']=='undefined') {
                            $poetryid=$userfeedpoetryitem['poetryId'];
                            $userid=$userfeedpoetryitem['userId'];
                        } else {
                            $poetryid=$userfeedpoetryitem['poetryRepostId'];
                            $userid=$userfeedpoetryitem['userPoetryownerId'];
                        }
                        VarDumper::dump(array('$userfeedpoetryitem'=>$userfeedpoetryitem,'$poetryid'=>$poetryid,'$userid'=>$userid));
                        
                        $tmparr=$this->uNewsFeedEntityAction($request,$userid,$this->session->get('login_id'),$poetryid,'JSON');
                        $tmparr['poetryownerurl']=$urlpart.$userfeedpoetryitem['userId'];
                        $feedlist[]=$tmparr;
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

                    return array('result'=>$datapart,
                                 'newsfeed'=>$feedlist,
                                 'unewsfeedlist'=>$feedlist,
                                 'unewsfeedlistcnt'=>$userfeedcnt[0][1],
                                 'ownprofile'=>$this->GetUserOwnprofileAjaxAnswer($authorization_parameters,$this->request));
                } else
                    return array('result'=>false);
            }
        }

    }
    //возвращаем AJAX данные по наличию стихов/комментариев у пользователя
    //для вывода в его ленте
    public function getFollowersUserFeedInfoAjaxAnswer($authorization_parameters,$request){
        $this->request=$request;
        //читаем данные по стихотворению по данным в параметрах url
        $stmt='';
        $feedlist=array();
        //проверяем что пришло в сессии
        $this->GetCache($request);

        if ($request->hasSession()) {

            VarDumper::dump(array('cache'=>$this->cacheDriver,'user'=>$authorization_parameters['user'],'datapart'=>$authorization_parameters['datapart']));

            $this->session=$request->getSession();
            $unewsfeed = $this->getDoctrine()->getEntityManager();
            if ($this->session->has('login')){
                //получаем кол-во записей
                $query=$unewsfeed->createQuery('SELECT COUNT(ip.poetryId) FROM IpoetryBundle\Entity\IpoetryPoetry ip JOIN ip.ipoetryUserUser usr WHERE usr.userId IN (SELECT ufb.ipoetryUserFollowedById FROM IpoetryBundle\Entity\IpoetryUserFollowedBy ufb WHERE ufb.ipoetryUserUserId=?1)');
                if (!empty($authorization_parameters['user']))
                    $query->setParameter(1,$authorization_parameters['user'] );
                else
                    $query->setParameter(1,$this->session->get('login_id') );
                    
                $userfeedcnt=$query->getResult();
                
                //Если спросили большим значением возвращаем оставшее кол-во записей
                $intervals=ceil($userfeedcnt[0][1]/$this->getParameter('ipoetry.uprofilenewsfeedlimit'));
                if ($userfeedcnt[0][1]>0 && $authorization_parameters['datapart']>0 && $authorization_parameters['datapart']<=$intervals ){
                    $ostatok=round($userfeedcnt[0][1]/10,0,PHP_ROUND_HALF_UP);
                    $datapart=abs($intervals-$authorization_parameters['datapart'])*$this->getParameter('ipoetry.uprofilenewsfeedlimit');
                    $ostatok_1=$userfeedcnt[0][1]-$datapart;
                    $datapart+=$ostatok_1;
                    //получаем список стихов
                    $query=$unewsfeed->createQuery('SELECT DISTINCT ip.poetryId,usr.userId FROM IpoetryBundle\Entity\IpoetryPoetry ip JOIN ip.ipoetryUserUser usr WHERE usr.userId IN (SELECT ufb.ipoetryUserFollowedById FROM IpoetryBundle\Entity\IpoetryUserFollowedBy ufb WHERE ufb.ipoetryUserUserId=?1)')
                            ->setFirstResult((($this->getParameter('ipoetry.uprofilenewsfeedlimit')*$authorization_parameters['datapart'])-$this->getParameter('ipoetry.uprofilenewsfeedlimit')))
                            ->setMaxResults($this->getParameter('ipoetry.uprofilenewsfeedlimit'));
                    if (!empty($authorization_parameters['user']))
                        $query->setParameter(1,$authorization_parameters['user'] );
                    else
                        $query->setParameter(1,$this->session->get('login_id') );
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
                                 'newsfeed'=>$feedlist);
                } else
                    return array('result'=>false);
            }
        }

    }

    //AJAX проверяем статус подписки на данный профиль пользователя
    public function GetUserSubscribedStatusAjaxAnswer($authorization_parameters,$request){

        $this->GetCache($request);
/*
        VarDumper::dump(array('cache'=>$this->cacheDriver,
            'request'=>$request,'login='=>$this->session->get('login'),
            'login_id='=>$this->session->get('login_id'),
            'user='=>$authorization_parameters['user']));
 */
            $usersubscribed = $this->getDoctrine()->getEntityManager();
        if ($request->hasSession()) {
            //пишем обновленные данные в базу
            if ($this->session->has('login') && $this->session->has('login_id')){
                //получаем кол-во записей
                $query=$usersubscribed->createQuery('SELECT COUNT(iuf.ipoetryUserFollowedById) FROM IpoetryBundle\Entity\IpoetryUserFollowedBy iuf JOIN iuf.ipoetryUserUser usr WHERE usr.userId=?1 and iuf.ipoetryUserFollowedById=?2');// usr usr.userId=?1 and 
                $query->setParameter(1,intval($this->session->get('login_id')) );//$this->session->has('login_id')
                $query->setParameter(2,$authorization_parameters['user']);// 
                //VarDumper::dump(array('sql'=>$query->getSQL()));                
                $usersubscribedcnt=$query->getResult();
                //VarDumper::dump(array('$usersubscribedcnt'=>$usersubscribedcnt));

                return $usersubscribedcnt[0][1];

            } else
                return 0;
        } else
            return 0;
        
    }
    //AJAX запрос на репост
    public function RepostFromFeedAjaxAnswer($authorization_parameters,$request) {
        
    }
    //AJAX подписаться на профиль
    public function AddYouFollowedbyProfileowner($authorization_parameters,$request){

        $this->GetCache($request);
        VarDumper::dump(array('cache'=>$this->cacheDriver,
            'request'=>$request,'login='=>$this->session->get('login'),
            'user='=>$authorization_parameters['user']));

        if ($request->hasSession()) {
            //пишем обновленные данные в базу
            if ($this->session->has('login') && $this->session->has('login_id')){
                $stmt = $this->getDoctrine()
                             ->getConnection()
                             ->prepare($this->sql_array['add_ipoetry_user_follower']);

                Vardumper::dump(array('session'=>$this->session,'$authorization_parameters'=>$authorization_parameters));
                //return 1;
                $stmt->bindValue(':ipoetry_user_login',$this->session->get('login_id'));
                $stmt->bindValue(':ipoetry_user_follower',$authorization_parameters['user']);

                $stmt->execute();
                return 1;

            } else
                return 0;
        } else
            return 0;
    }
    //AJAX отподписаться от профиля
    public function DelYouFollowedbyProfileowner($authorization_parameters,$request){

        $this->GetCache($request);
        VarDumper::dump(array('cache'=>$this->cacheDriver,
            'request'=>$request,'login='=>$this->session->get('login'),
            'user='=>$authorization_parameters['user']));

        if ($request->hasSession()) {
            //пишем обновленные данные в базу
            if ($this->session->has('login') && $this->session->has('login_id')){
                $stmt = $this->getDoctrine()
                             ->getConnection()
                             ->prepare($this->sql_array['del_ipoetry_user_follower']);

                Vardumper::dump(array('session'=>$this->session,'$authorization_parameters'=>$authorization_parameters));
                //return 1;
                $stmt->bindValue(':ipoetry_user_login',$this->session->get('login_id'));
                $stmt->bindValue(':ipoetry_user_follower',$authorization_parameters['user']);

                $stmt->execute();
                return -1;
            } else
                return 0;
        } else
            return 0;
    }
    //незадействована
    public function CreateUserFeed (Request $request,$user,$poetry){
        //return $this->render('IpoetryBundle:uRoom:unewsfeed.html.twig');
    }
    // просмотр ленты стихов подписантов пользователя
    public function uNewsFeedSubscribedAction(Request $request,$user){
        //echo $user+' '+$subscribe;
        return $this->render('IpoetryBundle:uRoom:unewsfeed_subscribed.html.twig');
        //return new Response($user);
    }
    // просмотр ленты стихов и комментариев в своем профиле    
    public function uNewsFeedAction(Request $request,$user){
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
        if (null !==$this->request->server->get('BASE'))
            $pathpart=$this->request->server->get('BASE');
        else
            $pathpart='';
        $uploadtmp=$this->request->server->get('DOCUMENT_ROOT').$pathpart.'/uploadtmp';        
        //читаем данные по стихотворению по данным в параметрах url
        $stmt='';
        //проверяем что пришло в сессии
        $this->GetCache($request);

        //if ($request->hasSession()) {

            VarDumper::dump(array('user'=>$user));

            //$this->session=$request->getSession();
            //$userentity = $this->getDoctrine()->getManager();
            //if ($this->session->has('login') && $this->session->has('login_id')){
                //получаем связанные таблицы для показа данных
                //получаем кол-во записей
                $userentity = $this->getDoctrine()->getEntityManager();

                $query=$userentity->createQuery('SELECT COUNT(usr.userId) FROM IpoetryBundle\Entity\IpoetryUser usr WHERE usr.userId=?1')
                     ->setMaxResults(1);
                $query->setParameter(1,$user );
                $userentitycnt=$query->getResult();
                //если есть такой пользователь то формируем вывод данных по нему
                if ($userentitycnt[0][1]==1){
                    //выбираем данные по пользователям подписантам на стих
                    $query=$userentity->createQuery('SELECT usr.userId,usr.userName,usr.userLastname,usr.userStatus,usrAge.ipoetryUserAge,usrCity.cityName,usrWebsite.ipoetryUserWebsite,usrphoto.userPhotoUrl,CONCAT(?2,usr.userId) AS reposterurl FROM IpoetryBundle\Entity\IpoetryUser usr JOIN usr.userPhoto usrphoto JOIN usr.userCity usrCity JOIN usr.userAge usrAge JOIN usr.userWebsite usrWebsite WHERE usr.userId=?1');
                    $query->setParameter(1,$user );
                    $query->setParameter(2,'\''.$this->getParameter('ipoetry.UserProfileUrl').'\'');
                    $userentities=$query->getResult();
                    //получаем кол-во записей своих стихов в свою ленту
                    $query=$userentity->createQuery('SELECT COUNT(pr.poetryId) FROM IpoetryBundle\Entity\IpoetryPoetryUserRepostView pr WHERE pr.userId=?1');
                    $query->setParameter(1,$user );
                    $userfeedcnt=$query->getResult();
                    VarDumper::dump(array('userfeedcnt'=>$userfeedcnt[0][1]));
                    //unset($userentity);
                    //выбираем подписантов
                    $authorization_parameters=array('usertype'=>'SUBSCRIBERS','user'=>$user,'datapart'=>1);
                    $subscribers=$this->GetUsersAjaxAnswer($authorization_parameters,$request);
                    //выбираем подписчиков
                    $authorization_parameters=array('usertype'=>'FOLLOW','user'=>$user,'datapart'=>1);
                    $followers=$this->GetUsersAjaxAnswer($authorization_parameters,$request);
                    //выбираем рейтинг стихов
                    $authorization_parameters=array('period'=>'day');
                    $poetryrating=$this->GetPoetriesRatingsAjaxAnswer($authorization_parameters,$request);
                }
            //}
        //}
        if (!isset($userentities[0])) {
            $userentities[0]["userId"] = -1;
            $userentities[0]["userName"] = "undefined";
            $userentities[0]["userLastname"] = "undefined";
            $userentities[0]["userPhotoUrl"] = "undefined";
            $userentities[0]["reposterurl"] =  "undefined";
            $userentities[0]["ipoetryUserAge"] =  "undefined";
            $userentities[0]["cityName"] =  "undefined";
            $userentities[0]["ipoetryUserWebsite"] =  "undefined";
        }
        if ($subscribers['result']===0){
            $subscribers['userslist'][0]['userId']=0;
            $subscribers['userslist'][0]['userName']='';
            $subscribers['userslist'][0]['userLastname']='';
            $subscribers['userslist'][0]['cityName']='';
            $subscribers['userslist'][0]['userPhotoUrl']='';
            $subscribers['userscount']=0;
        }
        if ($followers['result']===0){
            $followers['userslist'][0]['userId']=0;
            $followers['userslist'][0]['userName']='';
            $followers['userslist'][0]['userLastname']='';
            $followers['userslist'][0]['cityName']='';
            $followers['userslist'][0]['userPhotoUrl']='';
            $followers['userscount']=0;
        }
        if ($poetryrating['result']<>0){
            $poetryrating['poetriesratings']=array_slice($poetryrating['poetriesratings'], 0, 5);
        }
        $poetryratingcnt=count($poetryrating['poetriesratings']);
        VarDumper::dump(array('subscribers'=>$subscribers,'poetryrating'=>$poetryrating));
        $uprofilenewsfeedlimit=$this->getParameter('ipoetry.uprofilenewsfeedlimit');
        return $this->render('IpoetryBundle:uRoom:user-profile.html.twig',array('userheaderInfo'=>$userheaderInfo[0],
            'userprofileowner'=>$userentities[0],
            'uprofilenewsfeedlimit'=>$uprofilenewsfeedlimit,
            'MoreFeeds'=>$this->translator->trans('More comments',array(),'userprofile'),
            'userfeedcnt'=>$userfeedcnt[0][1],
            'subscribers'=>$subscribers,
            'followers'=>$followers,
            'poetryrating'=>$poetryrating,
            'poetryratingcnt'=>$poetryratingcnt));
    }
    // перепост стиха к себе в ленту
    public function PoetryRepostToOwnFeed($authorization_parameters,$request){
        //Vardumper::dump(array('session'=>$this->session,'$authorization_parameters'=>$authorization_parameters));
        $this->GetCache($request);

        if ($request->hasSession()) {
            //пишем обновленные данные в базу
            if ($this->session->has('login') && $this->session->has('login_id')){
                //Vardumper::dump(array('1'=>1));               
                //$PoetryRepost = $this->getDoctrine()->getRepository('IpoetryBundle:PoetryRepostToOwnFeed');
                //Vardumper::dump(array('2'=>2,'login_id'=>$this->session->get('login_id')));  
                //проверяем есть ли уже запись в базе
                //согласно переписке в скайп с Романом,Сергеем,Мишей у нас можно делать бесконечное кол-во репостов 
                //одного и тогоже стиха
                $PoetryRepost  = $this->getDoctrine()->getEntityManager();
                $PoetryRepostResult=$PoetryRepost->getRepository('IpoetryBundle:PoetryRepostToOwnFeed')->getPoetryReposts($this->session->get('login_id'),$authorization_parameters['poetry']);
                Vardumper::dump(array('$PoetryRepostResult'=>$PoetryRepostResult));
                //если записи нет то добавляем новую запись
                if (!isset($PoetryRepostResult[0]) || isset($PoetryRepostResult[0]))
                {
                    $PoetryRepost = $this->getDoctrine()->getManager();
                    $PoetryRepostToOwnFeed=new PoetryRepostToOwnFeed();
                    $PoetryRepostToOwnFeed->setPoetryRepostId(1);
                    $PoetryRepostToOwnFeed->setUserId($this->session->get('login_id'));
                    $PoetryRepostToOwnFeed->setPoetryId($authorization_parameters['poetry']);
                    $PoetryRepostToOwnFeed->setUserPoetryOwnerId($authorization_parameters['user']);
                    $poetryrepostat=new \DateTime("now");
                    $PoetryRepostToOwnFeed->setRepostedAt($poetryrepostat->format('Y-m-d H:i:s'));
                    $PoetryRepost->persist($PoetryRepostToOwnFeed);
                    $PoetryRepost->flush();
                    Vardumper::dump(array('$PoetryRepostToOwnFeed'=>$PoetryRepostToOwnFeed));
                    return 1;
                } else
                    return 0;
            }
        } else
            return 0;
    }
    //сохраняем лайк для стиха|комментария
    public function PoetryLikeRequest($authorization_parameters,$request,$source='POETRY'){
        //получаем кеш
        $this->GetCache($request);
        $this->session=$request->getSession();
        $up=$authorization_parameters['updown'];
        if ($this->session->has('login') && $this->session->has('login_id')){
            //если в кеше записи нет то пишем в базу данных
            //if (!$this->cacheDriver->contains('poetry_'.$authorization_parameters['poetry'])){
                $plike = $this->getDoctrine()->getManager();
                //получаем связанные таблицы для обновления данных
                //смотрим как like так и dislike
                if (strtoupper($source=='POETRY')){
                    $resultlike=$plike->getRepository('IpoetryBundle:PoetryLike')->findOneBy(array('userId'=>$this->session->get('login_id'),'poetryId'=>$authorization_parameters['poetry']));
                    $resultdislike=$plike->getRepository('IpoetryBundle:PoetryDisLike')->findOneBy(array('userId'=>$this->session->get('login_id'),'poetryId'=>$authorization_parameters['poetry']));
                }
                if (strtoupper($source=='COMMENT')){
                    $resultlike=$plike->getRepository('IpoetryBundle:CommentLike')->findOneBy(array('userId'=>$this->session->get('login_id'),'commentId'=>$authorization_parameters['commentid']));
                    $resultdislike=$plike->getRepository('IpoetryBundle:CommentDisLike')->findOneBy(array('userId'=>$this->session->get('login_id'),'commentId'=>$authorization_parameters['commentid']));
                }
                VarDumper::dump(array($resultlike,$resultdislike));
                if (strtoupper($up)=='UP'){
                    if (empty($resultlike) && empty($resultdislike)){
                        //добавляем запись что такой пользователь уже голосовал
                        if (strtoupper($source=='POETRY')){
                            $stmt = $this->getDoctrine()
                                        ->getConnection()
                                        ->prepare($this->sql_array['add_ipoetry_poetry_like']);
                            $stmt->bindValue(':ipoetry_user_id',$this->session->get('login_id'));
                            $stmt->bindValue(':ipoetry_poetry_id',$authorization_parameters['poetry']);
                            $stmt->execute();

                            /*
                            $result=new PoetryLike();
                            $result->setPoetryId($authorization_parameters['poetry']);
                            $result->setUserId($this->session->get('login_id'));
                            $plike->persist($result);
                            $plike->flush();
                            //получаем связанные таблицы для обновления данных
                            $result=$plike->getRepository('IpoetryBundle:IpoetryPoetryRating')->findOneBy(array('ipoetryPoetryPoetryId'=>$authorization_parameters['poetry']));
                            $result->setIpoetryPoetryRatingValueUp($result->getIpoetryPoetryRatingValueUp()+1);
                            $plike->merge($result);
                            $plike->flush();
                            */
                            //получаем связанные таблицы для обновления данных
                            $result=$plike->getRepository('IpoetryBundle:IpoetryPoetryRating')->findOneBy(array('ipoetryPoetryPoetryId'=>$authorization_parameters['poetry']));
                            $result->setIpoetryPoetryRatingValueUp($result->getIpoetryPoetryRatingValueUp()+1);
                            $plike->merge($result);
                            $plike->flush();
                            //количество дизлайков и отправляем обратно клиенту для вывода
                            $result=$plike->getRepository('IpoetryBundle:IpoetryPoetryRating')->getPoetryLikes($authorization_parameters['poetry']);
                            return $result[0];                            
                        }
                        if (strtoupper($source=='COMMENT')){
                            //заводим новый пост, через хранимую процедуру
                            $stmt = $this->getDoctrine()
                                        ->getConnection()
                                        ->prepare($this->sql_array['add_ipoetry_poem_comment_like']);
                            $stmt->bindValue(':ipoetry_user_id',$this->session->get('login_id'));
                            $stmt->bindValue(':ipoetry_poem_id',$authorization_parameters['commentid']);
                            $stmt->execute();
                            //$result=new CommentLike();
                            //$result->getLikeId();
                            //$result->setLikeId($result->getLatestlikeId());
                            //$result->setCommentId($authorization_parameters['commentid']);
                            //$result->setUserId($this->session->get('login_id'));
                            //$plike->persist($result);
                            //$plike->flush();

                            //получаем связанные таблицы для обновления данных
                            $result=$plike->getRepository('IpoetryBundle:IpoetryBlogPostRating')->findOneBy(array('ipoetryBlogPostPoetryId'=>$authorization_parameters['commentid']));
                            $result->setIpoetryBlogPostRatingValueUp($result->getIpoetryBlogPostRatingValueUp()+1);
                            $plike->merge($result);
                            $plike->flush();
                            //количество дизлайков и отправляем обратно клиенту для вывода
                            $result=$plike->getRepository('IpoetryBundle:IpoetryBlogPostRating')->getBlogPostLikes($authorization_parameters['commentid']);
                            return $result[0];
                        }
                    } else
                        return 0;
                }
                if (strtoupper($up)=='DOWN'){
                    if (empty($resultlike) && empty($resultdislike)){
                        //добавляем запись что такой пользователь уже голосовал
                        if (strtoupper($source=='POETRY')){
                            $stmt = $this->getDoctrine()
                                        ->getConnection()
                                        ->prepare($this->sql_array['add_ipoetry_poetry_dislike']);
                            $stmt->bindValue(':ipoetry_user_id',$this->session->get('login_id'));
                            $stmt->bindValue(':ipoetry_poetry_id',$authorization_parameters['poetry']);
                            $stmt->execute();
                            /*
                            $result=new PoetryDisLike();
                            $result->setPoetryId($authorization_parameters['poetry']);
                            $result->setUserId($this->session->get('login_id'));
                            $plike->persist($result);
                            $plike->flush();

                            //получаем связанные таблицы для обновления данных
                            $result=$plike->getRepository('IpoetryBundle:IpoetryPoetryRating')->findOneBy(array('ipoetryPoetryPoetryId'=>$authorization_parameters['poetry']));
                            $result->setIpoetryPoetryRatingValueDown($result->getIpoetryPoetryRatingValueDown()+1);
                            $plike->merge($result);
                            $plike->flush();
                             */
                            //получаем связанные таблицы для обновления данных
                            $result=$plike->getRepository('IpoetryBundle:IpoetryPoetryRating')->findOneBy(array('ipoetryPoetryPoetryId'=>$authorization_parameters['poetry']));
                            $result->setIpoetryPoetryRatingValueDown($result->getIpoetryPoetryRatingValueDown()+1);
                            $plike->merge($result);
                            $plike->flush();
                            //количество дизлайков и отправляем обратно клиенту для вывода
                            $result=$plike->getRepository('IpoetryBundle:IpoetryPoetryRating')->getPoetryLikes($authorization_parameters['poetry']);
                            return $result[0];                          
                        }
                        if (strtoupper($source=='COMMENT')){
                            //заводим новый пост, через хранимую процедуру
                            $stmt = $this->getDoctrine()
                                        ->getConnection()
                                        ->prepare($this->sql_array['add_ipoetry_poem_comment_dislike']);
                            $stmt->bindValue(':ipoetry_user_id',$this->session->get('login_id'));
                            $stmt->bindValue(':ipoetry_poem_id',$authorization_parameters['commentid']);
                            $stmt->execute();

                            //$result=new CommentDisLike();
                            //$result->setCommentId($authorization_parameters['commentid']);
                            //$result->setUserId($this->session->get('login_id'));
                            //$plike->persist($result);
                            //$plike->flush();
                            //получаем связанные таблицы для обновления данных
                            $result=$plike->getRepository('IpoetryBundle:IpoetryBlogPostRating')->findOneBy(array('ipoetryBlogPostPoetryId'=>$authorization_parameters['commentid']));
                            $result->setIpoetryBlogPostRatingValueDown($result->getIpoetryBlogPostRatingValueDown()+1);
                            $plike->merge($result);
                            $plike->flush();
                            //количество дизлайков и отправляем обратно клиенту для вывода
                            $result=$plike->getRepository('IpoetryBundle:IpoetryBlogPostRating')->getBlogPostLikes($authorization_parameters['commentid']);
                            return $result[0];
                        }
                    } else
                        return 0;
                }

            //}
        }
        return 0;
    }
    public function addUserStatusAjaxAnswer($authorization_parameters,$request){

            $this->GetCache($request);
    
            VarDumper::dump(array(
                'request'=>$request,'login='=>$this->session->get('login'),
                'login_id='=>$this->session->get('login_id'),
                'status='=>$authorization_parameters['status']));
     
            if ($request->hasSession()) {
                //пишем обновленные данные в базу
                if ($this->session->has('login') && $this->session->has('login_id')){
                    $stmt = $this->getDoctrine()
                                ->getConnection()
                                ->prepare($this->sql_array['add_user_status']);
                    $stmt->bindValue(':ipoetry_user_id',$this->session->get('login_id'));
                    $stmt->bindValue(':status_text',$authorization_parameters['status']);
                    $stmt->execute();
                    return 1;
                } else
                    return 0;
            } else
                return 0;    
    }
}