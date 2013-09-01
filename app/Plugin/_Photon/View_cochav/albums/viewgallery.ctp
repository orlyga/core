<header>
    <hgroup>
        <h1><?php __( 'Album',true);?>: <?php echo $album['Album']['title']; ?></h1>
        <h3><?php echo $album['Album']['description']; ?></h3>
    </hgroup>
</header>
<?php echo $this->element('gallery'); ?>
<footer>
	<nav id="pagination"><?php echo $html->link(__('Back', true), '/gallery'); ?></nav>
</footer>

<?php
	$counter = 0; //We need a counter in order to set up popeye properly
?>
	
	<?php if(count($albums) == 0): 
		echo '<article><p class="notification">';
        __d('No albums found.',true);
		echo '</p></article>';
	else: ?>
		<div class="albums">
			<ul class="album_tab">
		<?php foreach($albums as $album): ?>
				<?php //if (!empty($album['Photo'][0]['small'])) : ?>
				<li><a href="#"><?php echo $album['Album']['title']; ?></a></li>
						
		<?php endforeach; ?>
		
		</div> 
	<?php endif; ?>	
	


              