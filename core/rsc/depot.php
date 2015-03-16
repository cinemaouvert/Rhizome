<?php

$app->get(    '/depot/',                    		'_depot');         		   // affiche information du depot
$app->get(    '/depot/version/',                    '_depot_version');         // affiche version du depot
$app->get(    '/depot/option/',                     '_depot_option');          // affiche option du depot


function _depot(){
	// Analyse avec sections de core/core.ini .
	$ini_array = parse_ini_file('depot.ini', true);
	echo json_encode($ini_array); // Envoi de la réponse
}

function _depot_version(){
	// Analyse avec sections de core/core.ini .
	$ini_array = parse_ini_file('core/core.ini', true);
	echo json_encode($ini_array['DESCRIPTION']); // Envoi de la réponse
}

function _depot_option(){
	// Analyse avec sections de core/core.ini .
	$ini_array = parse_ini_file('depot.ini', true);
	echo json_encode($ini_array['OPTION']); // Envoi de la réponse
}