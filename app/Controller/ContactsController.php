<?php

App::uses('AppController', 'Controller');

/**
 * Contacts Controller
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
class ContactsController extends AppController {

/**
 * Controller name
 *
 * @var string
 * @access public
 */
	public $name = 'Contacts';

/**
 * Components
 *
 * @var array
 * @access public
 */
	public $components = array(
		'Akismet',
		'Email',
		'Recaptcha',
	);

/**
 * Models used by the Controller
 *
 * @var array
 * @access public
 */
	public $uses = array('Contact');

/**
 * Admin index
 *
 * @return void
 * @access public
 */
 function beforeFilter() {
		$this->Security->csrfCheck=false;
		$this->Auth->allow('*');
			parent::beforeFilter();
	}
	public function admin_index() {
		$this->set('title_for_layout', __('Contacts'));

		$this->Contact->recursive = 0;
		$this->paginate['Contact']['order'] = 'Contact.title ASC';
		$this->set('contacts', $this->paginate());
		$this->set('displayFields', $this->Contact->displayFields());
	}

/**
 * Admin add
 *
 * @return void
 * @access public
 */
	public function admin_add() {
		$this->set('title_for_layout', __('Add Contact'));

		if (!empty($this->request->data)) {
			$this->Contact->create();
			if ($this->Contact->save($this->request->data)) {
				$this->Session->setFlash(__('The Contact has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Contact could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		}
	}

/**
 * Admin edit
 *
 * @param integer $id
 * @return void
 * @access public
 */
	public function admin_edit($id = null) {
		$this->set('title_for_layout', __('Edit Contact'));

		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid Contact'), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->Contact->save($this->request->data)) {
				$this->Session->setFlash(__('The Contact has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Contact could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Contact->read(null, $id);
		}
	}

/**
 * Admin delete
 *
 * @param integer $id
 * @return void
 * @access public
 */
	public function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Contact'), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->Contact->delete($id)) {
			$this->Session->setFlash(__('Contact deleted'), 'default', array('class' => 'success'));
			$this->redirect(array('action' => 'index'));
		}
	}

/**
 * View
 *
 * @param string $alias
 * @return void
 * @access public
 */
	public function view($alias = null) {
		if (!$alias) {
			$this->redirect('/');
		}
		$mail_status="intitial";
		$contact = $this->Contact->find('first', array(
			'conditions' => array(
				'Contact.alias' => $alias,
				'Contact.status' => 1,
			),
			'cache' => array(
				'name' => 'contact_' . $alias,
				'config' => 'contacts_view',
			),
		));
		if (!isset($contact['Contact']['id'])) {
			$this->redirect('/');
		}
		$this->set('contact', $contact);

		$continue = true;
		if (!$contact['Contact']['message_status']) {
			$continue = false;
		}
		if (!empty($this->request->data) && $continue === true) {
			$mail_status="error";
			if((!isset($this->request->data['Message']['body']))||($this->request->data['Message']['body']=="")){
			$this->request->data['Message']['body']=__("Empty");
			
			}
			$body =  $this->request->data['Message']['body'];
			$body=str_replace('a href="','a href="'.$_SERVER['HTTP_HOST']."/",$this->request->data['Message']['body']);
			$body=str_replace('src="','src="http://'.$_SERVER['HTTP_HOST']."/",$body);
			$this->request->data['Message']['contact_id'] = $contact['Contact']['id'];
			$this->request->data['Message']['title'] = htmlspecialchars($this->request->data['Message']['title']);
			$this->request->data['Message']['name'] = htmlspecialchars($this->request->data['Message']['name']);
			$this->request->data['Message']['body'] = '<html><body>'.$body.'</body></html>';
			$this->request->data['Message']['phone'] = htmlspecialchars($this->request->data['Message']['phone']);

			$continue = $this->_validation($continue, $contact);
			$continue = $this->_spam_protection($continue, $contact);
			$continue = $this->_captcha($continue, $contact);
			$continue = $this->_send_email($continue, $contact);

			if ($continue === true) {
				//$this->Session->setFlash(__('Your message has been received.'));
				//unset($this->request->data['Message']);
				$mail_status="sent";
				$this->set(compact('mail_status'));
				//echo $this->flash(__('Your message has been received...'), '/');
				$this->render("view");
			}
		}
		$this->set('title_for_layout', $contact['Contact']['title']);
		$this->set(compact('continue','mail_status'));
		$this->render("view");
	}

/**
 * Validation
 *
 * @param boolean $continue
 * @param array $contact
 * @return boolean
 * @access protected
 */
	protected function _validation($continue, $contact) {
		if ($this->Contact->Message->set($this->request->data) &&
			$this->Contact->Message->validates() &&
			$continue === true) {
			if ($contact['Contact']['message_archive'] &&
				!$this->Contact->Message->save($this->request->data['Message'])) {
				$continue = false;
			}
		} else {
			$continue = false;
		}

		return $continue;
	}

/**
 * Spam protection
 *
 * @param boolean $continue
 * @param array $contact
 * @return boolean
 * @access protected
 */
	protected function _spam_protection($continue, $contact) {
		if (!empty($this->request->data) &&
			$contact['Contact']['message_spam_protection'] &&
			$continue === true) {
			$this->Akismet->setCommentAuthor($this->request->data['Message']['name']);
			$this->Akismet->setCommentAuthorEmail($this->request->data['Message']['email']);
			$this->Akismet->setCommentContent($this->request->data['Message']['body']);
			if ($this->Akismet->isCommentSpam()) {
				$continue = false;
				$this->Session->setFlash(__('Sorry, the message appears to be spam.'), 'default', array('class' => 'error'));
			}
		}

		return $continue;
	}

/**
 * Captcha
 *
 * @param boolean $continue
 * @param array $contact
 * @return boolean
 * @access protected
 */
	protected function _captcha($continue, $contact) {
		if (!empty($this->request->data) &&
			$contact['Contact']['message_captcha'] &&
			$continue === true &&
			!$this->Recaptcha->valid($this->request)) {
			$continue = false;
			$this->Session->setFlash(__('Invalid captcha entry'), 'default', array('class' => 'error'));
		}

		return $continue;
	}

/**
 * Send Email
 *
 * @param boolean $continue
 * @param array $contact
 * @return boolean
 * @access protected
 */
	protected function _send_email($continue, $contact) {
		$email = new CakeEmail();
		if ($contact['Contact']['message_notify'] && $continue === true) {
			$siteTitle = Configure::read('Site.title_eng');
			$email->from(Configure::read('Site.email'))
				->to($contact['Contact']['email'])
				->subject($contact['Contact']['title'])
				->template('contact')
				->emailFormat('html')
				->viewVars(array(
					'contact' => $contact,
					'message' => $this->request->data,
				));

			if (!$email->send()) {
				$continue = false;
			}
		}

		return $continue;
	}

}
