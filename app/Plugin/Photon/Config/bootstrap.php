<?php
	Croogo::hookRoutes('Photon');
	$cacheConfig= array(
	'duration' => '+1000 hour',
	'path' => CACHE . 'queries',
	'engine' => 'File', 
);
	Cache::config('albums', $cacheConfig);
Cache::config('photos', $cacheConfig);
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
  	Croogo::hookComponent('Nodes', 'Photon.NodeAlbum');
    Croogo::hookHelper('Nodes', 'Photon.Gallery');
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
    'action' => 'prefix',
	'Photon',
	
    ),
    'weight' => 30,
    ));
    Configure::write('photon.vertical', false);

?>