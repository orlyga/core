<?php
	$url = Router::url(array(
		'controller' => 'contacts',
		'action' => 'view',
		$contact['Contact']['alias'],
	), true);
	echo __('You have received a new message at:'). $url . "<br/> <br/>";
	echo __('Name').':'. $message['Message']['name'] . "<br/>";
	echo __('Email').':'.$message['Message']['email'] . "<br/>";
	echo __('Subject').':'.$message['Message']['title'] . "<br/>";
	echo __('IP Address').':'.$_SERVER['REMOTE_ADDR'] . "<br/>";
	echo __('Message').':'.$message['Message']['body'] . "<br/>";
?>