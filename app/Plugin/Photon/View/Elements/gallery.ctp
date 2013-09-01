
<script>
<?php 
if (!isset($extra_thumbs)){ ?>
function add_cart(){
		$( "#cartPop" ).dialog( "option", "width", '700px' );
		$( "#cartPop" ).dialog( "option", "z-index", '999' );
	$( "#cartPop" ).dialog( "open" );
	add_to_cart($('#imgdesc #pict_id').html(),$("#imgdesc h6").html(),$("#imgbig img").attr("src"));
}
<?php } ?>

</script>

<?php
 $url_tmp = $this->Html->url("/img/");
$html_gallery="";
 function set_thumb1($photo_obj=array(),$url_tmp){
 		
	$str1 = '<a href="'. $url_tmp. $photo_obj['large'].'" class="thumb" ';
	 $str1 .= 'data-term1="'.$photo_obj['term1'].$photo_obj['title'].'" data-description="'. $photo_obj['description'] .'">';
	 $str1 .= '<img src="'. $url_tmp. $photo_obj['small'].'" alt="'. $photo_obj['title'] .'"/></a>';

	 return $str1;	
}
function set_extra_thumbs($album){
$more_thumb='<ul id="'.$thumb_axes.'">';
				for ($x = $max_thumbs; $x < count($album['Photo']); $x++) {
							$photo = $album['Photo'][$x];
							$more_thumb .='
							<span style="display:none">
							'.set_info($album['Photo'][$x]).'
							</span>';
							$more_thumb .='
							<li>
							'.set_thumb1($photo,$url_tmp).'
							</li>';
							$x++;

				}
				$more_thumb .='</ul>';
				return $more_thumb;
}
 function set_info($album){
		$desc='<div id="imgdesc-inner" ><h6><a href=photo/'.$album['id'].' target="_blank">'.$album['title'].'</a></h6><hr/>
	<table id="desctable" dir="rtl">';
		foreach($album as $key=>$value){
			if ($value=="") continue;
				if ($key=="id") $desc .= '<div id="pict_id" style="display:none">'.$value.'</div>';
			if(!(strpos($key,"id")===false)) continue;
			
			if(in_array($key,array('small','large','title','weight','updated','created'))) continue;
				$desc.='
				<tr><td class="td_fld_name">
				<span class="fld_name">
				'.__($key."_".SITE_NAME).':
				</span>
				</td>
				<td>
				<span class="fld_value">
				'.$value.'
				</span>
				</td></tr>
				';
		}
	$desc.='</table></div>';
		return $desc;

}
if(!isset($gallery_id)) {
	$gallery_id = 0;
}
$more_thumb="";
$need_thumbs=0;
$max_thumbs=Configure::read('Photon.max_thumbs');
if($max_thumbs==0) $max_thumbs=10000;
$auto_first=Configure::read('Photon.auto_show_first_album');
if(!isset($album)&&($auto_first==1)) {
		$album = $this->requestAction(array('plugin' => 'photon', 'controller' => 'albums', 'action' => 'view'), array('pass' => array('slug' => $slug)));
}

if((!empty($album))&& (isset($album['Photo'])) && (count($album['Photo']))){
echo '<script>';
echo '$(["'.$this->Html->url($album['Photo'][0]['large']).'"]).preload();';
echo '</script>';
			$gallery_title ='<div id="album_id" style="display:none">'.$album['Album']['id'].'</div><div id="gallery_title"><h4>'.$album['Album']['title'].'</h4></div><div id="bottom-shadow"></div> ';
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
				$thumb_position=Configure::read('Photon.thumb_position');
				$thumb_axes=Configure::read('Photon.axes');
				$cart="";
					if (Configure::read('Photon.use_cart')==1)
					$cart='<div id="add_cart_button" class="btn btn-large btn-primary" onClick="javascript:add_cart();">'
					.__("I am intersted in this product").'</div>';
				$html_gallery .=
				'<div id="imgbig">
				<img class="big"
				src="'. $this->Html->url('/img/'. $album['Photo'][0]['large']).'
				" alt="'. $album['Photo'][0]['title'] .'"/>'.
				'</div>'.$cart.'<div id="imgdesc"  >'.$desc.'</div><hr/>';
				$thumb='<div id="thumbs-div"><ul id="'.$thumb_axes.'">';
				if (!isset($extra_thumbs)){ 
					for ($x = 0; $x < count($album['Photo']); $x++) {
						if ($x >= $max_thumbs) {
									
									$need_thumbs=1;
									break;
								}
								$photo = $album['Photo'][$x];
								$thumb .='
								<span style="display:none">
								'.set_info($album['Photo'][$x]).'
								</span>';
								$thumb .='
								<li>
								'.set_thumb1($photo,$url_tmp).'
								</li>';
					}
					$thumb .='</ul>';
					if ($need_thumbs==1){
						$thumb .='<div id="more-thumbs"><a href="#" onClick="return false;" >'.$this->Html->image("paperfolded.png").'</a></div>';
						$thumb .='<div class="fade" id="expand_thumb"></div>';
					}
					$thumb .='</div>';
				}
				else {
				$more_thumb='<ul id="'.$thumb_axes.'">';
				for ($x = $max_thumbs; $x < count($album['Photo']); $x++) {
							
							$photo = $album['Photo'][$x];
							$more_thumb .='
							<span style="display:none">
							'.set_info($album['Photo'][$x]).'
							</span>';
							$more_thumb .='
							<li>
							'.set_thumb1($photo,$url_tmp).'
							</li>';
							$x++;

				}
				$more_thumb .='</ul>';
				 echo $more_thumb;
			return ;
				}
		}
$expand='<div id="need_expand" style="display:none">'.$need_thumbs.'</div>';
if($thumb_position=="top")
			echo $expand.'<div id="gallery" class="well gallery'. $gallery_id.'">'.$gallery_title.$thumb.$html_gallery;
		else 
			echo $expand.'<div id="gallery" class="well gallery'. $gallery_id.'">'.$gallery_title.$html_gallery.$thumb;
	}
else{
		echo $this->Element('nophotos');
};
?>
