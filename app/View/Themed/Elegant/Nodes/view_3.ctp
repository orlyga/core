<?php $this->Layout->setNode($node); ?>
<div id="node-<?php echo $this->Layout->node('id'); ?>" class="node node-type-<?php echo $this->Layout->node('type'); ?>">
	<div  class="grid_10" style="margin-left:0;margin-right:0">
		<?php echo $this->Layout->nodeBody(); ?>
	</div>
	<div id="sidebar" style="width:15%">
			      <?php echo $nodes_for_layout['general_info'][0]['Node']['body']?>
	        <div class="articles">
				<?php echo $this->Layout->blocks('right'); ?>
			</div>
				
				<p><span><?php echo $this->Html->image("Facebook-Buttons-1-10-.png",array( 'width'=>"25" , 'alt'=>"Facebook-Buttons-1-10-"))?></span><span style="font-size: 8pt;">&nbsp;<span style="">בכל חודש מבצע אחר לחברינו בפייסבוק, הצטרפו עוד היום!</span></span></p>
			<tbody><tr><td class="vTop hCent" ><div><form rel="async" ajaxify="/plugins/like/connect" method="post" action="/plugins/like/connect" onsubmit="return window.Event &amp;&amp; Event.__inlineSubmit &amp;&amp; Event.__inlineSubmit(this,event)" id="u_0_3">
	</div>
</div>
</div>              
<div id="before_footer" class="container_12" style="margin-left:50px">
     	<div class="grid_10">
     		<div id="bottom-shadow" style="height:2px;margin-top:15px"></div>
			 <div id="phone_image" style="">
			 	
	        		 <?php echo $this->Html->image("phone.png",array("alt"=>"טלפון עץ השני","width"=>"30px"))?>	
	        		<span style="font-family: miau;vertical-align: middle;font-size:1.5em;color:rgb(156, 50, 24)"><span id="phone_title">09-7493701</span> &nbsp;&nbsp;&nbsp;&nbsp; עץ השני, מושב סלעית</span>
	     	</div>
     		<div id="bottom-shadow"></div>
     	</div>   
	     <div class=" grid_1">&nbsp;</div>
		<div class="bluebox grid_2">
				<h4><?php 	echo  $nodes_for_layout['customers'][0]['Node']['title'];?></h4>
						<?php echo  $nodes_for_layout['customers'][0]['Node']['body'];?>
		</div>	
		<div class="grid_6">
			<div class="bluebox">
					<?php 	echo $this->Layout->blocks("region2");?>
			</div>
			<div class="bluebox">
					<h4><?php 	echo $this->Html->link($nodes_for_layout['recommend'][0]['Node']['title'], array(
					'controller' => 'nodes',
					'action' => 'view',
					'type' => $nodes_for_layout['recommend'][0]['Node']['type'],
					'slug' => $nodes_for_layout['recommend'][0]['Node']['slug'],
				));?></h4>
					<?php echo  $nodes_for_layout['recommend'][0]['Node']['excerpt'];
					?>
			</div>	
		</div>	
	
</div>	