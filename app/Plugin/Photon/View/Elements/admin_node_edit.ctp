<?php
	$album_id = '';
	$slug='';
	if (isset($album['Album']['id'])) {
		$album_id = $album['Album']['id'];
	}
	if (isset($album['Album']['slug'])) {
		$slug = $album['Album']['slug'];
	}

echo '<div class="album upload" slug="$slug">';
$option_tech = '';


function set_dd ($str_options,$val){
$str_search='value="'.$val.'"';
return str_replace($str_search,$str_search." selected ",$str_options);
}
?>
<h3><?php echo __('Pictures for this album:', true);?></h3>
<small><?php echo __('Every node has got its private gallery album. Everytime you upload an image in this tab, it will be appended to this album. To show the whole album in your node, paste the following code at the location of your choice (of course this works in other nodes as well):', true);?><br/> </small>
<?php if(isset($album['Photo'])):
?>
<p>
	<div id="upload"></div>
</p>
<p>
	<div id="replace_img" styly="display:none"></div>
</p>
<p>

	<table cellpadding="0" cellspacing="0" id="return">
		<tr>
			<th><?php echo __('Picture', true);?></th>
			<th><?php echo __('Title, Description & URL', true);?></th>
			<!--<th><?php __('Embedding',true);?></th>-->
			<th><?php echo __('Actions', true);?></th>
			<th></th>
		</tr>
		<?php 		echo $this->Form->create("Photo");
$i=0;
			 	foreach($album['Photo'] as $photo):
			 
		?>
		<tr>
			<td><?php echo $this -> Html -> image('photos/' . $photo['small'], array('id' => $photo['id']));?></td>
			<td>
				<?php echo $this->Form->input("title",array("name"=>'data[Photo]['.$i.'][title]',"label"=>__('Name', true),"value"=>$photo['title']))?>
				<label><?php echo __('Description', true)?></label>
				<?php echo $this->Form->textarea("description",array("name"=>'data[Photo]['.$i.'][description]',"label"=>__('Description', true),"rows"=>'5',"cols"=>'40',"value"=>$photo['description']))?>
			
			
			<lable for="term1"><?php echo __('Term1', true)?></lable>
			<?php echo $this->Form->select("term1",$term1,array("name"=>'data[Photo]['.$i.'][term1]',"value"=>$photo['term1']))?>
			<br/>
			
			<?php __('URL: ');?><a href="/img/photos/<?php echo $photo['large'];?>">/img/photos/<?php echo $photo['large'];?></a></td>
			<td><?php
$actions = ' ' . '<div class=change_img'.$photo['id'].'></div>';
$actions .= ' ' . $this->Html->link(__('Move up', true), array('controller' => 'albums', 'action' => 'moveup_photo', $photo['id'],1,$album_id));
 $actions .= ' ' . $this->Html->link(__('Move down', true), array('controller' => 'albums', 'action' => 'movedown_photo', $photo['id'],1,$album_id));

echo $actions;
			?></td>
			<!--<td>Insert [Image:<?php echo $photo['id']; ?>] into your node.</td>-->
			<td><a href="javascript:;" class="removeimg" rel="<?php echo $photo['id'];?>"><?php echo __('Remove', true);?></a></td>
		</tr>
		
		<?php $i++;
		endforeach;?>
	
	</table>
</p>
	<?php echo $this->Form->end("Submit")?>
<?php endif;?>

<!--This container will be filled with data received from the Uploader-->

</div> <?php echo $this -> Html -> script('/photon/js/fileuploader', false);
	echo $this -> Html -> css('/photon/css/fileuploader', false);
?>

<script>
 var desctitleurl  = '<?php echo $this->Html->url(array('plugin' => 'photon', 'controller' => 'photos', 'action' => 'admin_updateTitleAndDescription')); ?>' ;
