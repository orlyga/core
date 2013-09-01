<script type="text/javascript" src="https://www.dropbox.com/static/api/1/dropins.js" id="dropboxjs" data-app-key="64jww1li3dhqqez"></script>
<?php
 echo $this->Html->script(array('jquery.carouFredSel','kinetic-v4.5.1'));
?>

 <div id = "host-howto">
<div id="howto-design" style="position:relative;"> 
<div style="position:absolute;top:0;left:0;z-index:-1">
<?php echo $this->Html->image("bg-howtodesign.jpg");?>
</div>
			<?php echo $this->requestAction('/page/howto-design'); ?>
	 		<a href="#" style=""  class="close">X <?php echo __("Continue");?></a>
</div>       
</div>       
		 
<script>
		if(!document.createElement('canvas').getContext)
{		
var str = '<br/><br/><br/><br/><br/><span id="ie_text">הנך משתמש בגירסא ישנה של אינטרנט אקספלורר.</br> ';
		str += 'כדי להשתמש ביכולות ההדמיה, ניתן להשתמש בגוגל כרום <br/><br/><a style="position:relative;" target = _blank href="https://www.google.com/intl/en/chrome/browser/" style="color:blue">להורדת כרום</a></br>';
		str += 'או להתקין גירסא חדשה יותר של אינטרנט אקספלורר <br/><br/><a style="position:relative;" target = _blank href="http://www.microsoft.com/downloads/details.aspx?FamilyID=f14f7ae7-14e3-4907-8ebe-8bedef8c2fba&DisplayLang=he" style="color:blue">לעדכון גירסת אינטרנט אקספלורר</a></span>';
$("#howto-design").html(str); 
	}
