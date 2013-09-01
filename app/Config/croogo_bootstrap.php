<?php
/**
 * Default Acl plugin.  Custom Acl plugin should override this value.
 */
Configure::write('Site.acl_plugin', 'Acl');

/**
 * Admin theme
 */
//Configure::write('Site.admin_theme', 'sample');

/**
 * Cache configuration
 */
$cacheConfig = array(
	'duration' => '+1000 hour',
	'path' => CACHE . 'queries',
	'engine' => 'File',
);

// models
Cache::config('setting_write_configuration', $cacheConfig);

// components
Cache::config('croogo_blocks', $cacheConfig);
Cache::config('croogo_menus', $cacheConfig);
Cache::config('croogo_nodes', $cacheConfig);
Cache::config('croogo_types', $cacheConfig);
Cache::config('croogo_vocabularies', $cacheConfig);

// controllers
Cache::config('nodes_view', $cacheConfig);
Cache::config('nodes_promoted', $cacheConfig);
Cache::config('nodes_term', $cacheConfig);
Cache::config('nodes_index', $cacheConfig);
Cache::config('contacts_view', $cacheConfig);


/**
 * Failed login attempts
 *
 * Default is 5 failed login attempts in every 5 minutes
 */
$failedLoginDuration = 300;
Configure::write('User.failed_login_limit', 5);
Configure::write('User.failed_login_duration', $failedLoginDuration);
Cache::config('users_login', array_merge($cacheConfig, array(
	'duration' => '+' . $failedLoginDuration. ' seconds',
)));

/**
 * Libraries
 */
App::import('Vendor', 'Spyc/Spyc');

/**
 * Settings
 */
//orly updated multisite
	//if (file_exists(APP . 'Config' . DS . 'settings.yml')) {
	if (file_exists(WWW_ROOT . 'Config' . DS . 'settings.yml')) {
	$settings = Spyc::YAMLLoad(file_get_contents(WWW_ROOT . 'Config' . DS . 'settings.yml'));
	foreach ($settings as $settingKey => $settingValue) {
		Configure::write($settingKey, $settingValue);
	}
}

/**
 * Locale
 */
Configure::write('Config.language', Configure::read('Site.locale'));

/**
 * Setup custom paths
 */
 
 //Orly Changed
//if ($theme = Configure::read('Site.theme')) {
//	App::build(array(
//	'View/Helper' => array(App::themePath($theme) . 'Helper' . DS),
//	));
//}
if ($theme = Configure::read('Site.theme')) {
	
	App::build(array(
		'View' => array(WWW_ROOT),
	));
	App::build(array(
		'View/Helper' => array(App::themePath($theme) . 'Helper' . DS),
		
		
	));
}


/**
 * Plugins
 */
$aclPlugin = Configure::read('Site.acl_plugin');
$pluginBootstraps = Configure::read('Hook.bootstraps');
$plugins = array_filter(explode(',', $pluginBootstraps));
if (!in_array($aclPlugin, $plugins)) {
	$plugins = Set::merge($aclPlugin, $plugins);
}
foreach ($plugins as $plugin) {
	$pluginName = Inflector::camelize($plugin);
	if (!file_exists(APP . 'Plugin' . DS . $pluginName)) {
		CakeLog::write(LOG_ERR, 'Plugin not found during bootstrap: ' . $pluginName);
		continue;
	}
	$bootstrapFile = APP . 'Plugin' . DS . $pluginName . DS . 'Config' . DS . 'bootstrap.php';
	$bootstrap = file_exists($bootstrapFile);
	$routesFile = APP . 'Plugin' . DS . $pluginName . DS . 'Config' . DS . 'routes.php';
	$routes = file_exists($routesFile);
	$option = array(
		$pluginName => array(
			'bootstrap' => $bootstrap,
			'routes' => $routes,
		)
	);
	CroogoPlugin::load($option);
}
CroogoEventManager::loadListeners();
