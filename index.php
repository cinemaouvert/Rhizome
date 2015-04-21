<?php
	session_start();
	header('Access-Control-Allow-Origin: *'); // Ouvre la connexion à tous les clients.
    header('Access-Control-Allow-Credentials: true'); 
    header('Access-Control-Max-Age: 86400'); // Gestion cache.
	require 'admin/configuration.php'; 		// initialisation de la configuration
	require 'core/core.php';     			// initialisation du depot
	require 'core/rsc.php';     			// initialisation des ressouces disponibles
	$app->run();