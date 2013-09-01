<?php echo $this->Form->create('Photo',array("accept-charset"=>"UTF-8")); ?>
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
<?php 		
$i=0;
$directory = $new_photos['directory'];
$baseUrl = $new_photos['baseUrl'];
$files=$new_photos['files'];
//echo '<div class="editphoto" id="'.$value['id'].'">;
foreach($files as $file):
	$f = basename($file);
	$url = $baseUrl . "/$f";
		echo $this->Form->input("large",array("name"=>'data[Photo]['.$i.'][large]','type'=>'hidden','value'=>$url));
		echo $this->Form->input("small",array("name"=>'data[Photo]['.$i.'][small]','type'=>'hidden','value'=>$f));
		echo $this->Form->input("album_id",array("name"=>'data[Photo]['.$i.'][album_id]','type'=>'hidden','value'=>$album_id));
				
		$f=substr($f,0,strlen($f)-4);
	
	//echo '<img src="'.$url.'"/>';
	echo '<tr><td>';
		echo $this->Html->image($url,array("width"=>100));
		echo '</td><td><table style="border:0;"><tr><td>';
				 echo $this->Form->input("item_code",array("name"=>'data[Photo]['.$i.'][item_code]'));
					echo '</td></tr><tr><td>';
		 				echo $this->Form->input("title",array("name"=>'data[Photo]['.$i.'][title]',"label"=>__('Name', true),"value"=>$f));
					echo '</td></tr><tr><td>';	
							echo $this->Form->input("term1",array("label"=>__("term1_".SITE_NAME),"name"=>'data[Photo]['.$i.'][term1]'));
					echo '</td></tr><tr><td>';
						echo $this->Form->input("term2",array("label"=>__("term2_".SITE_NAME),"name"=>'data[Photo]['.$i.'][term2]'));
					echo '</td></tr><tr><td>';
						echo $this->Form->input("term3",array("label"=>__("term3_".SITE_NAME),"name"=>'data[Photo]['.$i.'][term3]'));
			echo '</td></tr></table></td>';	
			echo '<td width="300px">'	;
				echo '<label>'. __('Description', true).'</label>';
				echo $this->Form->textarea("description",array("width"=>300,"height"=>'300px',"name"=>'data[Photo]['.$i.'][description]',"rows"=>'10',"cols"=>'25'));
			echo '</td></tr>';
		$i++;
	endforeach;
	echo '</table>';
	echo $this->Form->Submit('Submit');
	echo $this->Form->end();

?>