/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var usersApp = angular.module('usersApp', ['mgcrea.ngStrap.select', 'mgcrea.ngStrap.tooltip', 'mgcrea.ngStrap.helpers.parseOptions']).filter('trusted_html', ['$sce', function($sce){
        return function(text) {
            return $sce.trustAsHtml(text);
        };
    }]);
usersApp.config(function($sceProvider) {
  // Completely disable SCE.  For demonstration purposes only!
  // Do not use in new projects.
  $sceProvider.enabled(false);
});
usersApp.directive('styler', function () {
    return {
        restrict: 'A',
        require: 'ngModel',
         link: function (scope, element, attrs, ngModelCtrl) {
         	
         		if(attrs.type == 'checkbox')
         		{
         		
         			console.log(ngModelCtrl.modelValue,attrs.ngTrueValue.replace(/'/g,""),attrs);
         			if(attrs.value == attrs.ngTrueValue.replace(/'/g,""))
         				element.prop('checked', true);
         			else	
         				element.prop('checked', false);
         				
         				
         		}
         			console.log(ngModelCtrl.modelValue,attrs);
	            $(element).styler({
					onSelectClosed: function() {
						ngModelCtrl.$setViewValue(element.val());
	                    scope.$apply();	
					}
	            });
        }
    };
});

usersApp.controller('UsersController', function($scope,$http) {
    //var searchedpoetries=this;
    $scope.page;
    $scope.elements_on_page = 20;
    $scope.users_part_count;
    $scope.feedsortingtitle;
    $scope.users_count;
    $scope.usertype;
    $scope.userid;
    $scope.ajaxurls;
    $scope.userid;
    $scope.urltype;
    $scope.ownuser;
    $scope.userssearch=[];
    $scope.userssearch_maxlength=100;
    //карточки подписчиков
    $scope.users = [
    ];
    //города для фильтра
    $scope.selectedbootstrap_cities;
    $scope.cities = {
        availableOptions: [{value:null,label:null}]        
    };
    $scope.bootstrap_cities = {
        selected:null,
        availableOptions: []
    };

    /*
    $scope.searchedpoetries.addPoetrySearch = function() {
      $scope.searchedpoetries.push({p:$scope.searchedpoetriestext.text});
      $scope.searchedpoetriestext.text = '';
    };
    */
    $scope.plusPage = function()
    {
            $scope.page++;
    };

    $scope.init = function(userid,urltype,element,ajaxurls,usertype)
    {/*
        if ($scope.usertype=='subscribers')
            $scope.feedsortingtitle="Вы подписаны на <span>0</span> автора:";
        if ($scope.usertype=='follow')
            $scope.feedsortingtitle="У вас <span>0</span> подписчик:";
        */
        $scope.elements_on_page=element;
        $scope.page=1;
        $scope.usertype=usertype;
        $scope.ajaxurls=ajaxurls;
        $scope.userid=userid;
        $scope.urltype=urltype;
        $scope.ownuser=0;
        $scope.addCities();
        $scope.addUsers(null,null,$scope.urltype);
    };

    $scope.Users=function(usertype){
        $scope.usertype=usertype;
        $scope.addUsers(null,null,$scope.urltype);
    };
/*
    $scope.LoadPoetries = function(){
            if ($scope.page == 1)
                    $scope.searchedpoetries = [];	
            $http.post('/system/ajax/comments.php',{'action':'Load','filter':$scope.filter.comments,'page':$scope.page}).success(function(response)
            {
                    //$scope.comments = response.comments;
                    if(angular.isArray(response.comments))
                    {
                            $scope.comments_count = response.comments.length;
                            $scope.comments = $scope.comments.concat(response.comments);
                            $scope.comment_authors = $scope.comment_authors.concat(response.authors);
                    }
                    else
                            $scope.comments_count = 0;

                    if($scope.comments_count == 0 || $scope.FindInArray($scope.user.id,$scope.comment_authors))
                            $scope.show_comment_form = true;
                    else
                            $scope.show_comment_form = false;

            });

    }
*/
    $scope.addCities = function(){
            config={cache:true};
            $http.post($scope.ajaxurls,{type:"get_cities"},config).success(function(response)
            {
                if (response.result == 1)
                {
                    //если собственная страница пользователя сессии то делаем кнопки "убрать из подписчиков" неактивными
                    console.log(response.cities);
                    $scope.cities.availableOptions = $scope.cities.availableOptions.concat(response.cities);
                    $scope.bootstrap_cities.availableOptions=$scope.bootstrap_cities.availableOptions.concat(response.cities_bootstrap);
                }
            });
    };
    $scope.CityFilter = function(){
        console.log($scope.bootstrap_cities.selected);
        if ($scope.userssearch.length>2)
            $scope.addUsers($scope.bootstrap_cities.selected.label,$scope.userssearch,$scope.urltype);
        else
            $scope.addUsers($scope.bootstrap_cities.selected.label,null,$scope.urltype);
            
    };
    $scope.addUsers = function(city,user,urltype){
            $scope.users_count=0;
            console.log($scope.ajaxurls+' '+$scope.page+' '+$scope.usertype+' '+$scope.elements_on_page+' '+urltype);
            if ($scope.page == 1)
                    $scope.users = [];
            if ($scope.page > 1){
                $scope.page=1;
                $scope.users = [];
            }
                
            $http.post($scope.ajaxurls,{type:"get_users",user:$scope.userid,urltype:urltype,usertype:$scope.usertype,'datapart':$scope.page,'cityfilter':city,'userfilter':user}).success(function(response)
            {
                    if (response.result == 1)
                    {
                        //если собственная страница пользователя сессии то делаем кнопки "убрать из подписчиков" неактивными
                        console.log(response.userslist+' '+response.ownuser);
                        $scope.users_part_count = response.userslist.length;
                        //заполняем элементы данными
                        $scope.users_count=response.userscount;
                        $scope.users=response.userslist;
                        //защита от множественных ajax
                        if ($scope.page==1)
                            $scope.page++;
                        console.log($scope.users);
                        $scope.ownuser=response.ownuser;
                    }
                    else
                    {
                        $('#getusersblockbtn').fadeOut();
                        // $scope.loginError = response.error;
                    }
            });
    };
    $scope.moreUsers = function(city,user,urltype){
            console.log($scope.ajaxurls+' '+$scope.page+' '+$scope.usertype+' '+$scope.elements_on_page);
            $http.post($scope.ajaxurls,{type:"get_users",user:$scope.userid,urltype:$scope.urltype,usertype:$scope.usertype,'datapart':$scope.page,'cityfilter':city,'userfilter':user}).success(function(response)
            {
                    if (response.result == 1)
                    {
                        //если собственная страница пользователя сессии то делаем кнопки "убрать из подписчиков" неактивными
                        console.log(response.userslist+' '+response.ownuser);
                        $scope.users_part_count = response.userslist.length;
                        //заполняем элементы данными
                        $scope.users_count=response.userscount;
                        $scope.users=$scope.users.concat(response.userslist);
                        $scope.page++;
                        console.log($scope.users);
                        $scope.ownuser=response.ownuser;
                    }
                    else
                    {
                        $('#getusersblockbtn').fadeOut();
                        // $scope.loginError = response.error;
                    }
            });
    };
    $scope.Unsubscribe = function(usertype,userid){
            $scope.users_count=0;
            console.log($scope.ajaxurls+' '+$scope.page+' '+$scope.usertype+' '+$scope.elements_on_page);
            if ($scope.page == 1)
                    $scope.users = [];
            if ($scope.page > 1){
                $scope.page=1;
                $scope.users = [];
            }

            console.log($scope.ajaxurls+' '+$scope.page+' '+$scope.usertype,userid.currentTarget.getAttribute("userid"),usertype);
            //$scope.users=$filter('filter')($scope.users, {userId: '!16'});
            if (null!==$scope.bootstrap_cities.selected)
                city=$scope.bootstrap_cities.selected.label
            else
                city=null;
            if ($scope.userssearch.length>2 && $scope.userssearch.length<=$scope.userssearch_maxlength)
                user=$scope.userssearch;
            else
                user=null;

            $http.post($scope.ajaxurls,{type:"unsubscribe",user:$scope.userid,unsubscribeuser:userid.currentTarget.getAttribute("userid"),usertype:usertype,'datapart':$scope.page,'cityfilter':city,'userfilter':user}).success(function(response)
            {
                    if (response.result == 1)
                    {
                        console.log(response.result);
                        $scope.users_part_count = response.userslist.length;
                        //заполняем элементы данными
                        $scope.users=response.userslist;
                        console.log($scope.users);
                    }
            });
    };
    $scope.change_userssearch=function(){
        //console.log($scope.userssearch.length,$scope.userssearch);
        //шлем ajax на сервер для применения фильтра по ФИО пользователя
        if ($scope.userssearch.length>2 && $scope.userssearch.length<=$scope.userssearch_maxlength){
            if (null!==$scope.bootstrap_cities.selected)
                $scope.addUsers($scope.bootstrap_cities.selected.label,$scope.userssearch);
            else
                $scope.addUsers(null,$scope.userssearch);                
        }
        //console.log('$scope.userssearch wrong length');        
    };
    $scope.$watch(function($scope){
        if ($scope.ownuser==1){
            $('button[class="users-user-subscribers-del"]').each(function(index){
              console.log($(this));
              $(this).fadeIn();
            if ($scope.usertype=='subscribers'){
               $('button[class="users-user-subscribers-del"]:eq(0)').fadeOut();
               $('button[class="users-user-subscribers-del"]:eq(1)').fadeIn();             
            }
            if ($scope.usertype=='follow'){
               $('button[class="users-user-subscribers-del"]:eq(0)').fadeIn();
               $('button[class="users-user-subscribers-del"]:eq(1)').fadeOut(); 
            }
            });
            if ($scope.usertype=='subscribers')
                $scope.feedsortingtitle="подписан(а) на <span>"+$scope.users_count+"</span> человек(а):";
            if ($scope.usertype=='follow')
                $scope.feedsortingtitle="<span>"+$scope.users_count+"</span> человек(а) в подписчиках:";
        } else {
            $('button[class="users-user-subscribers-del"]').each(function(index){
              console.log($(this));
              $(this).fadeOut();
            });
            if ($scope.usertype=='subscribers')
                $scope.feedsortingtitle="подписан(а) на <span>"+$scope.users_count+"</span> человек(а):";
            if ($scope.usertype=='follow')
                $scope.feedsortingtitle="<span>"+$scope.users_count+"</span> человек(а) в подписчиках:";
        }
    },true);

});
//

/*
function initSliders(targetSlider, targetPager) {
  $(targetSlider).bxSlider({
    pagerCustom: targetPager,
    preloadImages: 'all',
    infiniteLoop: false
  });
}

var cosmo = angular.module("Cosmo",['JQPlugins','angular.vertilize','ru.modal-crop','angular-img-cropper','angular.filter','ngJcrop','youtube-embed']);
cosmo.directive('finishRepeat', function ($timeout) {  
    return function (scope, element, attrs) {  
        scope.$watch(attrs.finishRepeat, function (callback) {  
  
            if (scope.$last === undefined) {  
                scope.$watch('htmlElement', function () {  
                    if (scope.htmlElement !== undefined) {  
                        $timeout(eval(callback), 1);  
                    }  
                });  
            }  
  
            if (scope.$last) {  
                eval(callback)(); 
            }  
        });  
    }  
});  
cosmo.config(function(ngJcropConfigProvider){

    // [optional] To change the jcrop configuration
    // All jcrop settings are in: http://deepliquid.com/content/Jcrop_Manual.html#Setting_Options
    ngJcropConfigProvider.setJcropConfig({
        bgColor: 'black',
        bgOpacity: .4,
        aspectRatio: 16 / 9
    });

    // [optional] To change the css style in the preview image
    ngJcropConfigProvider.setPreviewStyle({
        'width': '560px',
        'overflow': 'hidden',
        'margin-left': '5px'
    });

            // Used to differ the uplaod example
            ngJcropConfigProvider.setJcropConfig('logo', {
                bgColor: 'black',
                bgOpacity: .4,
                aspectRatio: 1,
                maxWidth: 560,
            });

            // Used to differ the uplaod example
            ngJcropConfigProvider.setJcropConfig('bg', {
                bgColor: 'black',
                bgOpacity: .4,
                aspectRatio: 3,
                maxWidth: 1500,
            }); 
            
            ngJcropConfigProvider.setJcropConfig('ads', {
                bgColor: 'black',
                bgOpacity: .4,
                aspectRatio: 11.3,
                maxWidth: 945,
            });                         
});

cosmo.filter('searchFor', function(){
	return function(arr, searchString){
		if(!searchString){
			return arr;
		}
		var result = [];
		searchString = searchString.toLowerCase();
		angular.forEach(arr, function(item){
			if(item.name.toLowerCase().indexOf(searchString) !== -1){
				result.push(item);
			}
		});
		return result;
	};
});

cosmo.controller("cosmo",function($scope,$http)
{
	//$scope.page = 1;
	$scope.elements_on_page = 24;
	$scope.goods = [];
	$scope.exclude_goods = [];
	$scope.companies = [];
	$scope.brands = [];
	$scope.comments = [];
	$scope.comment_authors = [];
	$scope.show_comment_form = false;
	$scope.default_user = {fav:[],subscribe:[]};
	$scope.user = {fav:[],subscribe:[]};
	$scope.isCabinet = false;
	$scope.regions = [{'id':0,'name':'Р›СЋР±РѕР№'}];
	$scope.cities = [{'id':0,'name':'Р›СЋР±РѕР№'}];	
	$scope.brand = {'lines':[{'value':''}]};
	$scope.good = {};
	$scope.filter = {};
	$scope.filter.goods = {'brands':[],'line':'0','type':[]};
	$scope.filter.offers = {};
	$scope.filter.companies = {'country':'0','region':0,'region_new':0,'usertype':"0"};
	$scope.$watch('filter',function(){
		$scope.page = 1;
	},true);
	$scope.plusPage = function()
	{
		$scope.page++;
	}
	
	$scope.equalH = function()
	{
		equalH();	
	}
	$scope.brandToggle = function(id)
	{
		$("#brand-"+id).slideToggle();
	}	
	$scope.printCurrency = function(cur)
	{
		var r = 'СЂСѓР±';
		switch(cur)
		{
			case 'rub': r ='СЂСѓР±';break;
			case 'usd': r ='$';break;
			case 'eur': r ='eur';break;
			case 'byr': r ='Р±РµР».СЂСѓР±';break;
			case 'uah': r ='РіСЂРЅ';break;
		}
		return r;	
	}
	$scope.currency = [
	{'id':'rub','name':'СЂСѓР±'},
	{'id':'usd','name':'$'},
	{'id':'eur','name':'eur'},
	{'id':'byr','name':'Р±РµР».СЂСѓР±'},
	{'id':'uah','name':'РіСЂРЅ'},
	];
	$scope.bxslidereach = function()
	{
		
		$(document).ready(function(){
		$(".comments-bxslider-thumb").each(function(index,element){
			var id = $(element).attr("data-bx-id");
			initSliders("#bxs-"+id,"#bx-pager-"+id);
		});
		
		$(".ya-share2").each(function(index,element){
			var url = $(element).attr("data-url");
			var services = $(element).attr("data-services");
			Ya.share2(element, {
			    theme: {
			        services: 'vkontakte,facebook,odnoklassniki,moimir,twitter'	
			    },
			    content: {
		        	url: url
		        }
			});
		});
				
		});

	}
				
	$scope.renderHtml = function(html_code)
	{
	    return $sce.trustAsHtml(html_code);
	};	
	$scope.Range = function(start, end) {
	    var result = [];
	    for (var i = start; i <= end; i++) {
	        result.push(i);
	    }
	    return result;
	};
	$scope.DelIndexFromArr = function(index,arr){
	console.log(index,arr);
		$scope[arr.split(".")[0]][arr.split(".")[1]].splice(index, 1);	
	}	
	$scope.Login = function(){
		$http.post('/system/ajax/user.php',{'action':'Login','login':$scope.user.login,'password':$scope.user.password}).success(function(response)
		{
			if (response.user.id > 0)
			{
				$scope.user = response.user;
				$scope.loginError = "";
			
		        $(".main-enter-menu").fadeToggle();
		        $(".mobile-menu-hidden-wrapper").slideUp();
		        $(".login-bubble-arrow").fadeToggle();
		        $(".main-pass-recovery").fadeOut();
			}
			else
			{
				
				$scope.loginError = response.error;
			}
		});
	}
	$scope.LoginByHash = function(){
		$http.post('/system/ajax/user.php',{'action':'LoginByHash'}).success(function(response)
		{
			$scope.user = response.user;
		});
	}	
	$scope.Logout = function(){
		$http.post('/system/ajax/logout.php',{'action':'Logout'}).success(function(response)
		{
			$scope.user = {};
			if($scope.isCabinet)
				location.replace('/');
		});
	}
	$scope.resetPwd = function(){
		$http.post('/system/ajax/user.php',{'action':'ResetPwd','user':$scope.user,'hash':$scope.hash}).success(function(response)
		{
			$scope.resetPwdSuccess = "Р’Р°С€ РїР°СЂРѕР»СЊ СѓСЃРїРµС€РЅРѕ СЃРѕС…СЂР°РЅРµРЅ";
		});		
	}
	$scope.preResetPwd = function(){
		$http.post('/system/ajax/user.php',{'action':'preResetPwd','user':$scope.user}).success(function(response)
		{
			$scope.resetPwdSuccess = "Р”Р°Р»СЊРЅРµР№С€РёРµ РёРЅСЃС‚СЂСѓРєС†РёРё РѕС‚РїСЂР°РІР»РµРЅС‹ РЅР° Р’Р°С€ РїРѕС‡С‚РѕРІС‹Р№ СЏС‰РёРє";
		});		
	}	
	$scope.CheckPermission = function(url,isCompany){
			$scope.isCabinet = true;
			if (angular.equals($scope.default_user,$scope.user))
				location.replace("/");
			else
			{
				if(isCompany != -1)
				{
					if(isCompany != $scope.user.isCompany)
					{
						if(isCompany)
							location.replace(url.replace("-company.phtml",".phtml"));
						else
							location.replace(url.replace(".phtml","-company.phtml"));
		
					}
				}
			}
					

	}
	$scope.LoadUser = function(){
		$http.post('/system/ajax/user.php',{'action':'Load'}).success(function(response)
		{
			$scope.user = response.user;
			$scope.GetRegions(1);
			$scope.GetCities(1);
		});
	}
	$scope.Comment = function(){
		if($scope.comment._name.length > 200)
		{
			$http.post('/system/ajax/comments.php',{'action':'Save','comment':$scope.comment,'user':$scope.user}).success(function(response)
			{
				if (response.error)
				{
					$scope.commentError = response.error;
				}
				else
				{
					$scope.commentSuccess = "РЎРїР°СЃРёР±Рѕ Р·Р° Р’Р°С€ РѕС‚Р·С‹РІ";	
					$scope.LoadComments();
					$scope.comment = {};
					$scope.comments = [];
				}	
			});
		}
		else $scope.commentError = "РћС‚Р·С‹РІ РґРѕР»Р¶РµРЅ Р±С‹С‚СЊ РЅРµ РјРµРЅРµРµ 200 СЃРёРјРІРѕР»РѕРІ";	
	}	
	$scope.LoadComments = function(){
		if ($scope.page == 1)
			$scope.comments = [];	
		$http.post('/system/ajax/comments.php',{'action':'Load','filter':$scope.filter.comments,'page':$scope.page}).success(function(response)
		{
			//$scope.comments = response.comments;
			if(angular.isArray(response.comments))
			{
				$scope.comments_count = response.comments.length;
				$scope.comments = $scope.comments.concat(response.comments);
				$scope.comment_authors = $scope.comment_authors.concat(response.authors);
			}
			else
				$scope.comments_count = 0;		

			if($scope.comments_count == 0 || $scope.FindInArray($scope.user.id,$scope.comment_authors))
				$scope.show_comment_form = true;
			else
				$scope.show_comment_form = false;
								
		});
			
	}
	$scope.LoadSubComments = function(){
		if ($scope.page == 1)
			$scope.comments = [];	
		$http.post('/system/ajax/comments.php',{'action':'LoadSubComments','filter':$scope.filter.comments,'page':$scope.page}).success(function(response)
		{
			//$scope.comments = response.comments;
			if(angular.isArray(response.comments))
			{
				$scope.comments_count = response.comments.length;
				$scope.comments = $scope.comments.concat(response.comments);
			
			}
			else
				$scope.comments_count = 0;		

								
		});
			
	}	
	$scope.AnswerComment = function(id,answer){
		$http.post('/system/ajax/comments.php',{'action':'Answer','id':id,'answer':answer}).success(function(response)
		{
			
		});
	}
	$scope.UserAnswerComment = function(){
		$http.post('/system/ajax/comments.php',{'action':'UserAnswerComment','comment':$scope.comment,'user':$scope.user}).success(function(response)
		{
			if (response.error)
			{
				//$scope.loginError = response.error;
			}
			else
			{
				$scope.commentSuccess = "РЎРїР°СЃРёР±Рѕ Р·Р° Р’Р°С€ РѕС‚Р·С‹РІ";	
			}	
		});
	}								
	
	$scope.isFav = function(id)
	{
		if ($scope.user.fav.indexOf(id.toString()) != -1)
			return true;
		else
			return false;	
	}
	$scope.Fav = function(id)
	{
		console.log(id);
		if($scope.isFav(id))
			$scope.user.fav.splice($scope.user.fav.indexOf(id), 1);	
		else
			$scope.user.fav[$scope.user.fav.length] = id.toString();	
			
		$http.post('/system/ajax/user.php',{'action':'Fav','fav':$scope.user.fav});
	}
	$scope.isSubscribe = function(id)
	{
		if ($scope.user.subscribe.indexOf(id.toString()) != -1)
			return true;
		else
			return false;	
	}
	$scope.Subscribe = function(id)
	{
		if($scope.isSubscribe(id))
			$scope.user.subscribe.splice($scope.user.subscribe.indexOf(id), 1);	
		else
			$scope.user.subscribe[$scope.user.subscribe.length] = id.toString();	
			
		$http.post('/system/ajax/user.php',{'action':'Subscribe','subscribe':$scope.user.subscribe});
	}			
	$scope.SaveSettings = function(mode){
		$http.post('/system/ajax/user.php',{'action':'Save','mode':mode,'user':$scope.user}).success(function(response)
		{
			if (response.error)
			{
				$scope.loginError = response.error;
			}
			else
			{
				$scope.loginSuccess = "РР·РјРµРЅРµРЅРёСЏ СѓСЃРїРµС€РЅРѕ СЃРѕС…СЂР°РЅРµРЅС‹";	
			}	
		});
	}	
	$scope.SaveBrand = function(mode){
		$http.post('/system/ajax/brands.php',{'action':'Save','brand':$scope.brand}).success(function(response)
		{
			if (response.error)
			{
				//$scope.loginError = response.error;
			}
			else
			{
				$scope.brandSuccess = "РР·РјРµРЅРµРЅРёСЏ СѓСЃРїРµС€РЅРѕ СЃРѕС…СЂР°РЅРµРЅС‹";	
			}	
		});
	}
	$scope.SaveGood = function(mode){
		$http.post('/system/ajax/goods.php',{'action':'Save','good':$scope.good,'offer':$scope.offer}).success(function(response)
		{
			if (response.error)
			{
				$scope.loginError = response.error;
			}
			else
			{
				$scope.goodSuccess = "РР·РјРµРЅРµРЅРёСЏ СѓСЃРїРµС€РЅРѕ СЃРѕС…СЂР°РЅРµРЅС‹";
				$scope.good.id = response.good;
			}	
		});
	}
	$scope.Order = function(id,good_id,company_id){
		$http.post('/system/ajax/orders.php',{'action':'Save','_link4':id,'_link1':good_id,'_link2':company_id,'user':$scope.user}).success(function(response)
		{
			if (response.error)
			{
				//$scope.loginError = response.error;
			}
			else
			{
				$scope.orderSuccess = "Р—Р°РєР°Р· СѓСЃРїРµС€РЅРѕ РѕС‚РїСЂР°РІР»РµРЅ";	
			}	
		});
	}
	$scope.OrderFinish = function(id){
		$http.post('/system/ajax/orders.php',{'action':'Finish','id':id}).success(function(response)
		{
		});
	}	
	$scope.GetRegions = function(mode)
	{
		if(mode == 1)
			var input = $scope.user.country;
		else
			var input = $scope.filter.companies.country;
			
		$http.post('/system/ajax/companies.php',{'action':'GetRegions','country':input}).success(function(response)
		{
			if(response != "null")
				$scope.regions = response;
			else
			{
				if(mode == 1)
				{
					$scope.regions = [{'id':0,'name':'Р’С‹Р±РµСЂРёС‚Рµ СЂРµРіРёРѕРЅ'}];
					$scope.cities = [{'id':0,'name':'Р’С‹Р±РµСЂРёС‚Рµ РіРѕСЂРѕРґ'}];
					$scope.user.region = 0;
					$scope.user.region_new = 0;				
				}
				else
				{
					$scope.regions = [{'id':0,'name':'Р›СЋР±РѕР№'}];
					$scope.cities = [{'id':0,'name':'Р›СЋР±РѕР№'}];
					$scope.filter.companies.region = 0;
					$scope.filter.companies.region_new = 0;	
				}							
			}			
		});	
	}
	$scope.GetCities = function(mode)
	{
		if(mode == 1)
			var input = $scope.user.region;
		else
			var input = $scope.filter.companies.region;
		
		$http.post('/system/ajax/companies.php',{'action':'GetCities','region':input}).success(function(response)
		{
			if(response != "null")
				$scope.cities = response;
			else
			{
				if(mode == 1)
				{
					$scope.cities = [{'id':0,'name':'Р’С‹Р±РµСЂРёС‚Рµ РіРѕСЂРѕРґ'}];
					$scope.user.region_new = 0;				
				}
				else
				{
					$scope.cities = [{'id':0,'name':'Р›СЋР±РѕР№'}];
					$scope.filter.companies.region_new = 0;
				}	
			}		
		
		});	
	}								
	$scope.GetCompanies = function()
	{
		if ($scope.page == 1)
			$scope.companies = [];
		$http.post('/system/ajax/companies.php',{'action':'GetCompanies','filter':$scope.filter.companies,'page':$scope.page}).success(function(response)
		{
			$scope.companies_count = response.companies.length;		
			$scope.companies = $scope.companies.concat(response.companies);
		});
	}
	$scope.LoadBrands = function()
	{
		if ($scope.page == 1)
			$scope.brands = [];	
		$http.post('/system/ajax/brands.php',{'action':'GetBrands','filter':$scope.filter.brands,'page':$scope.page}).success(function(response)
		{
			$scope.brands_count = response.brands.length;		
			$scope.brands = $scope.brands.concat(response.brands);
		});
	}
	$scope.LoadBrand = function(id)
	{
		$http.post('/system/ajax/brands.php',{'action':'GetBrand','id':id}).success(function(response)
		{	
			$scope.brand = response.brand;
		});
	}	
	$scope.GetBrandLines = function(brand)
	{
		$http.post('/system/ajax/brands.php',{'action':'GetLines','brand':brand}).success(function(response)
		{
				
			$scope.lines = response.lines;
		});	
	}		
	$scope.LoadOrders = function()
	{
		$http.post('/system/ajax/orders.php',{'action':'GetOrders','filter':$scope.filter.orders}).success(function(response)
		{
			$scope.orders = response.orders;
			$scope.orders_count = response.count;
		});
	}
	$scope.CountOrders = function()
	{
		$http.post('/system/ajax/orders.php',{'action':'GetOrders','count':true}).success(function(response)
		{
			$scope.orders_count = response.count;
		});
	}	
	$scope.FindInArray = function(id,array)
	{
		var idx = -1;
		array.forEach(function(element, index){
		
			if(element == id)
			{
				idx = index;
			}	
		});
		return idx;

	}		
	$scope.FindObjectByIdInArray = function(id,array)
	{
		var idx = -1;
		array.forEach(function(element, index){
		
			if(element.id == id)
			{
				idx = index;
			}	
		});
		return idx;

	}
	$scope.AddFilterBrand = function(id,name)
	{
		if($scope.FindObjectByIdInArray(id,$scope.filter.goods.brands) == -1)
		{
			$scope.filter.goods.brands.push({'id':id,'name':name});
			//$scope.page = 1;
			$scope.GetGoods();
		}	
	}
	
	$scope.DelFilterBrand = function(id,name)
	{
		var idx = $scope.FindObjectByIdInArray(id,$scope.filter.goods.brands);
		
		if(idx != -1)
		{
			$scope.filter.goods.brands.splice(idx,1);
			//$scope.page = 1;
			$scope.GetGoods();
		}	
	}
	$scope.AddFilterType = function(id,name)
	{
		if($scope.FindObjectByIdInArray(id,$scope.filter.goods.type) == -1)
		{
			$scope.filter.goods.type.push({'id':id,'name':name});
			//$scope.page = 1;
			$scope.GetGoods();
		}	
	}
	
	$scope.DelFilterType = function(id,name)
	{
		var idx = $scope.FindObjectByIdInArray(id,$scope.filter.goods.type);
		
		if(idx != -1)
		{
			$scope.filter.goods.type.splice(idx,1);
			//$scope.page = 1;
			$scope.GetGoods();
		}	
	}
	$scope.AddPredstavitelstvo = function()
	{
		$scope.user.predstavitelstvo.push({});
	}
	$scope.GetGoods = function()
	{
		if ($scope.page == 1)
			$scope.goods = [];
		$http.post('/system/ajax/goods.php',{'action':'GetGoods','filter':$scope.filter.goods,'page':$scope.page,'no_limit':$scope.no_limit}).success(function(response)
		{
			if(angular.isArray(response.goods))
			{
				$scope.goods_count = response.goods.length;
				$scope.goods = $scope.goods.concat(response.goods);
			}
			else
				$scope.goods_count = 0;	
			
			
			if($scope.filter.goods.brands.length || $scope.filter.goods.type.length)
				$scope.hideAddOfferArray = false;
			else
				$scope.hideAddOfferArray = true;
			
			$scope.goodSuccess = true;		
		});
	}
	$scope.GetOffers = function()
	{
		$http.post('/system/ajax/offers.php',{'action':'GetOffers','filter':$scope.filter.offers,'company_filter':$scope.filter.companies}).success(function(response)
		{
			$scope.offers = response.offers;
		});
	}
	$scope.SaveOffer = function(id,price,isset,opt,currency)
	{
		$http.post('/system/ajax/offers.php',{'action':'Save','id':id,'price':price,'isset':isset,'opt':opt,'currency':currency}).success(function(response)
		{
		});
	}
	$scope.AddOffer = function(id)
	{
		$http.post('/system/ajax/offers.php',{'action':'Add','id':id}).success(function(response)
		{
		});
	}
	$scope.AddArrayOffer = function()
	{
		$scope.hideAddOfferArray = 1;
		$http.post('/system/ajax/goods.php',{'action':'GetGoods','filter':$scope.filter.goods,'onlyid':1}).success(function(response)
		{
			var goods = response.goods;
			var goods_count = response.goods.length;
			$http.post('/system/ajax/offers.php',{'action':'AddArray','goods':goods}).success(function(response)
			{
				$scope.hideAddOfferArray = 0;
				alert("Р’ Р’Р°С€ РєР°С‚Р°Р»РѕРі РґРѕР±Р°РІР»РµРЅРѕ С‚РѕРІР°СЂРѕРІ: "+goods_count);
				//location.reload();
			});			
		});
	}
	$scope.LoadAdv = function(id)
	{
		if($scope.user.id > 0)
		{
			$http.post('/system/ajax/adv.php',{'action':'Load','_link1':id}).success(function(response)
			{
				if(response.adv)
				{
					$scope.adv = response.adv;
					$scope.iHaveAdv = true;
				}	
			});
		}	
	}
	$scope.LoadAdvList = function()
	{
		if($scope.user.id > 0)
		{
			$http.post('/system/ajax/adv.php',{'action':'LoadList'}).success(function(response)
			{
				if(response.advs)
				$scope.advs = response.advs;
			});
		}	
	}	
	$scope.SaveAdv = function(id)
	{
			$scope.adv._link1 = id;
			$http.post('/system/ajax/adv.php',{'action':'Save','adv':$scope.adv}).success(function(response)
			{
				$scope.successAdv = response.status;
			});	
	}
	$scope.AdvActive = function(id,active)
	{
		$http.post('/system/ajax/adv.php',{'action':'Active','id':id,'active':active}).success(function(response)
		{
		});	
	}
	$scope.AdvClick = function(id)
	{
		$http.post('/system/ajax/adv.php',{'action':'Click','id':id}).success(function(response)
		{
		});	
	}
	$scope.OrderAnswer = function(id,answer)
	{
		$http.post('/system/ajax/orders.php',{'action':'OrderAnswer','id':id,'answer':answer}).success(function(response)
		{
			$scope.LoadOrders();
		});	
	}													
});	
*/