<?php

$app->get(    '/attachment/:id',                  '_attachment_view');              // affiche un attachment du depot


function _attachment_view($id){
	$ini_array = parse_ini_file('depot.ini', true);

	if (file_exists('depot/attachment/'.$id)) {

		// Identifiant resource
	    $result['_api_rsc']['_name'] = 'attachment';
		$result['_api_rsc']['_id'] = $id;
		$result['_api_rsc']['_depot'] = $ini_array['DEPOT']['local'];

		// Lien vers la ressource
		$result['href'] = $ini_array['DEPOT']['local'].'depot/attachment/'.$id;

		echo json_encode($result); // Envoi de la réponse
	} else {
	    $app = \Slim\Slim::getInstance();
	    $app->halt(404);
	}
	exit;	
}