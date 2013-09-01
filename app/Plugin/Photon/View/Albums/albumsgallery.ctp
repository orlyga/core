<?php $auto_first=Configure::read('Photon.auto_show_first_album');
 if(!isset($gallery_id)) {
	$gallery_id = 0;
}

if (($auto_first==1)&&($gallery_id==0)){ ?>

<script>
$(document).ready(function(){
	 $('#categories li ul:first').slideUp();
	 $('#categories li ul:first').slideToggle();
	 $('#categories li:first').addClass('current');
	 $('#is_frirst').html("1");
	 $('#categories li a:first').click();
});
</script>
<?php }
if (($auto_first==1)&&($gallery_id>0)){ ?>

<script>
$(document).ready(function(){
	var gallery_id="<?php echo $gallery_id ?>";
	// $('#link-'+gallery_id).parent().slideUp();
	 $('#categories_menu #link-'+gallery_id).parent().slideDown();
	 $('#categories_menu #link-'+gallery_id).addClass('current');
	 $('#is_frirst').html("1");
	 change_gallery('gallery/album/'+gallery_id);
	// $('#link-'+gallery_id+' > a').click();
});
</script>
<?php }?>
<?php 
    $is_vertical=Configure::read('photon.vertical');
	$vertical= ($is_vertical)? "vertical":"horizonal";

?>
<div id="albums_gallery">
	 
<?php	$counter = 0; //We need a counter in order to set up popeye properly
	
		?>
	
		<div id="categories_menu" class="nav-pills">
		  <?php echo $this->Custom->menu('categories', array('dropdown' => true,'alt'=>'title','onClick'=>'change_gallery(\'%link\')')); ?>

     </div>
	 
	<div id="overlayer" class=" well">
	 	<?php echo $this->Element('nophotos');?>
	</div>

</div>
 <div id="sending_big"></div>
  <div id= "is_frirst" style="display:none">0</div>
    