function before_send_mail(){
	if(!$("#MessageEmail")[0].checkValidity())	{
		("#MessageEmail").css("border","solid rbg(254, 33, 172)");
		$("#MessageEmail").attr("placeholder","<?php echo __("Email is Missing or Incorrect"); ?>");
		return false;} 
	else {$("#sending").show();}
}
function count_likes(nop){
	$("#count_like").html(nop);
	 nop++;
	var time=100+Math.floor(Math.random()*2500);
	 setTimeout(function(){
	 	 if (nop >99) nop=30;
	 	 if (nop==6) $(".bubble").fadeIn("slow");
	 	count_likes(nop);
	 },time);
}
function transit_up($this,i,class_i){
	 $this.css("top",i+"px");
	 i=parseInt($this.css("height"))+i+10;
	 setTimeout(function(){
	 	if($this.next().attr("class")==class_i)
	 	transit_up($this.next(),i,class_i)
	 },2000);
}
function sent_complete() {
$("#letter-send-fields").hide();
$("#email_recieved").show();
$("#sending").hide();
}
 $(function() {
 	  document.getElementById("db-chooser").addEventListener("DbxChooserSuccess",
        function(e) {
			var src=e.files[0].link;
			src=src.replace("https://www","http://dl");
            copy_img_from_dropbox(src);
        }, false);
    $("#host-howto").fadeIn();
	 $("#host-howto").css("top","0%");
 $("#host-howto").css("position","fixed");
 	$("#quate .simple-box").hover(function()
    { 
  
    	if($("#count_like").html()>0) return false;
    	var i=0;
    	transit_up($(".fb-comment").first(),20,"fb-comment");
    	count_likes(0);
  /*   $(".fb-comment").each(function(){
     	 $(this).next().css("top",i*1000+"px");
     	 $(this).css("top",i*20+"px");
             $.data($(this), 'timer', setTimeout(function () {
                
                if ($.isFunction(fn)) fn();
            }, delay + duration));
            i++;
	});  */         
});
 	$("#MessageWidth").change(function(){
 		if($("#MessageRatio").val()!=""){
 			$("#MessageHeight1").val($("#MessageRatio").val()*this.value);
 		}
 	});	
 	$("#host-howto").click(function(){
 	$('#host-howto').css('top','-800px');
 	
 	});	
 	$("#MessageChangeSize").change(function(){
 		if(this.checked){
 			//this.disabled='disabled';
 			$("#MessageHeight1").parent().removeClass("input-plain-text").addClass("input-not-plain-text");
 			$("#MessageWidth").parent().removeClass("input-plain-text").addClass("input-not-plain-text");

 			//$("#MessageHeight").parent().addClass("input-not-plain-text");
 		}
 	});
	$("#MessageQuate1").change(function(){
 		if(this.checked)
			$("#quate-fields").slideDown("slow");
 		else
			$("#quate-fields").slideUp();	
 		
 	});
    $( "#dialog" ).dialog({ autoOpen: false ,
    dialogClass: "nice-box",
	 
    create: function (event) { 
		$("#dialog .ui-dialog-titlebar-close").html('<?php echo __("Close")?>');
		$("#dialog .ui-dialog-titlebar-close").css({'width': 'auto','height': 'auto'});
	$("#dialog .ui-dialog-titlebar-close").parent().css({'border': 0,'background': 'rgba(0, 0, 0, 0.5)'});
	
	$('#contact-1').hide();
	}
    });
  
   $( "#dialog2" ).dialog({ autoOpen: false ,
    dialogClass: "nice-box",
	 
    create: function (event) { 
		$("#dialog2 .ui-dialog-titlebar-close").html('<?php echo __("Close")?>');
		$("#dialog2 .ui-dialog-titlebar-close").css({'width': 'auto','height': 'auto'});
	$("#dialog2 .ui-dialog-titlebar-close").parent().css({'border': 0,'background': 'rgba(0, 0, 0, 0.5)'});
	}
    });
  });
  $(window).load(function (){
  	$(".qq-upload-button").html('<?php echo __("Upload Picture");?>');
	 
	  $(".ui-tabs-panel").css('height',Math.floor($("#content").width()*7/10));
  
  
	// Using default configuration
	
	// Using custom configuration
// Using custom configuration

	$("#choose-list").carouFredSel({
		direction			: "up",
		auto    : false,

		scroll : {
			items			: "variable",
			
			duration		: 1000,							
			pauseOnHover	: true,
			
			
		},
		
		
	prev	: {	
		button	: "#foo2_prev",
		key		: "left"
	},
	next	: { 
		button	: "#foo2_next",
		key		: "right"
	},	
		
				
	});	
	var w=Math.floor($(".design-template").parent().width());
		
	var h=Math.floor(w*2/3)+50;
	var temp_pos = ({t:0,l:0});
	$(".design-template").width(w);
		$(".design-template").height(h);
		$("#add_photo_div").css({"width":w,"height":h})
		$(".caroufredsel_wrapper").css({"min-height":h+100});
	 $( ".item_c" ).draggable({
								            cancel: "a.ui-icon", 
								            revert: "invalid", // when not dropped, the item will revert back to its initial position
								            
								            helper: "clone",
								            cursor: "move",
								            appendTo: "body",
								            disabled:false,
								            start : function (event,ui){$(this).css('z-index','1000');reset_add_photo()}
	        });
		/* $( "#add_photo_div" ).draggable({
			
								            containment: "#design-template",
								            cursor: "move",
								            stop: function(event, ui) {
								            	// Show dropped position.
								            	temp_pos = $(this).position();
								            }
	        });*/
		$("#add_photo_div").droppable({
									
									 accept: ".item_c",
									  activeClass: "ui-state-default",
    									hoverClass: "ui-state-hover",
						            drop: function( event, ui ) {
						             //   $( this ).addClass( "ui-state-highlight" );
						             var new_width=Math.floor(h/3);
						            // $( this ).css("width",new_width+"px");
						             image_size_w = new_width;
						             //$( this ).css("height",new_width+"px");
						             $("#add_photo_div").html("");
						             $("#direction1").fadeOut();
									  $("#direction7").fadeOut();
						              $("#save_design").removeClass('hidden');
									  $("#save_design").removeAttr('disabled');
						             $("#MessagePhotoId").val(ui.draggable.find("img").attr("id"));
						             $( this ).find( "img" ).css("width",new_width+"px");
						             $( this ).find( "img" ).css("left",event.offsetX+"px");
									 $( this ).find( "img" ).css("top",event.offsetY+"px");
						                    var src_img = ui.draggable.find("img").attr("src");
						                  //  $( this ).find( "img" ).attr("src",src_img);
						                  sources={darthVader: src_img,bg_img:$(".main-img img").attr("src")};
						                    loadImages(sources, initStage,event.offsetX,event.offsetY);
						            }
        });
});
var blank_src;
function save_continue() {
	convertCanvasToImage();
	//$("#choose").css('left','3000px');
	
	 $("#letter-send-fields").show();
$("#email_recieved").hide();
}
function go_back(){
	 $('.tabs_move').css('left', '0');
}
function fb_share() {
var publish = {
		
		  method: 'feed',
		  message: $("#FBBody").val(),
		  user_message: $("#FBBody").val(),
		  name: $("#FBTitle").val(),
		  picture:'<?php echo $this->Html->url('/',true) ?>'+ $("#image_fb img").attr("src"),
		  description: ($("#FBBody").val()
		  ),
		  link: '<?php echo $this->Html->url('/',true) ?>',
		  
		  actions: [
		    { name: 'Orly Reznik', link: '<?php echo $this->Html->url('/',true) ?>' }
		  ],
		  user_message_prompt: 'מה דעתכם על העיצוב'
		};
		
FB.ui(publish,callback);
}
function callback(response) {
          //document.getElementById('msg').innerHTML = "Post ID: " + response['post_id'];
}


 function reset_add_photo(){
	 $("#add_photo_div" ).find( "img" ).attr("src","<?php echo $this->webroot ?>/img/blank100X70.gif");
//	 $("#add_photo_div").css("top","0px");
	// $("#add_photo_div").css("width",$("#design-template img").width());
 }
 function copy_img_from_dropbox(src){
 $.ajax({type:'POST',
	url:'<?php echo $this->Html->url(array('plugin'=>'photon','controller'=>'photos',
			   'action'=>'upload_img')) ?>',
	data:{src:src,folder:"files/temp/Album/1000"}, 
	dataType: 'json',
	beforeSend:function(){$('#sending').show();},
	success:function(data){
	var i=0;
	after_upload(data.filename);
	},
	
 });
}
  function convertCanvasToImage() {
	var image = new Image();
	var canvas=document.getElementsByTagName('canvas')[0];
	context = canvas.getContext('2d');
	
  	//base_image = new Image();
  	//base_image.src = $(".main-img img").attr("src");
  	
   // context_.drawImage(base_image, 0, 0,$(".main-img img").width(),$(".main-img img").height());
// context_new.drawImage(context_old,0,0);
	image.src = canvas.toDataURL("image/png");
		$.ajax({type:'POST',
	url:'<?php echo $this->Html->url(array('plugin'=>'photon','controller'=>'photos',
			   'action'=>'upload_img_montage')) ?>',
			   
	data:{image:image.src,photo_id:$('#MessagePhotoId').val()}, 
	dataType: 'json',
	beforeSend:function(){$('#sending_big').show();},
	success:
			   function(data){
			   	 
			   	 var data2='<?php echo $this->Html->url('/') ?>'+data.file_name;
			   	 data.file_name='<?php echo $this->Html->url('/',true) ?>'+data.file_name;
			   		$("#MessageImage").val(data.file_name);
			   		var ratio=data.Photo.term3;
			   		$("#MessageRatio").val(ratio);
					$("#MessageWidth").val(data.Photo.term4);
					$("#MessageHeight1").val(data.Photo.term5);
			   		if (ratio>0) 
			   			$("#MessageHeight1").attr("disabled","true");
			   		else
			   			$("#MessageHeight1").attr("disabled","false");
			   		ratio=0.5;
			   		if (ratio > 1) {var height_r=1; var width_r= 1/ratio;}
					else {var width_r=1; var height_r= ratio;}
					$("#MessageWidth").val(width_r);
					$("#MessageHeight1").val(height_r);
					$("#image_fb img").attr('src',data2);
			   		$("#final_image img").attr('src',data2);
					$("#sending_big").hide();
					 $('.tabs_move').css('left', '100%');
	}
});
	return true;
}
   function update(activeAnchor,type,ratio) {
      	if (type=='skew') return update_skew(activeAnchor);
        var group = activeAnchor.getParent();

        var topLeft = group.get('.topLeft')[0];
        var topRight = group.get('.topRight')[0];
        var bottomRight = group.get('.bottomRight')[0];
        var bottomLeft = group.get('.bottomLeft')[0];
        var image = group.get('.image')[0];

        var anchorX = activeAnchor.getX();
        var anchorY = activeAnchor.getY();

        // update anchor positions
        switch (activeAnchor.getName()) {
          case 'topLeft':
            topRight.setY(anchorY);
            //bottomLeft.setX(anchorX);
            break;
          case 'topRight':
            topLeft.setY(anchorY);
            bottomRight.setX(anchorX);
            break;
          case 'bottomRight':
            //bottomLeft.setY(anchorY);
            topRight.setX(anchorX); 
            break;
          case 'bottomLeft':
            bottomRight.setY(anchorY);
            topLeft.setX(anchorX); 
            break;
        }

        image.setPosition(topLeft.getPosition());
        var height = bottomRight.getY() - topRight.getY();
		if (ratio==1){
			        var width = image.getWidth()*height/image.getHeight();
			        bottomRight.setX(topLeft.getX()+width);
			        topRight.setX(topLeft.getX()+width);
			       }
		else
        		var width = topRight.getX() - topLeft.getX();
        if(width && height) {
          image.setSize(width, height);
        }
      }
      
             function update_skew(activeAnchor) {
        var group = activeAnchor.getParent();

        var topLeft = group.get('.topLeft')[0];
        var topRight = group.get('.topRight')[0];
        var bottomRight = group.get('.bottomRight')[0];
        var bottomLeft = group.get('.bottomLeft')[0];
        var image = group.get('.image')[0];

        
        var anchorY = activeAnchor.getY();
		 // update anchor positions
		var sk_per=anchorY-image.getY();
		image.setSkewY(sk_per/100);
		if( sk_per==0) {
		//	sk_per=anchorX-image.getX();
			//image.setSkewX(sk_per/100);
		}
		activeAnchor.setY(image.getY());
		activeAnchor.setX(image.getX());
		topRight.setY(topLeft.getY()+image.getSkewY()*image.getHeight());
		bottomRight.setY(topLeft.getY()+(1+image.getSkewY())*image.getHeight());

		
        //drawPerspective(image, 0.7);


      //  image.setPosition(topLeft.getPosition());
       // var height = bottomLeft.getY() - topLeft.getY();
       // 		var width = topRight.getX() - topLeft.getX();
      //  if(width && height) {
      //    image.setSize(width, height);
      //  }
      }
      
      
       function update_perspective(activeAnchor) {
        var group = activeAnchor.getParent();

        var topLeft = group.get('.topLeft')[0];
        var topRight = group.get('.topRight')[0];
        var bottomRight = group.get('.bottomRight')[0];
        var bottomLeft = group.get('.bottomLeft')[0];
        var image = group.get('.image')[0];

        
        var anchorY = activeAnchor.getY();
		 // update anchor positions
        switch (activeAnchor.getName()) {
          case 'topLeft':
          anchorYopp=(image.getY()-activeAnchor.getY()) + image.getHeight();
            topRight.setY(anchorY);
            break;
          case 'topRight':
            topLeft.setY(anchorY);
            bottomRight.setX(anchorX);
            break;
          case 'bottomRight':
            bottomLeft.setY(anchorY);
            topRight.setX(anchorX); 
            break;
          case 'bottomLeft':
            bottomRight.setY(anchorY);
            topLeft.setX(anchorX); 
            break;
        }
		//image.setSkewY(5);
        //drawPerspective(image, 0.7);

return;




        image.setPosition(topLeft.getPosition());
        var height = bottomLeft.getY() - topLeft.getY();
		if (ratio==1){
			        var width = image.getWidth()*height/image.getHeight();
			        bottomRight.setX(bottomLeft.getX()+width);
			        topRight.setX(bottomLeft.getX()+width);
			       }
		else
        		var width = topRight.getX() - topLeft.getX();
        if(width && height) {
          image.setSize(width, height);
        }
      }
     
       function addAnchor(group, x, y, name,type) {
        var stage = group.getStage();
        var layer = group.getLayer();
		
		var imageObj=new Image();
		imageObj.src="<?php echo $this->Html->url('/img/'); ?>"+type+'.png';
        var anchor = new Kinetic.Image({
          x: x,
          y: y,
          image:imageObj,
          width:15,
          height:15,
          name: name,
          draggable: true,
          opacity:1,
          dragOnTop: false
        });

        anchor.on('dragmove', function() {
          update(this,type,1);
          layer.draw();
        });
        anchor.on('mousedown touchstart', function() {
          group.setDraggable(false);
          this.moveToTop();
        });
        anchor.on('dragend', function() {
          group.setDraggable(true);
          layer.draw();
        });
        // add hover styling
        anchor.on('mouseover', function() {
          var layer = this.getLayer();
          document.body.style.cursor = 'pointer';
          this.setStrokeWidth(4);
          layer.draw();
        });
        anchor.on('mouseout', function() {
          var layer = this.getLayer();
          document.body.style.cursor = 'default';
          this.setStrokeWidth(2);
          layer.draw();
          group.setDraggable(true);
        });

        group.add(anchor);
      }
      function loadImages(sources, callback,l,t) {
        var images = {};
        var loadedImages = 0;
        var numImages = 0;
        for(var src in sources) {
          numImages++;
        }
        for(var src in sources) {
          images[src] = new Image();
          images[src].onload = function() {
            if(++loadedImages >= numImages) {
              callback(images,l,t);
            }
          };
          images[src].src = sources[src];
        }
      }
      
      function initStage(images,l,t) {
        var stage = new Kinetic.Stage({
          container: 'add_photo_div',
          width: $(".design-template").width(),
          height: $(".design-template").height(),
          top:t,
          left:l
        });
        
        var darthVaderGroup = new Kinetic.Group({
          
          draggable: true
        });
        
        var layer = new Kinetic.Layer();

        /*
         * go ahead and add the groups
         * to the layer and the layer to the
         * stage so that the groups have knowledge
         * of its layer and stage
         */
        var bg_img = new Kinetic.Image({
          x: 0,
          y: 0,
          image: images.bg_img,
          width: $(".main-img img").width(),
           height: $(".main-img img").height(),
          name: 'image',
          
        });
        layer.add(bg_img);
        layer.add(darthVaderGroup);
        stage.add(layer);

        // darth vader
        var darthVaderImg = new Kinetic.Image({
          x: 0,
          y: 0,
          image: images.darthVader,
          width: 200,
          
          name: 'image',
          shadowColor:"#000000",
          shadowBlur:10,
          shadowOffset:-7,
          shadowOffsetY:7,

          shadowOpacity:0.7
        });
		
        darthVaderGroup.add(darthVaderImg);
        addAnchor(darthVaderGroup, 0, 0, 'topLeft','skew');
        addAnchor(darthVaderGroup, 200, 0, 'topRight','resize');
        addAnchor(darthVaderGroup, 200, 138, 'bottomRight','resize');
      //  addAnchor(darthVaderGroup, 0, 138, 'bottomLeft');
 darthVaderGroup.on('mouseover', function() {
          this.children[1].setOpacity(1);
          this.children[2].setOpacity(1);
          this.children[3].setOpacity(1);
          layer.draw();
        });
         darthVaderGroup.on('mouseout', function() {
          this.children[1].setOpacity(0);
          this.children[2].setOpacity(0);
          this.children[3].setOpacity(0);
          layer.draw();
        });
        darthVaderGroup.on('dragstart', function() {
          this.moveToTop();
        });
       
        stage.draw();
      }

      var sources = {
        darthVader: 'http://www.html5canvastutorials.com/demos/assets/darth-vader.jpg',
        yoda: 'http://www.html5canvastutorials.com/demos/assets/yoda.jpg'
      };
      //loadImages(sources, initStage);
