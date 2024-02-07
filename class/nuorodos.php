<?php
	
	class Nuorodos extends ModelDbSarasas {
	
		public function gautiSarasaIsDuomenuBazes() {
		
			$qw_pasiimti_nuorodas = 
					"
				SELECT * FROM `nuorodos`
					";
			$res = $this -> db -> uzklausa ( $qw_pasiimti_nuorodas );
			
			while ( $row = mysqli_fetch_assoc ( $res ) ) {
			
				$this -> sarasas[] = $row;
			}
		}	
	}