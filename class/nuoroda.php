<?php

	class Nuoroda extends ModelDbIrasas {
	
		public $nuoroda, $pav, $aprasymas, $zymos, $id;
	
		public function __construct( $nuoroda, $pav, $aprasymas, $zymos, $id = 0 ) {
		
			$this -> nuoroda = $nuoroda;
			$this -> pav = $pav; 
			$this -> aprasymas = $aprasymas;
			$this -> zymos = $zymos;
			$this -> id = $id;
		
			parent::__construct();
		}		
	
		public function issaugotiDuomenuBazeje() {
		
			$this -> db -> uzklausa ( 
					"
				INSERT INTO `nuorodos` (
					`nuoroda`
					`pav`
					`aprasymas`
					`zymos`
				) VALUES (
					'" . $this -> nuoroda. "'
					, '" . $this -> pav . "'
					, '" . $this -> aprasymas . "'
					, '" . $this -> zymos . "'					
				)
					"
			);
		}
	}
?>