<?php 
function set_info($photo){
	$desc=
		'<table id="desctable" dir="rtl">';
		foreach($photo as $key=>$value){
			if ($value=="") continue;
			if(!(strpos($key,"id")===false)) continue;
			
			if(in_array($key,array('small','large','title','weight','updated','created'))) continue;
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
?>


<div class="grid_12">
			<div  class="grid_2">&nbsp;</div>
			<div  class="grid_8 nice-box" style="background-color:rgba(255,255,255,0.8);.margin-left:0;margin-right:0">
				
				<div id="imgbig">
	<h1><?php echo $photo['title'] ?></h1>
	<p><?php echo $photo['description'] ?></p>
	<div style="position:absolute;left:10%;top:30%">
				<?php  echo $this->Html->link(__("Back to Shopping"),"javascript:window.close()",array('class'=>'btn btn-warning',"style"=>'font-size: 1.5em;
padding: 20px;')); ?>
	</div>
	<hr/>
	<?php 
	echo  $this->Html->image($photo['large'],array('class'=>'big','alt'=>$photo['title']));?>
</div>
<div id="imgdesc" style="width:200px"><?php echo set_info($photo) ?></div><hr/>
				
<div>
			</div>
			<div class="clear"></div>
	</div>
	

</div>
<div class="clear"></div>



