<?php

namespace IpoetryBundle\Controller\Abstracts;

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
use Symfony\Component\Translation\Loader\ArrayLoader;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Component\Translation\MessageSelector;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Component\Yaml\Yaml;

use IpoetryBundle\Event\CloseUserSessionEvent;
use Doctrine\ORM\Query\ResultSetMapping;


//use AppBundle\Form\Type\User_profileType;

//use Gregwar\CaptchaBundle\Type\CaptchaType;
//use Gregwar\CaptchaBundle\Generator\CaptchaGenerator;
//use Gregwar\CaptchaBundle\Validator\CapchaValidator;
//use Gregwar\Captcha\CaptchaBuilder;
//use Gregwar\Captcha\PhraseBuilder;
//use Gregwar\CaptchaBundle\Generator\ImageFileHandler;

//use IpoetryBundle\Resources\public\images;

/**
 * Description of LoggingController
 *
 * @author d.krasavin
 * абстрактный контроллер для форм логина и регистрации
 */
abstract class LoggingController extends Controller{
    public $translator;
    public $config;
    public $encoders=array();
    public $normalizers=array();
    public $serializer;
    public $session;
    private $site_config='site_config.xml';
    private $captchabuilder;
    private $option;
    //кеширование запросов БД
    public $cacheDriver;
    
    public function loginAction(Request $request){
        $html='';
        $str_tab='';
        $action='';
        $retval=array();

        VarDumper::dump(array('request_locale'=>$request->getLocale()));//'messages_locale'=> 'z:/domains/ipoetry/standard-edition-master/src/IpoetryBundle/Resources/translations/messages.ru.yml'        
    }

    public function createAction(){

    }
    
