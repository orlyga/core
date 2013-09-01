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
 App::uses('AppController', 'Controller');

class PhotosController extends PhotonAppController {

	var $name = 'Photos';
	var $uses=array('Photon.Album','Photon.Photo');
var $components = array('AjaxMultiUpload.Upload','RequestHandler','Email');
		var $helpers = array(
		'Layout',
		'Html',
			'AjaxMultiUpload.Upload','Js'
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
$this->Layout="Nodes/view_3";
$this->Photo->create();
$this->Photo->id=$id;
		$photo = $this->Photo->read();
		if (isset($this->params['requested'])) {
			$photo=$photo['Photo'];
			$this->set(compact('photo'));
			return $photo;
		}

		if (!count($photo)) {
			$this->Session->setFlash(__('Invalid photo. Please try again.', true));
			$this->redirect(array('controller' => 'albums', 'action' => 'index'));
		}

		$this->set('title_for_layout',__("Photo", true) . $photo['Photo']['title']);
		$photo=$photo['Photo'];
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
				$this->Photo->nophotoupdate=true;
				$ret=$this->Photo->saveField($this->request->data['fld'], $this->request->data['val']);
			}
			if ($ret) {
			$newImage="";
			   if(isset($ret['Photo']['large'])) $newImage=$ret['Photo']['large'];
				echo json_encode(array('status' => 1,"newImageName"=>$newImage)); exit();
			}
				
		}
	}
