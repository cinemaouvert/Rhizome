<?php
	class System
	{
		public function _filter_json($string)
		{
			$ini_array = parse_ini_file('depot/depot.ini', true); // ouverture du depot.ini pour aller chercher les correspondances
			$string = str_replace('"_depot":"local"', '"_depot":"'.$ini_array['DEPOT']['local'].'"', $string);
			foreach($ini_array['RESOLVER HOST'] as $key => $value) {
				$string = str_replace('"_depot":"'.$key.'"', '"_depot":"'.$value.'"', $string);
			}
			return $string;
		}

		public function _filter_json_post($string)
		{
			$ini_array = parse_ini_file('depot/depot.ini', true); // ouverture du depot.ini pour aller chercher les correspondances
			$value = str_replace("/", "\/", $ini_array['DEPOT']['local']);
			$string = str_replace('"_depot":"'.$value.'"','"_depot":"local"', $string);
			foreach($ini_array['RESOLVER HOST'] as $key => $value) {
				$value = str_replace("/", "\/", $value);
				$string = str_replace('"_depot":"'.$value.'"', '"_depot":"'.$key.'"', $string);
			}
			return $string;
		}

		public function _wiki($array){
			if(isset($array['_api_key_user'])){
				if($array['_api_key_user'] <> ""){
					
				}
				else{
					$array['_api_key_user'] = "false";
				}
			}
			else{
				$array['_api_key_user'] = "false";
			}
			
			return $array;
		}

		public function _get_http_response_code($url) { // Renvoie le code erreur http d'une url.
			if (filter_var($url, FILTER_VALIDATE_URL)) {
			    $headers = get_headers($url);
		    	return substr($headers[0], 9, 3);
			} else {
			    return '404';
			}    
		}

		public function _rsc_info($adress, $resource, $id){
		    if($this->_get_http_response_code($adress.'resource/'.$resource.'/id/'.$id) != "404"){
		    	$context = stream_context_create(array('http' => array('header'=>'Connection: close\r\n')));
		    	$result = file_get_contents($adress.'resource/'.$resource.'/id/'.$id,false,$context);
		    	$result = json_decode($result, true);
		    	return $result;
		    }
		    else{
		    	return false;
		    }
		}

		public function _write_ini_file($assoc_arr, $path, $has_sections=FALSE) { 
		    $content = ""; 
		    if ($has_sections) { 
		        foreach ($assoc_arr as $key=>$elem) { 
		            $content .= "[".$key."]\n"; 
		            foreach ($elem as $key2=>$elem2) { 
		                if(is_array($elem2)) 
		                { 
		                    for($i=0;$i<count($elem2);$i++) 
		                    { 
		                        $content .= $key2."[] = \"".$elem2[$i]."\"\n"; 
		                    } 
		                } 
		                else if($elem2=="") $content .= $key2." = \n"; 
		                else $content .= $key2." = \"".$elem2."\"\n"; 
		            } 
		        } 
		    } 
		    else { 
		        foreach ($assoc_arr as $key=>$elem) { 
		            if(is_array($elem)) 
		            { 
		                for($i=0;$i<count($elem);$i++) 
		                { 
		                    $content .= $key."[] = \"".$elem[$i]."\"\n"; 
		                } 
		            } 
		            else if($elem=="") $content .= $key." = \n"; 
		            else $content .= $key." = \"".$elem."\"\n"; 
		        } 
		    } 

		    if (!$handle = fopen($path, 'w')) { 
		        return false; 
		    }

		    $success = fwrite($handle, $content);
		    fclose($handle); 

		    return $success; 
		}

		public function _write_php_file($content, $handle){
			$fp = fopen($handle, 'w');
		    $success = fwrite($fp, $content);
		    fclose($fp); 

		    return $success; 
		}

		public function _write_json_file($content, $handle){
			$fp = fopen($handle, 'w');
		    $success = fwrite($fp, $content);
		    fclose($fp); 

		    return $success; 
		}
	}