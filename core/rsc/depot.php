<?php

$app->get(    '/',                    				'_index');         		   // affiche index
$app->get(    '/depot/',                    		'_depot');         		   // affiche information du depot
$app->get(    '/depot/version/',                    '_depot_version');         // affiche version du depot
$app->get(    '/depot/option/',                     '_depot_option');          // affiche option du depot
$app->get(    '/depot/resolver/',                   '_depot_resolver');        // affiche tous les depots qui sont connecte à ce depot
$app->get(    '/depot/resource/:resource/',         '_depot_resource');        // affiche les champs d'une ressource


function _index(){

	$app = \Slim\Slim::getInstance();
	$depot_array = parse_ini_file('depot/depot.ini', true);
	if($depot_array['DEPOT']['local'] == "") $app->response->redirect($app->urlFor('install'), 303);
	else $app->halt(400);

}

function _depot(){

	// Analyse avec sections de depot.ini .
	$ini_array = parse_ini_file('depot/depot.ini', true);
	echo json_encode($ini_array); // Envoi de la réponse

}

function _depot_version(){

	// Analyse avec sections de core/core.ini .
	$ini_array = parse_ini_file('core/core.ini', true);
	echo json_encode($ini_array['DESCRIPTION']); // Envoi de la réponse

}

function _depot_option(){

	// Analyse avec sections de depot.ini .
	$ini_array = parse_ini_file('depot/depot.ini', true);
	echo json_encode($ini_array['OPTION']); // Envoi de la réponse

}

function _depot_resolver(){

	// Analyse avec sections de depot.ini .
	$ini_array = parse_ini_file('depot/depot.ini', true);
	echo json_encode($ini_array['RESOLVER HOST']); // Envoi de la réponse

}

function _depot_resource($resource){

	// on créer un variable contenant le chemin vers la ressource
	$filename = 'core/rsc/'.$resource.'.ini';

	// on vérifie si le fichier/ressource existe ou non
	if (file_exists($filename)) { // Si le fichier/ressource existe
		// Analyse avec sections de core/rsc/'resource'.ini .
	    $ini_array = parse_ini_file($filename, true);
	    echo json_encode($ini_array); // Envoi de la réponse 
	} else { // sinon on renvoi un 404
	    $app = \Slim\Slim::getInstance();
	    $app->halt(404);
	}

}
