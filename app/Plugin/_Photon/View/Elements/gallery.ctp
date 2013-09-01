<script>
$(function(){
	$("#imgbig").width($("#overlayer").width());
});
</script>
<?php 
 $url_tmp = $this->Html->url("/img/");

 function set_thumb1($photo_obj=array(),$url_tmp){
 		
	$str1 = '<a href="'. $url_tmp. $photo_obj['large'].'" class="thumb" ';
	 $str1 .= 'data-term1="'.$photo_obj['term1'].'" data-description="'. $photo_obj['description'] .'">';
	 $str1 .= '<img src="'. $url_tmp. $photo_obj['large'].'" alt="'. $photo_obj['title'] .'"/></a>';

	 return $str1;	
}
 function set_info($album){
	$desc='<h6>'.$album['title'].'</h6><hr/>
		<table id="desctable" dir="rtl">';
		foreach($album as $key=>$value){
			if ($value=="") continue;
			if(!(strpos($key,"id")===false)) continue;
			
			if(in_array($key,array('small','large','title'))) continue;
				$desc.='
				<tr><td>
				<span class="fld_name">
				'.__($key).':
				</span>
				</td>
				<td>
				<span class="fld_value">
				'.$value.'
				</span>
				</td></tr>
				';
		}
		$desc.='</table>';

		return $desc;

}
if(!isset($gallery_id)) {
	$gallery_id = 0;
}

if(!isset($album)) {
		$album = $this->requestAction(array('plugin' => 'photon', 'controller' => 'albums', 'action' => 'view'), array('pass' => array('slug' => $slug)));
}

if((!empty($album))&& (isset($album['Photo'])) && (count($album['Photo']))){
			$html_gallery ='<h4>'.$album['Album']['title'].'</h4><hr/> ';
			$desc=set_info($album['Photo'][0]);
			// is it video
			if (substr($album['Photo'][0]['large'],0,strlen('youtube:'))==='youtube:'){
						$video = substr($album['Photo'][0]['large'],strlen('youtube:')).'?version=3&amp;border=0&amp;autoplay=1&amp;rel=0';
							$videotxt=
							'<object style="height: 390px; width: 640px">'.
							'<param name="movie" value="http://www.youtube.com/v/'.$video.'">'.
							'<param name="allowFullScreen" value="true">'.
							'<param name="allowScriptAccess" value="always">'.
							'<embed src="http://www.youtube.com/v/'.$video.'" '.
							'type="application/x-shockwave-flash" allowfullscreen="true" allowScriptAccess="always" width="640" height="360"></object>';
								
			$html_gallery .=$videotxt;
			}

			//photo album and not video
			else
			{
				$html_gallery .=
				'<div id="imgdesc" >'.$desc.'</div>'.
				'<div id="imgbig">
				<img class="big"
				src="'. $this->Html->url('/img/'. $album['Photo'][0]['large']).'
				" alt="'. $album['Photo'][0]['title'] .'"/>'.
				'</div><hr/><div><ul id="horizonal_thumb">';
				for ($x = 0; $x < count($album['Photo']); $x++) {
							$photo = $album['Photo'][$x];
							$html_gallery .='
							<span style="display:none">
							'.set_info($album['Photo'][$x]).'
							</span>';
							$html_gallery .='
							<li>
							'.set_thumb1($photo,$url_tmp).'
							</li>';
							$x++;
							if ($x<count($album['Photo'])) {
									if ($x==count($album['Photo'])-1) {
										$br="";
										}
									else 
										{$br="<br/>";
									}
									$photo = $album['Photo'][$x];
									$tmp=set_thumb1($photo,$url_tmp);
									$html_gallery .='
									<span style="display:none">
									'.set_info($album['Photo'][$x]).'
									</span>';
									$html_gallery .='<li>'.$tmp.$br.'</li>';
							}
				}
				$html_gallery .='</ul></div>';
		}

		echo '<div id="gallery" class="gallery'. $gallery_id.'">'.$html_gallery;
}
else{
	echo __('No photos in  album ',true);
};
?>