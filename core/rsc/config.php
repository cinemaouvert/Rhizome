<?php

$app->get(    '/config/',                    		'_config');         		   // affiche connexion administration
$app->get(    '/config/:route/',                    	'_config_route');            // affiche home / install administration



function _config(){
	$page = 'welcome';
	require 'admin/index.php';
}

function _config_route($route){
	$page = $route;
	require 'admin/index.php';
}