function createUploader(){     

    var uploader = new qq.FileUploader({
    	  element: document.getElementById('upload'),
        action: '<?php echo $this->Html->url(array('plugin' => 'photon', 'controller' => 'albums', 'action' => 'admin_upload_photo', $album_id)); ?>',
		onComplete: function(id, fileName, responseJSON){
			$('.qq-upload-fail').fadeOut(function(){
				$(this).remove();
			});
			$('#return').append('<tr>' +
				'<td><img src="<?php echo $this->Html->url('/img/photos/'); ?>'+responseJSON.Photo.small+'" /></td>' +
				'<td>' +
				'<lable for="description"><?php echo __('Title', true)?></lable>'+
				'<input type="text" name="title'+responseJSON.Photo.id+'"  /><br/>' +
				'<lable for="description"><?php echo __('Description', true)?></lable>'+
				'<input type="text" name="desc'+responseJSON.Photo.id+'"  /><br/>' +

				'<?php __('URL: '); ?><a href="/img/photos/'+responseJSON.Photo.small+'">/img/photos/'+responseJSON.Photo.small+'</a>' + 
				'</td>' +
				'<td>Insert [Image:'+responseJSON.Photo.id+'] into your node.</td>' +
				'<td><a href="javascript:;" class="removeimg" rel="'+responseJSON.Photo.id+'"><?php echo __('Remove',true); ?></a></td>' +
			'</tr>');
		},
		
	        template: '<div class="qq-uploader">' + 
	                '<div class="qq-upload-drop-area"><span><?php echo __('Drop files here to upload',true); ?></span></div>' +
					'<a class="qq-upload-button ui-corner-all" style="background-color:#EEEEEE;float:left;font-weight:bold;margin-right:10px;padding:10px;text-decoration:none;cursor:pointer;"><?php echo __('Add new photos',true); ?></a>' +
					'<ul class="qq-upload-list"></ul>' + 
	             '</div>',
		      
			fileTemplate: '<li>' +
		                '<span class="qq-upload-file"></span>' +
		                '<span class="qq-upload-spinner"></span>' +
		                '<span class="qq-upload-size"></span>' +
		                '<a class="qq-upload-cancel" href="#"><?php echo __('cancel',true); ?></a>' +
		            '</li>',

    });

	}
	function setuploaderphoto(){
	var new_src = "<?php echo $this->Html->url('/img/photos/');?>";
	
	$("div[class^=change_img]").each(function(){
			var idd = $(this).attr("class");
	 idd=idd.replace('change_img','');
			var uploader = new qq.FileUploader({
			element: document.getElementsByClassName($(this).attr("class"))[0],
			action: '<?php echo $this->Html->url(array('plugin' => 'photon', 'controller' => 'photos', 'action' => 'admin_upload_replace_photo', $album_id, $slug));?>/'+idd,
			onComplete: function(id, fileName, responseJSON){
			$('.qq-upload-fail').fadeOut(function(){
			$(this).remove();
			});
			$("img[id^="+responseJSON.Photo.id+"]").attr({ src: new_src+responseJSON.Photo.small });
		
			},
		template: '<div class="qq-uploader">' + 
	                '<div class="qq-upload-drop-area"><span><?php echo __('Drop files here to upload',true); ?></span></div>' +
					'<a class="qq-upload-button ui-corner-all" style="background-color:#EEEEEE;float:left;font-weight:bold;margin-right:10px;padding:10px;text-decoration:none;cursor:pointer;"><?php echo __('Change photo',true); ?></a>' +
					'<ul class="qq-upload-list"></ul>' + 
	             '</div>',
		
			fileTemplate: '<li>' +
			'<span class="qq-upload-file"></span>' +
			'<span class="qq-upload-spinner"></span>' +
			'<span class="qq-upload-size"></span>' +
			'<a class="qq-upload-cancel" href="#"><?php echo  __('cancel', true);?></a>' +
			'</li>',
		
			});
	});
	}

	// in your app create uploader as soon as the DOM is ready
	// don't wait for the window to load
$(function(){

	createUploader();
	setuploaderphoto();
	$('.removeimg').live('click', function(){
			var obj = $(this);
			var slug= $('#AlbumSlug').val();
			var urldest =  '<?php echo $this -> Html -> url(array('plugin' => 'photon', 'controller' => 'albums', 'action' => 'delete_photo')); ?>/'+obj.attr('rel') + '/' +slug;
			$.getJSON(urldest, function(r) {
					if(r['status'] == 1) {
						obj.parent().parent().fadeOut(function() {
								$(this).remove();
						});
					}
					 else {
						alert(r['msg']);
					}
				});
	});
	$('input[name^=titleimg]').live('change', function() {
			var id = parseInt($(this).attr("name").replace("titleimg", ""));
			setforajax("title",id,$(this).val(),desctitleurl);
		});
	$('textarea[name^=descimg]').live('change', function() {
		var id = parseInt($(this).attr("name").replace("descimg", ""));
		
		setforajax("description",id,$(this).val(),desctitleurl);
	});
	$('select[name^=term1]').live('change', function() {
		var slug= $('#AlbumSlug').val();
		var id = parseInt($(this).attr("name").replace("term1", ""));
		setforajax("term1",id,$(this).val(),desctitleurl);
	});

});

</script>