<?php
/**
 * Photon Gallery Helper
 *
 * PHP version 5
 *
 * @category Helper
 * @package  Croogo
 * @version  1.3
 * @author   bumuckl <bumuckl@gmail.com> and Edinei L. Cipriani <phpedinei@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.bumuckl.com
 */
class GalleryHelper extends AppHelper {

/**
 * Other helpers used by this helper
 *
 * @var array
 * @access public
 */
	var $helpers = array(
		'Layout',
		'Html'
	);
	
	var $gallery_id = 0;
	var $popeye_id = 0;
	var $slider_id = 0;

/**
 * Called before LayoutHelper::setNode()
 *
 * @return void
 */
	public function beforeRender() {
		//if(ClassRegistry::getObject('View')){
			
			//load all CSS files
			//$this->Html->css('/photon/css/jquery.lightbox-0.5', 'stylesheet', array('inline' => false));
			$this->Html->css('gallery', 'stylesheet', array('inline' => false));
			//$this->Html->css('/photon/css/jquery.popeye', 'stylesheet', array('inline' => false));
			//$this->Html->css('/photon/css/jquery.popeye.style', 'stylesheet', array('inline' => false));
			
			//load all js libraries & scripts
			//echo $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js', array('inline' => false));
			//$this->Html->script('/photon/js/jquery.lightbox-0.5.min', array('inline' => false));
			//$this->Html->script('/photon/js/jquery.popeye-2.0.4.min', array('inline' => false));
			//$this->Html->script('/photon/js/easySlider1.5', array('inline' => false));
			$this->Html->script('/photon/js/gallery', array('inline' => false));
			
		//}
	}

/**
 * Called after LayoutHelper::nodeBody()
 *
 * @return string
 */
	public function afterSetNode() {
	    $this->Layout->setNodeField('body', $this->replace($this->Layout->node('body')));
	}
    
    /**
     * Replace all types of embedding codes in a text.
     */
    public function replace($body) {
    	if (isset($this->params['gallery_id'])) $this->gallery_id = $this->params['gallery_id'];
    	$body = preg_replace_callback('/\[AlbumsGallery.*?\]/', array(&$this,'replaceForAlbumsGallery'), $body);
	    $body = preg_replace_callback('/\[Gallery:.*?\]/', array(&$this,'replaceForGallery'), $body);
	    $body = preg_replace_callback('/\[Popeye:.*?\]/', array(&$this,'replaceForPopeye'), $body);
	    $body = preg_replace_callback('/\[Slider:.*?\]/', array(&$this,'replaceForSlider'), $body);
	    $body = preg_replace_callback('/\[Image]/', array(&$this,'replaceForImage'), $body);
	    
	    return $body;
	}

	/**
     * Callback function for replacing [Gallery:slug]. 
     * 
     * Should not be called directly, use replace($body) to replace all types of embedding codes in a text
     */
	public function replaceForGallery($subject){
		preg_match('/\[Gallery:(.*?)\]/', $subject[0], $matches);
		return $this->_View->element('gallery', array('slug' => $matches[1], 'gallery_id' => $this->gallery_id++),
				array('plugin' => 'photon',
						'cache' => array(
						'time'=> '+999 day',
						'key' => $this->gallery_id,
						'config' => 'albums',
				)));
	}
	
	/**
     * Callback function for replacing [Popeye:slug]. 
     * 
     * Should not be called directly, use replace($body) to replace all types of embedding codes in a content
     */
	public function replaceForAlbumsGallery($subject){

		preg_match('/\[Gallery:(.*?)\]/', $subject[0], $matches);
		return $this->_View->element('albumsgallery', array('gallery_id' => $this->gallery_id),
				array('plugin' => 'photon',
				'cache' => array(
						'time'=> '+999 day',
						'key' => $this->gallery_id,
						'config' => 'albums',
				)
		));		
				
	}
	public function replaceForPopeye($subject){
		preg_match('/\[Popeye:(.*?)\]/', $subject[0], $matches);
		return  $this->Layout->View->element('popeye', array('plugin' => 'photon', 'slug' => $matches[1], 'popeye_id' => $this->popeye_id++));
	}
	
	/**
     * Callback function for replacing [Slider:slug]. 
     * 
     * Should not be called directly, use replace($body) to replace all types of embedding codes in a content
     */
	public function replaceForSlider($subject){
		preg_match('/\[Slider:(.*?)\]/', $subject[0], $matches);
		return  $this->Layout->View->element('slider', array('plugin' => 'photon', 'slug' => $matches[1], 'slider_id' => $this->slider_id++));
	}
	
	/**
     * Callback function for replacing [Image:id]. 
     * 
     * Should not be called directly, use replace($body) to replace all types of embedding codes in a content
     */
	public function replaceForImage($subject){
			return $this->_View->element('image', array('id' => $this->params['id']),
				array('plugin' => 'photon',
						'cache' => array(
								'time'=> '+999 day',
								'key' => $this->gallery_id,
								'config' => 'albums',
						)
				));
	}

}

?>