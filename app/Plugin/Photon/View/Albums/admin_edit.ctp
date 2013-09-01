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
<script>
var imgreplace=0;
var destfield="";
function update_fld(fldd){
	var album_id=<?php echo $this->request->data['Album']['id']?>;
			var fld=fldd.attr("name");
			var matches = [];
			fld.replace(/\[(.*?)\]/g, function(g0,g1){matches.push(g1);});
			var val=fldd.val();
			fld=matches[2];
			var id = $('input[name="data['+matches[0]+']['+matches[1]+'][id]"]').val();
			$('#sending').css({"width":"20px","top":fldd.offset().top,"left":fldd.offset().left-20});
			$('#sending').fadeIn("fast");
			if (fld=="large")  {
			$('#sending').css("width","100px");
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

function after_uploadimg(data){
	if(imgreplace>0){
	imgreplace=0;
		$("input[name='"+destfield+"']").val($(data).find("#PhotoLarge").val());
		var destsmall=destfield.replace("large",'small');
		$("input[name='"+destsmall+"']").val($(data).find("#PhotoSmall").val());
		update_fld($("input[name='"+destfield+"']"));
		
		//update_fld(fldd)
	}
	else{
		$("#album-images-list").html(data);
		$("#submit_add").show();
		$(".qq-uploader").hide();
	}
}
function updateList(data){
	$("#submit_add").hide();$(".qq-uploader").show();
	$("#album-images-list").html(data);
 			$('#sending').fadeOut();
	}
</script>
<div id="sending" ></div>
<div class="albums form">
    
    <h2><?php echo __('Edit album')." ". $this->request->data['Album']['title']; 
    	?></h2>
    
    <div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('Back', true), array('action'=>'index')); ?></li>
		</ul>
	</div>
    <div class="tabs">
		<ul>
				<li><a href="#album-basic"><span><?php echo __('Settings'); ?></span></a></li>
				<li><a href="#album-images"><span><?php echo __('Images'); ?></span></a></li>
				<?php echo $this->Layout->adminTabs(); ?>
		</ul>
			
		<div id="album-basic">
		        <?php
					echo $this->Form->create('Album',array("accept-charset"=>"UTF-8"));
					echo $this->Form->input('id');
					echo $this->Form->input('link_id',array('type'=>'hidden'));
					echo $this->Form->input('parent_id', array('label' => __('Category'),'type' => 'select', 'options' => $parentLinks, 'empty' => true));
		            echo $this->Form->input('title',array('label' => __('Title', true)));
					echo $this->Form->input('description',array('label' => __('Description', true)));
					echo $this->Form->input('slug',array('type'=>'hidden'));
					echo $this->Form->input('status');
					echo $this->Form->input('seo_title',array('label' => 'SEO '.__('Title', true)));
			echo $this->Form->input('seo_desc',array('label' => 'SEO '.__('Description', true)));
			echo $this->Form->input('seo_keywords',array('label' => 'SEO '.__('Key Words', true)));
					echo $this->Form->unlockField('link_id');
					echo $this->Form->unlockField('slug');
					echo $this->Form->submit(__('Submit'));
					echo $this->Form->end();?>

		</div>
		<div id="album-images">
		    <div id="album-images-list">
		    			<?php  echo $this->requestAction(array('plugin'=>'photon','controller' => 'photos', 'action' => 'admin_editlist',$this->request->data['Album']['id']));?>
		    </div>	
			
			<?php  echo  $this->Upload->edit('Album', $this->request->data['Album']['id']); 
						 
		    	//echo $this->element('admin_node_edit', array('album' => $album) ); ?>
		</div>
			<?php echo $this->Layout->adminTabs(); ?>
	</div>
	
</div>