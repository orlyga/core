<?php

App::uses('Component', 'Controller');

class NodeAlbumComponent extends Object {

	var $controller = false;
	
	
	public function beforeRender(Controller $controller) {
	}
	
	/**
	 * Called after Controller::render() and before the output is printed to the browser.
	 *
	 * @param object $controller Controller with components to shutdown
	 * @return void
	 */
	public function shutdown(Controller $controller) {
	}
	public function beforeRedirect(Controller $controller) {
	}
	public function initialize(Controller $controller) {
		
	}
	
	public function startup(Controller $controller) {
	
		$controller->set('nodeAlbumComponent', 'NodeAlbumComponent startup');
		if (isset($controller->params['pass'][0]) && $controller->action == 'admin_edit') {
			//This ain't best practice ;)
			//But the behavior stuff was jsut too much struggling, so I decided to make the album creation logic righ here
			//absolutely provisory ;)
			$album_model = ClassRegistry::init('Photon.Album');
			$node_model = ClassRegistry::init('Node');
		
			//If no album for this node is existing yet, create it
			$nodeid = $controller->params['pass'][0];
			$does_album_exist = $album_model->find('first', array(
				'conditions' => array(
					'node_id' => $nodeid,
				),
			));
			if (empty($does_album_exist)) {
				$nodedata = $node_model->find('first', array(
					'conditions' => array(
						'Node.id' => $nodeid,
					),
				));
				$album_model->create( array(
					'title' => $nodedata['Node']['title'],
					'slug' => $nodedata['Node']['slug'],
					'node_id' => $nodeid,
					'status' => 1,
				));
				$album_model->save();
			}
	
			//Let's fetch the related album to this node
			$album = $album_model->find('first', array(
				'conditions' => array(
					'node_id' => $controller->params['pass'][0]
				),
			));
	
			$controller->set('album', $album);
		
		}
		
	}

}