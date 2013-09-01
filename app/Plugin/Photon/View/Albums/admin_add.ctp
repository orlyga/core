<div class="users form">
    <h2><?php __d('photon','Add album'); ?></h2>
    <?php echo $this->Form->create('Album',array("accept-charset"=>"UTF-8"));?>
        <fieldset>
        <?php
        echo $this->Form->input('parent_id', array(
						'label' => __('Category'),
						'options' => $parentLinks,
						'empty' => true,
					));
            echo $this->Form->input('title',array('label' => __('Title', true)));
			echo $this->Form->input('description',array('label' => __('Description', true)));
			echo $this->Form->input('status',array('value'=>'1','checked'=>true));
			echo $this->Form->input('seo_title',array('label' => 'SEO '.__('Title', true));
			echo $this->Form->input('seo_desc',array('label' => 'SEO '.__('Description', true)));
			echo $this->Form->input('seo_keywords',array('label' => 'SEO '.__('Key Words', true))););
			
        ?>
        </fieldset>
    <?php echo $this->Form->end('Submit');?>
</div>