function drawPerspective(layer,img, scale) {
	var context=img.getContext("2d");
 context.clearRect(0, 0, img.getWidth(),img.getHeight());
    numSlices   = img.getWidth() * 0.75;
    sliceWidth  = img.getWidth() / numSlices;
    sliceHeight = img.getHeight();
    heightScale = (1 - scale) / numSlices;
    widthScale  = (scale*scale);
   //     img.remove();

    for (var i = 0; i < numSlices; i++) {
      // Where is the vertical chunk taken from?
       var sx = sliceWidth * i,
           sy = 0;
      
      // Where do we put it?
       var dx      = sliceWidth * i * widthScale,
           dy      = (sliceHeight * heightScale * (numSlices - i)) / 2,
           dHeight = sliceHeight * (1 - (heightScale * (numSlices - i))),
           dWidth  = sliceWidth * scale;
           
   // context.setClearBeforeDraw(true);
   img.setPosition(dx, dy);
   img.setWidth(dWidth);
   img.setHeight(dHeight);
   img.setCrop([sx, sy, sliceWidth, sliceHeight]);
   layer.draw();
   layer.setClearBeforeDraw(false);
  //context.drawImage(img.attrs.image, sx, sy, sliceWidth, sliceHeight, dx, dy, dWidth, dHeight);
    }
    
   layer.setClearBeforeDraw(true);

}
//loadImages(sources, initStage);


