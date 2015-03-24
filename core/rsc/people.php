<?php

$app->get(    '/peoples/',                   '_peoples_list');         	   // affiche toutes les personnes du depot
$app->get(    '/people/:id',                 '_people_view');              // affiche une personne du depot
$app->post(   '/people/',                  	 '_people_add');               // ajoute une personne sur le depot



function _peoples_list(){
	// Analyse avec sections de core/core.ini .
	$ini_array = parse_ini_file('depot.ini', true);
	$i = 0;
	if($dir = opendir('depot/people')){
		while(false !== ($file = readdir($dir))){
			if($file != '.' && $file != '..' && $file != '.DS_Store'){
				$json = file_get_contents("depot/people/$file");
				$result[$i] = json_decode($json, true);

				//identifiant resource
				$result[$i]['_api_rsc']['_name'] = 'people';
				$result[$i]['_api_rsc']['_id'] = str_replace('.json', '', $file);
				$result[$i]['_api_rsc']['_depot'] = $ini_array['DEPOT']['local'];

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
	$system = new System();
	echo $system->_filter_json(json_encode($result)); // Envoi de la réponse
}

function _people_view($id){
	$ini_array = parse_ini_file('depot.ini', true);

	//identifiant resource
	$result['_api_rsc']['_name'] = 'people';
	$result['_api_rsc']['_id'] = $id;
	$result['_api_rsc']['_depot'] = $ini_array['DEPOT']['local'];

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
	$json = file_get_contents("depot/people/$id.json");
	$result1 = json_decode($json, true);
	$result = array_merge($result, $result1);
	$system = new System();
	echo $system->_filter_json(json_encode($result)); // Envoi de la réponse
}

function _people_add(){

}