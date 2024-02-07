<?php

	class NuoroduSistema extends Controller {
	
		public $nuoroda;
	
		public function __construct() {
		}
		
		public function tikrintiUzklausuDuomenis() {
		}		
	
		public function arAtsiustaNaujaNuoroda() {
		
			$id_nuorodos = isset ( $_POST [ 'id_nuorodos' ] ) ? $_POST [ 'id_nuorodos' ] : -1;
			$saugoti =  isset ( $_POST [ 'saugoti' ] ) ? $_POST [ 'saugoti' ] : 'nesaugoti';
			/*
				echo $id_nuorodos . ' - ' . $saugoti;
				print_r ( $_POST ); 
				die ("---");
			*/
			return ( $id_nuorodos == '0' ) && ( $saugoti == 'Saugoti' );
		}
	
		public function arAtsiustaPakoreguotaNuoroda() {
		}
		
		public function issaugotiNuoroda() {
		
			$nuoroda = $_POST [ 'nuoroda' ];
			$pav = $_POST [ 'pav' ];
			$aprasymas = $_POST [ 'aprasymas' ];
			$zymos = $_POST [ 'zymos' ];
			/*
			echo $nuoroda;
			die ("---");
			*/
			$this -> nuoroda = new Nuoroda( $nuoroda, $pav, $aprasymas, $zymos );
			
			$this -> nuoroda -> issaugotiDuomenuBazeje();
		}

		public function arNurodytaSalinamaNuoroda() {
		}
		
		public function pasalintiNuoroda() {
		}
	
		public function arUzduotiPaieskosKriterijai() {
		}
		
		public function gautiDuomenis() {
		}
		
		public function pateikti() {
		}		
	}