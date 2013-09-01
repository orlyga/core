<?php
/**
 * Albums Controller
 *
 * PHP version 5
 *
 * @category Controller
 * @package  Croogo
 * @version  1.3
 * @author   bumuckl <bumuckl@gmail.com> and Edinei L. Cipriani <phpedinei@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.bumuckl.com
 */
class AlbumsController extends PhotonAppController {
	var $menus_for_layout;
	var $name = 'Albums';
	var $albums=array();
	var $uses=array('Photon.Album','Link','Photon.Photo');
	var $components = array('AjaxMultiUpload.Upload');
	var $helpers = array(
		'Layout',
		'Html',
		'Photon.Gallery',
			'AjaxMultiUpload.Upload'
	);

	/*
	 * @description Index view for album administration
	 * @sets array albums
	 */
	function isAuthorized() {
		return true;
	}
	function beforeFilter() {
		$this->Security->csrfCheck=false;
		$this->Auth->allow(array('view','admin_delete','admin_edit','admin_upload_photo','upload_photo'));
		if(!$this->RequestHandler->isAjax())
			parent::beforeFilter();
		$this->menus_for_layout=$this->Croogo->menus($this);
	}
	
	function admin_index() {
		$this->set('title_for_layout', __('Albums', true));
		$this->Album->Link->create();
		$menu= $this->Album->Link->getTree('categories',array(
				'key' => 'id',
				'value' => 'title',
		));
		$this->Album->recursive = 0;
		$this->paginate = array(
				'limit' => Configure::read('Photon.album_limit_pagination'),
				'order' => 'Album.weight ASC');
		$this->set('albums', $this->paginate());
	}

	/*
	 * @description Adding a new new album to the database
	 */
	function admin_add() {
		if (!empty($this->request->data)) {
			$this->Album->create();
			if(empty($this->request->data['Album']['slug'])){
				$this->request->data['Album']['slug'] = strtolower(Inflector::slug($this->request->data['Album']['title'], '-'));
			}

			$this->Album->recursive = -1;
			$weight = $this->Album->find('all',array(
				'fields' => 'MAX(Album.weight) as weight'
			));

			$this->request->data['Album']['weight'] = $weight[0][0]['weight'] + 1;

			if ($this->Album->save($this->request->data)) {
				$this->Session->setFlash(__('Album is saved.', true));
				$menu=$this->Link->Menu->find('first',array("conditions"=>array('alias'=>"categories")));
				
				$data['Link']=$this->request->data['Album'];
				$data['Link']['menu_id']=$menu['Menu']['id'];
				$data['Link']['visibility_roles']="";
				$data['Link']['params']="";
				$data['Link']['target']="";
				$data['Link']['rel']="";
				$data['Link']['link']="/gallery/album/".$this->request->data['Album']['slug'];
				if(empty($data['Link']['parent_id']))
					$data['Link']['class']='categories-menu';
				else
					$data['Link']['class']='categories-submenu';
				$this->Link->create();
				$this->Link->set($data);
				$this->Link->save();
				$this->Album->saveField("link_id",$this->Link->getInsertID());
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Album could not be saved. Please try again.', true));
			}
		}
		
			$menu=$this->Link->Menu->find('first',array("conditions"=>array('alias'=>"categories")));
			$parentLinks = $this->Link->generateTreeList(array(
					'Link.menu_id' => $menu['Menu']['id'],
			));
			$this->set(compact('parentLinks'));
		

	}

