<style>
ul li ul {margin-left:20px;}
ul li ul li ul {margin-left:20px;}
ul li ul li ul li ul {margin-left:20px;}
ul li ul li ul li ul li ul {margin-left:20px;}
ul li ul li ul li ul li ul li ul{margin-left:20px;}
.categories-menu {font-weight:bold}
#menu-categories {display:inline;overflow: scroll;
height: 100%;}
#main #content {
     height: 1000px;
   }
</style>
<script>
$("body").delegate('#menu-categories a','click', function(e) {
			e.preventDefault();
			var h=$(this).attr("href");
			/*orly might be a problem for orlyreznik*/
			h=h.replace("gallery/album/","edit/");
			document.location=h;
			return false;
		});

	</script>
<div class="users index">
    <h2><?php echo $title_for_layout; ?></h2>

    <div class="actions">
        <ul>
            <li><?php echo $this->Html->link(__('New album'), array('action'=>'add')); ?></li>
        </ul>
    </div>
  </div>
<div class="clear"></div>
<div style="position:relative;height:400px">
<div id="menu-categories" class="grid_3">
	<?php echo $this->Layout->blocks("category-menu");
	
 echo $this->Custom->menu("categories")?>
</div>
<div class="grid_10">
    <table cellpadding="0" cellspacing="0">
    <?php
        $tableHeaders =  $this->Html->tableHeaders(array(
                                            $this->Paginator->sort('id'),
											//__d('photon','Order number', true),
                                            __('Title', true),
											$this->Paginator->sort('status'),                                            
                                              __('Actions', true),
                                             ));
        echo $tableHeaders;

        $rows = array();
        foreach ($albums as $album) {
           	$actions = $this->Html->link(__('Photos in album', true), array('controller' => 'albums', 'action' => 'edit', $album['Album']['id'], '#album-images'));

			$actions .= ' ' . $this->Html->link(__('Move up', true), array('controller' => 'albums', 'action' => 'moveup', $album['Album']['id']));
            $actions .= ' ' . $this->Html->link(__('Move down', true), array('controller' => 'albums', 'action' => 'movedown', $album['Album']['id']));

			$actions .= ' ' . $this->Layout->adminRowActions($album['Album']['id']);
            $actions .= ' ' . $this->Html->link(__('Edit', true), array('controller' => 'albums', 'action' => 'edit', $album['Album']['id']) );
            $actions .= ' ' . $this->Html->link(__('Delete', true), array('controller' => 'albums', 'action' => 'delete', $album['Album']['id']), null, __('Are you sure you want to delete this album?', true));

            $rows[] = array(
                        $album['Album']['id'],
						//$album['Album']['position'],
                        $album['Album']['title'],
					    $this->Layout->status($album['Album']['status']),
                       $actions,
                      );
        }

        echo $this->Html->tableCells($rows);
        echo $tableHeaders;
    ?>
    </table>


<?php if ($pagingBlock = $this->fetch('paging')): ?>
	<?php echo $pagingBlock; ?>
<?php else: ?>
	<?php if (isset($this->Paginator) && isset($this->request['paging'])): ?>
		<div class="paging">
			<?php echo $this->Paginator->first('< ' . __('first')); ?>
			<?php echo $this->Paginator->prev('< ' . __('prev')); ?>
			<?php echo $this->Paginator->numbers(); ?>
			<?php echo $this->Paginator->next(__('next') . ' >'); ?>
			<?php echo $this->Paginator->last(__('last') . ' >'); ?>
		</div>
		<div class="counter"><?php echo $this->Paginator->counter(array('format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%'))); ?></div>
	<?php endif; ?>
<?php endif; ?>
</div>
</div>