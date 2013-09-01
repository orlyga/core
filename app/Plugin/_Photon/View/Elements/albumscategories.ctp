
<?php 
		echo $this->Html->script(array('quickm'));

$albums = $this->requestAction(array('plugin' => 'photon', 'controller' => 'albums', 'action' => 'index_category'));

	$counter = 0; //We need a counter in order to set up popeye properly
		$html_albums = '<span class="qmclear">&nbsp;</span>
<div id="qm0" class="qmmc">';
		$proj_type = "";

		 foreach($albums as $album): 
			 $proj_type_loc = $album['Album']['term_id'];
			 //new parent
			 if ($proj_type_loc != $proj_type){
			 	
			 	if($proj_type <> "") $html_albums.= '</div>'; //close prev group
			 	$html_albums.=  $this->Html->link($album['Term']['slug'],'javascript:void(0)',array('class'=>'qmstripe')); 
				$html_albums.='<div>';
				$proj_type = $proj_type_loc; 
 			}
			//$url=$this->Html->url(array('plugin' => 'photon', 'controller' => 'albums', 'action' => 'view',$album['Album']['slug']));
			 $html_albums.=	$this->Html->link($album['Album']['slug'],array('plugin' => 'photon', 'controller' => 'albums', 'action' => 'view',$album['Album']['slug']));
			//$html_albums.=	$this->Html->link($album['Album']['slug'],'javascript:replaceAlbum("'.$url.'")',array('class'=>'album-ajax-link')); 					
 endforeach; 
		$html_albums .= "</div>";
echo $html_albums;
 ?>	
<script type="text/javascript">
qm_create(0,false,0,500,'all',false,false,false,false);
function replaceAlbum(url){
	replaceContent(url);
	return false;
}

</script>
<span class="qmclear">&nbsp;</span>
</div>
