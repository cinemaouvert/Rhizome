<?php
	session_start();
	header('Access-Control-Allow-Origin: *'); // Ouvre la connexion à tous les clients.
    header('Access-Control-Allow-Credentials: true'); 
    header('Access-Control-Max-Age: 86400'); // Gestion cache.

	require 'admin/configuration.php'; 		// initialisation de la configuration
	require 'core/core.php';     			// initialisation du depot
	require 'core/rsc.php';     			// initialisation des ressouces disponibles
	if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
	    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']) && (   
	       $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'] == 'POST' || 
	       $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'] == 'DELETE' || 
	       $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'] == 'PUT' )) {
	             header('Access-Control-Allow-Origin: *');
	             header("Access-Control-Allow-Credentials: true"); 
	             header('Access-Control-Allow-Headers: X-Requested-With');
	             header('Access-Control-Allow-Headers: Content-Type');
	             header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT'); // http://stackoverflow.com/a/7605119/578667
	             header('Access-Control-Max-Age: 86400'); 
	      }
	  exit;
	}
	$app->map('/:x+', function($x) {
	    http_response_code(200);
	})->via('OPTIONS');
	$app->run();