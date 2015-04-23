<?php

$app->get(    '/echo/attachment/id/:id/',             			   '_echo_attachment_by_id');          		   // Genere une resource attachment.


function _echo_attachment_by_id($id){
	$app = \Slim\Slim::getInstance();
	$depot_array = parse_ini_file('depot/depot.ini', true);
	if($depot_array['DEPOT']['local'] == "") $app->response->redirect($app->urlFor('install'), 303);
	// initialisation des variables et fonctions
	$system = new System();
	$result = [];

	// Analyse avec sections de depot.ini .
	$ini_array = parse_ini_file('depot/depot.ini', true);
	$adress_resolver = $ini_array['DEPOT']['local'];
	if($system->_get_http_response_code($adress_resolver.'resource/attachment/id/'.$id) != "404"){
    	$context = stream_context_create(array('http' => array('header'=>'Connection: close\r\n')));
    	$result1 = file_get_contents($adress_resolver.'resource/attachment/id/'.$id,false,$context);
    	$result1 = json_decode($result1, true);
    	$result = array_merge($result, $result1);
    }

	// On traite le resultat
	$app->response->headers->set('Content-Type', $result['_api_data']['data_type']);
	if($result <> null){
		$data = base64_decode($result['_api_data']['data']);
		$im = imagecreatefromstring($data);
		header('Content-Type: '.$result['_api_data']['data_type']);
	    imagepng($im);
	    imagedestroy($im);
	} 
	else { // s'il n'y a rien alors on fait un 404
	    $app->halt(404);
	}

}