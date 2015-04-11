<?php

$app->get(    '/resource/:resource/',             		 			   '_resource_list');         	  	  	// affiche une liste de ressource du depot
$app->get(    '/resource/:resource/key/:key/',       	 			   '_resource_list_by_key');            // affiche une liste de ressource sur le depot via une clé utilisateur
$app->get(    '/resource/:resource/id/:id/',             			   '_resource_view');          		    // affiche une resource sur le depot
$app->get(    '/resource/:resource/history/id/:id',             	   '_resource_history_view');           // affiche une resource sur le depot AVEC l'historique d'édition
$app->get(    '/resource/:resource/search/:search/:value',             '_resource_list_by_search');         // affiche une liste de resource via une recherche sur le depot
$app->post(   '/resource/:resource/',             		 			   '_resource_add');         	  	  	// affiche une liste de ressource du depot


function _resource_list($resource){
	$app = \Slim\Slim::getInstance();
	$depot_array = parse_ini_file('depot/depot.ini', true);
	if($depot_array['DEPOT']['local'] == "") $app->response->redirect($app->urlFor('install'), 303);
	// initialisation des variables et fonctions
	$system = new System();
	$i = 0;

	// Analyse avec sections de depot.ini .
	$ini_array = parse_ini_file('depot/depot.ini', true);

	// On verifie si le dossier/ressource existe puis on affiche les informations
	if(file_exists("depot/$resource")){
		if($dir = opendir("depot/$resource")){
			$list_rsc = glob("depot/$resource/*.json"); // On va chercher toutes les ressources dans le fichier ressource désigné par $ressource
			// on trie la liste de ressource par date plus récente
			usort($list_rsc, function($a, $b) {
			    return filemtime($a) < filemtime($b);
			});
			foreach($list_rsc as &$value) { // On ne garde que l'id de la ressource.
				$value = str_replace("depot/$resource/", "", $value);
				$value = str_replace(".json", "", $value);
			}
			foreach($list_rsc as &$value) { // on  utilise les list d'id de ressource pour contacter l'api et lister les détails de chaque ressource
				$depot = $ini_array['DEPOT']['local'];
				$id = $value;
				if($system->_get_http_response_code($depot.'resource/'.$resource.'/id/'.$id) != "404"){
					$context = stream_context_create(array('http' => array('header'=>'Connection: close\r\n')));
				    $result1 = file_get_contents($depot.'resource/'.$resource.'/id/'.$id,false,$context);
				    $result1 = json_decode($result1, true);
			    	$result[$i] = $result1;
			    	$i++;
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
	$app = \Slim\Slim::getInstance();
	$depot_array = parse_ini_file('depot/depot.ini', true);
	if($depot_array['DEPOT']['local'] == "") $app->response->redirect($app->urlFor('install'), 303);
	// initialisation des variables et fonctions
	$system = new System();
	$i = 0;

	// Analyse avec sections de depot.ini .
	$ini_array = parse_ini_file('depot/depot.ini', true);

	// On verifie si le dossier/ressource existe puis on affiche les informations
	if(file_exists("depot/$resource")){
		if($dir = opendir("depot/$resource")){
			$list_rsc = glob("depot/$resource/*.json"); // On va chercher toutes les ressources dans le fichier ressource désigné par $ressource
			// on trie la liste de ressource par date plus récente
			usort($list_rsc, function($a, $b) {
			    return filemtime($a) < filemtime($b);
			});
			foreach($list_rsc as &$value) { // On ne garde que l'id de la ressource.
				$value = str_replace("depot/$resource/", "", $value);
				$value = str_replace(".json", "", $value);
			}
			foreach($list_rsc as &$value) { // on  utilise les list d'id de ressource pour contacter l'api et lister les détails de chaque ressource
				$depot = $ini_array['DEPOT']['local'];
				$id = $value;
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
	$app = \Slim\Slim::getInstance();
	$depot_array = parse_ini_file('depot/depot.ini', true);
	if($depot_array['DEPOT']['local'] == "") $app->response->redirect($app->urlFor('install'), 303);
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
			// $result['_api_rsc']['_edited_on'] = date ("m/d/Y H:i:s", filemtime("depot/$resource/$id.json"));

			// Lien api
			$result['_api_link']['_view']['_href'] = $ini_array['DEPOT']['local'].'resource/'.$resource.'/id/'.$result['_api_rsc']['_id'];
			$result['_api_link']['_view']['_method'] = 'GET';
			$result['_api_link']['_view_history']['_href'] = $ini_array['DEPOT']['local'].'resource/'.$resource.'/history/id/'.$result['_api_rsc']['_id'];
			$result['_api_link']['_view_history']['_method'] = 'GET';
			$result['_api_link']['_edit']['_href'] = $ini_array['DEPOT']['local'].'resource/'.$resource.'/id/'.$result['_api_rsc']['_id'];
			$result['_api_link']['_edit']['_method'] = 'PUT';
			if($result1['_api_key_user'] <> "false") $result['_api_link']['_edit']['_require'] = '_api_key_password';
			$result['_api_link']['_delete']['_href'] = $ini_array['DEPOT']['local'].'resource/'.$resource.'/id/'.$result['_api_rsc']['_id'];
			$result['_api_link']['_delete']['_method'] = 'DELETE';
			if($result1['_api_key_user'] <> "false") $result['_api_link']['_delete']['_require'] = '_api_key_password';

			$count = count($result1['_api_data']);
			$data = $result1['_api_data'][$count];
			unset($result1['_api_data']);
			//suppression _api_key_password
			unset($result1['_api_key_password']);
			$result1['_api_data'] = $data;

			// fusion et affichage
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
	$app = \Slim\Slim::getInstance();
	$depot_array = parse_ini_file('depot/depot.ini', true);
	if($depot_array['DEPOT']['local'] == "") $app->response->redirect($app->urlFor('install'), 303);
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

function _resource_history_view($resource, $id){
	$app = \Slim\Slim::getInstance();
	$depot_array = parse_ini_file('depot/depot.ini', true);
	if($depot_array['DEPOT']['local'] == "") $app->response->redirect($app->urlFor('install'), 303);
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
			// $result['_api_rsc']['_edited_on'] = date ("m/d/Y H:i:s", filemtime("depot/$resource/$id.json"));

			// Lien api
			$result['_api_link']['_view']['_href'] = $ini_array['DEPOT']['local'].'resource/'.$resource.'/id/'.$result['_api_rsc']['_id'];
			$result['_api_link']['_view']['_method'] = 'GET';
			$result['_api_link']['_view_history']['_href'] = $ini_array['DEPOT']['local'].'resource/'.$resource.'/history/id/'.$result['_api_rsc']['_id'];
			$result['_api_link']['_view_history']['_method'] = 'GET';
			$result['_api_link']['_edit']['_href'] = $ini_array['DEPOT']['local'].'resource/'.$resource.'/id/'.$result['_api_rsc']['_id'];
			$result['_api_link']['_edit']['_method'] = 'PUT';
			if($result1['_api_key_user'] <> "false") $result['_api_link']['_edit']['_require'] = '_api_key_password';
			$result['_api_link']['_delete']['_href'] = $ini_array['DEPOT']['local'].'resource/'.$resource.'/id/'.$result['_api_rsc']['_id'];
			$result['_api_link']['_delete']['_method'] = 'DELETE';
			if($result1['_api_key_user'] <> "false") $result['_api_link']['_delete']['_require'] = '_api_key_password';

			//suppression _api_key_password
			unset($result1['_api_key_password']);

			// fusion et affichage
			$result = array_merge($result1, $result);
			echo $system->_filter_json(json_encode($result)); // Envoi de la réponse
		} else {
		    $app = \Slim\Slim::getInstance();
		    $app->halt(404);
		}
		exit(0);
	}
	
}

function _resource_list_by_search($resource, $search, $value){
	$app = \Slim\Slim::getInstance();
	$depot_array = parse_ini_file('depot/depot.ini', true);
	if($depot_array['DEPOT']['local'] == "") $app->response->redirect($app->urlFor('install'), 303);
	// initialisation des variables et fonctions
	$value_search = $value;
	$system = new System();
	$i = 0;

	// Analyse avec sections de depot.ini .
	$ini_array = parse_ini_file('depot/depot.ini', true);

	if($resource == "attachment"){
		$app = \Slim\Slim::getInstance();
		$app->halt(400);
	}

	// On verifie si le dossier/ressource existe puis on affiche les informations
	if(file_exists("depot/$resource")){
		
		$list_rsc = glob("depot/$resource/*.json"); // On va chercher toutes les ressources dans le fichier ressource désigné par $ressource
		// on trie la liste de ressource par date plus récente
		usort($list_rsc, function($a, $b) {
		    return filemtime($a) < filemtime($b);
		});
		foreach($list_rsc as &$value) { // On ne garde que l'id de la ressource.
			$value = str_replace("depot/$resource/", "", $value);
			$value = str_replace(".json", "", $value);
		}
		foreach($list_rsc as &$value) { // on  utilise les list d'id de ressource pour contacter l'api et lister les détails de chaque ressource
			$depot = $ini_array['DEPOT']['local'];
			$id = $value;
			if($system->_get_http_response_code($depot.'resource/'.$resource.'/id/'.$id) != "404"){
				$context = stream_context_create(array('http' => array('header'=>'Connection: close\r\n')));
			    $result1 = file_get_contents($depot.'resource/'.$resource.'/id/'.$id,false,$context);
			    $result1 = json_decode($result1, true);
			    $count = count($result1['_api_data']);
			    $find = false;
			    // on trie par rapport à search/value
			    if(isset($result1[$search]) and $result1[$search] == $value_search and $find == false){
			    	$result[$i] = $result1;
			    	$i++;
			    	$find = true;
			    }
			    if(isset($result1[$search]) and $result1[$search] == strtoupper($value_search) and $find == false){
			    	$result[$i] = $result1;
			    	$i++;
			    	$find = true;
			    }
			    if(isset($result1[$search]) and $result1[$search] == strtolower($value_search) and $find == false){
			    	$result[$i] = $result1;
			    	$i++;
			    	$find = true;
			    }
			    if(isset($result1[$search]) and $result1[$search] == ucfirst($value_search) and $find == false){
			    	$result[$i] = $result1;
			    	$i++;
			    	$find = true;
			    }
			    if(isset($result1['_api_data'][$search]) and $result1['_api_data'][$search] == $value_search and $find == false){
			    	$result[$i] = $result1;
			    	$i++;
			    	$find = true;
			    }
			    if(isset($result1['_api_data'][$search]) and $result1['_api_data'][$search] == strtoupper($value_search) and $find == false){
			    	$result[$i] = $result1;
			    	$i++;
			    	$find = true;
			    }
			    if(isset($result1['_api_data'][$search]) and $result1['_api_data'][$search] == strtolower($value_search) and $find == false){
			    	$result[$i] = $result1;
			    	$i++;
			    	$find = true;
			    }
			    if(isset($result1['_api_data'][$search]) and $result1['_api_data'][$search] == ucfirst($value_search) and $find == false){
			    	$result[$i] = $result1;
			    	$i++;
			    	$find = true;
			    }
			}
		}
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

function _resource_add($resource){

	$app = \Slim\Slim::getInstance();
	$data = $app->request()->post();
	$depot_array = parse_ini_file('depot/depot.ini', true);
	// initialisation des variables et fonctions
	$system = new System();
	$id = uniqid();
	// On verifie si le dossier/ressource existe puis on affiche les informations
	if(file_exists("depot/$resource")){
		$data = $app->request()->getBody();
		$data = json_decode($data, true);
		$data_cache = $data['_api_data'];
		unset($data['_api_data']);
		$data['_api_data']['1'] = $data_cache;
		$data['_api_data']['1']['_edited_on'] = date("m/d/Y H:i:s");
		$data = $system->_filter_json_post(json_encode($data));
		$system->_write_json_file($data, "depot/$resource/$id.json");
		_resource_view($resource,$id);
	}
	else {
	    $app = \Slim\Slim::getInstance();
	    $app->halt(404);
	}
	exit(0);

}