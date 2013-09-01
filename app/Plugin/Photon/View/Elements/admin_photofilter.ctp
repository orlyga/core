<?php
	if (isset($this->params['named']['filter'])) {
		$this->Html->scriptBlock('var filter = 1;', array('inline' => false));
	}
?>
<div class="filter">
<?php
	echo $this->Form->create('Filter');
	$filterItemCode = '';
	if (isset($filters['item_code'])) {
		$filterType = $filters['item_code'];
	}
	echo $this->Form->input('item_code', array(
		'value' => $filterItemCode,
	));
	$filterSearch = '';
	if (isset($this->params['named']['q'])) {
		$filterSearch = $this->params['named']['q'];
	}
	echo $this->Form->input('Filter.q', array(
		'label' => __('Search'),
		'value' => $filterSearch,
	));
	echo $this->Form->end(__('Filter'));
?>
	<div class="clear">&nbsp;</div>
</div>