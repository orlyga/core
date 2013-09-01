<?php 
	echo $this -> Html -> css('/photon/css/gallery', false);
    $is_vertical=Configure::read('photon.vertical');
	$vertical= ($is_vertical)? "vertical":"horizonal";
if(!isset($gallery_id)) {
	$gallery_id = 0;
}?>
<div id="albums_gallery" class="grid_9 well">
	
<?php	$counter = 0; //We need a counter in order to set up popeye properly
	//echo'<div class="grid_9">';
	//echo '<div class="grid_2">';
	//	$html_albums .= '<ul id="albums">';
		$first=true;
	//	// foreach($albums as $album): 
				 //if (!empty($album['Photo'][0]['small'])) : 
			//	 $link_txt = $this->Html->link($album['Album']['title'], "/gallery/album/".$album['Album']['slug'], array('class'=>'js-ajax',));
			//	 if ($first){
			//	 	$html_albums .='<li class="select">'.$link_txt; 
			//		 $first=false;
			//	 }
			//	 else
			//	 	$html_albums .='<li >'.$link_txt; 
			//	 $html_albums .=$this->Html->image('/photon/img/flower.png',array('class'=>'flower '.$album['Album']['slug'],)).'</li>';
				//$html_albums .='<li><a href="#">'.$album['Album']['title'].'</a></li><br>';
								
		// endforeach; 
		//$html_albums .= "</ul></div>";
		?>
	
		<div id="categories_menu" class="grid_3">
		  <?php echo $this->Custom->menu('categories', array('dropdown' => true)); ?>
     </div>
     <div id="overlayer" class="grid_6 well" style="direction:ltr"></div>
</div>