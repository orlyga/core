<?php
	$url = Router::url(array(
		'controller' => 'contacts',
		'action' => 'view',
		$contact['Contact']['alias'],
	), true);
	echo '<div style="direction:rtl">';
	//echo __('You have received a new message at:'). $url . "<br/> <br/>";
	echo __('Name').':'. $message['Message']['name'] . "<br/>";
	echo __('Email').':<a href="mailto:'.$message['Message']['email'].'?Subject='.__('Response From:').Configure::read('Site.title').'">'.$message['Message']['email'] . '</a><br/>';
	echo __('Phone').':'.$message['Message']['phone'] . "<br/>";
	echo __('Subject').':<span style="font-size:130%">'.$message['Message']['title'] . "</span><br/>";
	echo __('Message').':'.$message['Message']['body'] . "<br/>";
	echo '</div>';
?>