<?php

$app->get(    '/movies/',                    '_movies_list');         	  // affiche tous les films du depot
$app->get(    '/movie/:id',                  '_movie_view');              // affiche un film du depot
$app->post(   '/movie/',                  	 '_movie_add');               // ajoute un film dans le depot 



function _movies_list(){
	// Analyse avec sections de core/core.ini .
	$ini_array = parse_ini_file('depot.ini', true);
	$i = 0;
	$system = new System();
	if($dir = opendir('depot/movie')){
		while(false !== ($file = readdir($dir))){
			if($file != '.' && $file != '..' && $file != '.DS_Store'){
				$json = file_get_contents("depot/movie/$file");
				$result[$i] = $system->_wiki(json_decode($json, true));
				
				//identifiant resource
				$result[$i]['_api_rsc']['_name'] = 'movie';
				$result[$i]['_api_rsc']['_id'] = str_replace('.json', '', $file);
				$result[$i]['_api_rsc']['_depot'] = $ini_array['DEPOT']['local'];

				//lien api
				$result[$i]['_api_link']['_resolver']['_list']['_url'] = $ini_array['DEPOT']['local'].'resolver/movies/';
				$result[$i]['_api_link']['_resolver']['_list']['_method'] = 'GET';
				$result[$i]['_api_link']['_list']['_url'] = $ini_array['DEPOT']['local'].'movies/';
				$result[$i]['_api_link']['_list']['_method'] = 'GET';
				$result[$i]['_api_link']['_view']['_url'] = $ini_array['DEPOT']['local'].'movie/'.$result[$i]['_api_rsc']['_id'];
				$result[$i]['_api_link']['_view']['_method'] = 'GET';
				$result[$i]['_api_link']['_add']['_url'] = $ini_array['DEPOT']['local'].'movie/';
				$result[$i]['_api_link']['_add']['_method'] = 'POST';
				$result[$i]['_api_link']['_edit']['_url'] = $ini_array['DEPOT']['local'].'movie/';
				$result[$i]['_api_link']['_edit']['_method'] = 'PUT';
				$result[$i]['_api_link']['_delete']['_url'] = $ini_array['DEPOT']['local'].'movie/';
				$result[$i]['_api_link']['_delete']['_method'] = 'DELETE';

				$i++;
			}
		}
	}
	closedir($dir);
	echo $system->_filter_json(json_encode($result)); // Envoi de la réponse
}

function _movie_view($id){
	$ini_array = parse_ini_file('depot.ini', true);
	if (file_exists('depot/movie/'.$id.'.json')) {

		// Identifiant resource
		$result['_api_rsc']['_name'] = 'movie';
		$result['_api_rsc']['_id'] = $id;
		$result['_api_rsc']['_depot'] = $ini_array['DEPOT']['local'];
		

		// Lien api
		$result['_api_link']['_resolver']['_list']['_url'] = $ini_array['DEPOT']['local'].'resolver/movies/';
		$result['_api_link']['_resolver']['_list']['_method'] = 'GET';
		$result['_api_link']['_list']['_url'] = $ini_array['DEPOT']['local'].'movies/';
		$result['_api_link']['_list']['_method'] = 'GET';
		$result['_api_link']['_view']['_url'] = $ini_array['DEPOT']['local'].'movie/'.$id;
		$result['_api_link']['_view']['_method'] = 'GET';
		$result['_api_link']['_add']['_url'] = $ini_array['DEPOT']['local'].'movie/';
		$result['_api_link']['_add']['_method'] = 'POST';
		$result['_api_link']['_edit']['_url'] = $ini_array['DEPOT']['local'].'movie/';
		$result['_api_link']['_edit']['_method'] = 'PUT';
		$result['_api_link']['_delete']['_url'] = $ini_array['DEPOT']['local'].'movie/';
		$result['_api_link']['_delete']['_method'] = 'DELETE';

		// Traitement resource
		$system = new System();
		$json = file_get_contents("depot/movie/$id.json");
		$result1 = $system->_wiki(json_decode($json, true));
		$result = array_merge($result1, $result);
		echo $system->_filter_json(json_encode($result)); // Envoi de la réponse

	} else {
	    $app = \Slim\Slim::getInstance();
	    $app->halt(404);
	}
	exit;	
}

function _movie_add(){

}


