function after_upload(result){
	
	var img_src="<?php $x=  $this->webroot.'img'.DS.'files'.DS.'temp'.DS.'Album'.DS.'1000'.DS; echo str_replace("\\","/",$x); ?>"+result;
	$(".design-template ").fadeOut();
	$(".main-img p").html("");
	$(".design-template img").attr("src",img_src).load(function() {  
		if (this.width > this.height){
			$(".design-template img").width('100%');
			if (this.height> $(".design-template").height()){
				//$(".design-template img").height('100%');
			var w=this.width*$(".design-template").height()/this.height;
					$(".design-template img").width(Math.floor(w));

			}
		}
		else {
			var w=this.width*$(".design-template").height()/this.height;
			$(".design-template img").width(Math.floor(w));

		}
		$(".design-template ").fadeIn();
		$('#sending').hide();
		$("#direction1").fadeIn(600);
		$("#direction7").fadeIn(600);
  
});  
	 //$("#tabs").tabs('option','active',1);
}
</script>
<style>

.ui-tabs-panel {
    display: inline-block;
    *display: inline;
    *zoom: 1;
    vertical-align: top;
}
.qq-upload-list {display:none}
.item_c{
	z-index:1000;
}

.caroufredsel_wrapper,#choose-list {height:100%;width:100%;min-width:180px;}

