<?php
/**
 * Photos Controller
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
class PhotosController extends PhotonAppController {

	var $name = 'Photos';
var $components = array('AjaxMultiUpload.Upload');
		var $helpers = array(
		'Layout',
		'Html',
			'AjaxMultiUpload.Upload',
	);
	
	/*
	 * @description Shows an index overview for all photos in any album
	 */
	function beforeFilter() {
		$this->Security->csrfCheck=false;
		$this->Auth->allow('*');
		if($this->action<>"'admin_delete") $this->request->params['requested']=1;
	
		//if(!$this->RequestHandler->isAjax())
			parent::beforeFilter();
	}
	
	public function admin_index() {
	    $this->set('title_for_layout', __('Photos', true));

		$this->Photo->recursive = -1;
		$this->paginate = array('order' => 'weight ASC');
		$this->set('photos', $this->paginate('Photo'));
	}

	/*
	 * @description View a single photo
	 * @param int id
	 * @sets array photo, title_for_layout
	 */
	public function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid photo. Please try again.', true));
			$this->redirect(array('controller' => 'albums', 'action' => 'index'));
		}

		$photo = $this->Photo->find('first', array('conditions' => array('Photo.id' => $id)) );
		
		if (isset($this->params['requested'])) {
			return $photo;
		}

		if (!count($photo)) {
			$this->Session->setFlash(__('Invalid photo. Please try again.', true));
			$this->redirect(array('controller' => 'albums', 'action' => 'index'));
		}

		$this->set('title_for_layout',__("Photo", true) . $photo['Photo']['title']);
		$this->set(compact('photo'));
	}
	
	/*
	 * @description Update title and description of a photo, AJAX powered!
	 * @param int id, string title, string description
	 * @sets JSON
	 */
	public function admin_update() {
		if(!empty($this->request->data)){
			$this->Photo->create();
			$this->Photo->id=$this->request->data['id'];
			set_time_limit ( 360 ) ;
			$this->layout = 'ajax';
			$this->render(false);
			if($this->request->data['fld']=="large"){
				$this->request->data['Photo']=$this->request->data;
				$this->request->data['Photo']['large']=$this->request->data['val'];
				$ret=$this->Photo->save($this->request->data);
			}
			else{
				$this->Photo->beforesave=false;
				$ret=$this->Photo->saveField($this->request->data['fld'], $this->request->data['val']);
			}
			if ($ret) {
				echo json_encode(array('status' => 1)); exit();
			}
				
		}
	}
	private	function admin_complete_ajax($id,$slug){
		//Clearing the cache
		$db = ConnectionManager::getDataSource('default');
		@unlink(TMP . 'cache' . DS . 'models/cake_model_default_' . $db->config["database"] . '_list');
		@unlink(TMP . 'cache' . DS . 'models/cake_model_default_photos');
		@unlink(TMP . 'cache' . DS . 'models/cake_model_default_albums');
		if (isset($slug))
		@unlink(TMP . 'cache' . DS . 'views/element_'.$slug.'_photongallery');
		
		$db->sources(true);
		
		$result = $this->Photo->findById($id);

		echo json_encode($result);
		exit;
		$this->render('Photon/Albums/admin_edit');
		
	}
	public function admin_delete($id = null, $slug=null) {
		set_time_limit ( 360 ) ;
		$this->layout = 'ajax';
		$this->render(false);
		Configure::write('debug', 0);
		$this->Photo->create();
		$this->Photo->id = $id;
		$this->beforesave=false;
		if($this->Photo->delete($id))
				//admin_complete_ajax($id,$slug);
			$this->redirect(array('plugin'=>'photon','controller'=>'albums','action' => 'admin_edit','#'=>'album-images',$slug));
				
		else
			echo json_encode(array('status' => 0,  'msg' => __('Problem to remove photo. Please try again.', true))); exit();
	}
	public function admin_moveup($id, $step = 1,$album_id) {
		$this->Photo->create();
		$this->Photo->id = $id;
		$this->beforesave=false;
		if( $this->Photo->moveUp($id, $step) ) {
			$this->Session->setFlash(__('Moved up successfully', true), 'default', array('class' => 'success'));
		} else {
			$this->Session->setFlash(__('Could not move up', true), 'default', array('class' => 'error'));
		}
		$this->redirect(array('plugin'=>'photon','controller'=>'albums','action' => 'admin_edit','#'=>'album-images',$album_id));
			}
	
	public function admin_movedown($id, $step = 1,$album_id) {
		$this->Photo->create();
		$this->Photo->id = $id;
		$this->beforesave=false;
		if( $this->Photo->moveDown($id, $step,$album_id) ) {
			$this->Session->setFlash(__('Moved down successfully', true), 'default', array('class' => 'success'));
		} else {
			$this->Session->setFlash(__('Could not move down', true), 'default', array('class' => 'error'));
		}
		$this->redirect(array('plugin'=>'photon','controller'=>'albums','action' => 'admin_edit','#'=>'album-images',$album_id));
	}
	public function admin_upload_replace_photo ($albumid = null, $slug=null,$id=null) {
		set_time_limit ( 240 ) ;
		$this->layout = 'ajax';
		$this->render(false);
		Configure::write('debug', 0);
		
		$this->Photo->create();
		$this->Photo->id = $id;
		$this->request->data = $this->Photo->upload($this->request->data);
		$this->Photo->saveField('small', $this->request->data['Photo']['small']);
		$this->Photo->saveField('large', $this->request->data['Photo']['large']);
		
		$this->request->data = $this->Photo->upload($this->request->data);
		$result = $this->Photo->findById($this->Photo->id);
	if (isset($id)){
			if ($result) @unlink(TMP . 'cache' . DS . 'views/element_'.$slug.'_photongallery');
		}
		echo json_encode($result);
	}
	function admin_editlist($album_id){
		$this->layout='ajax';
		$this->Photo->recursive=-1;
		
		$this->paginate = array(
				'limit' => 20,
				'conditions'=>array('album_id'=>$album_id),
				'order' => 'Photo.weight Asc');
		$this->set('photos', $this->paginate());
		$this->set('album_id');
		$this->render('admin_editlist');
		
		
	}
	function admin_addlist($album_id){
		if(!empty($this->request->data)){
			$this->layout='ajax';
			if($this->Photo->saveAll($this->request->data['Photo'])){
				$this->admin_editlist($album_id);
				$this->Photo->recursive=-1;
				$this->paginate = array(
						'limit' => 20,
						'conditions'=>array('album_id'=>$album_id),
						'order' => 'Photo.weight Asc');
				$this->set('photos', $this->paginate());
				$this->set('album_id');
				$this->render('admin_editlist');
			}
		}
		else {
			$this->layout='ajax';
			$new_photos=$this->Upload->listing('Album',$album_id);
			$this->set(compact('new_photos','album_id'));
			$this->render('admin_addlist');
		}
	}
}
?>