<?php

$app->get(    '/resolver/:resources/',                    '_resolver_resources_all');         			// affiche toutes les ressource d'un type du resolver
$app->get(    '/resolver/:resources/:key/',               '_resolver_resources_all_by_key');            // affiche toutes les ressource d'un type par clé utilisateur du resolver


function _resolver_resources_all($resources){
	
	// initialisation des variables et fonctions
	$system = new System();
	$result = [];

	// Analyse avec sections de depot.ini .
	$ini_array = parse_ini_file('depot.ini', true);
	$adress_resolver = $ini_array['DEPOT']['local'];

	// On va chercher dans le depot local en premier
    if($system->_get_http_response_code($adress_resolver.$resources.'/') != "404"){
    	$context = stream_context_create(array('http' => array('header'=>'Connection: close\r\n')));
    	$result1 = file_get_contents($adress_resolver.$resources.'/',false,$context);
    	$result1 = json_decode($result1, true);
    	$result = array_merge($result, $result1);
    }

    // On va chercher dans les différents depot du resolver par la suite
	foreach($ini_array['RESOLVER HOST'] as $row) {
		$adress_resolver = $row;
		if($system->_get_http_response_code($adress_resolver.$resources.'/') != "404"){
			$context = stream_context_create(array('http' => array('header'=>'Connection: close\r\n')));
		    $result1 = file_get_contents($adress_resolver.$resources.'/',false,$context);
		    $result1 = json_decode($result1, true);
		    $result = array_merge($result, $result1);
		}
	}

	// On traite le resultat
	if($result <> null) echo $system->_filter_json(json_encode($result)); // Envoi de la réponse
	else { // s'il n'y a rien alors on fait un 404
		$app = \Slim\Slim::getInstance();
	    $app->halt(404);
	}

}

function _resolver_resources_all_by_key($resources,$key){
	
	// initialisation des variables et fonctions
	$system = new System();
	$result = [];

	// Analyse avec sections de depot.ini .
	$ini_array = parse_ini_file('depot.ini', true);
	$adress_resolver = $ini_array['DEPOT']['local'];

	// On va chercher dans le depot local en premier
    if($system->_get_http_response_code($adress_resolver.$resources.'/'.$key) != "404"){
    	$context = stream_context_create(array('http' => array('header'=>'Connection: close\r\n')));
    	$result1 = file_get_contents($adress_resolver.$resources.'/'.$key,false,$context);
    	$result1 = json_decode($result1, true);
    	$result = array_merge($result, $result1);
    }

    // On va chercher dans les différents depot du resolver par la suite
	foreach($ini_array['RESOLVER HOST'] as $row) {
		$adress_resolver = $row;
		if($system->_get_http_response_code($adress_resolver.$resources.'/'.$key) != "404"){
			$context = stream_context_create(array('http' => array('header'=>'Connection: close\r\n')));
		    $result1 = file_get_contents($adress_resolver.$resources.'/'.$key,false,$context);
		    $result1 = json_decode($result1, true);
		    $result = array_merge($result, $result1);
		}
	}

	// On traite le resultat
	if($result <> null) echo $system->_filter_json(json_encode($result)); // Envoi de la réponse
	else { // s'il n'y a rien alors on fait un 404
		$app = \Slim\Slim::getInstance();
	    $app->halt(404);
	}
}

