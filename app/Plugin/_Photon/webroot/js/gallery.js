$(document).ready(function(){
	 $('#categories li ul:first').slideUp();
	 $('#categories li ul:first').slideToggle();
	 $('#categories li:first').addClass('current');
	 $('#categories li:first').click();
	 $(document).ready(function () {
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
		
    	
    });
	
$('a.js-ajax').live('click', function() { 
    // Now we simply make the ajax call. load($url) will pull the url's VIEW and put it  
    // into ther innerhtml of whatever tag you called load on. In this case, I want to fill   
    // up my #overlayer div with the results of the ajax. 
	$("img[class^=flower]").hide();

	 	 $(this).next('img[class^=flower]').show('fast').css("display","inline-block");

    $('#overlayer').load( 
        // Here is the tricky part. Instead of hard-coding a url to pass, I just had jquery  
        // go look at what the link (from the outside scope, .click() part) was already going  
        // to (href) and used that as the argument. 
        $(this).attr('href') 
    , function () { 
        // This is a callback, after the ajax gets loaded, the #overlayer div gets faded in at 300 miliseconds. 
        $(this).fadeIn(300); 
       // setcurrent();
        
    }); 
    // And finally to prevent actually making the link go anywhere 
    return false; 
}); 
	/*Add lightbox to any pictures wearing this class
	//$('div[id^=gallery] a.big').lightBox(lightbox_settings);
	//$('a.single_thumb').lightBox(lightbox_settings);
	//$('a.slider').lightBox(lightbox_settings);
	//$('#slider li a').lightBox(lightbox_settings);*/
	
	//Image replacement Gallery for #gallery
	$("div[class^=gallery] a.thumb").live("hover",function(){
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
	$("div[class^=gallery] a.thumb").live("click",function(){
		event.returnValue=false;
		if(event.preventDefault) event.preventDefault();
		var largePath = $(this).attr("href");
		var largeAlt = $(this).attr("title");
		//$(".gallery" + gallery_id + " img.img_big").hide();
		$("#overlayer img.big").attr({ src: largePath, alt: largeAlt });
		//$("#overlayer a.big").attr({ href: largePath, title: largeAlt });
		$("#overlayer a.big img").fadeIn("slow");
		$("#imgdesc").html($(this).closest("span").html());

		return false;
	});
	//PopEye	('div[class^=popeye]').popeye();
	
	//nivoSlider
	/*$('div[class^=slider]').easySlider( {
		continuous: true
	});
	$('#slider li').css('width', $('#slider').css('width'));
	*/
});
function change_gallery(gallery,me){
	$('#overlayer').load( 
	        // Here is the tricky part. Instead of hard-coding a url to pass, I just had jquery  
	        // go look at what the link (from the outside scope, .click() part) was already going  
	        // to (href) and used that as the argument. 
	       "gallery/album/"+ gallery
	    , function () { 
	        // This is a callback, after the ajax gets loaded, the #overlayer div gets faded in at 300 miliseconds. 
	        $(this).fadeIn(300); 
	       // setcurrent();
	        
	    }); 
	return true;
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
//closest("img[class^=flower]").show('fast').css("display","inline-block");
