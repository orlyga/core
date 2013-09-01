<style>
table tr td{padding:0;padding-right:10px;
}
div.input {margin-top:5px;}
label{font-size:14px}
table tr td tr td{border:0;}
table tr{border-bottom: 1px solid rgb(223, 223, 223);}
form textarea {height:100px;}
form input[type="text"]{margin-bottom:0;padding:2px}
table img {padding-left:10px}
</style>
<div id="update-list">
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
<?php 		echo $this->Form->create("Photo");
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
		 echo $this->Html->Link(__("Change Picture"),"javascript:change_picture(".$photo['Photo']['id'].",'data[Photo][".$i."][large]')",array("class"=>"linkview"));
		echo '</td><td>';
		 			echo $this->Form->input("title",array("name"=>'data[Photo]['.$i.'][title]',"value"=>$photo['Photo']['title'],"label"=>__('Name', true)));
		echo '<br/>';
				 	echo $this->Form->input("item_code",array("value"=>$photo['Photo']['item_code'],"name"=>'data[Photo]['.$i.'][item_code]'));
		echo '</td></tr><tr><td colspan="2">';
					echo '<label>'. __('Description', true).'</label>';
					echo $this->Form->textarea("description",array("value"=>$photo['Photo']['description'],"width"=>300,"height"=>'100px',"name"=>'data[Photo]['.$i.'][description]',"rows"=>'10',"cols"=>'25'));
		echo '</td></tr></table></td>';
		 echo '<td>';	
				echo $this->Form->input("term1",array("value"=>$photo['Photo']['term1'],"name"=>'data[Photo]['.$i.'][term1]'));
				echo '<br/>';
				echo $this->Form->input("term2",array("value"=>$photo['Photo']['term2'],"name"=>'data[Photo]['.$i.'][term2]'));
				echo '<br/>';
				echo $this->Form->input("term3",array("value"=>$photo['Photo']['term3'],"name"=>'data[Photo]['.$i.'][term3]'));
				echo '<br/>';
		echo '</td><td>';
			$actions = ' ' . '<div class=change_img'.$photo['Photo']['id'].'></div>';
			$actions .= ' ' . $this->Html->link(__('Move up', true), array('controller' => 'photos', 'action' => 'admin_moveup', $photo['Photo']['id'],1,$photo['Photo']['album_id']));
 			$actions .= ' ' . $this->Html->link(__('Move down', true), array('controller' => 'photos', 'action' => 'admin_movedown', $photo['Photo']['id'],1,$photo['Photo']['album_id']));
			$actions .='<br/>';
			$actions .= ' ' . $this->Html->link(__('Remove', true),array('controller' => 'photos', 'action' => 'admin_delete', $photo['Photo']['id'],$photo['Photo']['album_id']));;
			echo $actions;
			echo '</td></tr>';
		$i++;
	endforeach;
echo $this->Form->end("Submit");

?>
</table>
</div>