/* ------------------------------------------------- */


.placeholder {
	top: 0px;
left: 0px;
z-index: 40;
display:inline-block;
}
div.design-template > div.placeholder {
position: absolute;
background-color: rgba(255, 255, 255, 0.001);
-moz-box-sizing: border-box;
-webkit-box-sizing: border-box;
-ms-box-sizing: border-box;
box-sizing: border-box;
-moz-transition-property: opacity, border, background;
-moz-transition-duration: 0.5s;
-webkit-transition-property: opacity, border, background;
-webkit-transition-duration: 0.5s;
transition-property: opacity, border, background;
transition-duration: 0.5s;
margin-left: -1px;
margin-top: -1px;
}
div.design-template .single-grid {
width: 282px;
height: 560px;
border: 0;
}
designmedia="all"
.grabbable {
cursor: -moz-grab;
cursor: move;
cursor: grab;

}
.design-template img{width:100%;}
#add_photo_div {border:0;background:transparent; position:absolute;left:0;top:0};

#add_photo_div img {width:100%}
.placehodler {
	z-index: 40;
top: 0;
position: absolute;
min-height: 2em;
background-color: rgba(255, 255, 255, 0.001);
-moz-box-sizing: border-box;
-webkit-box-sizing: border-box;
-ms-box-sizing: border-box;
box-sizing: border-box;
-moz-transition-property: opacity, border, background;
-moz-transition-duration: 0.5s;
-webkit-transition-property: opacity, border, background;
-webkit-transition-duration: 0.5s;
transition-property: opacity, border, background;
transition-duration: 0.5s;
margin-left: -1px;
margin-top: -1px;
}


