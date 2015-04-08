<?php

$app->get(    '/config/',                    			'_config')->name("login");         		 		 		 	// affiche connexion administration
$app->post(   '/config/',                    			'_config_home')->name("home");         		    			// verifie l'indentification
$app->get(    '/config/dashboard/',                    	'_config_dashboard')->name("dashboard");         		 	// affiche le dashboard de l'admin
$app->get(    '/config/logout/',                    	'_config_logout')->name("logout");         		 			// deconnecte
$app->get(    '/config/install/',                    	'_config_install')->name("install");        		    	// affiche installation administration
$app->post(   '/config/install/',                    	'_config_install_done')->name("install_done");        		// affiche installation administration
$app->post(   '/config/depot/',                    		'_config_depot')->name("depot_add");         		    	// ajoute un depot


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
	if($_SESSION['login'] == ADMIN_LOGIN and $_SESSION['password'] == ADMIN_PASSWORD){
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
	$data = $app->request()->post();
	$depot_array = parse_ini_file('depot/depot.ini', true);
	$depot_array['RESOLVER HOST'][$data['depot_name']] = $data['depot_host'];
	unlink('depot/depot.ini');
	$system->_write_ini_file($depot_array, 'depot/depot.ini', true);
	$app->response->redirect($app->urlFor('dashboard'), 303);
}