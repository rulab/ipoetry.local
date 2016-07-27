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
use Symfony\Component\Form\Extension\Core\Type\EmailType;

use SwiftMailer;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use IpoetryBundle\Controller\uRoomController;

/**
 * Description of LoginVkController
 * контроллер интеграции авторизации с соцсетью вконтакте
 * @author d.krasavin
 */
class LoginVkController extends Controller {
    //put your code here
    public function checkvkAction(Request $request) {
        try {
            $form_fields=array();
        //обрабатываем редирект из vkontakte
        if ($request->get('error')!==null)
            $info=$request->get('error').' '.$request->get('error_reason').' '.$request->get('error_description');
        else
            $info='vkontakte authentication successfull.';
        if ($request->get('code')!==null){
        //генерируем редирект обратно в vkontakte
        //будем использовать AJAX для получения Access Token'a
            
        $info.='<a href="'.$this->configureVKOptions()['access_token_url'].'?'.
                'client_id='.$this->getParameter('ipoetry.vkontakte')['client_id'].
                '&client_secret='.$this->getParameter('ipoetry.vkontakte')['client_secret'].
                '&redirect_uri='.$this->getParameter('ipoetry.vkontakte')['target_path_parameter'].
                '&code='.$request->get('code').'">get vkontakte user token</a>';

        $info2=$this->configureVKOptions()['access_token_url'].'?'.
                'client_id='.$this->getParameter('ipoetry.vkontakte')['client_id'].
                '&client_secret='.$this->getParameter('ipoetry.vkontakte')['client_secret'].
                '&redirect_uri='.$this->getParameter('ipoetry.vkontakte')['target_path_parameter'].
                '&code='.$request->get('code');
        
        $vk_access_token_url=$this->configureVKOptions()['access_token_url'];

        $vk_parameters='{"client_id":"'.$this->getParameter('ipoetry.vkontakte')['client_id'].
                '","client_secret":"'.$this->getParameter('ipoetry.vkontakte')['client_secret'].
                '","redirect_uri":"'.$this->getParameter('ipoetry.vkontakte')['target_path_parameter'].
                '","code":"'.$request->get('code').'"}';
        }
        //читаем данные по пользователю+access_token
        $user_vk_info=json_decode(file_get_contents($info2));
        //пишем access-token в сессию
        if ($request->hasSession()) {
            $session=$request->getSession();
            $session->set('vk_access_token', $user_vk_info->{'access_token'});
        }
        //читаем расширенные данные по пользователю
        $info3=$this->configureVKOptions()['infos_url'].'?'
                .'fields='.$this->configureVKOptions()['fields']
                .'&user_id='.$user_vk_info->{'user_id'}.
                '&v='.$this->getParameter('ipoetry.vkontakte')['version'].
                '&access_token='.$user_vk_info->{'access_token'}.
                '&code='.$request->get('code');
        $user_vk_info2=json_decode(file_get_contents($info3),true);
        
        //если не получили email,а пользователь существует то должны запросить у пользователя email
        //$user_vk_info->{'email'}=null;
        if (isset($user_vk_info2['response'][0]['first_name']))
            $form_fields['first_name']=$user_vk_info2['response'][0]['first_name'];
        if (isset($user_vk_info2['response'][0]['last_name']))
            $form_fields['last_name']=$user_vk_info2['response'][0]['last_name'];
        if (isset($user_vk_info2['response'][0]['city']['title']))
            $form_fields['city']=$user_vk_info2['response'][0]['city']['title'];        
        VarDumper::dump(array('user_vk_info'=>$user_vk_info,'user_vk_info2'=>$user_vk_info2,'$form_fields'=>$form_fields));

        if (property_exists($user_vk_info,'email')==false){
                $user_has_no_email='email parameter was not received.';
                $email_password_form=$this->generate_email_password_form($request);
        } else
              if ($user_vk_info->{'email'}==null) {
                $user_has_no_email='email parameter was not received.';   
                $email_password_form=$this->generate_email_password_form($request);
              } else {
                $user_has_no_email='email parameter was received.';
                $form_fields['email']=$user_vk_info->{'email'};
                $email_password_form=$this->generate_email_password_form($request,$form_fields);
              }

        $html=$this->render('IpoetryBundle:LoginVk:loginvk.html.twig',array('info' => $info,
            'vk_access_token_url'=>$vk_access_token_url,
            'vk_parameters'=>$vk_parameters,
            'user_has_no_email'=>$user_has_no_email,
            'email_password_form'=>$email_password_form->createView(),));
        return new Response($html);            
        } catch (Exception $e) {
          echo 'Выброшено исключение: '.  $e->getMessage();  
        }
    }
    //часть опций используется специально для вконтакте
    static public function configureVKOptions()
    {
        $vkoptions=array(
            'authorization_url'   => 'https://oauth.vk.com/authorize',
            'access_token_url'    => 'https://oauth.vk.com/access_token',
            'infos_url'           => 'https://api.vk.com/method/users.get',

            'use_commas_in_scope' => true,

            'fields'              => 'city,has_mobile,contacts,email',
            'name_case'           => null,
        );

        return $vkoptions;

    }
    public function generate_email_password_form($request,$fields=null){
        $formFactory = Forms::createFormFactoryBuilder()
            ->addExtension(new HttpFoundationExtension())
            ->getFormFactory();
        $translator = new Translator($request->getLocale());
        $form = $formFactory->createBuilder('form', array('action' => '#','method' => 'POST'))
            ->add('username',HiddenType::class,array('attr' => array('maxlength' => 50,'required' => true,'placeholder'=>$translator->trans('John')),'data'=>$fields['first_name'],'label' => $translator->trans('Name')))//array('attr' => array('maxlength' => 50,'required' => true)))
            ->add('userlastname',HiddenType::class,array('attr' => array('maxlength' => 50,'required' => true,'placeholder'=>$translator->trans('Whatson')),'data'=>$fields['last_name'],'label' => $translator->trans('LastName')))//array('attr' => array('maxlength' => 50,'required' => true)))
            ->add('usercity',HiddenType::class,array('attr' => array('maxlength' => 255,'required' => true,'placeholder'=>$translator->trans('Whatson')),'data'=>$fields['city'],'label' => $translator->trans('LastName')))//array('attr' => array('maxlength' => 50,'required' => true)))
            ->add('useremail',EmailType::class,array('attr' => array('maxlength' => 255,'required' => true,'placeholder'=>$translator->trans('JWhatson@mail.ru')),'data'=>$fields['email'],'label' => $translator->trans('email')))//array('attr' => array('maxlength' => 50,'required' => true)))
            ->add('userpassword',TextType::class,array('attr' => array('maxlength' => 20,'required' => true,'placeholder'=>$translator->trans('Wha37on')),'label' => $translator->trans('Password')))
            ->add('Send_email', SubmitType::class, array('attr'=>array('class'=>'btn btn-lg btn-primary btn-block'),'label' => $translator->trans('Send email')))
            ->getForm();
        return $form;
    }
    
    public function onKernelRequest(GetResponseEvent $event) {
            $request = $event->getRequest();
            // some logic to determine the $locale
            echo 'error';
    }

}