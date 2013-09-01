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