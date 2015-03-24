<?php
	class System
	{
		public function _filter_json($string)
		{
			$ini_array = parse_ini_file('depot.ini', true); // ouverture du depot.ini pour aller chercher les correspondances
			$string = str_replace('"_depot":"local"', '"_depot":"'.$ini_array['DEPOT']['local'].'"', $string);
			foreach($ini_array['RESOLVER HOST'] as $key => $value) {
				$string = str_replace('"_depot":"'.$key.'"', '"_depot":"'.$value.'"', $string);
			}
			return $string;
		}

		public function _wiki($array){
			if(isset($array['_api_key_user'])){
				if($array['_api_key_user'] <> ""){
					$array['_api_key_user'] = "true";
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
	}