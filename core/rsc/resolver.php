<?php

$app->get(    '/resolver/:resource/',                   	 			'_resolver_resource_all');         			// affiche  les 20 dernieres ressource d'un type du resolver
$app->get(    '/resolver/:resource/o/:p_index_first/:p_index_last',     '_resolver_resource_all_offset');         	// affiche les ressource d'un type du resolver via un offset
$app->get(    '/resolver/:resource/key/:key/',               			'_resolver_resource_all_by_key');           // affiche toutes les ressource d'un type par clé utilisateur du resolver


function _resolver_resource_all($resource){
	_resolver_resource_all_offset($resource, '1', '20');
}

function _resolver_resource_all_offset($resource, $p_index_first, $p_index_last){
	$app = \Slim\Slim::getInstance();
	$depot_array = parse_ini_file('depot/depot.ini', true);
	if($depot_array['DEPOT']['local'] == "") $app->response->redirect($app->urlFor('install'), 303);
	// initialisation des variables et fonctions
	$system = new System();
	$result = [];

	// Analyse avec sections de depot.ini .
	$ini_array = parse_ini_file('depot/depot.ini', true);
	$adress_resolver = $ini_array['DEPOT']['local'];
	if($p_index_last-$p_index_first >20) $app->halt(416); // Si l'écart dans offset est plus grand que 20 alors on fait un 416
	// On va chercher dans le depot local en premier
	$i = $p_index_first;
	$j = $p_index_first;
	while ($i <= $p_index_last) {
		if($j > $p_index_last) break;
		if($system->_get_http_response_code($adress_resolver.'resource/'.$resource.'/o/'.$i.'/'.$i) != "404"){
	    	$context = stream_context_create(array('http' => array('header'=>'Connection: close\r\n')));
	    	$result1 = file_get_contents($adress_resolver.'resource/'.$resource.'/o/'.$i.'/'.$i,false,$context);
	    	$result1 = json_decode($result1, true);
	    	$result = array_merge($result, $result1);
	    	$j++;
	    }
	    if($j > $p_index_last) break;
	    // On va chercher dans les différents depot du resolver par la suite
		foreach($ini_array['RESOLVER HOST'] as $row) {
			$adress_resolver = $row;
			if($system->_get_http_response_code($adress_resolver.'resource/'.$resource.'/o/'.$i.'/'.$i) != "404"){
				$context = stream_context_create(array('http' => array('header'=>'Connection: close\r\n')));
			    $result1 = file_get_contents($adress_resolver.'resource/'.$resource.'/o/'.$i.'/'.$i,false,$context);
			    $result1 = json_decode($result1, true);
			    $result = array_merge($result, $result1);
			    $j++; 
			}
			if($j > $p_index_last) break;
		}
		$i++;
	}
    

	// On traite le resultat
	if($result <> null) echo $system->_filter_json(json_encode($result)); // Envoi de la réponse
	else { // s'il n'y a rien alors on fait un 404
		$app = \Slim\Slim::getInstance();
	    $app->halt(404);
	}

}


function _resolver_resource_all_by_key($resource,$key){
	$app = \Slim\Slim::getInstance();
	$depot_array = parse_ini_file('depot/depot.ini', true);
	if($depot_array['DEPOT']['local'] == "") $app->response->redirect($app->urlFor('install'), 303);
	// initialisation des variables et fonctions
	$system = new System();
	$result = [];

	// Analyse avec sections de depot.ini .
	$ini_array = parse_ini_file('depot/depot.ini', true);
	$adress_resolver = $ini_array['DEPOT']['local'];

	// On va chercher dans le depot local en premier
    if($system->_get_http_response_code($adress_resolver.'resource/'.$resource.'/key/'.$key) != "404"){
    	$context = stream_context_create(array('http' => array('header'=>'Connection: close\r\n')));
    	$result1 = file_get_contents($adress_resolver.'resource/'.$resource.'/key/'.$key,false,$context);
    	$result1 = json_decode($result1, true);
    	$result = array_merge($result, $result1);
    }

    // On va chercher dans les différents depot du resolver par la suite
	foreach($ini_array['RESOLVER HOST'] as $row) {
		$adress_resolver = $row;
		if($system->_get_http_response_code($adress_resolver.'resource/'.$resource.'/key/'.$key) != "404"){
			$context = stream_context_create(array('http' => array('header'=>'Connection: close\r\n')));
		    $result1 = file_get_contents($adress_resolver.'resource/'.$resource.'/key/'.$key,false,$context);
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