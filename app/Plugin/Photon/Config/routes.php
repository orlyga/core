<?php
CroogoRouter::connect('/photos/view_extra_thumbs/:album_id', array('plugin' => 'photon', 'controller' => 'photos', 'action' => 'view_extra_thumbs'),array('pass' => array('album_id')));
CroogoRouter::connect('/category/:slug', array('plugin'=>'photon','controller' => 'albums', 'action' => 'view'),array('pass' => array('slug')));	
CroogoRouter::connect('/photon/albums/getAlbumInfo/:album_id', array('plugin' => 'photon', 'controller' => 'albums', 'action' => 'getAlbumInfo'),array('pass' => array('album_id')));

CroogoRouter::connect('/photon/*', array('plugin' => 'photon', 'controller' => 'albums', 'action' => 'index'));
CroogoRouter::connect('/admin/albums', array('plugin' => 'photon', 'controller' => 'albums', 'action' => 'index','prefix'=>'admin','admin'=>1));
CroogoRouter::connect('/admin/photon/albums/gallery/album/:id', array('plugin' => 'photon', 'controller' => 'albums', 'action' => 'edit','prefix'=>'admin','admin'=>1),array('pass' => array('id')));

CroogoRouter::connect('/admin/edit/:id', array('plugin' => 'photon', 'controller' => 'albums', 'action' => 'edit','prefix'=>'admin','admin'=>1),array('pass' => array('id')));
CroogoRouter::connect('/photos/movedown', array('plugin' => 'photon', 'controller' => 'photos', 'action' => 'movedown','prefix'=>'admin','admin'=>1));

CroogoRouter::connect('/gallery', array('plugin' => 'photon', 'controller' => 'albums', 'action' => 'index'));
CroogoRouter::connect('/gallery/albums', array('plugin' => 'photon', 'controller' => 'albums', 'action' => 'index'));
CroogoRouter::connect('/gallery/album/:slug', array('plugin' => 'photon', 'controller' => 'albums', 'action' => 'view'), array('pass' => array('slug')));
CroogoRouter::connect('/photon/albums/gallery/album/:slug', array('plugin' => 'photon', 'controller' => 'albums', 'action' => 'view'), array('pass' => array('slug')));

CroogoRouter::connect('/albums/view/:slug', array('plugin' => 'photon', 'controller' => 'albums', 'action' => 'viewall'), array('pass' => array('slug')));
CroogoRouter::connect('/album/:slug', array('plugin' => 'photon', 'controller' => 'albums', 'action' => 'view'), array('pass' => array('slug')));
//CroogoRouter::connect('/photo/:id', array('controller' => 'nodes', 'action' => 'view','type' => 'page','slug'=>'product_page',"id"));
CroogoRouter::connect('/photos/editlist/:id', array('plugin' => 'photon', 'controller' => 'photos', 'action' => 'editlist','prefix'=>'admin','admin'=>1));
CroogoRouter::connect('/photos/addlist/:id', array('plugin' => 'photon', 'controller' => 'photos', 'action' => 'addlist','prefix'=>'admin','admin'=>1));
CroogoRouter::connect('/photos/view/:id', array('plugin' => 'photon', 'controller' => 'photos', 'action' => 'view'),array('pass' => array('id')));
CroogoRouter::connect('/photo/:id', array('plugin' => 'photon', 'controller' => 'photos', 'action' => 'view'),array('pass' => array('id')));
//maybe problem orly exist in local version orly reznik CroogoRouter::connect('/photo/:id', array('controller' => 'nodes', 'action' => 'view','type' => 'page','slug'=>'product_page'), array('pass' => array('id')));
CroogoRouter::connect('/photos/ajaxupdate', array('plugin' => 'photon', 'controller' => 'photos', 'action' => 'ajaxupdate','prefix'=>'admin','admin'=>1));
CroogoRouter::connect('/nodes/gallery/album/gallery/album/:slug', array('plugin' => 'photon', 'controller' => 'albums', 'action' => 'view'), array('pass' => array('slug')));
CroogoRouter::connect('/albums/addtocart/*', array('plugin' => 'photon', 'controller' => 'albums', 'action' => 'addtocart'));
CroogoRouter::connect('/album/edit/:id', array('plugin' => 'photon', 'controller' => 'albums', 'action' => 'edit','prefix'=>'admin','admin'=>1),array('pass' => array('id')));
CroogoRouter::connect('/albums/design', array('plugin' => 'photon', 'controller' => 'albums', 'action' => 'design'));
CroogoRouter::connect('/photos/upload_img_montage', array('plugin' => 'photon', 'controller' => 'photos', 'action' => 'upload_img_montage'));
CroogoRouter::connect('/photos/send_mail_tome', array('plugin' => 'photon', 'controller' => 'photos', 'action' => 'send_mail_tome'));
CroogoRouter::connect('/photos/upload_img', array('plugin' => 'photon', 'controller' => 'photos', 'action' => 'upload_img'));

?>