public function send_mail_tome($template="tome"){
		$this->Email->to      = Configure::read('Site.email');
		$this->Email->bcc      = array(Configure::read('Site.email'));
		$this->Email->subject = 'ask for quate';
		$this->Email->from    = Configure::read('Site.email');
		$this->Email->sendAs  = 'html'; 
		$this->Email->template="tome";
		if($this->Email->send()){
				echo __("Message Was Recieved");
				}
			
			else{
		      die("Message Was Not Recieved, Please try again");
		    }
		exit;
}
public function upload_img(){

$src=$this->request->data['src'];
$folder=$this->request->data['folder'];
$content = file_get_contents($src);
$filename_s=time();
$filename =  WWW_ROOT.'img/'.$folder.DS.$filename_s;
$fp = fopen($filename, "w");
fwrite($fp, $content);
fclose($fp);
 $im = new Imagick();
	 //if (!file_exists($src)) {echo $src; exit;}
	  $im->readImage($filename);

	  $d=$im->getImageGeometry();
$width=Configure::read ('Photon.AMUchangeTowidth');
	  $height=ceil($d['height']*$width/$d['width']);
	  $im->resizeImage($width,$height,imagick::FILTER_CATROM, 1);

	$im->setImageResolution(72,72);

	$im->writeImage($filename);

	$im->clear();
	$im->destroy();
	$this->layout = "ajax";
	echo json_encode(array('status' => 1,"filename"=>$filename_s)); exit();
}
public function upload_img_montage(){
		
	if (isset($this->request->data)){
		//pr($this->request->data);
		//exit;
		if(isset($this->request->data['Message'])){
	//	$this->Email->filePaths  = array($this->request->data['Message']['Image']);
		$file_image=basename($this->request->data['Message']['Image']);
       $this->Email->attachments =array(WWW_ROOT."img/files/Album/customers/".$file_image);
		$this->Email->to      = $this->request->data['Message']['email'];
		$this->Email->bcc      = array(Configure::read('Site.email'));
		$this->Email->subject = htmlspecialchars($this->request->data['Message']['title']);
		$this->Email->body = '<html><body><p>'."Quate will be sent later on".'<p></body></html>';
		$this->Email->from    = Configure::read('Site.email');
		$this->Email->sendAs  = 'html'; 
		$this->Email->template="ack_email";
		if ($this->request->data['Message']['quate1']==1) $this->Email->template="send_to_customer_w_quate";
		$this->Email->template="send_to_customer_no_quate";
		 if($this->Email->send()){
			$this->Email->subject = "to me";
			$this->Email->template="ack_email";
			if($this->request->data['Message']['quate1']==0){
				$this->request->data['Message']['width']=0;
				$this->request->data['Message']['height1']=0;
				$this->request->data['Message']['message']="no quate";
			}
			if (!isset($this->request->data['Message']['height1'])) 
				$this->request->data['Message']['height1']=$this->request->data['Message']['width']*$this->request->data['Message']['Ratio'];
				
			$this->request->data['Message']['body'] = '<html><body>'.
			"Width: ".$this->request->data['Message']['width']. "<br/>".
			"Height: ".$this->request->data['Message']['height1']. "<br/>".
			"Name: ".$this->request->data['Message']['name']. "<br/>".
			"Email: ".$this->request->data['Message']['email']. "<br/>".
			"Comments: ".$this->request->data['Message']['message']. "<br/>".
			"file: ".$this->request->data['Message']['Image']. "<br/>".'</body></html>';
			$this->Email->to      = Configure::read('Site.email');
			if($this->Email->send()){
				echo __("Message Was Recieved");
				}
			
			else{
		      die("Message Was Not Recieved, Please try again");
		    }
		}	
		else{
		      die("Message Was Not Recieved, Please try again");
		    } 		
			exit;
	}
}
		$upload_dir = WWW_ROOT."/img/files/Album/customers/";
		$img=$this->request->data['image'];

		$img = str_replace('data:image/png;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$data = base64_decode($img);
		$file = $upload_dir.time().".jpg";
		$success = file_put_contents($file, $data);
		$image = imagecreatefrompng($file);
		imagejpeg($image, $file, 70);
		imagedestroy($image);
		$this->layout = "ajax";
		$file=str_replace(WWW_ROOT."/","", $file);
		$photo=array();
		if(isset($this->request->data['photo_id'])){
			$this->Photo->create();
			$this->Photo->id=$this->request->data['photo_id'];
			$photo=$this->Photo->read();
		}
		$photo['file_name']=$file;
		echo json_encode($photo);
		//echo $file;
		exit;
		if ($this->RequestHandler->isAjax()){
					$this->layout = "ajax";
					
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
		$this->Photo->nophotoupdate=true;
		if($this->Photo->delete($id))
				//admin_complete_ajax($id,$slug);
			$this->redirect(array('plugin'=>'photon','controller'=>'albums','action' => 'admin_edit','#'=>'album-images',$slug));
				
		else
			echo json_encode(array('status' => 0,  'msg' => __('Problem to remove photo. Please try again.', true))); exit();
	}
	public function admin_moveup($id, $step = 1,$album_id) {
		$this->Photo->create();
		$this->Photo->id = $id;
		$this->Photo->nophotoupdate=true;
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
		$this->Photo->nophotoupdate=true;
		$ret=$this->Photo->moveDown($id, $step,$album_id);
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
	$this->Photo->create();
			$this->Photo->recursive=-1;
		$this->paginate = array(
				'limit' => 20,
				'conditions'=>array('Photo.album_id'=>$album_id),
				'order' => 'Photo.weight Asc');
	if (!empty($this->request->data)) {
		if (isset($this->request->data['Filter'])) {
			if (isset($this->request->data['Filter']['item_code'])){
				$this->paginate['Photo']['conditions']['item_code'] = $this->request->data['Filter']['item_code'];
				}
			}
			if (isset($this->request->data['Filter']['q'])){
				App::uses('Sanitize', 'Utility');
				$q = Sanitize::clean($this->request->data['Filter']['q']);
				$this->paginate['Photo']['conditions']['OR'] = array(
					'Photo.title LIKE' => '%' . $q . '%',
					'Photo.item_code LIKE' => '%' . $q . '%',
					);
			}
			$this->set('filters', $this->request->data['Filter']);
		}
		//$this->layout='ajax';
		$photos=$this->paginate('Photo');
		$this->set(compact('photos'));
		$this->set('album_id',$album_id);
		$this->render('admin_editlist');
		
		
	}
	function admin_addlist($album_id){
	if(!empty($this->request->data)){
			//pr($this->request->data);
			//exit;
			$this->layout='ajax';
			if($this->Photo->saveAll($this->request->data['Photo'])){
			
			        $this->redirect(array('plugin'=>"photon",'controller' => 'albums', 'action' => 'edit',$album_id,'#' => 'album-images'));

				//$this->admin_editlist($album_id);
				//$this->Photo->recursive=-1;
				//$this->paginate = array(
				//		'limit' => 20,
				//		'conditions'=>array('album_id'=>$album_id),
				//		'order' => 'Photo.weight Asc');
				//$this->set('photos', $this->paginate());
				//$this->set('album_id');
				//$this->render('admin_editlist');
			}
			else {
			echo "Problem accured";
			}
		}
		else {
			$this->layout='ajax';
			$new_photos=$this->Upload->listing('Album',$album_id);
			$this->set(compact('new_photos','album_id'));
			$this->render('admin_addlist');
		}
	}
	public function view_extra_thumbs($album_id){
	$this->Album->create(); 
	$this->Album->id=$album_id;
	$this->Album->Behaviors->attach('Containable');
		$album = $this->Album->find('first', array(
		'conditions' => array('Album.id' => $album_id),
		 'contain' => 'Photo',
		'cache' => array(
                    'name' => 'album_photo_'.$album_id,
                    'config' => 'albums_view',
			),
		));
	$this->layout='ajax';
	$this->set("album_id",$album_id);
	$this->set(compact('album',$album));
	$this->set('extra_thumbs','1');
	$this->render("view_extra_thumbs");
	}
}
?>