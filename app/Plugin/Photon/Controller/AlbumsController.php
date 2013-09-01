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
 App::uses('AppController', 'Controller');

class AlbumsController extends PhotonAppController {
	public $cacheAction = array(
			'view' => 360000,
			'index'  => 480000,
			'index_all'  => 480000
	);
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
		$this->Auth->allow(array('getAlbumInfo','view','admin_delete','admin_edit','admin_upload_photo','upload_photo','design'));
		if(!$this->RequestHandler->isAjax())
			parent::beforeFilter();

		$this->menus_for_layout=$this->Croogo->getmenu('categories',$this);
		//pr($this->menus_for_layout);
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
				$result = $this->Album->find('all', array
						('fields' =>  array('MAX(Album.id) as max_id'),
						'recursive' =>  -1, ));
			}
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
				$menu=$this->Link->Menu->find('first',array("conditions"=>array('Menu.alias'=>"categories")));
				$this->Album->id=$this->Album->getInsertID();
				$this->Album->saveField("slug",$this->Album->id);
				$this->request->data['Album']['slug']=$this->Album->id;
				$data['Link']=$this->request->data['Album'];
				$data['Link']['menu_id']=$menu['Menu']['id'];
				$data['Link']['visibility_roles']="";
				$data['Link']['params']="";
				$data['Link']['target']="";
				$data['Link']['rel']="";
				//v2 might be a problem for orlyreznik, which add / before gallery
				$data['Link']['link']="gallery/album/".$this->request->data['Album']['slug'];
				if(empty($data['Link']['parent_id']))
				{
					$data['Link']['class']='categories-menu';
						$link=$this->Link->find('first',array("conditions"=>array('params'=>"special_menu=gallery")));
						//changed v2
						if($link) {
								$data2['Link'][0]=$data['Link'];
								$data2['Link'][1]=$data['Link'];
								$data2['Link'][1]['parent_id']=$link['Link']['id'];
								$data2['Link'][1]['menu_id']=$link['Link']['menu_id'];
								$data2['Link'][1]['slug']=$link['Link']['menu_id']."_";
								$data2['Link'][1]['class']="";
								$data=$data2['Link'];
								
						}
					}
				else
					$data['Link']['class']='categories-submenu';
				$this->Link->create();
				$this->Link->set($data);
				//change v2
					$this->Link->saveMany($data);
				
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
				//$this->Link->create();
				//$this->Link->id=$this->request->data['Album']['link_id'];
				//$this->Link->saveField("title",$this->request->data['Album']['title']);
				// change v2 link is now serves for category tree and to show categories in main menu, therefore, several links are connected to one album				
				$lks=$this->_setLink($this->request->data['Album']['id']);	
				foreach($lks as $key => $lk) {
    				$this->Link->id = $lk['Link']['id'];
    				$this->Link->saveField('title', $this->request->data['Album']['title']);
				}
				
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
			$this->Album->recursive=1;
			$ssluga = $this->Album->findById($id);
			$sslug = $ssluga['Album']['slug'];

			$dir  = WWW_ROOT . 'img' . DS . $sslug;
		}
		$link=$ssluga['Link']['link'];
		$this->Album->Link->deleteAll(array('Link.link'=>$link));
		if ($this->Album->delete($id, true)) {
			$this->Session->setFlash(__('Album is deleted, and whole directory with images.', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->render(false);
	}
public function admin_moveup($id, $step = 1) {
	    if( $this->Album->moveUp($id, $step) ) {
			$lks=$this->_setLink($id);
			foreach($lks as $key => $lk) {
					if( $this->Album->Link->moveUp($lk['Link']['id'], $step) ) {
						$this->Session->setFlash(__('Moved up successfully', true), 'default', array('class' => 'success'));
					}
        	} 
		}
        else {
            $this->Session->setFlash(__('Could not move up', true), 'default', array('class' => 'error'));
        }
			

        $this->redirect(array('action' => 'index'));
    }
    
    public function admin_movedown($id, $step = 1) {
        if( $this->Album->moveDown($id, $step) ) {
			$lks=$this->_setLink($id);
			foreach($lks as $key => $lk) {
				if( $this->Album->Link->moveDown($lk['Link']['id'], $step) ) {
						$this->Session->setFlash(__('Moved up successfully', true), 'default', array('class' => 'success'));
					}
			}
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
	public function albumsgallery($gallery_id=null){
	
		$albums=$this->getAlbums();
		$this->set(compact('gallery_id','albums'));
		$this->render('albumsgallery');
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
	private function _setLink($id){
			$this->Link->create();
		$link=$this->Album->read('link_id',$id);
		$link=$this->Link->read('link',$link['Album']['link_id']);
		$lks=$this->Link->find('all',array('conditions'=>array('link'=>$link['Link']['link'])));
		return $lks;
		
}
public function design($slug = null) {
	
	if ($this->request->data){
		$upload_dir = WWW_ROOT."/img/files/Album/customers/";
		
$img = $this->request->data['Album']['Image'];
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);

$file = $upload_dir."image_name.png";
$success = file_put_contents($file, $data);
if ($this->RequestHandler->isAjax()){
			$this->layout = "ajax";
			return $file;
		}
	}
		$this->Photo->create();
		$Photos=$this->Photo->photo_list();
		$this->set(compact('Photos'));
$this->render("design");	}


public function addtocart($item_id,$item_type) {
		if(empty($item_type)) $item_type="photos";
		if($item_type=="photos"){
			$this->Photo->create();
			$this->Photo->id=$item_id;
			$item_info=$this->Photo->read();
		}
	$mail_status="new";
		$this->set(compact("item_info","mail_status"));
}
public function getAlbumInfo($album_id) {
$this->Album->recursive=-1;
		return $this->Album->read(null,$album_id);
		
}
}
?>