<?php
/**
 * Album
 *
 * PHP version 5
 *
 * @category Model
 * @package  Croogo
 * @version  1.3
 * @author   bumuckl <bumuckl@gmail.com> and Edinei L. Cipriani <phpedinei@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.bumuckl.com
 */
 App::uses('AppModel', 'Model');

class Album extends PhotonAppModel {

	var $name = 'Album';
	
	var $actsAs = array(
	     'Ordered' => array(
			'field' => 'weight',
			'foreign_key' => false,
		),
	);

	var $validate = array(
		'slug' => array(
			'rule' => 'isUnique',
			'message' => 'Slug is already in use.',
		),
	);
	var $hasMany = array(
			'Photo' => array(
				'className' => 'Photon.photo',
				'foreignKey' => 'album_id',
				'dependent' => true,
				'conditions' => '',
				'fields' => '',
				'order' => 'Photo.weight ASC',
				'limit' => '',
				'offset' => '',
				'exclusive' => '',
				'finderQuery' => '',
				'counterQuery' => ''
			),
	);
	
	var $belongsTo = array(
        'Node' => array(
            'className'    => 'Node',
            'foreignKey'    => 'node_id'
        ),
			'Link' => array(
					'className'    => 'Link',
					'foreignKey'    => 'link_id'
			)
    );  
	public function beforeSave($options = array()) {
		parent::beforeSave($options);
		$this->data['Album']['slug'] = (isset($this->data['Album']['slug'])) ? Inflector::slug($this->data['Album']['slug']) : $this->data['Album']['id'];
		return true;
	}
	function paginateCount($conditions = null, $recursive = 0, $extra = array()) {
		if (!empty($extra) && isset($extra['customCount'])) {
			return $extra['customCount'];
		}
        $count = $this->find('count', array(
			'conditions' => $conditions,
		));
        return $count;
    } 
public function afterSave($options = array()){
		$files=glob(TMP . 'cache' . DS . 'queries' . DS . 'cake_element_*');
		if (is_array($files) && count($files) > 0) {
				foreach ($files as $file) {
					unlink($file);
				}
		}
	}
	public function afterDelete($options = array()){
		$files=glob(TMP . 'cache' . DS . 'queries' . DS . 'cake_element_*');
		if (is_array($files) && count($files) > 0) {
				foreach ($files as $file) {
					unlink($file);
				}
		}
	}

}
?>