<?php echo $this->Layout->nodeList("news",array('element'=>'node_excerpt_list'));?>
<div id="node-list-" class="node-excerpt-list" style="margin-top:-20px">
	<ul>
	<?php
	function set_excerpt($nd){
				echo '<li>';
				//echo '<h6>'.$nd['Node']['title'].'</h6>';
				//echo '<p>'.$nd['Node']['excerpt'].'</p>';
				echo $this->Html->link('xx', array(
					//'plugin' => $options['plugin'],
					//'controller' => $options['controller'],
					//'action' => $options['action'],
					'type' => $nd['Node']['type'],
					//'slug' => $nd['Node']['slug'],
				));
			//	echo '</li>';
}
	if (isset($nodesList['children']) ){
		$ar1=$nodesList['children'];
		unset($nodesList['children']);
		$nodesList=array_merge($nodesList,$ar1);
	}
		foreach ($nodesList AS $n) {
			if(!isset($n['Node'])) $n['Node']=$n;
			echo '<li>';
			echo '<h6>'.$n['Node']['title'].'</h6>';
		    echo '<p>'.$n['Node']['excerpt'].'</p>';
			if ($n['Node']['body']<>"")
			echo $this->Html->link(__("read more..."), array(
					'plugin' => $options['plugin'],
					'controller' => $options['controller'],
					'action' => $options['action'],
					'type' => $n['Node']['type'],
					'slug' => $n['Node']['slug'],
				));
			echo '</li>';
			//echo $this->Html->link('xx');
		}
	?>
	</ul>
</div>