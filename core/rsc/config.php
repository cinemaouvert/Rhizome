<?php

$app->get(    '/config/',                    					'_config')->name("login");         		 		 		 			// affiche connexion administration
$app->post(   '/config/',                    					'_config_home')->name("home");         		    					// verifie l'indentification
$app->get(    '/config/dashboard/',                    			'_config_dashboard')->name("dashboard");         		 			// affiche le dashboard de l'admin
$app->get(    '/config/dashboard/resolver/:resolver/',  		'_config_dashboard_resolver')->name("dashboard_resolver");         	// supprime un depot du resolver
$app->get(    '/config/dashboard/depot/info/',          		'_config_dashboard_depot_info')->name("dashboard_depot_info");      // affiche les infos sur le depot dans l'admin
$app->get(    '/config/logout/',                    			'_config_logout')->name("logout");         		 					// deconnecte
$app->get(    '/config/install/',                    			'_config_install')->name("install");        		    			// affiche installation administration
$app->post(   '/config/install/',                    			'_config_install_done')->name("install_done");        				// affiche installation administration
$app->post(   '/config/depot/',                    				'_config_depot')->name("depot_add");         		    			// ajoute un depot
$app->get(    '/config/dashboard/depot/info/access/:key_user',	'_config_dashboard_access')->name("dashboard_access");         		// supprime un cle utilisateur dans access.ini
$app->post(   '/config/dashboard/depot/info/',          		'_config_dashboard_access_add')->name("access_add");         		// ajoute un cle utilisateur dans access.ini
$app->get(    '/config/dashboard/depot/access/',				'_config_dashboard_depot_access')->name("access_change");         		// change l'état ouvert / fermé du depot dans depot.ini


function _config(){
	$app = \Slim\Slim::getInstance();
	if(ADMIN_LOGIN <> null){
		$path = "../";
		$app->render('welcome.php', array(
			'app' => $app, 
			'path' => $path
		));
	}
	else{
		$app->response->redirect($app->urlFor('install'), 303);
	}
}

function _config_home(){
	$app = \Slim\Slim::getInstance();
	$data = $app->request()->post();
	if(isset($data['login'])) $_SESSION['login'] = $data['login'];
	if(isset($data['login'])) $_SESSION['password'] = $data['password'];
	$path = "../";
	$app->response->redirect($app->urlFor('dashboard'), 303);
}

function _config_dashboard(){
	$app = \Slim\Slim::getInstance();
	$path = "../../";

	if(isset($_SESSION['login']) and $_SESSION['login'] == ADMIN_LOGIN and isset($_SESSION['password']) and $_SESSION['password'] == ADMIN_PASSWORD){
		$resolver_list = parse_ini_file('depot/depot.ini', true);
		$resolver_list = $resolver_list['RESOLVER HOST'];
		$app->render('home.php', array(
			'app' => $app, 
			'path' => $path,
			'resolver_list' => $resolver_list
		));
	}
	else{
		$app->response->redirect($app->urlFor('login'), 303);
	}
}

function _config_dashboard_depot_info(){
	$app = \Slim\Slim::getInstance();
	$path = "../../../../";
	if(isset($_SESSION['login']) and $_SESSION['login'] == ADMIN_LOGIN and isset($_SESSION['password']) and $_SESSION['password'] == ADMIN_PASSWORD){
		$depot = parse_ini_file('depot/depot.ini', true);
		$access_list = parse_ini_file('depot/access.ini', true);
		$depot['VERSION'] = parse_ini_file('core/core.ini', true);
		$app->render('depot_info.php', array(
			'app' => $app, 
			'path' => $path,
			'depot' => $depot,
			'access_list' => $access_list['ACCESS']
		));
	}
	else{
		$app->response->redirect($app->urlFor('login'), 303);
	}
}

function _config_dashboard_resolver($resolver){
	$system = new System();
	$app = \Slim\Slim::getInstance();
	if(isset($_SESSION['login']) and $_SESSION['login'] == ADMIN_LOGIN and isset($_SESSION['password']) and $_SESSION['password'] == ADMIN_PASSWORD){
		$depot_array = parse_ini_file('depot/depot.ini', true);
		unset($depot_array['RESOLVER HOST'][$resolver]);
		unlink('depot/depot.ini');
		$system->_write_ini_file($depot_array, 'depot/depot.ini', true);
		$app->response->redirect($app->urlFor('dashboard'), 303);
	}
	else{
		$app->response->redirect($app->urlFor('login'), 303);
	}
}

function _config_logout(){
	$app = \Slim\Slim::getInstance();
	session_destroy();
	$app->response->redirect($app->urlFor('login'), 303);
}