/* Central mechanism */

.wrapper {
    overflow: hidden;
}

.tabs_move {
    position: relative;
    -webkit-transition: all 1.2s ease-in-out; 
    -moz-transition: all 1.2s ease-in-out; 
    -ms-transition: all 1.2s ease-in-out; 
    -o-transition: all 1.2s ease-in-out; 
    transition: all 1.2s ease-in-out; 
}

.tabs_move > * {
    width: 100%;
}

.tabs_move[data-tab='1'] {
    left: 100%;
}

.tabs_move[data-tab='2'] {
    left: 200%;
}

/* Layout
 * 
 * This verbose technique allows horizontal sequences of block elements
 * without resorting to float, thereby allowing more flexible
 * dimension properties.
 * 
 * Credit goes to the YUI team, Chris Coyer & one Bill Brown: http://css-tricks.com/fighting-the-space-between-inline-block-elements/#comment-168807
 */

.\_inliner {
    font-size: 0rem;
    letter-spacing: -.31em;
    word-spacing: -.43em;
    white-space: nowrap;
}

.\_inliner > * {
    display: inline-block;
    *display: inline;
    *zoom: 1;
    font-size: 1rem;
    letter-spacing: normal;
    vertical-align: top;
    word-spacing: normal;
    white-space: normal;
}

/* Prettification */



h2 {
    font-size: 1.5em;
    font-weight: bold;
    margin: .5em 0;
}

.tablinks a {
    -webkit-appearance: button;
}
.qq-upload-button {
	margin-left:auto;
	margin-right:auto;
}

/* Insert viewport meta definitions for mobile
 * 
 * http://doc.jsfiddle.net/use/hacks.html#css-panel-hack
 */
</style>


