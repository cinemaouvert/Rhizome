<?php

$app->get(    '/movies/',                    '_movies_list');         	  // affiche tous les films du depot
$app->get(    '/movie/:id',                  '_movie_view');              // affiche un film du depot
$app->post(   '/movie/',                  	 '_movie_add');               // ajoute un film dans le depot 



function _movies_list(){
	// Analyse avec sections de core/core.ini .
	$ini_array = parse_ini_file('depot.ini', true);
	$i = 0;
	if($dir = opendir('depot/movie')){
		while(false !== ($file = readdir($dir))){
			if($file != '.' && $file != '..' && $file != '.DS_Store'){
				$json = file_get_contents("depot/movie/$file");
				$result[$i] = json_decode($json, true);
				
				//identifiant resource
				$result[$i]['api_rsc']['name'] = 'movie';
				$result[$i]['api_rsc']['id'] = str_replace('.json', '', $file);
				$result[$i]['api_rsc']['depot'] = $ini_array['DEPOT']['local'];

				//lien api
				$result[$i]['api_link']['resolver']['list']['url'] = $ini_array['DEPOT']['local'].'resolver/movies/';
				$result[$i]['api_link']['resolver']['list']['method'] = 'GET';
				$result[$i]['api_link']['list']['url'] = $ini_array['DEPOT']['local'].'movies/';
				$result[$i]['api_link']['list']['method'] = 'GET';
				$result[$i]['api_link']['view']['url'] = $ini_array['DEPOT']['local'].'movie/'.$result[$i]['api_rsc']['id'];
				$result[$i]['api_link']['view']['method'] = 'GET';
				$result[$i]['api_link']['add']['url'] = $ini_array['DEPOT']['local'].'movie/';
				$result[$i]['api_link']['add']['method'] = 'POST';
				$result[$i]['api_link']['edit']['url'] = $ini_array['DEPOT']['local'].'movie/';
				$result[$i]['api_link']['edit']['method'] = 'PUT';
				$result[$i]['api_link']['delete']['url'] = $ini_array['DEPOT']['local'].'movie/';
				$result[$i]['api_link']['delete']['method'] = 'DELETE';

				$i++;
			}
		}
	}
	closedir($dir);
	echo json_encode($result); // Envoi de la réponse
}

function _movie_view($id){
	$ini_array = parse_ini_file('depot.ini', true);

	// Identifiant resource
	$result['api_rsc']['name'] = 'movie';
	$result['api_rsc']['id'] = $id;
	$result['api_rsc']['depot'] = $ini_array['DEPOT']['local'];

	// Lien api
	$result['api_link']['resolver']['list']['url'] = $ini_array['DEPOT']['local'].'resolver/movies/';
	$result['api_link']['resolver']['list']['method'] = 'GET';
	$result['api_link']['list']['url'] = $ini_array['DEPOT']['local'].'movies/';
	$result['api_link']['list']['method'] = 'GET';
	$result['api_link']['view']['url'] = $ini_array['DEPOT']['local'].'movie/'.$id;
	$result['api_link']['view']['method'] = 'GET';
	$result['api_link']['add']['url'] = $ini_array['DEPOT']['local'].'movie/';
	$result['api_link']['add']['method'] = 'POST';
	$result['api_link']['edit']['url'] = $ini_array['DEPOT']['local'].'movie/';
	$result['api_link']['edit']['method'] = 'PUT';
	$result['api_link']['delete']['url'] = $ini_array['DEPOT']['local'].'movie/';
	$result['api_link']['delete']['method'] = 'DELETE';

	// Traitement resource
	$json = file_get_contents("depot/movie/$id.json");
	$result1 = json_decode($json, true);
	$system = new System();
	$result1 = $system->_filter_json($result1); // Filtre json
	$result = array_merge($result, $result1);
	echo json_encode($result); // Envoi de la réponse
}

function _movie_add(){

}


