function _config_install(){
	$app = \Slim\Slim::getInstance();
	$path = "../../";
	if(ADMIN_LOGIN == null){
		$app->render('install.php', array(
			'app' => $app, 
			'path' => $path
		));
	}
	else{
		$app->response->redirect($app->urlFor('login'), 303);
	}
}

function _config_install_done(){
	$system = new System();
	$app = \Slim\Slim::getInstance();
	$data = $app->request()->post();
	$path = "../../";
	if($data['login'] <> null){
		$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; 
        $url = str_replace('config/install/', '', $url);
		$depot_array = parse_ini_file('depot/depot.ini', true);
		$depot_array['DEPOT']['local'] = $url;
		unlink('depot/depot.ini');
		$system->_write_ini_file($depot_array, 'depot/depot.ini', true);
		$config = '<?php define(\'ADMIN_LOGIN\', \''.$data["login"].'\'); define(\'ADMIN_PASSWORD\', \''.$data["password"].'\');';
		unlink('admin/configuration.php');
		$system->_write_php_file($config, 'admin/configuration.php');
		$app->render('install_done.php', array(
			'app' => $app, 
			'path' => $path,
			'data' => $data
		));
	}
	else{
		$app->response->redirect($app->urlFor('install'), 303);
	}
}

function _config_depot(){
	$system = new System();
	$app = \Slim\Slim::getInstance();
	if(isset($_SESSION['login']) and $_SESSION['login'] == ADMIN_LOGIN and isset($_SESSION['password']) and $_SESSION['password'] == ADMIN_PASSWORD){
		$data = $app->request()->post();
		if(empty($data['depot_name']) or empty($data['depot_host'])){
			$app->response->redirect($app->urlFor('dashboard'), 303);
		}
		else{
			$depot_array = parse_ini_file('depot/depot.ini', true);
			$depot_array['RESOLVER HOST'][$data['depot_name']] = $data['depot_host'];
			unlink('depot/depot.ini');
			$system->_write_ini_file($depot_array, 'depot/depot.ini', true);
			$app->response->redirect($app->urlFor('dashboard'), 303);
		}
	}
	else{
		$app->response->redirect($app->urlFor('login'), 303);
	}
}

function _config_dashboard_access($key_user){
	$system = new System();
	$app = \Slim\Slim::getInstance();
	if(isset($_SESSION['login']) and $_SESSION['login'] == ADMIN_LOGIN and isset($_SESSION['password']) and $_SESSION['password'] == ADMIN_PASSWORD){
		$access_array = parse_ini_file('depot/access.ini', true);
		unset($access_array['ACCESS'][$key_user]);
		unlink('depot/access.ini');
		$system->_write_ini_file($access_array, 'depot/access.ini', true);
		$app->response->redirect($app->urlFor('dashboard_depot_info'), 303);
	}
	else{
		$app->response->redirect($app->urlFor('login'), 303);
	}
}

function _config_dashboard_access_add(){
	$system = new System();
	$app = \Slim\Slim::getInstance();
	if(isset($_SESSION['login']) and $_SESSION['login'] == ADMIN_LOGIN and isset($_SESSION['password']) and $_SESSION['password'] == ADMIN_PASSWORD){
		$data = $app->request()->post();
		if(empty($data['key_user']) or empty($data['key_access'])){
			$app->response->redirect($app->urlFor('dashboard_depot_info'), 303);
		}
		else{
			$access_array = parse_ini_file('depot/access.ini', true);
			$access_array['ACCESS'][$data['key_user']] = $data['key_access'];
			unlink('depot/access.ini');
			$system->_write_ini_file($access_array, 'depot/access.ini', true);
			$app->response->redirect($app->urlFor('dashboard_depot_info'), 303);
		}
		
	}
	else{
		$app->response->redirect($app->urlFor('login'), 303);
	}
}

function _config_dashboard_depot_access(){
	$system = new System();
	$app = \Slim\Slim::getInstance();
	if(isset($_SESSION['login']) and $_SESSION['login'] == ADMIN_LOGIN and isset($_SESSION['password']) and $_SESSION['password'] == ADMIN_PASSWORD){
		$depot_array = parse_ini_file('depot/depot.ini', true);
		if($depot_array['OPTION']['open'] == "0" ){
			$depot_array['OPTION']['open'] = "1";
		}
		else $depot_array['OPTION']['open'] = "0";
		unlink('depot/depot.ini');
		$system->_write_ini_file($depot_array, 'depot/depot.ini', true);
		$app->response->redirect($app->urlFor('dashboard_depot_info'), 303);
	}
	else{
		$app->response->redirect($app->urlFor('login'), 303);
	}
}