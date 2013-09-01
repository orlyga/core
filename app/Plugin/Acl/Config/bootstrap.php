<?php

if (Configure::read('Site.acl_plugin') == 'Acl') {

	// activate AclFilter component only until after a succesful install
//orly updated multisite
	//if (file_exists(APP . 'Config' . DS . 'settings.yml')) {
	if (file_exists(WWW_ROOT . 'Config' . DS . 'settings.yml')) {
	Croogo::hookComponent('*', 'Acl.AclFilter');
		Croogo::hookComponent('*', array(
			'CroogoAccess' => array(
				'className' => 'Acl.AclAccess',
				),
			));
	}

	Croogo::hookBehavior('User', 'Acl.UserAro');
	Croogo::hookBehavior('Role', 'Acl.RoleAro');

	CroogoNav::add('users.children.permissions', array(
		'title' => __('Permissions'),
		'url' => array(
			'admin' => true,
			'plugin' => 'acl',
			'controller' => 'acl_permissions',
			'action' => 'index',
			),
		'weight' => 30,
		));

}
