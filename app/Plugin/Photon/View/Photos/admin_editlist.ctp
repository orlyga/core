<script>
function update_fld(fldd){
	var album_id=<?php echo $album_id?>;
			var fld=fldd.attr("name");
			var matches = [];
			fld.replace(/\[(.*?)\]/g, function(g0,g1){matches.push(g1);});
			var val=fldd.val();
			fld=matches[2];
			var id = $('input[name="data['+matches[0]+']['+matches[1]+'][id]"]').val();
			$('#sending').css({"top":fldd.offset().top,"left":fldd.offset().left-20});
			$('#sending').fadeIn("fast");
			if (fld=="large")  {
				var i=$("#img"+id).attr("src");
				var bs=basename(i);
				i=i.replace(bs,basename(val));
			}
$.post('<?php echo $this->Html->url(array('plugin'=>'photon','controller'=>'photos',
			   'action'=>'admin_update')) ?>',{id:id,fld:fld,val:val,album_id:album_id}, 
			   function(data){$('#sending').fadeOut("fast");
			   img_prefix=$("#img"+id).attr("src");
			   img_prefix=img_prefix.substr(0,img_prefix.indexOf("/files")+1);
			   if(fld=="large") $("#img"+id).attr("src",img_prefix+data.newImageName);}, 'json');
}
function basename(str)
{
   var base = new String(str).substring(str.lastIndexOf('/') + 1); 
    if(base.lastIndexOf(".") != -1)       
       base = base.substring(0, base.lastIndexOf("."));
   return base;
}
$(function(){
$('#update-list :input').live('change', function() {
			update_fld($(this));
		});
});
function change_picture(pict_id,dest_input_field,x,y){
	$('#sending').css({"top":y,"left":x});$('#sending').fadeIn("fast");
	imgreplace=pict_id;
	destfield=dest_input_field;
$("input[name='file']").click();
}
</script>
<div id="sending" ></div>
<div id="update-list">
<?php echo $this->element("admin_photofilter"); ?>
<table cellpadding="0" cellspacing="0" id="return">
		<!--<tr>
			<th><?php echo __('Picture', true);?></th>
			<th><?php echo __('Title', true);?></th>
			<th><?php echo __('Description', true);?></th>
			<th><?php echo __('term1', true);?></th>
			<th><?php echo __('term2', true);?></th>
			<<th><?php __('Embedding',true);?></th>
			<th><?php echo __('Actions', true);?></th>
			<th></th>
		</tr>-->
<?php 	//	echo $this->Form->create("Photo");
$i=0;
//echo '<div class="editphoto" id="'.$value['id'].'">;
echo $this->Form->create('Photo',array("accept-charset"=>"UTF-8"));
$this->request->data=$photos;

foreach($photos as $photo):
		echo $this->Form->input("id",array("value"=>$photo['Photo']['id'],"name"=>'data[Photo]['.$i.'][id]','type'=>'hidden'));
		echo $this->Form->input("large",array("value"=>$photo['Photo']['large'],"name"=>'data[Photo]['.$i.'][large]','type'=>'hidden'));
		echo $this->Form->input("small",array("value"=>$photo['Photo']['small'],"name"=>'data[Photo]['.$i.'][small]','type'=>'hidden'));
		echo $this->Form->input("album_id",array("value"=>$photo['Photo']['album_id'],"name"=>'data[Photo]['.$i.'][album_id]','type'=>'hidden'));
	//echo '<img src="'.$url.'"/>';
	echo '<tr><td><table style="border:0;"><tr><td>';
		 echo $this -> Html -> image( $photo['Photo']['large'], array('width' => 150,'id'=>'img'.$photo['Photo']['id']));
		 echo '<br/>';
		 echo $this->Html->Link(__("Change Picture"),"javascript:change_picture(".$photo['Photo']['id'].",'data[Photo][".$i."][large]',this.pageX,this.pageY)",array("class"=>"linkview"));
		echo '</td><td>';
		 			echo $this->Form->input("title",array("name"=>'data[Photo]['.$i.'][title]',"value"=>$photo['Photo']['title'],"label"=>__('Name', true)));
		echo '<br/>';
				 	echo $this->Form->input("item_code",array("value"=>$photo['Photo']['item_code'],"name"=>'data[Photo]['.$i.'][item_code]'));
		echo '</td></tr><tr><td colspan="2">';
					echo '<label>'. __('Description', true).'</label>';
					echo $this->Form->textarea("description",array("value"=>$photo['Photo']['description'],"width"=>300,"height"=>'100px',"name"=>'data[Photo]['.$i.'][description]',"rows"=>'10',"cols"=>'25'));
		echo '</td></tr></table></td>';
		 echo '<td>';	
				echo $this->Form->input("term1",array("label"=>__("term1_".SITE_NAME,true),"value"=>$photo['Photo']['term1'],"name"=>'data[Photo]['.$i.'][term1]'));
				echo '<br/>';
				echo $this->Form->input("term2",array("label"=>__("term2_".SITE_NAME,true),"value"=>$photo['Photo']['term2'],"name"=>'data[Photo]['.$i.'][term2]'));
				echo '<br/>';
				echo $this->Form->input("term3",array("label"=>__("term3_".SITE_NAME,true),"value"=>$photo['Photo']['term3'],"name"=>'data[Photo]['.$i.'][term3]'));
				echo '<br/>';
		echo '</td><td>';
			$actions = ' ' . '<div class=change_img'.$photo['Photo']['id'].'></div>';
			//$actions .= ' ' . $this->Html->link(__('Move up', true), array('controller' => 'photos', 'action' => 'admin_moveup', $photo['Photo']['id'],1,$photo['Photo']['album_id']));
 			//$actions .= ' ' . $this->Html->link(__('Move down', true), array('controller' => 'photos', 'action' => 'admin_movedown', $photo['Photo']['id'],1,$photo['Photo']['album_id']));
			$actions .='<br/>';
			$actions .= ' ' . $this->Html->link(__('Remove', true),array('controller' => 'photos', 'action' => 'admin_delete', $photo['Photo']['id'],$photo['Photo']['album_id']));;
			echo $actions;
			echo '</td></tr>';
		$i++;
	endforeach;
if (count($photos)>0)
echo $this->Form->submit(__('Submit'),array('div'=>array('class'=>'fade','style'=>"display:none")));
echo $this->Form->end();
?>
</table>
<footer>
	<nav id="pagination"><?php $this->Paginator->options(array('update' => '#album-images-list',
	'evalScripts' => true,
	    'complete' => $this->Js->get('#Sending')->effect('fadeOut', array('buffer' => false)),
)); echo $this->Paginator->numbers(); echo $this->Js->writeBuffer();?></nav>
</footer>
</div>