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
 * Description of UserEmailAuthController
 * контроллер для верификации email пользователя
 * @author d.krasavin
 */
class UserEmailAuthController extends Controller {
    //массив запросов к БД
    private $sql_array=array('get_user_md5'=>'CALL get_ipoetry_user_md5(:user_md5)',
                             'set_user_md5_status'=>'CALL set_user_md5_status(:user_md5,:user_email_is_verified)');

    public function useremailauthAction(Request $request){
        //$user_name='Тестовый пользователь';
        //$email='denvkr@yandex.ru';
        //$url_verify_param='5hrtGtdfjy';
        //uRoomController::SendVerificationMail($user_name,$email,$url_verify_param);
        //проверяем ссылку пользователя по результатам пишем в базу
        $code_param=$request->get('code');
        if ($code_param!=null && strlen(utf8_decode($code_param))==32) {
            $stmt = $this->getDoctrine()
                         ->getConnection()
                         ->prepare($this->sql_array['get_user_md5']);
            $stmt->bindValue(':user_md5',$code_param);
            $stmt->execute();
            $result_userver=$stmt->fetchAll();
            //корректная ссылка, для непрошедшего верификацию пользователя
            //пишем в базу новый статус и делаем видимую кнопку перехода на
            //главную страницу
            if ($result_userver[0]['ipoetry_user_md5']==1){
                $stmt=$this->getDoctrine()
                         ->getConnection()
                        ->prepare($this->sql_array['set_user_md5_status']);
                $stmt->bindValue(':user_md5',$code_param);                
                $stmt->bindValue(':user_email_is_verified',1);
                $stmt->execute();
            } else {
                //если ссылка уже неактуальная то шлем редиректом на главную страницу
              //return 0;  
            }
                
        }
        
        $result_userver[0]['ipoetry_user_md5']=(empty($result_userver[0]['ipoetry_user_md5'])) ? 0 : $result_userver[0]['ipoetry_user_md5'];
        VarDumper::dump(array('code='=>$code_param,'result_userver='=>$result_userver[0]['ipoetry_user_md5']));
        $html = $this->render('IpoetryBundle:UserEmailAuth:useremailauth.html.twig',array('button_visibility'=>$result_userver[0]['ipoetry_user_md5']));
        return new Response($html);
    }
}
