<script>
$(window).load(function(){
$("#MessageImage").val($('#photo_src').attr("src"));
});
</script>
<div id="itemslist" class="nice-box grid_12" style="padding-bottom:6%" >
<?php
echo $this->Form->create('Message',array(
  'type' => 'post', 
  'action' => 'add',
  'class'=>'grid_12',
  'onSubmit' => 'return false;'
 ));
		?>					
	<div class="grid_1">&nbsp;</div>
	<div class="grid_7" >
		<?php 
	 if ($mail_status<>'sent') { ?>
		<div class="close-send-message grid_7">
				<?php
						
					//is reprodution
					//if ($item_info['Photo']['term2']==1) echo "ליטוגרפיה עם נגיעות שמן";
					$disabled=false;
					$OnChange='void(0)';
					if (!empty($item_info['Photo']['term3'])) 
					{
						$disabled=true;
						$OnChange='$("#MessageHeight").val(this.value*'.$item_info['Photo']['term3'].')';
					}
					echo '<div class="grid_3" style="float:right">';
						echo '<p style="font-size: 120%;font-weight: bold;">אנא עדכנו את רוחב הציור שתרצו, הגובה יתעדכן אוטומטית במידה והפרופורציה צריכה להישמר</p>';
						
						echo $this->Form->input('Message.width',array('value'=>$item_info['Photo']['term4'],"style"=>"width:50px;",'required'=>true,'label' => false,'placeholder'=>__('Width'),"onChange"=>$OnChange,'div'=>array('style'=>'display:inline-block;')));echo '<span style="font-size:120%;padding-right:10px">'. __('Yard') . '</span><br/>';
						echo $this->Form->input('Message.height',array('value'=>$item_info['Photo']['term5'],"style"=>"width:50px",'label' => false,'placeholder'=>__('Height'),"disabled"=>$disabled,'div'=>array('style'=>'display:inline-block;'))); echo '<span style="font-size:120%;padding-right:10px">'. __('Yard') . '</span>';
					echo '</div>';
					echo '<div class="grid_3" style="float:right">';
						echo $this->Form->input('Message.name',array('label' => false,'placeholder'=>__('Name')));
						echo $this->Form->input('Message.email',array('label' => false,'placeholder'=>__('Email')));
						echo $this->Form->input('Message.phone',array('label' => false,'placeholder'=>__('Phone')));
						echo $this->Form->input('Message.title',array('label' => false,'placeholder'=>__('Subject'),"value"=>"הצעת מחיר",'type' => 'hidden'));
						echo $this->Form->input('Message.body', array( 'type' => 'hidden'));
						echo $this->Form->input('Message.image', array( 'type' => 'hidden'));
						echo $this->Form->input('Message.message',array('label'=>false,'type'=>'textarea','style'=>'height:70px;width:100%','placeholder'=>__('Add Comment')));
						
						echo '</div>';
						
				
				echo '</div>';
				
				if (isset($nodes_for_layout['contact_inf'])){
				//echo '<div class="grid_5 nice-box" style="min-height: 500px;">';
					//echo  $nodes_for_layout['contact_inf'][0]['Node']['body'];
			
			echo '</div>';
			}	
	}
	else {
			
				echo "<h2> ההודעה נשלחה... </h2>";
				//echo $this->Html->link(__("Back to Shopping"),"/",array('class'=>'btn btn-warning')); 

			echo '</div>';
	}	?>
	
	<div class="grid_3">
	<?php echo $this->Element('order/items');?>
	</div>
	<div style="position:absolute;left:2%;bottom:20%">
		<?php	
		 echo  $this->Js->submit(__("Submit"), 
									  array( 'url'=> array('plugin'=>'photon','controller'=>'photos',
									   'action'=>'send_mail_tome'),
									    'before'=>'if(!$("#MessageEmail")[0].checkValidity()) {("#MessageEmail").css("border","solid red");$("#MessageEmail").attr("placeholder","'.__("Email is Missing or Incorrect").'");return false;}',
									    'class' => 'btn btn-warning',
									    'buffer' => false,
									    'success'=>'$("#itemslist").html(data);',
									    'error'=>'alert(data);'
	     						 ));
					
		echo $this->Form->end();?>
	</div>
</div>
</div>
<div class="clear"></div>
<div class="grid_12" style="position:relative;width:100%">
	
</div>
<div id="sending"></div>