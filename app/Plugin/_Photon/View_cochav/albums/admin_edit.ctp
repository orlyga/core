<div class="users form">
    
    <h2><?php __('Edit album',true); ?></h2>
    
    <div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('Back', true), array('action'=>'index')); ?></li>
		</ul>
	</div>
    
    <?php echo $this->Form->create('Album');?>
	<fieldset>
    <div class="tabs">
			<ul>
				<li><a href="#album-basic"><span><?php echo __('Settings',true); ?></span></a></li>
				<li><a href="#album-images"><span><?php echo __('Images',true); ?></span></a></li>
				<?php echo $this->Layout->adminTabs(); ?>
			</ul>
			
			<div id="album-basic">
		        <?php
					echo $this->Form->input('id');
		            echo $this->Form->input('title',array('label' => __('Title', true)));
		            echo $this->Form->input('slug');
					echo $this->Form->input('description',array('label' => __('Description', true)));
					echo $this->Form->input('status');
		        ?>
		    </div>
		    
		    <div id="album-images">
		    	<?php echo $this->element('admin_node_edit', array('album' => $album) ); ?>
		    </div>
			<?php echo $this->Layout->adminTabs(); ?>
	</div>
	</fieldset>
	<?php echo $this->Form->end(__('Submit', true));?>
	
</div>