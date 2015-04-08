<?php

$app->get(    '/config/',                    			'_config')->name("login");         		 		 		 	// affiche connexion administration
$app->post(   '/config/',                    			'_config_home')->name("home");         		    			// affiche administration
$app->get(    '/config/install/',                    	'_config_install')->name("install");        		    	// affiche installation administration
$app->post(   '/config/install/',                    	'_config_install_done')->name("install_done");        		// affiche installation administration


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
	$app = \Slim\Slim::getInstance();
	$data = $app->request()->post();
	$path = "../../";
	if($data['login'] <> null){
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


function _config_home(){
	$app = \Slim\Slim::getInstance();
	$data = $app->request()->post();
	$path = "../";
	if($data['login'] == ADMIN_LOGIN and $data['password'] == ADMIN_PASSWORD){
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