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
 
class UploadComponent extends Component {
	public function startup(Controller $controller) {
		$controller->set('UploadComponent', 'UploadComponent startup');
	}
	
	public function deleteAll ($model, $id) {
		require_once (ROOT . DS . APP_DIR . "/Plugin/AjaxMultiUpload/Config/bootstrap.php");
		$dir = Configure::read('AMU.directory');
		if (strlen($dir) < 1) $dir = "files";

		$lastDir = $this->last_dir ($model, $id);
		$dirPath = WWW_ROOT . DS . $dir . DS . $lastDir . DS;
		$files = glob($dirPath . '*', GLOB_MARK);
		foreach ($files as $file) {
			unlink($file);
		}
		if (is_dir($dirPath)) rmdir($dirPath);
	}

	// The "last mile" of the directory path for where the files get uploaded
	//orly added
	public function listing($model, $id){
		require_once (ROOT . DS . APP_DIR . "/Plugin/AjaxMultiUpload/Config/bootstrap.php");
		$dir = Configure::read('AMU.directory');
		if (strlen($dir) < 1) $dir = "files";
		$lastDir = $this->last_dir ($model, $id);
		$directory = WWW_ROOT . DS . $dir . DS . $lastDir;
		$baseUrl = str_replace("img/","",$dir) . "/" . $lastDir;
		$files = glob ("$directory/*");
		return array("baseUrl" => $baseUrl, "directory" => $directory, "files" => $files);
	}

	function last_dir ($model, $id) {
		return $model . "/" . $id;
	}
}
