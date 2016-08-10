/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var unewsfeedApp = angular.module('unewsfeedApp', ['mgcrea.ngStrap.select', 'mgcrea.ngStrap.tooltip', 'mgcrea.ngStrap.helpers.parseOptions']).filter('trusted_html', ['$sce', function($sce){
        return function(text) {
            return $sce.trustAsHtml(text);
        };
    }]);
unewsfeedApp.config(function($sceProvider) {
  // Completely disable SCE.  For demonstration purposes only!
  // Do not use in new projects.
  $sceProvider.enabled(false);
});
unewsfeedApp.controller('unewsfeedController', function($scope,$http,$filter) {
    //var searchedpoetries=this;
    $scope.page;
    $scope.elements_on_page = 20;
    $scope.users_part_count;
    $scope.feedsortingtitle;
    $scope.users_count;
    $scope.userid;
    $scope.poemid;
    $scope.ajaxurls;
    $scope.requesturl;
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
                        //защита от множественных ajax
                        if ($scope.page==1)
                            $scope.page++;
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
                    $scope.page++;
                }
                else
                {
                    $('#getunewsfeedblockbtn').fadeOut();
                    // $scope.loginError = response.error;
                }
        });
    };
    $scope.Likefunc=function(postid,option){
        //console.log(option,commentid.currentTarget.getAttribute("commentid"));

        var oReq = new XMLHttpRequest();
        oReq.onreadystatechange = function() {
            if (oReq.readyState == 4 && oReq.status == 200) {
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
    //функция наблюдения
    $scope.$watch(function($scope){

    },true);

});