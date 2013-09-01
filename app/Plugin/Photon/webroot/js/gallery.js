$(document).ready(function(){
	 var w=$('.grid_8').width()-100;
	var h=w/1.5;
	 $('#categories li > a').click(function(){
			  var cl=$(this).closest("ul").closest("li").attr('class');
		    if ((cl=== undefined)||(cl.indexOf('current')<0)){
		      $('#categories li ul').slideUp();
		      $(this).next().slideToggle();
		      $('#categories li').removeClass('current');
		      $(this).parent().addClass('current');
		    }
		    else
		    	{
			      $('#categories li ul li').removeClass('current');
			      $(this).parent().addClass('current');
		    	}
		    return true;
		  });
	//Image replacement Gallery for #gallery
	$("#gallery a.thumb").live("hover",function(){
	return true;
		if ($("#site_name").html()=="ortal") return true;
		var largePath = $(this).attr("href");
		largePath=largePath.replace("thumb_","");
		var largeAlt = $(this).attr("title");
		$("#imgbig").stop(true, true).fadeOut("slow");
		$("img.big").attr({ src: largePath, alt: largeAlt });
		$("#imgbig").stop(true, true).fadeIn(500);
		$("#imgdesc").html($(this).parent().prev().html());

	});
		$("#extra_thumbs a.thumb").live("hover",function(){
		if ($("#site_name").html()=="ortal") return true;
		//event.preventDefault();
		//var gallery_id = parseInt($(this).closest("div").attr("class").replace("innergallery", ""));
		var largePath = $(this).attr("href");
		var largeAlt = $(this).attr("title");
		//$(".gallery" + gallery_id + " img.img_big").hide();
		$("#overlayer img.big").attr({ src: largePath, alt: largeAlt });
		//$("#overlayer a.big").attr({ href: largePath, title: largeAlt });
		$("#overlayer a.big img").fadeIn("slow");
		$("#imgdesc").html($(this).parent().prev().html());

	});
	$("#more-thumbs img").live("click",function(e){
	e.preventDefault();
	before_expand();
});	
$("#close_all img").live("click",function(e){
	e.preventDefault();
	before_expand();
});	
	$("#extra_thumbs a.thumb").live("click",function(){
		var largePath = $(this).attr("href");
		var largeAlt = $(this).attr("title");
		$("#overlayer img.big").attr({ src: largePath, alt: largeAlt });
		$("#overlayer a.big img").fadeIn("slow");
		$("#imgdesc").html($(this).parent().prev().html());
		return false;
	});
	$("#gallery a.thumb").live("click",function(e){
	e.preventDefault();
		var largePath = $(this).attr("href");
		largePath=largePath.replace("thumb_","");
		var largeAlt = $(this).attr("title");
		//$(".gallery" + gallery_id + " img.img_big").hide();
		$("img.big").attr({ src: largePath, alt: largeAlt });
		//$("#overlayer a.big").attr({ href: largePath, title: largeAlt });
		$("a.big img").fadeIn("slow");
		$("#imgdesc").html($(this).parent().prev().html());

		return false;
	});
});
function change_gallery(gallery){
if ( typeof change_gallery_local == 'function' ) {
if (!change_gallery_local(gallery)) return;
}
	$('#sending_big').fadeIn("fast");
	$('#overlayer').fadeOut("slow");
	$('#overlayer').load( 
	        // Here is the tricky part. Instead of hard-coding a url to pass, I just had jquery  
	        // go look at what the link (from the outside scope, .click() part) was already going  
	        // to (href) and used that as the argument. 
	      gallery
	    , function () {  
	        // This is a callback, after the ajax gets loaded, the #overlayer div gets faded in at 300 miliseconds. 
	       	  $("#before_footer").css("padding-top","100px");

			//if thumbs were opened for previous gallary, then first close it
			if ($('#expand_thumb').hasClass("fade.in")){
					if ($("#expand_content").html()=="opened"){
					$("#expand_content").html("clear");
						$(".pf__trigger").click();
						}
					$('#expand_thumb').removeClass("fade.in").addClass('fade');
					$("#expand_content").html("empty");
			}
				//if extra thumbs is needed for new galarry
			if ($("#need_expand").html()!=0){
					$('#expand_thumb').removeClass("fade").addClass('fade.in');
				//	$(".pf__original #extra_thumbs").html($("#need_expand").html());
				//$(".pf__fold").height($("#extra_thumbs").height());
			}
			//else $('#expand_thumb').addClass("fade");
	       // setcurrent();
			  $(this).fadeIn(300); 
			  $('#sending_big').fadeOut("fast");
	        
	    }); 
	return false;
}
function switchpic(obj){
	var largePath = $(this).attr("href");
		var largeAlt = $(this).attr("title");
		//$(".gallery" + gallery_id + " img.img_big").hide();
		$("#overlayer img.img_big").attr({ src: largePath, alt: largeAlt });
		$("#overlayer a.big").attr({ href: largePath, title: largeAlt });
		$("#overlayer a.big img").fadeIn("fast");
}
function setcurrent(){
	}	
function setforajax(fld,id,val,myurl){
	var slug= $('#AlbumSlug').val();
$.post(myurl,{id:id,fld:fld,val:val,slug:slug}, function(data){
console.log(data);
}, 'json');
};
function before_expand(){
if ($("#extra_thumbs").length) {
$(".pf__trigger").first().click();
if ($("#close_all").hasClass("fade") ) $("#close_all").removeClass("fade"); else $("#close_all").addClass("fade");

return true;}

var album_id=$("#album_id").html();
$("#more-thumbs a").attr("disabled", true);
$('#sending_big').css("top","90%");
$('#sending_big').fadeIn("fast");
$("#expand_thumb").load(
  			'/photos/view_extra_thumbs/'+album_id
		, function () { 
				$("#expand_content").html("closed");
	        // This is a callback, after the ajax gets loaded, the #overlayer div gets faded in at 300 miliseconds. 
			 // $('.pf__original #extra_thumbs').fadeOut("fast");
	       // $(".pf__wrapper #extra_thumbs").each(function() {$(this).html($(".pf__original #extra_thumbs").html());});
			$('.pf').paperfold({
					duration : 700,
					CSSAnimation : false,
					useOriginal : true,
					
				});	  
				//if(!$.browser.msie) //IE not working here
				 //$(this).fadeIn(300); 
				 $('#sending_big').fadeOut("fast");
				 $('#sending_big').css("top","50%");
					$(".pf__trigger").first().click();
					$("#more-thumbs a").attr("disabled", false);

				 //$('.pf').paperfold("manualopen");
		}); 
	return false;	
		
//$(".pf__original #extra_thumbs").html($("#extra_thumbs").html());

}
//closest("img[class^=flower]").show('fast').css("display","inline-block");
