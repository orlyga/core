<?php
	echo '<div style="direction:rtl">';
	//echo __('You have received a new message at:'). $url . "<br/> <br/>";
	echo __('Photo').': http://'.$_SERVER['SERVER_NAME']. $this->request->data['Message']['image'] . "<br/>";
		echo __('Name').':'. $this->request->data['Message']['name'] . "<br/>";

	echo __('Email').':<a href="mailto:'.$this->request->data['Message']['email'].'?Subject='.__('Response From:').Configure::read('Site.title').'">'.$this->request->data['Message']['email'] . '</a><br/>';
	echo __('Phone').':'.$this->request->data['Message']['phone'] . "<br/>";
	echo __('Width').':'.$this->request->data['Message']['width'] . "<br/>";
	if (isset($this->request->data['Message']['height']))
	echo __('Height').':'.$this->request->data['Message']['height'] . "<br/>";
	echo __('Subject').':<span style="font-size:130%">'.$this->request->data['Message']['title'] . "</span><br/>";
	echo __('Message').':'.$this->request->data['Message']['message'] . "<br/>";
	echo '</div>';
?>