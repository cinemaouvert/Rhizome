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
	}