<?php

$app->get(    '/resolver/movies/',                    '_resolver_movies_all');         			// affiche tous les films du resolver
$app->get(    '/resolver/movies/:key/',               '_resolver_movies_all_by_key');           // affiche toutes les films du resolver
$app->get(    '/resolver/peoples/',                   '_resolver_peoples_all');         		// affiche toutes les personnes du resolver
$app->get(    '/resolver/peoples/:key/',              '_resolver_peoples_all_by_key');          // affiche toutes les personnes du resolver
$app->get(    '/resolver/organisations/',             '_resolver_organisations_all');         	// affiche toutes les personnes du resolver
$app->get(    '/resolver/organisations/:key/',        '_resolver_organisations_all_by_key');    // affiche toutes les personnes du resolver


function _resolver_movies_all(){
	// Analyse avec sections de depot.ini .
	$result = [];
	$ini_array = parse_ini_file('depot.ini', true);
	$adress_resolver = $ini_array['DEPOT']['local'];
	$context = stream_context_create(array('http' => array('header'=>'Connection: close\r\n')));
    $result1 = file_get_contents($adress_resolver.'movies',false,$context);
    $result1 = json_decode($result1, true);
    $result = array_merge($result, $result1);
	foreach($ini_array['RESOLVER HOST'] as $key => $value) {
		$adress_resolver = $value;
		$context = stream_context_create(array('http' => array('header'=>'Connection: close\r\n')));
	    $result1 = file_get_contents($adress_resolver.'movies',false,$context);
	    $result1 = json_decode($result1, true);
	    $result = array_merge($result, $result1);
	}
	echo json_encode($result); // Envoi de la réponse
}

function _resolver_movies_all_by_key($key){
	// Analyse avec sections de depot.ini .
	$result = [];
	$ini_array = parse_ini_file('depot.ini', true);
	$adress_resolver = $ini_array['DEPOT']['local'];
	$context = stream_context_create(array('http' => array('header'=>'Connection: close\r\n')));
    $result1 = file_get_contents($adress_resolver.'movies/'.$key,false,$context);
    $result1 = json_decode($result1, true);
    $result = array_merge($result, $result1);
	foreach($ini_array['RESOLVER HOST'] as $row) {
		$adress_resolver = $row;
		$context = stream_context_create(array('http' => array('header'=>'Connection: close\r\n')));
	    $result1 = file_get_contents($adress_resolver.'movies/'.$key,false,$context);
	    $result1 = json_decode($result1, true);
	    $result = array_merge($result, $result1);
	}
	echo json_encode($result); // Envoi de la réponse
}

function _resolver_peoples_all(){
	// Analyse avec sections de depot.ini .
	$result = [];
	$ini_array = parse_ini_file('depot.ini', true);
	$adress_resolver = $ini_array['DEPOT']['local'];
	$context = stream_context_create(array('http' => array('header'=>'Connection: close\r\n')));
    $result1 = file_get_contents($adress_resolver.'peoples',false,$context);
    $result1 = json_decode($result1, true);
    $result = array_merge($result, $result1);
	foreach($ini_array['RESOLVER HOST'] as $row) {
		$adress_resolver = $row;
		$context = stream_context_create(array('http' => array('header'=>'Connection: close\r\n')));
	    $result1 = file_get_contents($adress_resolver.'peoples',false,$context);
	    $result1 = json_decode($result1, true);
	    $result = array_merge($result, $result1);
	}
	echo json_encode($result); // Envoi de la réponse
}

function _resolver_peoples_all_by_key($key){
	// Analyse avec sections de depot.ini .
	$result = [];
	$ini_array = parse_ini_file('depot.ini', true);
	$adress_resolver = $ini_array['DEPOT']['local'];
	$context = stream_context_create(array('http' => array('header'=>'Connection: close\r\n')));
    $result1 = file_get_contents($adress_resolver.'peoples/'.$key,false,$context);
    $result1 = json_decode($result1, true);
    $result = array_merge($result, $result1);
	foreach($ini_array['RESOLVER HOST'] as $row) {
		$adress_resolver = $row;
		$context = stream_context_create(array('http' => array('header'=>'Connection: close\r\n')));
	    $result1 = file_get_contents($adress_resolver.'peoples/'.$key,false,$context);
	    $result1 = json_decode($result1, true);
	    $result = array_merge($result, $result1);
	}
	echo json_encode($result); // Envoi de la réponse
}

function _resolver_organisations_all(){
	// Analyse avec sections de depot.ini .
	$result = [];
	$ini_array = parse_ini_file('depot.ini', true);
	$adress_resolver = $ini_array['DEPOT']['local'];
	$context = stream_context_create(array('http' => array('header'=>'Connection: close\r\n')));
    $result1 = file_get_contents($adress_resolver.'organisations',false,$context);
    $result1 = json_decode($result1, true);
    $result = array_merge($result, $result1);
	foreach($ini_array['RESOLVER HOST'] as $row) {
		$adress_resolver = $row;
		$context = stream_context_create(array('http' => array('header'=>'Connection: close\r\n')));
	    $result1 = file_get_contents($adress_resolver.'organisations',false,$context);
	    $result1 = json_decode($result1, true);
	    $result = array_merge($result, $result1);
	}
	echo json_encode($result); // Envoi de la réponse
}

function _resolver_organisations_all_by_key($key){
	// Analyse avec sections de depot.ini .
	$result = [];
	$ini_array = parse_ini_file('depot.ini', true);
	$adress_resolver = $ini_array['DEPOT']['local'];
	$context = stream_context_create(array('http' => array('header'=>'Connection: close\r\n')));
    $result1 = file_get_contents($adress_resolver.'organisations/'.$key,false,$context);
    $result1 = json_decode($result1, true);
    $result = array_merge($result, $result1);
	foreach($ini_array['RESOLVER HOST'] as $row) {
		$adress_resolver = $row;
		$context = stream_context_create(array('http' => array('header'=>'Connection: close\r\n')));
	    $result1 = file_get_contents($adress_resolver.'organisations/'.$key,false,$context);
	    $result1 = json_decode($result1, true);
	    $result = array_merge($result, $result1);
	}
	echo json_encode($result); // Envoi de la réponse
}

