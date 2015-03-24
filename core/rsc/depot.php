<?php

$app->get(    '/depot/',                    		'_depot');         		   // affiche information du depot
$app->get(    '/depot/version/',                    '_depot_version');         // affiche version du depot
$app->get(    '/depot/option/',                     '_depot_option');          // affiche option du depot
$app->get(    '/depot/resolver/',                   '_depot_resolver');        // affiche tous les depots qui sont connecte à ce depot
$app->get(    '/depot/movie/',                      '_depot_movie');           // affiche les champs de la ressource movie
$app->get(    '/depot/people/',                     '_depot_people');          // affiche les champs de la ressource people


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

function _depot_resolver(){
	// Analyse avec sections de depot.ini .
	$ini_array = parse_ini_file('depot.ini', true);
	echo json_encode($ini_array['RESOLVER HOST']); // Envoi de la réponse
}

function _depot_movie(){
	// Analyse avec sections de core/rsc/movie.ini .
	$ini_array = parse_ini_file('core/rsc/people.ini', true);
	echo json_encode($ini_array); // Envoi de la réponse
}

function _depot_people(){
	// Analyse avec sections de core/rsc/movie.ini .
	$ini_array = parse_ini_file('core/rsc/people.ini', true);
	echo json_encode($ini_array); // Envoi de la réponse
}