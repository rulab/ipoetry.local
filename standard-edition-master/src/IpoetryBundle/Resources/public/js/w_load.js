/*
window.onload = function () {
	var Width = (window.screen.width);
	var Height = (window.screen.height);
	if (Width < 1160) {
		
		if (document.getElementById("container_main")!==null) {
			document.getElementById("container_main").style.left="0px";			
		}
		if (document.getElementById("container_news")!==null) {
			document.getElementById("container_news").style.left="0px";			
		}
		if (document.getElementById("container_rentrules")!==null) {
			document.getElementById("container_rentrules").style.left="0px";			
		}
		if (document.getElementById("container_cars")!==null) {
			document.getElementById("container_cars").style.left="0px";			
		}
		if (document.getElementById("container_contact")!==null) {
			document.getElementById("container_contact").style.left="0px";			
		}		
	} else if (Width >= 1160) {
		
		var left_size=Math.round((Width-1160)/2);

		if (document.getElementById("container_main")!==null) {
			document.getElementById("container_main").style.left=String(left_size)+"px";			
		}
		if (document.getElementById("container_news")!==null) {
			document.getElementById("container_news").style.left=String(left_size)+"px";			
		}
		if (document.getElementById("container_rentrules")!==null) {
			document.getElementById("container_rentrules").style.left=String(left_size)+"px";			
		}
		if (document.getElementById("container_cars")!==null) {
			document.getElementById("container_cars").style.left=String(left_size)+"px";			
		}
		if (document.getElementById("container_contact")!==null) {
			document.getElementById("container_contact").style.left=String(left_size)+"px";			
		}
	}
	document.getElementById("body_container").style.visibility="visible";
}
*/
//$(document).ready(function() {

function btn_font_size() {
	//console.log('clientWidth'+' '+$('#body_container').prop('clientWidth'));
	//console.log('clientHeight'+' '+$('#body_container').prop('clientHeight'));

	var Width = $('#body_container').attr('clientWidth');
	var Height = $('#body_container').attr('clientHeight');
	
	//console.log(Width);
	//console.log(Height);	
	//console.log($(".btn-lg, .btn-group-lg > .btn[name='_Registering']").css('font-size'));
	if (Width < 700) {
                //уменшаем размер шрифта на кнопках
		$("button[name='_Registering']:eq(0)").css('font-size','10px');
		$("button[name='_Registering']:eq(0)").html('Оставить запрос');
                console.log($("#requestauto"));
		$("[name='_Sign_In']").css('font-size','12px');
                $(".form-signin-heading").css('font-size','16px');
                //модифицируем структуру страницы с row(3) на row(2)
                if ($(".row:eq(1)").length && $(".row:eq(2)").length){
                    //выбираем элементы из row(2) и вставляем после row(1) 
                    $(".row:eq(1)").children().insertAfter(".row:eq(0)");
                    //выбираем элементы из row(2) и вставляем после row(1)
                    $(".row:eq(2)").children().insertAfter(".col-xs-6:eq(2)");
                    $(".row:eq(1)").remove();
                    $(".row:eq(2)").remove();
                    $('<div></div>').insertAfter(".row:eq(0)");
                    $(".row:eq(0)+div").addClass('row');
                    $(".row:eq(1)").html('<div class="col-xs-12"></div><div class="col-xs-12"></div><div class="col-xs-12"></div><div class="col-xs-12"></div><div class="col-xs-12"></div><div class="col-xs-12"></div>');
                    $(".col-xs-12:eq(0)").html($(".col-xs-6:eq(0)").html());
                    $(".col-xs-12:eq(1)").html($(".col-xs-6:eq(1)").html());
                    $(".col-xs-12:eq(2)").html($(".col-xs-6:eq(2)").html());
                    $(".col-xs-12:eq(3)").html($(".col-xs-6:eq(3)").html());
                    $(".col-xs-12:eq(4)").html($(".col-xs-6:eq(4)").html());
                    $(".col-xs-12:eq(5)").html($(".col-xs-6:eq(5)").html());
                    $(".col-xs-6").remove();//:gt(5)
                }
	} else if (Width >= 700) {
            console.log('>700');
		$("[name='_Registering']").css('font-size','18px');
		$("[name='_Sign_In']").css('font-size','18px');
                $(".form-signin-heading").css('font-size','30px');
                //console.log($(".row:eq(2)"));
                if (!$(".row:eq(2)").length){
                    $('<div></div>').insertAfter(".row:eq(1)");
                    $(".row:eq(1)+div").addClass('row');
                    $(".row:eq(2)").html('<div class="col-xs-6 col-md-4"></div><div class="col-xs-6 col-md-4"></div><div class="col-xs-6 col-md-4"></div>');
                    $(".col-xs-6:eq(0)").html($(".col-xs-12:eq(3)").html());
                    $(".col-xs-6:eq(1)").html($(".col-xs-12:eq(4)").html());
                    $(".col-xs-6:eq(2)").html($(".col-xs-12:eq(5)").html());                    
                }
                $(".col-xs-12:gt(2)").remove();
                $(".col-xs-12:eq(0)").attr('class','col-xs-6 col-md-4');
                $(".col-xs-12:eq(1)").attr('class','col-xs-6 col-md-4');
                $(".col-xs-12:eq(2)").attr('class','col-xs-6 col-md-4');
	}
}
//});

function BrowserInfo() {
 uaVers="";
	if (window.navigator.userAgent.indexOf("Opera") >= 0)
	  {
	   ua = "Opera";
	   uaVers=window.navigator.userAgent.substr(window.navigator.userAgent.indexOf("Opera")+6,4);
	  }
	else
	if (window.navigator.userAgent.indexOf("Gecko") >= 0)// (Mozilla, Netscape, FireFox)
	  {
	   ua = "Netscape";
	   uaVers=window.navigator.userAgent.substr(window.navigator.userAgent.indexOf("Gecko")+6,8)+ " ("+ window.navigator.userAgent.substr(8,3) + ")";
	  }
	else
	if (window.navigator.userAgent.indexOf("MSIE") >= 0)
	  {
	   ua = "Explorer";
	   uaVers=window.navigator.userAgent.substr(window.navigator.userAgent.indexOf("MSIE")+5,3);
	  }
	else
	   ua = window.navigator.appName;
return ua;
}

function Dimension () {
	var Width = (window.screen.width);
	var Height = (window.screen.height);
	if (Width < 1160) {
		document.getElementById("container_main").style.left="0px";
	} else if (Width >= 1160) {
		var left_size=Math.round((Width-1160)/2);
		document.getElementById("container_main").style.left=String(left_size)+"px";
	}
}

function gotopage(Page){
	switch (Page)
	{
	case 0:
		window.location.href = "http://"+location.host+"/index.php";
		break;
	case 1:
		window.location.href = "http://"+location.host+"/news.php";
		break;
	case 2:
		window.location.href = "http://"+location.host+"/rentrules.php";
		break;
	case 3:
		window.location.href = "http://"+location.host+"/cars.php";
		break;
    case 4:
		window.location.href = "http://"+location.host+"/contact.php";
		break;
	};
}