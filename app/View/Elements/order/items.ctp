<script>
function set_amount(cur){
$(cur).next(".amount").html(this.value);
}
var trash_icon='<?php
$image=$this->Html->image("trash.png",array("width"=>"100%","alt"=>__("Remove From List")));
echo $image;
// echo $this->Html->link($image,"#",array('onClick'=>"javascript:$(this).parent().parent().remove();return false")); 
?>';
function request_quate(){
/*$('#cartPop .nice-box').slideToggle();*/
$('#cartPop').css('max-height','none');
$('#cartPop').css('min-height','400px');
$('#cartPop').css('min-width','300px');
$('#contact-1').slideDown("slow");
$('#cartPop').parent().css('min-width','350px');
$('#MessageTitle').val('<?php echo __('Request Quate'); ?>');
$('#MessageBody').parent().addClass('fade');
$('#MessageBody').val($('#itemslist').html());
}

function add_to_cart(product_id,product_title,product_img){
var str = '<tr ><td style="width:10%">'+product_id+'</td>'+
'<td style="width:120px"><img class="itemlistimg" src="'+product_img+'"></td>'+
'<td class="titletable"">'+product_title+'</td>'+
'<td style="width:10%" ><input name="amount" style="width:70%" type="number" onChange="$(this).next(\'.amount\').html(this.value);" value=""/><div class="amount fade" ></div></td>'+
'<td style="width:5%">'+
'<a href="#" onClick="javascript:$(this).parent().parent().remove();return false";>'+
trash_icon+'</a>'+
 '</td></tr>';
    $('#first-row').after(str);
    $("#bodymsg").val($("#itemslist").html());
 }
 
</script>

<h3><strong><?php echo __("What's in your Shopping Cart?"); ?></strong></h3>
<?php if ($this->Session->check("cartInfo"))
		echo $this->Session->read("cartInfo") ;
	else {
 ?>
<div id="itemslist">
	<table class='nice' id='order-details' width="100%"  dir="rtl" border="1" cellpadding="10" cellspacing="0">
	<tr id="first-row">
		<th nowrap><?php echo __("Id") ?></h4></th>	
		<th><h4>&nbsp</h4></th>
		<th><h4><?php echo __("Product") ?></h4></th>
		<th nowrap><?php echo __("Amount") ?></h4></th>
		<th nowrap><h4>&nbsp</h4></th>
		</tr>	
		
	</table>
</div>
<?php } ?>
<div class="span-15">&nbsp;</div>
<div class="span-3 last">
	<br />
	
	<ul class="button-actions button-actions-checkout">
		<li class="button-action-checkout">
			<?php  echo $this->Html->link(__("Back to Shopping"),"void(0)",array('onClick'=>"javascript:$('.ui-dialog-titlebar-close').click();$('#contact-1').hide();return false;",'class'=>'btn',"style"=>'color:black')); ?>
			<?php  echo $this->Html->link(__("Request Quate"),"#",array('onClick'=>"request_quate();return false;",'class'=>'btn btn-warning')); ?>

		</li>
	</ul>
</div>

	<?php //echo $this->element('send_quate');
	echo $this->requestAction("/contacts/view/contact")?>

