<?php
/**
 *
 * Dual-licensed under the GNU GPL v3 and the MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2012, Suman (srs81 @ GitHub)
 * @package       plugin
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 *                and/or GNU GPL v3 (http://www.gnu.org/copyleft/gpl.html)
 */
 App::uses('AppController', 'Controller');

class UploadsController extends AjaxMultiUploadAppController {

	public $name = "Upload";
	var $components=array("Photon.NodeAlbum");
	// list of valid extensions, ex. array("jpeg", "xml", "bmp")
	var $allowedExtensions = array();
	function isAuthorized() {
		return true;
	}
	
	function beforeFilter() {
		$this->Auth->allow(array('upload','delete'));
	}
	function upload($dir=null) {
		
       	require_once (ROOT . DS . APP_DIR . "/Plugin/AjaxMultiUpload/Config/bootstrap.php");
		// max file size in bytes
		$size = Configure::read ('AMU.filesizeMB');
		ini_set('max_execution_time', 300);
		if (strlen($size) < 1) $size = 4;
		$relPath = Configure::read ('AMU.directory');
		if (strlen($relPath) < 1) $relPath = "files";

		$sizeLimit = $size * 1024 * 1024;
                $this->layout = "ajax";
	        Configure::write('debug', 0);
		$directory = WWW_ROOT . DS . $relPath;
		 
		if ($dir === null) {
			$this->set("result", "{\"error\":\"Upload controller was passed a null value.\"}");
			return;
		}
		// Replace underscores delimiter with slash
		$dir = str_replace ("___", "/", $dir);
		$dir_file=$dir;
		$dir = $directory . DS . "$dir/";
		if (!file_exists($dir)) {
			mkdir($dir, 0777, true);
		}
		$uploader = new qqFileUploader($this->allowedExtensions, 
			$sizeLimit);
		$result = $uploader->handleUpload($dir);
		if ((isset($result['filename']))&&(Configure::read ('Photon.AMUchangeTowidth')>0)) {
					$this->_resize( $result['filename'],null,Configure::read ('Photon.AMUchangeTowidth'));
		}
		//$this->NodeAlbum->addMultiPhotos($dir);
		$this->set("result", htmlspecialchars(json_encode($result), ENT_NOQUOTES,'utf-8'));
		//$this->set("result");
	}
 private function _resize($src,$scale=null,$width=null,$height=null) {
     if ($scale == 1) return;
	  $im = new Imagick();
	 //if (!file_exists($src)) {echo $src; exit;}
	  $im->readImage($src);

	  $d=$im->getImageGeometry();

	  if ($scale<>null){
      $width = ceil($d['width'] * $scale);
      $height =ceil($d['height']* $scale);
	  }
	  if ($width<>null)
	  $height=ceil($d['height']*$width/$d['width']);
	  $im->resizeImage($width,$height,imagick::FILTER_CATROM, 1);

	$im->setImageResolution(72,72);

	$im->writeImage($src);

	$im->clear();
	$im->destroy();
  
   }
	/**
	 *
	 * delete a file
	 *
	 * Thanks to traedamatic @ github
	 */
	public function delete($file = null) {
		if(is_null($file)) {
			$this->Session->setFlash(__('File parameter is missing'));
			$this->redirect($this->referer());
		}
		$file = base64_decode($file);
		if(file_exists($file)) {
			if(unlink($file)) {
				$this->Session->setFlash(__('File deleted!'));				
			} else {
				$this->Session->setFlash(__('Unable to delete File'));					
			}
		} else {
			$this->Session->setFlash(__('File does not exist!'));					
		}
		
		$this->redirect($this->referer());	
	}
}

?>
