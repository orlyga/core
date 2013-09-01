<?php

/**
 * Ecart Controller
 *
 * PHP version 5
 *
 * @category Controller
 * @package  Croogo
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
class EcartsController extends AppController {

/**
 * Controller name
 *
 * @var string
 * @access public
 */
	public $name = 'Ecart';

/**
 * Models used by the Controller
 *
 * @var array
 * @access public
 */
	public $uses = array('Setting');

/**
 * admin_index
 *
 * @return void
 */
 function beforeFilter() {
		$this->Security->csrfCheck=false;
		$this->Auth->allow('*');
		if($this->action<>"'admin_delete") $this->request->params['requested']=1;
	
		//if(!$this->RequestHandler->isAjax())
			parent::beforeFilter();
	}
	public function admin_index() {
		$this->set('title_for_layout', __('Ecart'));
	}

/**
 * index
 *
 * @return void
 */
	public function index() {
		$this->set('title_for_layout', __('Ecart'));
		$this->set('ecartVariable', 'value here');
	}
	function view() {
		$this->set('title_for_layout', __('Ecart'));
		$this->render("view");
	
	}
	function complete() {
	if (isset($this->request->data['text'])){

	$this->Session->write("cartInfo",$this->request->data['text']);
	$this->layout="ajax";
	
	}
	}

}
