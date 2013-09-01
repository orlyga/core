<div id="contact-<?php echo $contact['Contact']['id']; ?>" class="">
	<h2><?php echo $contact['Contact']['title']; ?></h2>
	<div class="contact-body">
	<?php echo $contact['Contact']['body']; ?>
	</div>
<table style="color: #600b06; font-family: Arial, sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: normal; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; background-color: #d9c7ba;" border="0" width="100%">
<tbody>
<tr>
<td rowspan="2" align="right" valign="top"><br /></td>
</tr>
<tr>
<td>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tbody>
<tr>
<td rowspan="6" width="40" valign="top"><img src="http://www.etzhashani.co.il/images/M_images/house.png" alt="?????: " /></td>
</tr>
<tr>
<td valign="top">צור קשר</td>
</tr>
</tbody>
</table>
<br /> 
<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tbody>
<tr>
<td width="40"><img src="http://www.etzhashani.co.il/images/M_images/telephone.png" alt="?????: " /></td>
<td>?? 09-7493701</td>
</tr>
<tr>
<td width="40"><img src="http://www.etzhashani.co.il/images/M_images/con_fax.png" alt="???: " /></td>
<td>??? 09-7493361</td>
</tr>
<tr>
<td width="40"><br /></td>
<td><a style="color: #600b05;" href="http://www.facebook.com/etzhashani" target="_blank">http://www.facebook.com/etzhashani</a></td>
</tr>
</tbody>
</table>
<br /> 
<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tbody>
<tr>
<td width="40" valign="top"><img src="http://www.etzhashani.co.il/images/M_images/mobile_phone.png" alt="???? ????: " /></td>
<td>?????- 057-6584396<br /><br />???? - 057-7555617<br /><br />????: info@etzhashani.co.il</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<p><br class="Apple-interchange-newline" /><br class="Apple-interchange-newline" /></p>
	<?php if ($contact['Contact']['message_status']) { ?>
	<div class="contact-form">
	<?php
		echo $this->Form->create('Message', array(
			'url' => array(
				'controller' => 'contacts',
				'action' => 'view',
				$contact['Contact']['alias'],
			),
		));
		echo $this->Form->input('Message.name', array('label' => __('Name')));
		echo $this->Form->input('Message.email', array('label' => __('Email')));
		echo $this->Form->input('Message.phone', array('label' => __('Phone')));
		echo $this->Form->input('Message.title', array('label' => __('Subject')));
		echo $this->Form->input('Message.body', array('label' => __('Message')));
		if ($contact['Contact']['message_captcha']) {
			echo $this->Recaptcha->display_form();
		}
		echo $this->Form->end(__('Send'));
	?>
	</div>
	<?php } ?>
</div>