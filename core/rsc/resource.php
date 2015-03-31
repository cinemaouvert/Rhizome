<?php

$app->get(    '/resource/:resource/',             		 '_resource_list');         	  	  // affiche une liste de ressource du depot
$app->get(    '/resource/:resource/key/:key/',       	 '_resource_list_by_key');            // affiche une liste de ressource sur le depot via une clé utilisateur
$app->get(    '/resource/:resource/id/:id/',             '_resource_view');          		  // affiche une resource sur le depot




function _resource_list($resource){

	$system = new System();
	$result = [];
	$i = 0;
	// Analyse avec sections de depot.ini .
	$ini_array = parse_ini_file('depot/depot.ini', true);
	if(file_exists("depot/$resource")){
		if($dir = opendir("depot/$resource")){
			while(false !== ($file = readdir($dir))){
				if($file != '.' && $file != '..' && $file != '.DS_Store'){
					$depot = $ini_array['DEPOT']['local'];
					$id = str_replace('.json','',$file);
					if($system->_get_http_response_code($depot.'resource/'.$resource.'/id/'.$id) != "404"){
						$context = stream_context_create(array('http' => array('header'=>'Connection: close\r\n')));
					    $result1 = file_get_contents($depot.'resource/'.$resource.'/id/'.$id,false,$context);
					    $result1 = json_decode($result1, true);
					    $result[$i] = $result1;
					    $i++;
					}
				}
			}
		}
		closedir($dir);
		if(isset($result)) echo $system->_filter_json(json_encode($result)); // Envoi de la réponse
		else {
			$app = \Slim\Slim::getInstance();
		    $app->halt(404);
		}
	}
	else {
	    $app = \Slim\Slim::getInstance();
	    $app->halt(404);
	}
	exit(0);

}

function _resource_list_by_key($resource, $key){

	$system = new System();
	$result = [];
	$i = 0;
	// Analyse avec sections de depot.ini .
	$ini_array = parse_ini_file('depot/depot.ini', true);
	if(file_exists("depot/$resource")){
		if($dir = opendir("depot/$resource")){
			while(false !== ($file = readdir($dir))){
				if($file != '.' && $file != '..' && $file != '.DS_Store'){
					$depot = $ini_array['DEPOT']['local'];
					$id = str_replace('.json','',$file);
					if($system->_get_http_response_code($depot.'resource/'.$resource.'/id/'.$id) != "404"){
						$context = stream_context_create(array('http' => array('header'=>'Connection: close\r\n')));
					    $result1 = file_get_contents($depot.'resource/'.$resource.'/id/'.$id,false,$context);
					    $result1 = json_decode($result1, true);
					    if($result1["_api_key_user"] == $key){
					    	$result[$i] = $result1;
					    	$i++;
					    }
					}
				}
			}
		}
		closedir($dir);
		if(isset($result)) echo $system->_filter_json(json_encode($result)); // Envoi de la réponse
		else {
			$app = \Slim\Slim::getInstance();
		    $app->halt(404);
		}
	}
	else {
	    $app = \Slim\Slim::getInstance();
	    $app->halt(404);
	}
	exit(0);

}

function _resource_view($resource, $id){
	if($resource == "attachment") _attachment_view($id);
	else{
		$ini_array = parse_ini_file('depot/depot.ini', true);
		if(file_exists('depot/'.$resource.'/'.$id.'.json')){



			// Traitement resource
			$system = new System();
			$json = file_get_contents("depot/$resource/$id.json");
			$result1 = $system->_wiki(json_decode($json, true));

			// Identifiant resource
			$result['_api_rsc']['_name'] = $resource;
			$result['_api_rsc']['_id'] = $id;
			$result['_api_rsc']['_depot'] = $ini_array['DEPOT']['local'];

			// Lien api
			$result['_api_link']['_view']['_href'] = $ini_array['DEPOT']['local'].'resource/'.$resource.'/id/'.$result['_api_rsc']['_id'];
			$result['_api_link']['_view']['_method'] = 'GET';
			$result['_api_link']['_edit']['_href'] = $ini_array['DEPOT']['local'].'resource/'.$resource.'/id/'.$result['_api_rsc']['_id'];
			$result['_api_link']['_edit']['_method'] = 'PUT';
			if($result1['_api_key_user'] <> "false") $result['_api_link']['_edit']['_require'] = '_api_key_password';
			$result['_api_link']['_delete']['_href'] = $ini_array['DEPOT']['local'].'resource/'.$resource.'/id/'.$result['_api_rsc']['_id'];
			$result['_api_link']['_delete']['_method'] = 'DELETE';
			if($result1['_api_key_user'] <> "false") $result['_api_link']['_delete']['_require'] = '_api_key_password';

			//suppression _api_key_password
			unset($result1['_api_key_password']);

			$result = array_merge($result1, $result);
			echo $system->_filter_json(json_encode($result)); // Envoi de la réponse

		} else {
		    $app = \Slim\Slim::getInstance();
		    $app->halt(404);
		}
		exit(0);
	}
	

}


function _attachment_view($id){
	$ini_array = parse_ini_file('depot/depot.ini', true);

	if (file_exists('depot/attachment/'.$id)) {

		// Identifiant resource
	    $result['_api_rsc']['_name'] = 'attachment';
		$result['_api_rsc']['_id'] = $id;
		$result['_api_rsc']['_depot'] = $ini_array['DEPOT']['local'];

		// Lien vers la ressource
		$result['data'] = base64_encode(file_get_contents('depot/attachment/'.$id));

		echo json_encode($result); // Envoi de la réponse
	} else {
	    $app = \Slim\Slim::getInstance();
	    $app->halt(404);
	}
	exit(0);	
}