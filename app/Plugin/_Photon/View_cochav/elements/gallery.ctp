<?php 
if(!isset($gallery_id)) {
	$gallery_id = 0;
}

if(!isset($album)) {
		$album = $this->requestAction(array('plugin' => 'photon', 'controller' => 'albums', 'action' => 'view'), array('pass' => array('slug' => $slug)));
	} 
	
if(!empty($album)): 

	if(isset($album['Photo']) && count($album['Photo'])): 
	$html_gallery ='<img class="big" src="'. $this->Html->url('/img/photos/'. $album['Photo'][0]['large']).'" alt="'. $album['Photo'][0]['title'] .'"/>';
 	$html_gallery .='<ul id="vertical_thumb">';
 	for ($x = 0; $x < count($album['Photo']); $x++) {
 		$photo = $album['Photo'][$x];
		$html_gallery .= '<li><a href="'. $this->Html->url("/img/photos/". $photo['large']).'" class="thumb" ';
		 $html_gallery .= 'title="'. $photo['title'] .'"><img src="'. $this->Html->url('/img/photos/'. $photo['large']).'" alt="'. $photo['title'] .'"/></li>';
		   $x++; 
		  if ($x<count($album['Photo'])) {
		  		if ($x==count($album['Photo'])-1) {
		  			$br="";
		  		}
		  		else {$br="<br/>";}
		  		$photo = $album['Photo'][$x];
				$html_gallery .= '<li><a href="'. $this->Html->url("/img/photos/". $photo['large']).'" class="thumb" ';
		 		$html_gallery .= 'title="'. $photo['title'] .'"><img src="'. $this->Html->url('/img/photos/'. $photo['large']).'" alt="'. $photo['title'] .'"/></a>'.$br.'</li>';
				 } 
				}
				$html_gallery .='</ul>';
				//<a href="'. $this->Html->url('/img/photos/'. $album['Photo'][0]['large']).' class="big" title="'.$photo['title'] .'">';
	 echo $html_gallery;
	 else: 
		  __('No photos in the album',true); 
	 endif;?>
	
<?php else: ?>[Gallery:<?php echo $slug; ?>]<?php endif; ?>