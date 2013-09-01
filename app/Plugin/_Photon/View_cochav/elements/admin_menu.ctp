<a href="#"><?php __d('photon',__('Photon Gallery',true)); ?></a>
<?php $roleid= $this->Layout->Session->read('Auth.User.role_id')?>
<ul>
   <li><?php echo $html->link(__d('photon',__('List albums',true), true), array('plugin' => 'photon', 'controller' => 'albums', 'action' => 'index')); ?></li>
   <?php if ($roleid==1):?>
   <li><?php echo $html->link(__d('photon',__('New album',true), true), array('plugin' => 'photon', 'controller' => 'albums', 'action' => 'add')); ?></li>
   <?php endif?>
   <li><?php echo $html->link(__d('photon',__('List photos',true), true), array('plugin' => 'photon', 'controller' => 'photos', 'action' => 'index')); ?></li>
  <?php if ($roleid==1):?>
   <li><?php echo $html->link(__d('photon',__('Gallery settings',true), true), array('plugin' => '', 'controller' => 'settings', 'action' => 'prefix', 'Photon')); ?></li>
<?php endif?>
</ul>
