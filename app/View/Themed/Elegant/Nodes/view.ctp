<div class="grid_12">
<?php $this->Layout->setNode($node); ?>
	<div id="node-<?php echo $this->Layout->node('id'); ?>" class="node node-type-<?php echo $this->Layout->node('type'); ?>">
			<div  class="grid_10" style="margin-left:0;margin-right:0">
				<h3><?php echo $this->Html->link($this->Layout->node('title'), $this->Layout->node('url')); ?> 
			                <small><?php // echo $this->Layout->nodeInfo(); ?></small>
			        </h3><hr/>
				<?php echo $this->Layout->nodeBody(); ?>
			        <hr/>
			        <?php echo $this->Layout->nodeMoreInfo(); ?><br/>
			</div>
	</div>
	<div id="sidebar" style="width:15%">
				<?php echo $this->Layout->blocks('right'); ?>
	</div>

</div>
<div class="clear"></div>
