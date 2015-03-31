<?php

$app->get(    '/peoples/',                   '_peoples_list');         	   // affiche toutes les personnes du depot
$app->get(    '/peoples/:key/',              '_peoples_list_by_key');      // affiche toutes les personnes du depot par clé
$app->get(    '/people/:id/',                '_people_view');              // affiche une personne du depot




function _peoples_list(){
	// Analyse avec sections de core/core.ini .
	$ini_array = parse_ini_file('depot.ini', true);
	$i = 0;
	$system = new System();
	if($dir = opendir('depot/people')){
		while(false !== ($file = readdir($dir))){
			if($file != '.' && $file != '..' && $file != '.DS_Store'){
				$json = file_get_contents("depot/people/$file");
				$result[$i] = $system->_wiki(json_decode($json, true));

				//identifiant resource
				$result[$i]['_api_rsc']['_name'] = 'people';
				$result[$i]['_api_rsc']['_id'] = str_replace('.json', '', $file);
				$result[$i]['_api_rsc']['_depot'] = $ini_array['DEPOT']['local'];

				//suppression _api_key_password
				unset($result[$i]['_api_key_password']);

				//lien api
				$result[$i]['_api_link']['_resolver']['_list']['_url'] = $ini_array['DEPOT']['local'].'resolver/peoples/';
				$result[$i]['_api_link']['_resolver']['_list']['method'] = 'GET';
				$result[$i]['_api_link']['_list']['_url'] = $ini_array['DEPOT']['local'].'peoples/';
				$result[$i]['_api_link']['_list']['_method'] = 'GET';
				$result[$i]['_api_link']['_view']['_url'] = $ini_array['DEPOT']['local'].'people/'.$result[$i]['_api_rsc']['_id'];
				$result[$i]['_api_link']['_view']['_method'] = 'GET';
				$result[$i]['_api_link']['_add']['_url'] = $ini_array['DEPOT']['local'].'people/';
				$result[$i]['_api_link']['_add']['_method'] = 'POST';
				$result[$i]['_api_link']['_edit']['_url'] = $ini_array['DEPOT']['local'].'people/';
				$result[$i]['_api_link']['_edit']['_method'] = 'PUT';
				$result[$i]['_api_link']['_delete']['_url'] = $ini_array['DEPOT']['local'].'people/';
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

function _peoples_list_by_key($key){
	// Analyse avec sections de core/core.ini .
	$ini_array = parse_ini_file('depot.ini', true);
	$i = 0;
	$system = new System();
	if($dir = opendir('depot/people')){
		while(false !== ($file = readdir($dir))){
			if($file != '.' && $file != '..' && $file != '.DS_Store'){
				$json = file_get_contents("depot/people/$file");
				$result1 = json_decode($json, true);		
				if(isset($result1['_api_key_user']) AND $result1['_api_key_user'] == $key){
					$result[$i] = json_decode($json, true);	
					$result[$i] = $system->_wiki(json_decode($json, true));
					
					//identifiant resource
					$result[$i]['_api_rsc']['_name'] = 'people';
					$result[$i]['_api_rsc']['_id'] = str_replace('.json', '', $file);
					$result[$i]['_api_rsc']['_depot'] = $ini_array['DEPOT']['local'];

					//suppression _api_key_password
					unset($result[$i]['_api_key_password']);

					//lien api
					$result[$i]['_api_link']['_resolver']['_list']['_url'] = $ini_array['DEPOT']['local'].'resolver/peoples/';
					$result[$i]['_api_link']['_resolver']['_list']['_method'] = 'GET';
					$result[$i]['_api_link']['_list']['_url'] = $ini_array['DEPOT']['local'].'peoples/';
					$result[$i]['_api_link']['_list']['_method'] = 'GET';
					$result[$i]['_api_link']['_view']['_url'] = $ini_array['DEPOT']['local'].'people/'.$result[$i]['_api_rsc']['_id'];
					$result[$i]['_api_link']['_view']['_method'] = 'GET';
					$result[$i]['_api_link']['_add']['_url'] = $ini_array['DEPOT']['local'].'people/';
					$result[$i]['_api_link']['_add']['_method'] = 'POST';
					$result[$i]['_api_link']['_edit']['_url'] = $ini_array['DEPOT']['local'].'people/';
					$result[$i]['_api_link']['_edit']['_method'] = 'PUT';
					$result[$i]['_api_link']['_delete']['_url'] = $ini_array['DEPOT']['local'].'people/';
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


function _people_view($id){
	$ini_array = parse_ini_file('depot.ini', true);

	//identifiant resource
	$result['_api_rsc']['_name'] = 'people';
	$result['_api_rsc']['_id'] = $id;
	$result['_api_rsc']['_depot'] = $ini_array['DEPOT']['local'];

	//suppression _api_key_password
	unset($result['_api_key_password']);

	//lien api
	$result['_api_link']['_resolver']['_list']['_url'] = $ini_array['DEPOT']['local'].'resolver/peoples/';
	$result['_api_link']['_resolver']['_list']['_method'] = 'GET';
	$result['_api_link']['_list']['_url'] = $ini_array['DEPOT']['local'].'peoples/';
	$result['_api_link']['_list']['_method'] = 'GET';
	$result['_api_link']['_view']['_url'] = $ini_array['DEPOT']['local'].'people/'.$id;
	$result['_api_link']['_view']['_method'] = 'GET';
	$result['_api_link']['_add']['_url'] = $ini_array['DEPOT']['local'].'people/';
	$result['_api_link']['_add']['_method'] = 'POST';
	$result['_api_link']['_edit']['_url'] = $ini_array['DEPOT']['local'].'people/';
	$result['_api_link']['_edit']['_method'] = 'PUT';
	$result['_api_link']['_delete']['_url'] = $ini_array['DEPOT']['local'].'people/';
	$result['_api_link']['_delete']['_method'] = 'DELETE';

	// Traitement resource
	$system = new System();
	$json = file_get_contents("depot/people/$id.json");
	$result1 = $system->_wiki(json_decode($json, true));
	$result = array_merge($result1, $result);
	echo $system->_filter_json(json_encode($result)); // Envoi de la réponse
}

