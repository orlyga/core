<div class="users index">
    <h2><?php echo $title_for_layout; ?></h2>

    <div class="actions">
        <ul>
            <li><?php echo $this->Html->link(__('New album', true), array('action'=>'add')); ?></li>
        </ul>
    </div>

    <table cellpadding="0" cellspacing="0">
    <?php
        $tableHeaders =  $this->Html->tableHeaders(array(
                                            $this->Paginator->sort('id'),
											//__('Order number', true),
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
</div>

<div class="paging"><?php echo $this->Paginator->numbers(); ?></div>
<div class="counter"><?php echo $this->Paginator->counter(array('format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true))); ?></div>