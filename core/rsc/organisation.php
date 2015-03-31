<?php

$app->get(    '/organisations/',                     '_organisations_list');         	  // affiche tous les organisations du depot
$app->get(    '/organisations/:key/',                '_organisations_list_by_key');       // affiche tous les organisation du depot par clé
$app->get(    '/organisation/:id/',                  '_organisation_view');               // affiche une organisation du depot




function _organisations_list(){
	// Analyse avec sections de core/core.ini .
	$ini_array = parse_ini_file('depot.ini', true);
	$i = 0;
	$system = new System();
	if($dir = opendir('depot/organisation')){
		while(false !== ($file = readdir($dir))){
			if($file != '.' && $file != '..' && $file != '.DS_Store'){
				$json = file_get_contents("depot/organisation/$file");
				$result[$i] = $system->_wiki(json_decode($json, true));
				
				//identifiant resource
				$result[$i]['_api_rsc']['_name'] = 'organisation';
				$result[$i]['_api_rsc']['_id'] = str_replace('.json', '', $file);
				$result[$i]['_api_rsc']['_depot'] = $ini_array['DEPOT']['local'];

				//suppression _api_key_password
				unset($result[$i]['_api_key_password']);

				//lien api
				$result[$i]['_api_link']['_resolver']['_list']['_url'] = $ini_array['DEPOT']['local'].'resolver/organisations/';
				$result[$i]['_api_link']['_resolver']['_list']['_method'] = 'GET';
				$result[$i]['_api_link']['_list']['_url'] = $ini_array['DEPOT']['local'].'organisations/';
				$result[$i]['_api_link']['_list']['_method'] = 'GET';
				$result[$i]['_api_link']['_view']['_url'] = $ini_array['DEPOT']['local'].'organisation/'.$result[$i]['_api_rsc']['_id'];
				$result[$i]['_api_link']['_view']['_method'] = 'GET';
				$result[$i]['_api_link']['_add']['_url'] = $ini_array['DEPOT']['local'].'organisation/';
				$result[$i]['_api_link']['_add']['_method'] = 'POST';
				$result[$i]['_api_link']['_edit']['_url'] = $ini_array['DEPOT']['local'].'organisation/'.$result[$i]['_api_rsc']['_id'];
				$result[$i]['_api_link']['_edit']['_method'] = 'PUT';
				$result[$i]['_api_link']['_delete']['_url'] = $ini_array['DEPOT']['local'].'organisation/'.$result[$i]['_api_rsc']['_id'];
				$result[$i]['_api_link']['_delete']['_method'] = 'DELETE';

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

function _organisations_list_by_key($key){
	// Analyse avec sections de core/core.ini .
	$ini_array = parse_ini_file('depot.ini', true);
	$i = 0;
	$system = new System();
	if($dir = opendir('depot/organisation')){
		while(false !== ($file = readdir($dir))){
			if($file != '.' && $file != '..' && $file != '.DS_Store'){
				$json = file_get_contents("depot/organisation/$file");
				$result1 = json_decode($json, true);		
				if(isset($result1['_api_key_user']) AND $result1['_api_key_user'] == $key){
					$result[$i] = json_decode($json, true);	
					$result[$i] = $system->_wiki(json_decode($json, true));

					//identifiant resource
					$result[$i]['_api_rsc']['_name'] = 'organisation';
					$result[$i]['_api_rsc']['_id'] = str_replace('.json', '', $file);
					$result[$i]['_api_rsc']['_depot'] = $ini_array['DEPOT']['local'];

					//suppression _api_key_password
					unset($result[$i]['_api_key_password']);

					//lien api
					$result[$i]['_api_link']['_resolver']['_list']['_url'] = $ini_array['DEPOT']['local'].'resolver/movies/';
					$result[$i]['_api_link']['_resolver']['_list']['_method'] = 'GET';
					$result[$i]['_api_link']['_list']['_url'] = $ini_array['DEPOT']['local'].'organisations/';
					$result[$i]['_api_link']['_list']['_method'] = 'GET';
					$result[$i]['_api_link']['_view']['_url'] = $ini_array['DEPOT']['local'].'organisation/'.$result[$i]['_api_rsc']['_id'];
					$result[$i]['_api_link']['_view']['_method'] = 'GET';
					$result[$i]['_api_link']['_add']['_url'] = $ini_array['DEPOT']['local'].'organisation/';
					$result[$i]['_api_link']['_add']['_method'] = 'POST';
					$result[$i]['_api_link']['_edit']['_url'] = $ini_array['DEPOT']['local'].'organisation/'.$result[$i]['_api_rsc']['_id'];
					$result[$i]['_api_link']['_edit']['_method'] = 'PUT';
					$result[$i]['_api_link']['_delete']['_url'] = $ini_array['DEPOT']['local'].'organisation/'.$result[$i]['_api_rsc']['_id'];
					$result[$i]['_api_link']['_delete']['_method'] = 'DELETE';
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

function _organisation_view($id){
	$ini_array = parse_ini_file('depot.ini', true);
	if (file_exists('depot/organisation/'.$id.'.json')) {

		// Identifiant resource
		$result['_api_rsc']['_name'] = 'organisation';
		$result['_api_rsc']['_id'] = $id;
		$result['_api_rsc']['_depot'] = $ini_array['DEPOT']['local'];

		// Lien api
		$result['_api_link']['_resolver']['_list']['_url'] = $ini_array['DEPOT']['local'].'resolver/organisations/';
		$result['_api_link']['_resolver']['_list']['_method'] = 'GET';
		$result['_api_link']['_list']['_url'] = $ini_array['DEPOT']['local'].'organisations/';
		$result['_api_link']['_list']['_method'] = 'GET';
		$result['_api_link']['_view']['_url'] = $ini_array['DEPOT']['local'].'organisation/'.$result['_api_rsc']['_id'];
		$result['_api_link']['_view']['_method'] = 'GET';
		$result['_api_link']['_add']['_url'] = $ini_array['DEPOT']['local'].'organisation/';
		$result['_api_link']['_add']['_method'] = 'POST';
		$result['_api_link']['_edit']['_url'] = $ini_array['DEPOT']['local'].'organisation/'.$result['_api_rsc']['_id'];
		$result['_api_link']['_edit']['_method'] = 'PUT';
		$result['_api_link']['_delete']['_url'] = $ini_array['DEPOT']['local'].'organisation/'.$result['_api_rsc']['_id'];
		$result['_api_link']['_delete']['_method'] = 'DELETE';

		// Traitement resource
		$system = new System();
		$json = file_get_contents("depot/organisation/$id.json");
		$result1 = $system->_wiki(json_decode($json, true));

		//suppression _api_key_password
		unset($result1['_api_key_password']);

		$result = array_merge($result1, $result);
		echo $system->_filter_json(json_encode($result)); // Envoi de la réponse

	} else {
	    $app = \Slim\Slim::getInstance();
	    $app->halt(404);
	}
	exit;	
}



































