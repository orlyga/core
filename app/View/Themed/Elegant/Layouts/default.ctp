<?php
/**
 * Bootstrao Twitter Theme for Croogo CMS
 *
 * @author Nitish Dhar <nitishdhar11@gmail.com>
 * @link http://www.croogo.org
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" />
  <script src="http://code.jquery.com/jquery-1.8.3.js"></script>
  <script src="http://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>
    <?php echo $this->Seo->meta();
	 echo $this->Html->css(array(
        'prettyinpink','modal',
            'bootstrap',
            'bootstrap-responsive',
            'style','hebrew'
        ));
    if(!$this->Seo->isTitleSet())
		if (!isset($title_for_layout)) $title_for_layout="";
			echo '<title>'.$title_for_layout.' &raquo; '.Configure::read('Site.title').'</title>';?>
	<meta name="viewport" content="width=device-width" />
        <!--[if lt IE 9]>
		<?php echo $this->Html->css('ie'); ?>
	<![endif]-->
   <script type="text/javascript">
	function ajax_failed(text){
		if(text=='Forbidden'){
			window.location="/";
		}
	}
	function myCallback(i, width) {
	  // Alias HTML tag.
	  var html = document.documentElement;
	
	  // Find all instances of range_NUMBER and kill 'em.
	  html.className = html.className.replace(/(\s+)?range_\d/g, '');
	
	  // Check for valid range.
	  if (i > -1) {
	    // Add class="range_NUMBER"
	    html.className += ' range_' + i;
	  }
	
	  // Note: Not making use of width here, but I'm sure
	  // you could think of an interesting way to use it.
	}
	var ADAPT_CONFIG = {
	  path: '<?php echo $this->Html->assetUrl("/", array() + array('pathPrefix' => CSS_URL));?>css/',
	    callback: myCallback,
	      dynamic: true,
	  range: [
	    '0px    to 760px  = mobile.css',
	    '760px  to 980px  = 720.css',
	    '980px  to 1200px = 960.css',
	    '1200px to 1600px = 1200.css',
	    '1600px to 1920px = 1560.css',
	    '1920px           = 1920.css'
	  ]
	}


	</script>
    <?php
        echo $this->Layout->meta();
        echo $this->Layout->feed();
       
        echo $this->Layout->js();
        echo $this->Html->script(array(
            'adapt.min',
		'jquery/jquery.hoverIntent.minified',
		'jquery/superfish',
		'jquery/supersubs',
		'/photon/js/gallery',
            'bootstrap'
            
        ));
        echo $scripts_for_layout;
    ?>
 
</head>
<body>
	<?php $this->Layout->blocks('hidden'); ?>
<div id="center-highlight" class="container_12">
	 <div class="navbar grid_10" style="padding-top:20px">
	        <div class="navbar-inner">
	             <div class="container">
	                <div class="nav">
	                     <?php echo $this->Custom->menu('main', array('dropdown' => true)); ?>
	                 </div>
	            </div>
	        </div>
	        <div id="bottom-shadow" style="height:2px"></div>
			<div id="phone_image" >
	         	<?php echo $this->Html->image("phone.png",array("alt"=>"טלפון עץ השני","width"=>"30px"))?>	
	        	<span style="font-family: miau;vertical-align: middle;font-size:1.5em;color:rgb(156, 50, 24)"><span id="phone_title">09-7493701</span> &nbsp;&nbsp;&nbsp;&nbsp; עץ השני, מושב סלעית</span>
	     	</div>
	     	<div id="bottom-shadow"></div>
     </div>              
     <div class="grid_2">
         <?php echo $this->Html->image("logo.png", array('style'=>"padding-top:10px","alt" => "לוגו עץ השני",'url' => array("/")));?>
    </div>
    <div class="clear"></div>
    <div class="grid_12">
        
	            <?php
	                echo $this->Layout->sessionFlash();
	                echo $content_for_layout;
	            ?>
    
    </div>        
<div class="clear"></div>	
</div>
<div id="footer">
	<div id="bottom-shadow" style="position:relative;top:-1px"></div>

	<div class="container_12">
		<div class="grid_6" style="padding-right:20px"><?php 
						echo  $nodes_for_layout['extra-footer'][0]['Node']['body'];?>
</div>
		<div id="menu-categories" class="grid_3" style="padding-left:20px">
			<?php echo $this->Layout->blocks("category-menu");
 			echo $this->Custom->menu("categories",array("id"=>"plain-oneline"))?>
		</div>
		
		<div class="right grid_2">
			         <?php echo $this->Html->image("logo.png", array('style'=>"width:80px","alt" => "לוגו עץ השני",'url' => array("/")));?>

		</div>
		<div class="clear"></div>
	</div>
</div>
<?php	echo $this->Js->writeBuffer(); ?>

    </body>
</html>