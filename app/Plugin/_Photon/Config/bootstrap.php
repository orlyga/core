<?php
/**
 * Routes
 */
	Croogo::hookRoutes('Photon');
	
/**
 * Behavior
 */
   	Croogo::hookBehavior('Node', 'Photon.RelatedAlbum', array(
	'relationship' => array(
		'hasOne' => array(
			'Album' => array(
				'className' => 'Photon.Album',
				'foreignKey' => 'node_id',
				),
			),
		),
	));
/**
 * Component
 */
	Croogo::hookComponent('Nodes', 'Photon.NodeAlbum');
/**
 * Helper
 */
    Croogo::hookHelper('Nodes', 'Photon.Gallery');
/**
 * Admin menu (navigation)
 *
 * This plugin's admin_menu element will be rendered in admin panel under Extensions menu.
 */
    CroogoNav::add('photon', array(
    'title' => __('Gallery'),
    'url' => array(
    'admin' => true,
    'plugin' => 'photon',
    'controller' => 'albums',
    'action' => 'index',
    ),
    'weight' => 30,
    ));
    CroogoNav::add('settings.children.photon', array(
    'title' => __('Gallery'),
    'url' => array(
    'admin' => true,
    'controller' => 'settings',
    'action' => 'prefix', 'Photon'
        ),
    'weight' => 30,
    ));
    Configure::write('photon.vertical', false);
    
    /*
    CroogoNav::add('extensions.children.photon', array(
    'title' => __('Gallery'),
    'url' => '#',
    'children' => array(
    'Category' => array(
    'title' => __('Category'),
    'url' => '#',
    ),
    'Photos' => array(
    'title' => __('Photos'),
    'url' => '#',
    ),
    ),
    ));
    Croogo::hookAdminRowAction('Nodes/admin_index', 'Gallery', 'plugin:photon/controller:album/action:index/:id');
    
   

 * Admin tab
 
 	Croogo::hookAdminTab('Nodes/admin_add', 'Images', 'photon.admin_node_add');
	Croogo::hookAdminTab('Nodes/admin_edit', 'Images', 'photon.admin_node_edit');
*/
?>

