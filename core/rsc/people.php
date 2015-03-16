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
				$result[$i]['api_rsc']['name'] = 'people';
				$result[$i]['api_rsc']['id'] = str_replace('.json', '', $file);
				$result[$i]['api_rsc']['depot'] = $ini_array['DEPOT']['local'];

				//lien api
				$result[$i]['api_link']['resolver']['list']['url'] = $ini_array['DEPOT']['local'].'resolver/peoples/';
				$result[$i]['api_link']['resolver']['list']['method'] = 'GET';
				$result[$i]['api_link']['list']['url'] = $ini_array['DEPOT']['local'].'peoples/';
				$result[$i]['api_link']['list']['method'] = 'GET';
				$result[$i]['api_link']['view']['url'] = $ini_array['DEPOT']['local'].'people/'.$result[$i]['api_rsc']['id'];
				$result[$i]['api_link']['view']['method'] = 'GET';
				$result[$i]['api_link']['add']['url'] = $ini_array['DEPOT']['local'].'people/';
				$result[$i]['api_link']['add']['method'] = 'POST';
				$result[$i]['api_link']['edit']['url'] = $ini_array['DEPOT']['local'].'people/';
				$result[$i]['api_link']['edit']['method'] = 'PUT';
				$result[$i]['api_link']['delete']['url'] = $ini_array['DEPOT']['local'].'people/';
				$result[$i]['api_link']['delete']['method'] = 'DELETE';

				$i++;
			}
		}
	}
	closedir($dir);
	echo json_encode($result); // Envoi de la réponse
}

function _people_view($id){
	$ini_array = parse_ini_file('depot.ini', true);

	//identifiant resource
	$result['api_rsc']['name'] = 'people';
	$result['api_rsc']['id'] = $id;
	$result['api_rsc']['depot'] = $ini_array['DEPOT']['local'];

	//lien api
	$result['api_link']['resolver']['list']['url'] = $ini_array['DEPOT']['local'].'resolver/peoples/';
	$result['api_link']['resolver']['list']['method'] = 'GET';
	$result['api_link']['list']['url'] = $ini_array['DEPOT']['local'].'peoples/';
	$result['api_link']['list']['method'] = 'GET';
	$result['api_link']['view']['url'] = $ini_array['DEPOT']['local'].'people/'.$id;
	$result['api_link']['view']['method'] = 'GET';
	$result['api_link']['add']['url'] = $ini_array['DEPOT']['local'].'people/';
	$result['api_link']['add']['method'] = 'POST';
	$result['api_link']['edit']['url'] = $ini_array['DEPOT']['local'].'people/';
	$result['api_link']['edit']['method'] = 'PUT';
	$result['api_link']['delete']['url'] = $ini_array['DEPOT']['local'].'people/';
	$result['api_link']['delete']['method'] = 'DELETE';

	// Traitement resource
	$json = file_get_contents("depot/people/$id.json");
	$result1 = json_decode($json, true);
	$result = array_merge($result, $result1);
	echo json_encode($result); // Envoi de la réponse
}

function _people_add(){

}