    function get_site_config($xmlfile,$attribute)
    {
        try {
        $this->config=new config();
        //получаем конфигурационный файл
        $finder = new Finder();
        $contents='';        
        $finder->files()->name($xmlfile);
        //$request=Request::createFromGlobals();
        //читаем конфигурационный файл
        foreach ($finder->in(__DIR__) as $file) {
            $contents = $file->getContents();
        }
        $xmlEncoder=new XmlEncoder();
        $xmlEncoder->setRootNodeName('config');
        $this->encoders = array($xmlEncoder, new JsonEncoder());
        $this->normalizers = array(new ObjectNormalizer());
        $this->serializer = new Serializer($this->normalizers, $this->encoders);

        $retval=$xmlEncoder->encode($this->config, 'xml');
        $xmlContent = $this->serializer->serialize($this->config, 'xml');
        $this->serializer->deserialize($contents, 'AppBundle\denvkrClasses\config', 'xml',array('object_to_populate' => $this->config));

         return true;
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

    }
    function captcha_options($key=false,$val=false){
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

    public function GetMd5hash($hashstring='5hrtGtdfjy'){
        return md5($hashstring);
    }
    
    //читаем данные из сессии о кеше
    public function GetCache($request){
        //проверяем что пришло в сессии
        if ($request->hasSession()) {
            $this->session=$request->getSession();
            $this->cacheDriver=$this->session->get('cacheDriver');
            return 1;
        if (!isset($this->cacheDriver))
            $this->cacheDriver = new \Doctrine\Common\Cache\ArrayCache();
            return 1;
        } else
            return 0;
    }
    
    // просмотр отдельного стиха 
    // заход в эту функцию осуществляется как с роутинга так и с функций контроллера uProfileController
    public function uNewsFeedEntityAction(Request $request,$poetryowneruser=0,$user,$poetry,$retvaltype='TEMPLATE'){
        $this->request=$request;
        $this->GetTranslator($request);
        //директория для хранения временных файлов
        $uploadtmp=$this->request->server->get('DOCUMENT_ROOT').$this->request->server->get('BASE').'/uploadtmp';        
        //читаем данные по стихотворению по данным в параметрах url
        $stmt='';
        $originalpoetryid=$poetry;
        //проверяем что пришло в сессии
        $this->GetCache($request);

        if ($request->hasSession()) {

            VarDumper::dump(array('cache'=>$this->cacheDriver,'$poetryowneruser'=>$poetryowneruser,'user'=>$user,'poetry='=>$poetry));

            $this->session=$request->getSession();
            //если есть обновленные поля то обновляем их
            //пишем обновленные данные в базу
            $unewsfeedentity = $this->getDoctrine()->getManager();
            if ($this->session->has('login') && $this->session->has('login_id')){
                //получаем связанные таблицы для показа данных
                //получаем кол-во записей
                $userspoetry = $this->getDoctrine()->getEntityManager();

                if (is_string($poetry) && $poetryowneruser<>0){
                    $query=$userspoetry->createQuery('SELECT COUNT(pr.poetryId),pr.poetryId FROM IpoetryBundle\Entity\IpoetryPoetryUserRepostView pr WHERE pr.poetryRepostId=?1')
                         ->setMaxResults(1);
                    $query->setParameter(1,$poetry );
                } else {
                    $query=$userspoetry->createQuery('SELECT COUNT(ip.poetryId),ip.poetryId FROM IpoetryBundle\Entity\IpoetryPoetry ip JOIN ip.ipoetryUserUser usr WHERE usr.userId=?1 and ip.poetryId=?2');// usr usr.userId=?1 and
                    //если это не стих репост
                    if ($poetryowneruser<>0)
                        $query->setParameter(1,$poetryowneruser );//$this->session->has('login_id')
                    else
                        $query->setParameter(1,$user );//$this->session->has('login_id')

                    $query->setParameter(2,$poetry );
                }
                    
                //VarDumper::dump(array('sql'=>$query->getSQL()));                
                $usersubscribedcnt=$query->getResult();
                VarDumper::dump(array('$usersubscribedcnt'=>$usersubscribedcnt,'$query'=>$query->getDQL()));
                $poetry=$usersubscribedcnt[0]['poetryId'];
                //$usersubscribedcnt[0][1];
                if ($usersubscribedcnt[0][1]==1) {
                    $result['user']=$unewsfeedentity->getRepository('IpoetryBundle:IpoetryUser')->findOneBy(array('userId'=>$user));
                    //если это не стих репост
                    if ($poetryowneruser<>0) {
                        $result['userowner']=$unewsfeedentity->getRepository('IpoetryBundle:IpoetryUser')->findOneBy(array('userId'=>$poetryowneruser));
                        $result['poetryrepost']=$unewsfeedentity->getRepository('IpoetryBundle:PoetryRepostToOwnFeed')->findOneBy(array('userId'=>$user,'poetryId'=>$poetry));
                        //VarDumper::dump(array('$result[poetryrepost]'=>$result['poetryrepost']));
                    }
                    $result['poetry']=$unewsfeedentity->getRepository('IpoetryBundle:IpoetryPoetry')->findOneBy(array('poetryId'=>$poetry));
                    $result['poetrybackgroundimage']=$unewsfeedentity->getRepository('IpoetryBundle:IpoetryBackgroundImages')->findOneBy(array('ipoetryPoetryPoetry'=>$poetry));
                    $result['poetryrating']=$unewsfeedentity->getRepository('IpoetryBundle:IpoetryPoetryRating')->findOneBy(array('ipoetryPoetryPoetry'=>$poetry));
                } else
                    throw $this->createNotFoundException('No user or poetry found for login:'.$this->session->get('login'). ' login_id:'.$this->session->get('login_id').' poetry_id:'.$poetry);
            }
        }
        //VarDumper::dump(array('1'=>1));
        //если не получили данные по пользователю или стихотворению выбрасываем исключение
        /*
        if (!$result['user'] || !$result['poetry']) {
            throw $this->createNotFoundException('No user or poetry found for email:'.$this->session->get('login'));
        }
        */
        //VarDumper::dump(array('$result["user"]'=>$result['user'],'$result["poetry"]'=>$result['poetry'],'$result["poetrybackgroundimage"]'=>$result['poetrybackgroundimage']));
        $poetryresult['userid']=$user;
        $poetryresult['poetryowneruserid']=$poetryowneruser;
        if (!empty($result['poetryrepost']))
            $poetryresult['reposted']=$result['poetryrepost']->getRepostedAt()->format('Y-m-d H:i:s');
        else
            $poetryresult['reposted']='';
        $poetryresult['title']=$result['poetry']->getPoetryTitle();
        $poetryresult['created']=$result['poetry']->getPoetryCreatedAt()->format('Y-m-d H:i:s');//->date
        $poetryresult['body']=$result['poetry']->getPoetryBodyText();//$result['poetry']->getPoetryBody();
        $poetryresult['comment']=$result['poetry']->getPoetryDescription();//$result['poetry']->getPoetryBody();        
        $poetryresult['like']=$result['poetryrating']->getIpoetryPoetryRatingValueUp();
        $poetryresult['dislike']=$result['poetryrating']->getIpoetryPoetryRatingValueDown();
        if ($retvaltype=='TEMPLATE'){
            //данные по тегам
            $poetryresult['tags']=$result['poetry']->getIpoetryTagsTags();
            //данные по создателю стихотворения
            $poetryresult['uname']=$result['user']->getUserName();
            $poetryresult['ulastname']=$result['user']->getUserLastname();
            $poetryresult['uphotourl']=$result['user']->getUserPhoto()->getUserPhotoUrl();
        }
        if ($retvaltype=='JSON') {
            //$poetryresult['tags']=$result['poetry']->getIpoetryTagsTags();        
            $poetryresult['tags_only']=array();
            $poetryresult['poetry_id']=$originalpoetryid;
            $poetryresult['poetryoriginal_id']=$result['poetry']->getPoetryId();
            foreach ($result['poetry']->getIpoetryTagsTags() as $poetryresultitem) {
                //$IpoetryTags=new IpoetryTags();
                //$IpoetryTags=$poetryresultitem;
                $poetryresult['tags_only'][]=array('tagid'=>$poetryresultitem->getIpoetryTagsTagsId(),'tagtext'=>$poetryresultitem->getTagsText(),'moderated'=>$poetryresultitem->getModerated());//$IpoetryTags;
            }
            $poetryresult['uname']=$result['user']->getUserName();
            $poetryresult['ulastname']=$result['user']->getUserLastname();
            $poetryresult['uphotourl']=$result['user']->getUserPhoto()->getUserPhotoUrl();
            if (!empty($result['userowner'])){
                $poetryresult['owneruname']=$result['userowner']->getUserName();
                $poetryresult['ownerulastname']=$result['userowner']->getUserLastname();
                $poetryresult['owneruphotourl']=$result['userowner']->getUserPhoto()->getUserPhotoUrl();                
            } else {
                $poetryresult['owneruname']='';
                $poetryresult['ownerulastname']='';
                $poetryresult['owneruphotourl']='';                
            }

        }
        //$poetryresult['tags_id']=$result['poetry']->getIpoetryTagsTags()->getIpoetryTagsTagsId();
        //готовим пути для сохранения бинарных (фото,текста стиха) данных
        //$rand=rand(1,9999999999);
        $uploadtmpfile=$uploadtmp.'/poetry_data_'.$poetryowneruser.'_'.$poetry.'.jpeg';
        $urltmpfile=$this->request->server->get('BASE').'/uploadtmp/poetry_data_'.$poetryowneruser.'_'.$poetry.'.jpeg';
        //тольков в случае если такого файла нет пишем в него данные из базы
        if (!file_exists ($uploadtmpfile) && !empty($result['poetrybackgroundimage'])){
            //Vardumper::dump(array('imgfile'=>'Z:/domains/ipoetry/standard-edition-master/web/uploadtmp/poetry_background'.rand(1,9999999999).'.png','request content'=>$udl));        
            $fp=fopen($uploadtmpfile, 'w+');
            $bytes = @fwrite($fp,$result['poetrybackgroundimage']->getIpoetryBackgroundImage());
            if ($bytes === false || $bytes <= 0)
                throw new NotFoundHttpException();
            fclose($fp);
        }
        $poetryresult['image']=$urltmpfile;
        //VarDumper::dump(array('$poetry'=>$poetryresult,'tags'=>$poetryresult['tags_only']));
        if ($retvaltype=='TEMPLATE') {
            //получаем данные по пользователю для шапки страницы
            $userheaderInfo=$this->UserHeaderInfo($request);

            $reposters=$this->GetPoetryReposterPeople($request,$poetryowneruser,$user,$poetry,$retvaltype);
            VarDumper::dump(array('$reposters'=>$reposters,'$userheaderInfo'=>$userheaderInfo[0]));
            $comments=$this->AddBlogPosts($request,$poetryowneruser,$poetry,'TEMPLATE');
            return $this->render('IpoetryBundle:uRoom:poem.html.twig',
            array('poetry'=>$poetryresult,'CommentsCnt'=>$comments[0],//'CommentsBodies'=>$comments[1],
                'reposters'=>$reposters,
                'CommentsHeader'=>$this->translator->trans('Comments',array(),'unewsfeedentity'),
                'MadeHeader'=>$this->translator->trans('They Made Reposts.',array(),'unewsfeedentity'),
                'More comments'=>$this->translator->trans('More comments',array(),'unewsfeedentity'),
                'repostbtntext'=>$this->translator->trans('Repost poetry to your feed',array(),'unewsfeedentity'),
                'userheaderInfo'=>$userheaderInfo[0],
                'poemcommentslimit'=>$this->getParameter('ipoetry.uprofilecommentslimit')));
        } else if ($retvaltype=='JSON')
            return $poetryresult;
    }
    //ответ на загруженную фоновую картинку
    public function FileUploadAjaxAnswer($request,$source){
        $this->request=$request;
        //директория для хранения временных файлов
        $uploadtmp=$this->request->server->get('DOCUMENT_ROOT').$this->request->server->get('BASE').'/uploadtmp';

        //тип файла для хранения данных
        $filetype;
        switch ($request->headers->get('content-type')){
            case 'image/png':
                $filetype='png';
                break;
            case 'image/jpeg':
                $filetype='jpeg';
                break;
            case 'image/jpg':
                $filetype='jpg';
                break;
            case 'image/gif':
                $filetype='gif';
                break;
            case 'image/ico':                
                $filetype='ico';
                break;
            case 'text/plain':
                $filetype='txt';
                break;                
            default: $filetype='tmp';
        } 
        //путь к временному файлу с картинкой
        if (strtoupper($source)=='POETRY')
            $uploadtmpfile=$uploadtmp.'/poetry_data'.rand(1,9999999999).'.'.$filetype;
        if (strtoupper($source)=='POETRYCOMMENT')
            $uploadtmpfile=$uploadtmp.'/poetrycomment_data'.rand(1,9999999999).'.'.$filetype;
        if (strtoupper($source)=='NEWPOETRYCOMMENT')
            $uploadtmpfile=$uploadtmp.'/newpoetrycomment_data'.rand(1,9999999999).'.'.$filetype;
                
        Vardumper::dump(array('request'=>$request,'file'=>$request->files->get('files')[0],'conent type'=>$request->headers->get('content-type')));
        //$StreamedResponse=new StreamedResponse(null,200,array($request->headers->get('content-disposition'),
        //    $request->headers->get('content-length'),
        //    $request->headers->get('content-type')));
        $udl=$request->getContent(false);
        //Vardumper::dump(array('imgfile'=>'Z:/domains/ipoetry/standard-edition-master/web/uploadtmp/poetry_background'.rand(1,9999999999).'.png','request content'=>$udl));        
        $fp=fopen($uploadtmpfile, 'w+');
        $bytes = @fwrite($fp,$udl);
        if ($bytes === false || $bytes <= 0)
            throw new NotFoundHttpException();
        fclose($fp);
        /*
        $StreamedResponse->setCallback(function () use ($udl) {
           $fp=fopen ($request->get('baseUrl').'/uploadtmp/udl'.rand(1,9999).'.png', 'w+');
           $bytes = @fwrite($fp);
            if ($bytes === false || $bytes <= 0)
                throw new NotFoundHttpException();
            fclose($fp);
        });
         
         */
        //Vardumper::dump(array('StreamedResponse'=>$StreamedResponse->getContent()));
        //подготавливаем данные для записи в базу+картинка если есть
        //читаем путь файла в сессию
        if ($request->hasSession()) {
            $this->session=$request->getSession();
            if (strtoupper($source)=='POETRY') {
                if ($filetype=='txt') {
                    $this->session->set('poetry_body',$uploadtmpfile );
                }
                else {
                    $this->session->set('poetry_background_image',$uploadtmpfile );
                }
                $this->session->set('poetry_resource_ext',$filetype );                               
            }
            //комментарии пользователей к существующему стиху
            if (strtoupper($source)=='POETRYCOMMENT') {
                if ($filetype=='txt') {
                    $this->session->set('poetrycomment_body',$uploadtmpfile );
                }
                $this->session->set('poetrycomment_resource_ext',$filetype );                               
            }
            //комментарий автора к новому стиху
            if (strtoupper($source)=='NEWPOETRYCOMMENT') {
                if ($filetype=='txt') {
                    $this->session->set('newpoetrycomment_body',$uploadtmpfile );
                }
                $this->session->set('newpoetrycomment_resource_ext',$filetype );                               
            }
            if (strtoupper($source)=='USERPROFILE') {
                $this->session->set('user_profile_image',$uploadtmpfile );
            }
        }
        return 1;
    }
    //построение списка комментариев
    public function AddBlogPosts (Request $request,$user,$poetry,$retvaltype='TEMPLATE'){
        
        //вытаскиваем массив JSON с комментариями к стиху
        //Проверяем есть ли комментарии у данного стихотворения
        $this->request=$request;
        //директория для хранения временных файлов
        $uploadtmp=$this->request->server->get('DOCUMENT_ROOT').$this->request->server->get('BASE').'/uploadtmp';
        //читаем данные по стихотворению по данным в параметрах url
        $stmt='';
        //проверяем что пришло в сессии
        $this->GetCache($request);

        if ($request->hasSession()) {

            //VarDumper::dump(array('cache'=>$this->cacheDriver,'user'=>$user,'poetry='=>$poetry));

            $this->session=$request->getSession();
            //если есть обновленные поля то обновляем их
            //пишем обновленные данные в базу
            //$unewsfeedentity = $this->getDoctrine()->getManager();
            if ($this->session->has('login') && $this->session->has('login_id')){
                //получаем связанные таблицы для показа данных
                //получаем кол-во записей
                $poetryposts = $this->getDoctrine()->getEntityManager();
                $query=$poetryposts->createQuery('SELECT COUNT(iub.ipoetryUserBlogPostPoetryId) FROM IpoetryBundle\Entity\IpoetryUserBlogPost iub WHERE iub.ipoetryUserBlogPostPoetryId=?1');// usr usr.userId=?1 and 
                $query->setParameter(1,$poetry );//$this->session->has('login_id')
                //VarDumper::dump(array('sql'=>$query->getSQL()));
                $poetrypostscnt=$query->getResult();
                //VarDumper::dump(array('$usersubscribedcnt'=>$usersubscribedcnt));

                //$poetrypostscnt[0][1];
                //Если есть комментарии то вытаскиваем данные по ним
                if ($poetrypostscnt[0][1]>0) {
                    $query=$poetryposts->createQuery('SELECT iub.ipoetryUserBlogPostId,iub.ipoetryUserBlogPostParentId,iub.ipoetryUserBlogPostText,ipu.userName,ipu.userLastname,iub.ipoetryUserBlogPostCreatedAt,ipuphoto.userPhotoUrl,iubrat.ipoetryBlogPostRatingValueUp,iubrat.ipoetryBlogPostRatingValueDown FROM IpoetryBundle\Entity\IpoetryUserBlogPost iub JOIN iub.ipoetryUserUser ipu JOIN ipu.userPhoto ipuphoto JOIN iub.ipoetryBlogPostRating iubrat WHERE iub.ipoetryUserBlogPostPoetryId=?1');// usr usr.userId=?1 and 
                    $query->setParameter(1,$poetry );//$this->session->has('login_id')
                    //VarDumper::dump(array('sql'=>$query->getSQL()));
                    $poetryposts=$query->getResult();
                    VarDumper::dump(array('poetryposts'=>$poetryposts,'$poetry'=>$poetry));

                    return array($poetrypostscnt[0][1],$poetryposts);
                    //$result['user']=$unewsfeedentity->getRepository('IpoetryBundle:IpoetryUser')->findOneBy(array('userId'=>$user));
                    //$result['poetry']=$unewsfeedentity->getRepository('IpoetryBundle:IpoetryPoetry')->findOneBy(array('poetryId'=>$poetry));
                    //$result['poetrybackgroundimage']=$unewsfeedentity->getRepository('IpoetryBundle:IpoetryBackgroundImages')->findOneBy(array('ipoetryPoetryPoetry'=>$poetry));
                    //$result['poetryrating']=$unewsfeedentity->getRepository('IpoetryBundle:IpoetryPoetryRating')->findOneBy(array('ipoetryPoetryPoetry'=>$poetry));
                } else
                    return 0;//throw $this->createNotFoundException('No user or poetry found for login:'.$this->session->get('login'));
            }
        }
        
    }
    //AJAX ответ закрытие сессии пользователя
    public function setUserSessionClosedAjaxAnswer($authorization_parameters,$request){
        if ($request->hasSession()) {
            //закрываем выход из сессии пользователя
            $inactivity=getdate($this->session->getMetadataBag()->getLastUsed()-$this->session->getMetadataBag()->getCreated());
            VarDumper::dump( array('lastupdated'=>$this->session->getMetadataBag()->getLastUsed(),'inactivity'=>$this->session->getMetadataBag()->getCreated(),'inactivity_min'=>$inactivity['minutes']) );
            $this->session->invalidate();
             //$eventDispatcher = $this->get('event_dispatcher');
            //$customusercloseevent=new CloseUserSessionEvent();
            //$customusercloseevent->setCode('CLOSEUSERSESSION');
            //$eventDispatcher->dispatch('custom.event.CLOSEUSERSESSION',$customusercloseevent);
            return 1;
        } else
            return 0;
    }
    //выводим в шаблоне unewsfeedentity
    //раздел "Сделали репост"
    public function GetPoetryReposterPeople($request,$poetryowneruser=0,$user,$poetry,$retvaltype='TEMPLATE'){
        $unewsfeedentity = $this->getDoctrine()->getManager();
        //получаем связанные таблицы для показа данных
        //получаем кол-во записей
        $userspoetry = $this->getDoctrine()->getEntityManager();

        if ($poetryowneruser==0){
            $query=$userspoetry->createQuery('SELECT COUNT(DISTINCT pr.userId) FROM IpoetryBundle\Entity\PoetryRepostToOwnFeed pr WHERE pr.poetryId=?1');
                //пока убираем лимит на вывод 
                // ->setMaxResults(20);
            $query->setParameter(1,$poetry );
        }
        $usersubscribedcnt=$query->getResult();
        //если есть подписчики у стиха то формируем их вывод
        if ($usersubscribedcnt[0][1]>0){
            //выбираем данные по пользователям подписантам на стих
            $query=$userspoetry->createQuery('SELECT usr.userId,usr.userName,usr.userLastname,usrphoto.userPhotoUrl,CONCAT(\''.$this->getParameter('ipoetry.UserProfileUrl').'\',usr.userId) AS reposterurl FROM IpoetryBundle\Entity\IpoetryUser usr JOIN usr.userPhoto usrphoto WHERE usr.userId IN (SELECT DISTINCT pr.userId FROM IpoetryBundle\Entity\PoetryRepostToOwnFeed pr WHERE pr.poetryId=?1 ORDER BY pr.repostedAt DESC)');
                //пока убираем лимит на вывод 
                // ->setMaxResults(20);
            $query->setParameter(1,$poetry );
        }
        $usersubscribed=$query->getResult();
        if (isset($usersubscribed[0][1])){
            if ($usersubscribed[0][1]==0){
                unset($usersubscribed);
                $usersubscribed[0]=array('userId'=>'','userName'=>'','userLastname'=>'','userPhotoUrl'=>'','reposterurl'=>'');                
            }
        }
        return $usersubscribed;
    }
    //подключаем транслятор для шаблонов
    public function GetTranslator(Request $request){
        $this->translator = new Translator($this->request->getLocale(), new MessageSelector());
        $this->translator->addLoader('yaml',new YamlFileLoader());
        $this->translator->addResource('yaml',$this->getTranslatorPath($this->request).'/unewsfeedentity.ru.yml', 'ru_RU','unewsfeedentity');
        $this->translator->addResource('yaml',$this->getTranslatorPath($this->request).'/users.ru.yml', 'ru_RU','users');
        //VarDumper::dump(array($this->translator,$this->translator->trans('Comments',array(),'unewsfeedentity')));
    }

    //AJAX проверяем что пользователь является владельцем профиля
    public function GetUserOwnprofileAjaxAnswer($authorization_parameters,$session){
        if ($session->hasSession()) {
            $session=$session->getSession();
        }
        return $this->urlsession($authorization_parameters,$session);
    }

    public function PoetryRepostAllowed($authorization_parameters,$session){
        //VarDumper::dump(array('$session->hasSession()'=>$session->hasSession()));
        if ($session->hasSession()) {
            $session=$session->getSession();
        }
        return $this->urlsession($authorization_parameters,$session);
    }
    
    public function urlsession($authorization_parameters,$session){
        //проверяем что пришло в сессии
        //$this->GetCache($session);
        varDumper::dump(array('$authorization_parameters["user"]'=>$authorization_parameters['user'],'session'=>$session->get('login_id'),'has login_id'=>$session->has('login_id')));
        if ($session->has('login_id')){
            if ($authorization_parameters['user']==$session->get('login_id') )
                return 1;
            else
                return 0;                
        } else
            return 0;

    }
    //функция выборки данных по пользователю в шапку страницы
    public function UserHeaderInfo($request) {
        if ($request->hasSession()) {

            $this->session=$request->getSession();

            if ($this->session->has('login') && $this->session->has('login_id')) {
                //проверяем что пришло в сессии
                $this->GetCache($request);

                $usersfeed = $this->getDoctrine()->getEntityManager();
                //проверяем существование пользователя
                $query=$usersfeed->createQuery('SELECT COUNT(usr.userId) FROM IpoetryBundle\Entity\IpoetryUser usr WHERE usr.userId=?1');
                $query->setParameter(1,$this->session->get('login_id'));

                $usersfeedcnt=$query->getResult();

                //вытаскиваем пользователя
                if ($usersfeedcnt[0][1]>0){
                $query=$usersfeed->createQuery('SELECT DISTINCT usr.userId,usr.userName,usr.userLastname,usrphoto.userPhotoUrl FROM IpoetryBundle\Entity\IpoetryUser usr JOIN usr.userPhoto usrphoto WHERE usr.userId=?1');
                $query->setParameter(1,$this->session->get('login_id'));
                $user=$query->getResult();
                return $user;                
                } else {
                    return array(0=>array('userId'=>-1,'userName'=>'undefined','userLastname'=>'undefined','userPhotoUrl'=>'undefined'));
                }
            } else
                return array(0=>array('userId'=>-1,'userName'=>'undefined','userLastname'=>'undefined','userPhotoUrl'=>'undefined'));
        } else {
            return array(0=>array('userId'=>-1,'userName'=>'undefined','userLastname'=>'undefined','userPhotoUrl'=>'undefined'));
        }

    }
    //функция выборки данных по пользователю из url страницы
    public function UserURLInfo($request,$user=null) {
            if (!empty($user)) {
                //проверяем что пришло в сессии
                $this->GetCache($request);

                $usersfeed = $this->getDoctrine()->getEntityManager();
                //проверяем существование пользователя
                $query=$usersfeed->createQuery('SELECT COUNT(usr.userId) FROM IpoetryBundle\Entity\IpoetryUser usr WHERE usr.userId=?1');
                $query->setParameter(1,$user);

                $usersfeedcnt=$query->getResult();

                //вытаскиваем пользователя
                if ($usersfeedcnt[0][1]>0){
                    $query=$usersfeed->createQuery('SELECT DISTINCT usr.userId,usr.userName,usr.userLastname,usrphoto.userPhotoUrl FROM IpoetryBundle\Entity\IpoetryUser usr JOIN usr.userPhoto usrphoto WHERE usr.userId=?1');
                    $query->setParameter(1,$user);
                    $user=$query->getResult();
                    return $user;                
                } else {
                    return array(0=>array('userId'=>-1,'userName'=>'undefined','userLastname'=>'undefined','userPhotoUrl'=>'undefined'));
                }
            } else
                return array(0=>array('userId'=>-1,'userName'=>'undefined','userLastname'=>'undefined','userPhotoUrl'=>'undefined'));
    }
    public function array_datetime_fomatter(&$item, $key,$keyname)
    {
        if ($key==$keyname)
            $item->format('Y-m-d H:i:s');
    }
    public function getTranslatorPath($request){
        if ($request->server->get('SERVER_NAME')==='ipoetry.local')
            return $request->server->get('DOCUMENT_ROOT').'/standard-edition-master/src/IpoetryBundle/Resources/translations';
        else if ($request->server->get('SERVER_NAME')==='www.ipoetry.ru' || $request->server->get('SERVER_NAME')==='ipoetry.ru')
            return '/var/www/ipoetryadm/data/www/ipoetry.ru/standard-edition-master/src/IpoetryBundle/Resources/translations';
        else
            return $request->server->get('DOCUMENT_ROOT').'/standard-edition-master/src/IpoetryBundle/Resources/translations';
    }
   
}