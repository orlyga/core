<div id="menu-<?php echo $menu['Menu']['id']; ?>" class="menu">
<?php
	echo "<div id='try'></div>";
	echo $this->Layout->nestedLinks($menu['threaded'], $options);
?>
</div>