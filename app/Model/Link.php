<?php

App::uses('AppModel', 'Model');

/**
 * Link
 *
 * PHP version 5
 *
 * @category Model
 * @package  Croogo
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
class Link extends AppModel {

/**
 * Model name
 *
 * @var string
 * @access public
 */
	public $name = 'Link';

/**
 * Behaviors used by the Model
 *
 * @var array
 * @access public
 */
	public $actsAs = array(
		'Encoder',
		'Tree',
		'Cached' => array(
			'prefix' => array(
				'link_',
				'menu_',
				'croogo_menu_',
			),
		),
	);

/**
 * Validation
 *
 * @var array
 * @access public
 */
	public $validate = array(
		'title' => array(
			'rule' => array('minLength', 1),
			'message' => 'Title cannot be empty.',
		),
		'link' => array(
			'rule' => array('minLength', 1),
			'message' => 'Link cannot be empty.',
		),
	);

/**
 * Model associations: belongsTo
 *
 * @var array
 * @access public
 */
	public $belongsTo = array(
		'Menu' => array('counterCache' => true)
	);
//orly added all down
	public function getTree($alias, $options = array()) {
		$_options = array(
				'key' => 'id',		// Term.slug
				'value' => 'title',	 // Term.title
				'linkId' => false,
				'cache' => false,
		);
		$options = array_merge($_options, $options);
	
		// Check if cached
		if ($this->useCache && isset($options['cache']['config'])) {
			if (isset($options['cache']['prefix'])) {
				$cacheName = $options['cache']['prefix'] . '_' . md5($alias . serialize($options));
			} elseif (isset($options['cache']['name'])) {
				$cacheName = $options['cache']['name'];
			}
	
			if (isset($cacheName)) {
				$cacheName .= '_' . Configure::read('Config.language');
				$cachedResult = Cache::read($cacheName, $options['cache']['config']);
				if ($cachedResult) {
					return $cachedResult;
				}
			}
		}
	
		$menu = $this->Menu->findByAlias($alias);
		if (!isset($menu['Menu']['id'])) {
			return false;
		}
		$this->Behaviors->attach('Tree', array(
				'scope' => array(
						'Link.menu_id' => $menu['Menu']['id'],
				),
		));
		$treeConditions = array(
				'Link.menu_id' => $menu['Menu']['id'],
		);
		$tree = $this->generateTreeList($treeConditions, '{n}.Link.id', '{n}.Link.parent_id');
		$linkIds = array_keys($tree);
		$links = $this->find('list', array(
				'conditions' => array(
						'Link.id' => $linkIds,
				),
				'fields' => array(
						$options['key'],
						$options['value'],
						'id',
				),
		));
		$linksTree = array();
		foreach ($tree as $linkId => $tvId) {
			if (isset($links[$linkId])) {
				$link = $links[$linkId];
				$key = array_keys($link);
				$key = $key['0'];
				$value = $link[$key];
				if (strstr($tvId, '_')) {
					$tvIdN = str_replace('_', '', $tvId);
					$tvIdE = explode($tvIdN, $tvId);
					$value = $tvIdE['0'] . $value;
				}
	
					$linksTree[str_replace('_', '', $tvId)] = $value;
				
			}
		}
	
		// Write cache
		if (isset($cacheName)) {
			Cache::write($cacheName, $linksTree, $options['cache']['config']);
		}
		return $linksTree;
	}

}