	/*
	 * @description Edit an existing album
	 * @param int id
	 * @sets array album
	 */
	function admin_edit($id = null,$tab="",$slug="") {
		if($slug<>"") {
			$ret=$this->Album->find("first",array("conditions"=>array('Album.slug' => $slug)));
			$id=$ret['Album']['id'];
		}
		if (!$id) {
			$this->Session->setFlash(__('Invalid album.', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->Album->save($this->request->data)) {
				$menu=$this->Link->find('first',array("conditions"=>array('alias'=>"categories")));
				$data['Link']=$this->request->data['Album'];
				$data['Link']['id']=$this->request->data['Album']['link_id'];
				$data['Link']['link']="/gallery/album/".$this->request->data['Album']['slug'];
				$this->Link->create();
				$this->Link->set($data);
				$this->Link->save();
				$this->Session->setFlash(__('Album is saved.', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Album could not be saved. Please try again.', true));
			}
		}
		$menu=$this->Link->Menu->find('first',array("conditions"=>array('alias'=>"categories")));
		$parentLinks = $this->Link->generateTreeList(array(
				'Link.menu_id' => $menu['Menu']['id'],
		));
		//$term1=$this->Photo->Term->Taxonomy->getTree('term1');
		$this->set(compact('parentLinks'));
	   	$this->request->data = $this->Album->read(null, $id);
	   	$album = $this->Album->find('first', array('conditions' => array('Album.id' => $id), 'contain' => 'Photo'));
		$this->set('album', $album);
		if ($tab=="") $tab='album-basic';
		$this->set('tab');
	//	$this->set(compact('term1'));

	}

	/*
	 * @description Delete an existing album
	 * @param int id
	 */
	function admin_delete($id = null) {
		if (!$id) {
			
			$this->Session->setFlash(__('Invalid ID for album.', true));
			$this->redirect(array('action' => 'index'));
		} else {
			$ssluga = $this->Album->findById($id);
			$sslug = $ssluga['Album']['slug'];

			$dir  = WWW_ROOT . 'img' . DS . $sslug;
		}
		$this->Album->Link->id= $ssluga['Album']['link_id'];
		$this->Album->Link->delete($ssluga['Album']['link_id']);
		if ($this->Album->delete($id, true)) {
			$this->Session->setFlash(__('Album is deleted, and whole directory with images.', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->render(false);
	}
	
	public function admin_moveup($id, $step = 1) {
        if( $this->Album->moveUp($id, $step) ) {
            $this->Session->setFlash(__('Moved up successfully', true), 'default', array('class' => 'success'));
        } else {
            $this->Session->setFlash(__('Could not move up', true), 'default', array('class' => 'error'));
        }

        $this->redirect(array('action' => 'index'));
    }
    
    public function admin_movedown($id, $step = 1) {
        if( $this->Album->moveDown($id, $step) ) {
            $this->Session->setFlash(__('Moved down successfully', true), 'default', array('class' => 'success'));
        } else {
            $this->Session->setFlash(__('Could not move down', true), 'default', array('class' => 'error'));
        }

        $this->redirect(array('action' => 'index'));
    }

	/*
	 * @description Public index view, displaying all albums (accessible via yoururl.tld/gallery)
	 * @sets array albums
	 */
	public function index($action=null,$prm1=null) {
		if (!empty($action)){
		switch ($action){
			case "albumsgallery":
				return $this->albumsgallery($prm1)	;
		}
		}
		//pr($this->params);
		$this->set('title_for_layout',__("Albums", true));
		$this->getAlbums();
	}
	private function albumsgallery($gallery_id=null){
		$albums=$this->getAlbums();
		$this->set(compact('gallery_id','albums'));
		$this->render('albumsgallery');
	}
	private function getAlbums(){
		//We're gonna use this in order to hack the pagination a bit
		$customCount = $this->Album->find('count', array(
			'conditions' => array('Album.status' => 1),
			'fields' => 'DISTINCT Album.id',
			'joins'  => array(
		    	array(
		        	'table' => 'photos',
		        	'alias' => 'Photos',
		        	'type' => 'inner',
		        	'conditions' => array('Album.id = Photos.album_id'),
		    	'cache' => array(
                    'name' => 'albums',
                    'config' => 'albums_view',
                ),
		        )
		    ),
    	));

		$this->Album->recursive = -1;
		$this->Album->Behaviors->attach('Containable');
		$this->paginate = array(
				'conditions' => array('Album.status' => 1),
				'cache' => array(
                    'name' => 'album_photo',
                    'config' => 'albums_view'),
				'contain' => array('Photo'),
				'fields' => array('DISTINCT Album.id', 'Album.*'),
				'joins'  => array(
				    array(
				        'table' => 'photos',
				        'alias' => 'Photos',
				        'type' => 'inner',
				        'conditions' => array('Album.id = Photos.album_id'),
				        )
				    ),
				'limit' => Configure::read('Photon.album_limit_pagination'),
				'order' => 'Album.weight ASC',
				'customCount' => $customCount, //This is kind of a hacky part
		);
		
		$this->albums=$this->paginate();
		return $this->albums;
		
}


public function index_all() {
	
		 $this->getAlbums();
		return $this->Albums;
if (isset($this->params['requested'])) {
			return $this->Albums;
		}
	}
	/*
	 * @description View a single album
	 * @param sstring slug
	 * @sets array album, title_for_layout
	 */
	public function viewelement($slug=null){
		if (!$slug) {
			$this->Session->setFlash(__('Invalid album. Please try again.', true));
			$this->redirect(array('action' => 'index'));
		}
		return;
	}
	public function view($slug = null) {
		if (!$slug) {
			$this->Session->setFlash(__('Invalid album. Please try again.', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Album->Behaviors->attach('Containable');
		$album = $this->Album->find('first', array(
		'conditions' => array('Album.slug' => $slug),
		 'contain' => 'Photo',
		'cache' => array(
                    'name' => 'album_photo_'.$slug,
                    'config' => 'albums_view',
			),
		));

		if (isset($this->params['requested'])) {
			return $album;
		}

		if (!count($album)) {
			$this->Session->setFlash(__('Invalid album. Please try again.', true));
			$this->redirect(array('action' => 'index'));
		}

		$this->set('title_for_layout',__("Album", true) . $album['Album']['title']);
		$this->set(compact('album'));
	}


	/*
	 * @description Upload a photo, AJAX powered!
	 * @sets JSON
	 */
	public function admin_upload_photo($id = null) {
	
		set_time_limit ( 240 ) ;
		$this->layout = 'ajax';
		$this->render(false);
		Configure::write('debug', 0);

		$this->request->data['Photo']['album_id'] = $id;
		$this->Photo->create();
		$this->request->data = $this->Photo->upload($this->request->data);
		$this->Photo->save($this->request->data);
		$result = $this->Photo->findById($this->Photo->id);
	if (isset($id)){
			$ssluga = $this->Album->findById($id);
			$sslug = $ssluga['Album']['slug'];
			if ($result) @unlink(TMP . 'cache' . DS . 'views/element_'.$this->request->data['Album']['slug'].'_photongallery');
		}
		echo json_encode($result);

	}

	/*
	 * @description delete a photo, AJAX powered!
	 * @sets JSON
	 */
	public function admin_delete_photo($id = null) {
		$this->layout = 'ajax';
		$this->autoRender = false;

		if (!$id) {
			echo json_encode(array('status' => 0, 'msg' => __('Invalid photo. Please try again.', true))); exit();
		}

		if ($this->Photo->delete($id)) {
			echo json_encode(array('status' => 1)); exit();
		} else {
			echo json_encode(array('status' => 0,  'msg' => __('Problem to remove photo. Please try again.', true))); exit();
		}
	}
}
?>