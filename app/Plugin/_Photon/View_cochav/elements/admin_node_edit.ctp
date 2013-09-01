<?php
	$album_id = '';
	$slug='';
	if (isset($album['Album']['id'])) {
		$album_id = $album['Album']['id'];
	}
	if (isset($album['Album']['slug'])) {
		$slug = $album['Album']['slug'];
	}

echo '<div class="album upload" slug="$slug">'
?>
<h3><?php echo __('Pictures for this album:', true);?></h3>
<small><?php echo __('Every node has got its private gallery album. Everytime you upload an image in this tab, it will be appended to this album. To show the whole album in your node, paste the following code at the location of your choice (of course this works in other nodes as well):', true);?><br/> </small>
<?php if(isset($album['Photo'])):
?>
<p>
	<table cellpadding="0" cellspacing="0" id="return">
		<tr>
			<th><?php echo __('Picture', true);?></th>
			<th><?php echo __('Title, Description & URL', true);?></th>
			<!--<th><?php __('Embedding',true);?></th>-->
			<th><?php echo __('Actions', true);?></th>
			<th></th>
		</tr>
		<?php foreach($album['Photo'] as $photo):
		?>
		<tr>
			<td><?php echo $this -> Html -> image('photos/' . $photo['small'], array('id' => $photo['id']));?></td>
			<td>
			<input type="text" name="title<?php echo $photo['id'];?>" value="<?php echo $photo['title'];?>" />
			<br/>
			<input type="text" name="desc<?php echo $photo['id'];?>" value="<?php echo $photo['description'];?>" />
			<br/>
			<?php __('URL: ');?><a href="/img/photos/<?php echo $photo['large'];?>">/img/photos/<?php echo $photo['large'];?></a></td>
			<td><?php
$actions = ' ' . '<div class=change_img'.$photo['id'].'></div>';

echo $actions
			?></td>
			<!--<td>Insert [Image:<?php echo $photo['id']; ?>] into your node.</td>-->
			<td><a href="javascript:;" class="remove" rel="<?php echo $photo['id'];?>"><?php echo __('Remove', true);?></a></td>
		</tr>
		<?php endforeach;?>
	</table>
</p>
<?php endif;?>

<!--This container will be filled with data received from the Uploader-->
<p>
	<div id="upload"></div>
</p>
<p>
	<div id="replace_img" styly="display:none"></div>
</p>
</div> <?php echo $this -> Html -> script('/photon/js/fileuploader', false);
	echo $this -> Html -> css('/photon/css/fileuploader', false);
?>

<script>
var desctitleurl  = '<?php echo $this->Html->url(array('plugin' => 'photon', 'controller' => 'photos', 'action' => 'updateTitleAndDescription')); ?>' ;
 
function createUploader(){     

    var uploader = new qq.FileUploader({
        element: document.getElementById('upload'),
        action: '<?php echo $this->Html->url(array('plugin' => 'photon', 'controller' => 'albums', 'action' => 'upload_photo', $album_id)); ?>',
		onComplete: function(id, fileName, responseJSON){
			$('.qq-upload-fail').fadeOut(function(){
				$(this).remove();
			});
			$('#return').append('<tr>' +
				'<td><img src="<?php echo $this->Html->url('/img/photos/'); ?>'+responseJSON.Photo.small+'" /></td>' +
				'<td>' +
				'<input type="text" name="title'+responseJSON.Photo.id+'" value="" /><br/>' +
				'<input type="text" name="desc'+responseJSON.Photo.id+'" value="" /><br/>' +
				'<?php __('URL: '); ?><a href="/img/photos/'+responseJSON.Photo.small+'">/img/photos/'+responseJSON.Photo.small+'</a>' + 
				'</td>' +
				'<td>Insert [Image:'+responseJSON.Photo.id+'] into your node.</td>' +
				'<td><a href="javascript:;" class="remove" rel="'+responseJSON.Photo.id+'"><?php echo __('Remove',true); ?></a></td>' +
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
	var new_src = "<?php echo $this -> Html -> url('/img/photos/');?>";
	
	$("div[class^=change_img]").each(function(){
			var idd = $(this).attr("class");
	 idd=idd.replace('change_img','');
			var uploader = new qq.FileUploader({
			element: document.getElementsByClassName($(this).attr("class"))[0],
			action: '<?php echo $this -> Html -> url(array('plugin' => 'photon', 'controller' => 'photos', 'action' => 'admin_upload_replace_photo', $album_id, $slug));?>/'+idd,
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
	$('.remove').live('click', function(){
	var obj = $(this);
	$.getJSON('<?php echo $this -> Html -> url('/admin/photon/albums/delete_photo/');?>
		'+obj.attr('rel'), function(r) {
		if(r['status'] == 1) {
			obj.parent().parent().fadeOut(function() {
				$(this).remove();
			});
		} else {
			alert(r['msg']);
		}
		});
		});

		});
</script>