<div id="sending_big" ><?php echo __("This action might take some time.")?></div>
<div id="sending"></div>
<div class="wrapper">
   
  <div id="tabs" class="grid_10">
		<div id="content">
    <div class="tabs_move _inliner">
        <div id="choose" class="ui-tabs-panel ui-widget-content ui-corner-bottom " style="width:100%;">
				<div witdh="100%" style="position:relative">
					<div id="direction1"><?php echo $this->Html->image('direction1.png');?></div>
					<a href="#" id="direction7" onClick="$( '#dialog' ).dialog( 'open' );"><?php echo $this->Html->image('direction7.png');?></a>

					<div id="dialog" style="display:none"; title="עיצוב התמונה">
							
								<h4>בחירת הציור:</h4>
								<p> בחרו את הציור הרצוי, וגגרו אותו על גבי הצילום שלכם.</p>
								<p>  ניתן להעזר בחץ העליון והתחתון כדי לראות תמונות נוספות .</p>
								<h4>לשינוי מקום הציור:</h4>
								<p> בחרו את הציור שעל גבי הצילום וגררו אותו למקום המתאים.</p>
								<h4>לשינוי גודל הציור:</h4>
								<p> בחרו בריבועים הלבנים הקטנים, אשר נמצאים בפינות וגררו אותם להקטנה והגדלה.</p>
							
					</div>
				<div class="grid_1" style="margin-top:30%;padding-left:100px">
					
					<div><button id="save_design" class="hidden" disabled="disabled" onClick="save_continue();">
							</button>
					</div>
				</div>
				<div class="grid_7" style="margin-left:-5%">
									<?php  echo  $this->Upload->edit('Album', '1000',array('buttontext'=>"Upload Photo")); ?>
									<input type="dropbox-chooser" name="selected-file" id="db-chooser" class='btn btn-warning'/>

					<div class="design-template nice_image_frame"  >
						<div class="main-img " >
							<p>
