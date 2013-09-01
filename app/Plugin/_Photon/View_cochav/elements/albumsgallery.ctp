<?php 
$albums = $this->requestAction(array('plugin' => 'photon', 'controller' => 'albums', 'action' => 'index_all'));

if(!isset($gallery_id)) {
	$gallery_id = 0;
}

	$counter = 0; //We need a counter in order to set up popeye properly

	
if(count($albums) == 0): 
		echo '<article><p class="notification">';
        __('No albums found.',true);
		echo '</p></article>';
	else: 
		$html_albums = '<ul id="albums">';
		 foreach($albums as $album): 
				 //if (!empty($album['Photo'][0]['small'])) : 
				 $link_txt = $html->link($album['Album']['title'], "/gallery/album/".$album['Album']['slug'], array('class'=>'js-ajax',));
				 $html_albums .='<li>'.$link_txt; 
				 $html_albums .=$html->image('/photon/img/flower.png',array('class'=>'flower '.$album['Album']['slug'],)).'</li>';
				//$html_albums .='<li><a href="#">'.$album['Album']['title'].'</a></li><br>';
						
 endforeach; 
		$html_albums .= "</ul>";

	 endif; ?>	
	
<?php	
$slug=$albums[0]['Album']['slug'];
		$album = $this->requestAction(array('plugin' => 'photon', 'controller' => 'albums', 'action' => 'view'), array('pass' => array('slug' => $slug)));
if(!empty($album)): 

 if(isset($album['Photo']) && count($album['Photo'])): 
 	$html_gallery ='<div id="overlayer" style="direction:ltr"><img class="big" src="'. $this->Html->url('/img/photos/'. $album['Photo'][0]['large']).'" alt="'. $album['Photo'][0]['title'] .'"/><ul id="vertical_thumb">';
 	for ($x = 0; $x < count($album['Photo']); $x++) {
 		$photo = $album['Photo'][$x];
		$html_gallery .= '<li><a href="'. $this->Html->url("/img/photos/". $photo['large']).'" class="thumb" ';
		 $html_gallery .= 'title="'. $photo['title'] .'"><img src="'. $this->Html->url('/img/photos/'. $photo['large']).'" alt="'. $photo['title'] .'"/></a></li>';
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
				//<a href="'. $this->Html->url('/img/photos/'. $album['Photo'][0]['large']).'" class="big" title="'.$photo['title'] .'">';
				$html_gallery .='</div></div>';
	?>
	<div id="gallery" class="gallery<?php echo $gallery_id; ?>"><?php echo $html_albums;echo $html_gallery;?>
	<?php else: ?>
		<?php  __('No photos in the album',true); ?>
	<?php endif;?>
	
<?php else: ?>[Gallery:<?php echo $slug; ?>]<?php endif; ?>