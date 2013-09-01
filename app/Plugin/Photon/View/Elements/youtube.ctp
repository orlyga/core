<?php 
 $url_tmp = $this->Html->url("/img/photos/");

 function set_thumb($photo_obj=array(),$url_tmp){
	$str = '<a href="'. $url_tmp. $photo_obj['large'].'" class="thumb" ';
	 $str .= 'technique="'.$photo_obj['Term']['title'].'"description="'. $photo_obj['description'] .'"><img src="'. $url_tmp. $photo_obj['large'].'" alt="'. $photo_obj['title'] .'"/>';
return $str;	
}
if(!isset($gallery_id)) {
	$gallery_id = 0;
}

if(!isset($album)) {
		$album = $this->requestAction(array('plugin' => 'photon', 'controller' => 'albums', 'action' => 'view'), array('pass' => array('slug' => $slug)));
	} 
	
if(!empty($album)): 

	if(isset($album['Photo']) && count($album['Photo'])): 
	 	$html_gallery ='<div id="overlayer" style="direction:ltr">';
	 	$html_gallery .='<h4 style="display:inline;padding-right:20px">'.$album['Photo'][0]['title'].'</h4>  Technique:'.
	 					'<p class="technique" style="display:inline">'.$album['Photo'][0]['Term']['title'].'</p>'.
	 					'<p class="desc">'.$album['Photo'][0]['description'].'</p>'.
	 					'<img class="big" 
	 						src="'. $this->Html->url('/img/photos/'. $album['Photo'][0]['large']).'
	 						" alt="'. $album['Photo'][0]['title'] .'"/>
	 						<ul id="vertical_thumb">';
 	for ($x = 0; $x < count($album['Photo']); $x++) {
 		$photo = $album['Photo'][$x];
		$html_gallery .='<li>'.set_thumb ($photo,$url_tmp).'</li>';
				   $x++; 
		  if ($x<count($album['Photo'])) {
		  		if ($x==count($album['Photo'])-1) {
		  			$br="";
		  		}
		  		else {$br="<br/>";}
		  		$photo = $album['Photo'][$x];
				$html_gallery .='<li>'.set_thumb ($photo,$url_tmp).$br.'</li>';
					 } 
				}
				$html_gallery .='</ul>';
				$html_gallery .='</div></div>';
				//<a href="'. $this->Html->url('/img/photos/'. $album['Photo'][0]['large']).' class="big" title="'.$photo['title'] .'">';
	?>
	<div id="gallery" class="gallery<?php echo $gallery_id; ?>"><?php echo $html_gallery;?>
	<?php else: 
		  __('No photos in the album',true); 
	 endif;?>
	
<?php else: ?>[Gallery:<?php echo $slug; ?>]<?php endif; ?>