לחצו על הכפתור "העלה צילום". העלו צילום של המקום בו תרצו לתלות את הציור								</p>
							<?php echo $this->Html->Image("blank100X70.gif",array("style"=>"vertical-align:top;"))?>
						</div>
						<div id="add_photo_div" class="placehodler ui-state-hover"></div>
						
					
				<!--<div id="choose-list" ><?php echo $this->Html->Image("blank100X70.gif",array("width"=>"70%"))?></div>-->
					
					</div>
				</div>
			</div>
			<div class="grid_2" style="float:right">
				<div id="wrap" class="embossed">
							<a class="prev" id="foo2_prev" href="#"><span>prev</span></a>
							<div id="choose-list" >
								<?php $i=0;
								 foreach ($Photos as $photo) {
								 	
									
									 $i++;
									echo '<div class="item_c">';
									echo $this->Html->Image("/img/".$photo['Photo']['small'],array("width"=>"150","id"=>$photo['Photo']['id'])); 
									echo '</div>';
							} ?>
							</div>
						    <a class="next" id="foo2_next" href="#"><span>next</span></a>
				</div>
			</div>	
		</div>
        <div id="quate"             class="ui-tabs-panel ui-widget-content ui-corner-bottom ">	
				<div class="grid_5">
					
					<div class="simple-box" style="padding:0">
						<div class="blueBar">
							<?php echo $this->Html->image('fb_small.jpg');?>
						</div>
						<div id="content-fb" >
						<?php echo $this->Form->input("FB.title",array('value'=>__('What do you think about the painting?'),'style'=>'width:98%;font-size: 0.8em;font-weight: bold;color:rgb(59, 89, 152);','type'=>'textarea','rows'=>1,'label'=>false,'class'=>'simple-input'))?>
							<div class="simple-input">
								<div class="grid_2" style="margin: 0;float:none;display:inline-block;vertical-align:top">
									<?php echo $this->Form->input("FB.body",array('style'=>'width:95%;font-size: 0.7em;color:rgb(115, 115, 115);','type'=>'textarea','label'=>false,'value'=>' ','class'=>'simple-input'))?>
								</div>
								<div class="grid_3" id="image_fb" style="margin: 0;float:none;display:inline-block;">
									<?php echo $this->Html->Image("blank100X70.gif",array('style'=>'width:100%'));?>
								</div>
								
							</div>
						</div>
						<a href="#" style="color:#ffffff" class='fb-button' onClick="fb_share()"><?php echo __('Share');?></a>
					</div>
					<div style="position:relative">
						<div class="bubble"><div>צברתם יותר מ-100 לייקים? קבלו הנחה של 10%</div></div>

						<ul width="100%" id="fb-comments" style="margin-right:5%" >
							<li class="fb-comment"> <?php echo $this->Html->image("like-fb.png");
								echo '<span id="count_like">0</span>';
								echo __("people like this.");?>
							</li>
							<li class="fb-comment"> <?php echo $this->Html->image("face1.jpg");
								echo '<span id="count_like">אהבתי!!!</span>';
								?></li>
								<li class="fb-comment"> <?php echo $this->Html->image("face2.jpg");
								echo '<span id="count_like">מקסים - תזמינו אליכם כשתתלו את התמונה</span>';
								?></li>
								<li class="fb-comment"> <?php echo $this->Html->image("face3.jpg");
								echo '<span id="count_like">תנסו להזיז קצת שמאלה, שהתמונה תהיה מעל מרכז הספה</span>';
								?></li>
								<li class="fb-comment"> <?php echo $this->Html->image("face5.jpg");
								echo '<span id="count_like">נראה ממש מתאים לסלון שלכם, לכו על זה...</span>';
								?></li>
								<li class="fb-comment"> <?php echo $this->Html->image("face4.jpg");
								echo '<span id="count_like">נכנסתי לגלריה, ראיתי שם עוד ציור שיכול להתאים לכם בשם </span>';
								?></li>
						</ul>
						
					</div>
				</div>
				<div  class="grid_5 left-side" style="margin-left:10%">
					<div><button id="arrow-back"  onClick="go_back();">
						<?php echo __("Back"); ?>
						</button>
					</div>
					<div id="direction5" >
						
						<a href="#" onClick="$( '#dialog2' ).dialog( 'open' );" >
							<?php echo $this->Html->image("direction5.png");?>
						</a>
					<div id="dialog2" style="display:none"; title="עיצוב התמונה">
								<h4>בקשו הצעת מחיר:</h4>
								<p>אנא עדכנו את רוחב הציור שתרצו, הגובה יתעדכן אוטומטית במידה והפרופורציה נשמרת</p>
					</div>
						
					</div>
					<div id="direction6" ><?php echo $this->Html->image("direction6.png")?></div>
					<div id="direction4" ><?php echo $this->Html->image("direction4.png")?></div>
					<div id="send-to-customer">
						<?php
								echo $this->Form->create('Message',array(
  'type' => 'post', 
  'action' => 'add',
  'onSubmit' => 'return false;'
 ));
								?>
						<div id="final_image"><?php echo $this->Html->Image("blank100X70.gif");
							?></div>
						<div id="letter-div">
						<?php echo $this->Html->image('letter.png',array('id'=>'letter-top')); ?>
						<?php echo $this->Html->image('letter-bottom.jpg',array('id'=>'letter-bottom')); ?>
						</div>
					<div id="email_recieved" class="grid_2" style="display:none">
						<h2><?php echo __("Your email is on its way")?></h2>
					</div>
					<div id="letter-send-fields">
						<div class="grid_1">&nbsp;</div>
						
						<div id="div_address" class="grid_2" style="">
							<?php 
							
							echo $this->Form->input('Message.name',array('label'=>false,'placeholder'=>__('To'),'style'=>'width:100%'));
							echo $this->Form->input('Message.email',array('label'=>false,'placeholder'=>__('Email'),'style'=>'width:100%'));
							echo '<div id="quate-checkbox">';
							echo $this->Form->input('Message.quate1',array('type'=>'checkbox','checked'=>false,'label'=>__('Add a Quate')));
							echo '</div>';
							?>
							<div id="quate-fields">
									<?php
									//$ratio=$photo['Photo']['tem2'];
									
									echo $this->Form->input('Message.width',array('style'=>'width:30px','label'=>__('Width').":"))."<div style='display:inline-block'>". __('Yard')."</div>";
									echo '<br/>';
									echo  $this->Form->input('Message.height1',array('style'=>'width:30px','label'=>__('Height').":"))."<div style='display:inline-block'>". __('Yard')."</div>";
									 echo $this->Form->input('Message.message',array('label'=>false,'type'=>'textarea','rows'=>2,'placeholder'=>__('Add Comment')));
									?>
								</div>
						</div>
						<?php
					echo $this->Form->input('Message.title', array('type' => 'hidden','value'=>__('My Design from Orly Reznik Site')));
								echo $this->Form->input('Message.PhotoId', array('type' => 'hidden'));
								echo $this->Form->input('Message.body', array('type' => 'hidden','value'=>__('Message')));
								echo $this->Form->input('Message.Ratio',array('type' => 'hidden'));
								echo $this->Form->input('Message.Image',array('type' => 'hidden'));
					 		 $this->Form->unlockField('Message.Image');
					 		 $this->Form->unlockField('Message.Ratio');
								$this->Form->unlockField('Message.body');
								$this->Form->unlockField('Message.PhotoId');
								$this->Form->unlockField('Message.title');
								?>
										<?php
					 echo  $this->Js->submit(__("Submit"),
									  array( 'url'=> array('plugin'=>'photon','controller'=>'photos',
									   'action'=>'upload_img_montage'),
									    'before'=>'before_send_mail();',
									    'class' => 'btn btn-warning',
									    'buffer' => false,
									    'success'=>'sent_complete();',
									    'error'=>'alert(data);'
	     						 ));
	  
 echo $this->Form->end();?>
 </div></div>
				</div>
			</div>
</div>		
</div>	
        
    </div>
</div>
</div>
</div>