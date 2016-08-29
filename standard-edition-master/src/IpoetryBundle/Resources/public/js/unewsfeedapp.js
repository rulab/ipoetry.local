/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var unewsfeedApp = angular.module('unewsfeedApp', ['mgcrea.ngStrap','ngAnimate','ngRoute']).filter('trusted_html', ['$sce', function($sce){
        return function(text) {
            return $sce.trustAsHtml(text);
        };
    }])
.config(function($sceProvider) {
  // Completely disable SCE.  For demonstration purposes only!
  // Do not use in new projects.
  $sceProvider.enabled(false);
})
.controller('unewsfeedController', function($scope,$http,$filter,$modal,$route, $routeParams, $location) {
    //var searchedpoetries=this;
    $scope.$route = $route;
    $scope.$location = $location;
    $scope.$routeParams = $routeParams;
    $scope.page;
    $scope.elements_on_page = 20;
    $scope.users_part_count;
    $scope.feedsortingtitle;
    $scope.users_count;
    $scope.userid;
    $scope.poemid;
    $scope.ajaxurls;
    $scope.requesturl;
    $scope.reverse = false;
    $scope.propertyName = 'created';
    $scope.filterset=false;
    $scope.filtersetperiod=365;
    $scope.ownershow=true;
    $scope.MyModal;
    $scope.delpoetryid;
    //$modal.delpoetryid;
    $scope.title = 'Подтверждение действия.';
    $scope.content = 'Вы действительно хотите удалить запись?';

    //карточки ленты стихов
    $scope.unewsfeed = [
    ];
    $scope.plusPage = function()
    {
            $scope.page++;
    };
    //инициализируем параметры scope
    $scope.init = function(userid,element,ajaxurls,requesturl)
    {
        console.log(userid+' '+element+' '+ajaxurls);
        $scope.unewsfeed_part_count;
        $scope.unewsfeed_count;
        $scope.unewsfeed_on_page=element;
        $scope.page=1;
        $scope.ajaxurls=ajaxurls;
        $scope.userid=userid;
        $scope.requesturl=requesturl
        //$scope.modal=modal;
        $scope.addunewsfeed();
    };
    //получение ленты стихов
    $scope.addunewsfeed = function(){
            $scope.users_count=0;
            console.log($scope.ajaxurls+' '+$scope.page+' '+$scope.userid+' '+$scope.elements_on_page);
            if ($scope.page == 1)
                    $scope.comments = [];
            if ($scope.page > 1){
                $scope.page=1;
                $scope.comments = [];
            }

            $http.post($scope.ajaxurls,{type:"get_user_feed_info",url:$scope.requesturl,user:$scope.userid,poetry:$scope.poemid,'datapart':$scope.page}).success(function(response)
            {
                    if (response.result >= 1)
                    {
                        console.log(response.unewsfeedlist);
                        $scope.unewsfeed_part_count = response.unewsfeedlistcnt;
                        //заполняем элементы данными
                        $scope.unewsfeed_count=response.unewsfeedcount;
                        $scope.unewsfeed=response.unewsfeedlist;
                        //if ($scope.frominit===false){
                            $scope.sortBy($scope.propertyName,$scope.filtersetperiod,$scope.reverse);                            
                        //}
                        //защита от множественных ajax
                        if ($scope.page==1)
                            $scope.page++;
                        if (response.ownprofile===0)
                            $scope.ownershow=false;
                        //$scope.$apply();
                    }
                    else
                    {
                        $('#getunewsfeedblockbtn').fadeOut();
                        // $scope.loginError = response.error;
                    }
            });
    };
    //еще комметарии
    $scope.moreuNewsfeed = function(){
        console.log($scope.ajaxurls+' '+$scope.page+' '+$scope.userid+' '+$scope.poemid+' '+$scope.elements_on_page);
        $http.post($scope.ajaxurls,{type:"get_user_feed_info",url:$scope.requesturl,user:$scope.userid,poetry:$scope.poemid,'datapart':$scope.page}).success(function(response)
        {
                if (response.result >= 1)
                {
                    console.log(response.unewsfeedlist);
                    $scope.unewsfeed_part_count = response.unewsfeedlistcnt;
                    //заполняем элементы данными
                    $scope.unewsfeed_count=response.unewsfeedcount;
                    $scope.unewsfeed=$scope.unewsfeed.concat(response.unewsfeedlist);
                    //if ($scope.filterset===false)
                        $scope.sortBy($scope.propertyName,$scope.filtersetperiod,$scope.reverse);
                    $scope.page++;
                    if (response.ownprofile===0)
                        $scope.ownershow=false;
                    //$scope.$apply();
                }
                else
                {
                    $('#getunewsfeedblockbtn').fadeOut();
                    // $scope.loginError = response.error;
                }
        });
    };
    $scope.shbutton = function(element) {
        console.log(element.currentTarget.children[0].getAttribute("style"));
        if (element.currentTarget.children[0].getAttribute("style")==='display: none; opacity: 1;')
            element.currentTarget.children[0].setAttribute("style",'display: block; opacity: 1;');
        //element.currentTarget.children[0].//.stop().fadeToggle();
    };
    $scope.delbutton = function(element) {
        if (element.currentTarget.children[0].getAttribute("style")==='display: block; opacity: 1;')
        element.currentTarget.children[0].setAttribute("style",'display: none; opacity: 1;');
    };
    $scope.delelement = function(element) {
        //console.log($scope.ajaxurls+' '+$scope.page+' '+$scope.userid+' '+$scope.poemid+' '+$scope.elements_on_page);
        //return false;
        $http.post($scope.ajaxurls,{type:"del_user_post",user:$scope.userid,poetry:element}).success(function(response)
        {
            if (response.result === 1)
            {
                // To refresh the page
                //$timeout(function () {
                    // 0 ms delay to reload the page.
                $route.reload();
                //}, 0);
                //$state.transitionTo($state.current, $state.$current.params, { reload: true, inherit: true, notify: true });
                return true;
                //заполняем элементы данными
                $scope.unewsfeed_count=($scope.unewsfeed_count-1);
                for(i=0;i<$scope.unewsfeed.length;i++){
                  //console.log(unewsfeeddate,'#',curdate,(unewsfeeddate<curdate));
                  if (Number($scope.unewsfeed[i].poetry_id)===Number(element)){
                      //indx=i;
                      $scope.unewsfeed.splice(i, 1);
                      break;
                  };
                };
                //if (typeof indx !== 'undefined')
                //    $scope.unewsfeed.splice(indx, 1);
                //$scope.$apply(); 
                //if ($scope.filterset===true)
                //    $scope.sortBy($scope.propertyName,$scope.filtersetperiod,false);
            }
        });
        
    };
    $scope.sortBy = function(propertyName,period,reverse) {
        if ($scope.filterset===false)
            $scope.reverse=true;
        else
            $scope.reverse=reverse;
      //$scope.reverse = ($scope.propertyName === propertyName) ? !$scope.reverse : false;      
      if (Number($scope.filtersetperiod)<Number(period) && $scope.filterset===true){
         //console.log((Number($scope.filtersetperiod)<Number(period)));          
         $scope.filtersetperiod=period;
          $scope.addunewsfeed();
      };
      $scope.filtersetperiod=period;
      $scope.filterset=true;
      console.log(Number(period));
      if (Number(period)!==365){
        curdate=new Date();
        curdate.setDate(curdate.getDate() - Number(period));
        //console.log(propertyName,period,curdate);
        $scope.unewsfeedtmp = [
        ];
        for(i=0;i<$scope.unewsfeed.length;i++){
          unewsfeeddate=new Date($scope.unewsfeed[i].created);
          console.log(unewsfeeddate,'#',curdate,(unewsfeeddate<curdate));
          if (unewsfeeddate>curdate){
              //indx=i;
              $scope.unewsfeedtmp=$scope.unewsfeedtmp.concat($scope.unewsfeed[i])
          };
        };
        //if (typeof indx !== 'undefined') {
        //    $scope.unewsfeed.splice(indx, ($scope.unewsfeed.length-indx));
        //}
        console.log($scope.unewsfeedtmp);
        $scope.unewsfeed=$scope.unewsfeedtmp;
        if ($('#getunewsfeedblockbtn').length<=$scope.unewsfeed_part_count){
           $('#getunewsfeedblockbtn').fadeOut();          
        };
      };
      $scope.$apply();
      //$scope.$apply(function() {
      //  $scope.unewsfeed = $scope.unewsfeed;
      //});
      //$scope.$digest();
      $scope.propertyName = propertyName;
    };
    $scope.Likefunc=function(postid,option){
        //console.log(option,commentid.currentTarget.getAttribute("commentid"));

        var oReq = new XMLHttpRequest();
        oReq.onreadystatechange = function() {
            if (oReq.readyState === 4 && oReq.status === 200) {
                response=JSON.parse(oReq.response);
                console.log(response.poetrylike+' '+response.poetrydislike+' sendLike|Dislike done');
                //$scope.like=response.commentlike;
                //$scope.dislike=response.commentdislike;
                if (typeof response.poetrylike!== 'undefined' && typeof response.poetrydislike!== 'undefined') {
                    for(i=0;i<$scope.unewsfeed.length;i++){
                        //console.log($scope.comments[i].ipoetryUserBlogPostId,commentid.currentTarget.getAttribute("commentid"))
                        if ($scope.unewsfeed[i].poetry_id===Number(postid.currentTarget.getAttribute("poetryid"))){
                            $scope.unewsfeed[i].like=response.poetrylike;
                            $scope.unewsfeed[i].dislike=response.poetrydislike;
                        }
                    };
                    $scope.$apply();
                    //console.log($scope.comments[i],$scope.comments.length);
                }
            }
        };
        
        //шлем доппараметры как json
        //отправляем like к комментарию
        oReq.open("POST", $scope.ajaxurls,true);
        oReq.setRequestHeader("Content-Type", "application/json");
        console.log("login_json="+JSON.stringify({type:"poetrylikerequest",poetry:Number(postid.currentTarget.getAttribute("poetryid")),user:$scope.userid,updown:option}));
        oReq.send(JSON.stringify({type:"poetrylikerequest",poetry:Number(postid.currentTarget.getAttribute("poetryid")),user:$scope.userid,updown:option}));
    };
    $scope.addMessage=function(newmsgurl){
        
        var oReq = new XMLHttpRequest();
        oReq.onreadystatechange = function() {
        if (oReq.readyState === 4 && oReq.status === 200) {
            response=JSON.parse(oReq.response);
            if (response.result===1){
                $http.post($scope.ajaxurls,{type:"new_message",user:$scope.userid}).success(function(response)
                {
                    if (response.result === 1)
                    {
                        $('#poetrymessage').val('');
                        console.log('AJAX_user_new_message result='+response.result);
                        $scope.addunewsfeed();
                    }
                });
            } else
                return 0;
            }
        };

        //посылаем комментарий к стиху
        oReq.open("POST", newmsgurl, true);
        var blob = new Blob([$('#poetrymessage').val()], {type: 'text/plain'});
        oReq.setRequestHeader("Content-Type", "text/plain");
        oReq.send(blob);        

    }
    //function MyModalController($scope) {
    //  $scope.title = 'Подтверждение действия.';
    //  $scope.content = 'Hello Modal<br />This is a multiline message from a controller!';
    //}
    //MyModalController.$inject = ['$scope'];
    $scope.showModal = function(element) {
      $scope.delpoetryid=element.currentTarget.getAttribute("postid");
      $scope.MyModal = $modal({controller: 'unewsfeedController', templateUrl: '/standard-edition-master/web/app_dev.php/modal/'+$scope.userid+'_'+$scope.delpoetryid, show: false,container: 'body',delpoetryid:$scope.delpoetryid});
      console.log('showModal',$scope.delpoetryid,element.currentTarget.getAttribute("postid"),$scope.MyModal);
      $scope.MyModal.$promise.then($scope.MyModal.show);
    };
    $scope.hideModal = function(status,element,ajaxurl) {
      console.log('hideModal',$scope.delpoetryid,status,element.currentTarget.getAttribute("poetryid"),element.currentTarget.getAttribute("userid"),ajaxurl);
      $scope.userid=element.currentTarget.getAttribute("userid");
      $scope.ajaxurls=ajaxurl;
      if (status===1)
        $scope.delelement(element.currentTarget.getAttribute("poetryid"));
      //MyModal.$promise.then(MyModal.hide);
    };
    //функция наблюдения
    $scope.$watchCollection('unewsfeed', function(newNames, oldNames) {
        console.log('unewsfeed changed');
    },true);

});

