<?php

	class NuoroduSistema extends Controller {
	
		public $nuoroda, $nuorodos, $id_nuorodos, $saugoti, $ieskoti, $paieskos_tekstas = '';
	
		public function __construct() {
		}
		
		public function tikrintiUzklausuDuomenis() {
		
			$this -> id_nuorodos = isset ( $_POST [ 'id_nuorodos' ] ) ? $_POST [ 'id_nuorodos' ] : -1;
			$this -> saugoti =  isset ( $_POST [ 'saugoti' ] ) ? $_POST [ 'saugoti' ] : 'nesaugoti';
					
			$this -> ieskoti =  isset ( $_POST [ 'ieskoti' ] ) ? $_POST [ 'ieskoti' ] : 'neieškoti';
			
			if ( $this -> ieskoti == 'Ieškoti' ) {
			
				$this -> paieskos_tekstas = $_POST [ 'paieska_pagal' ]; 
			}
		}		
	
		public function arAtsiustaNaujaNuoroda() {
			/*
				echo $id_nuorodos . ' - ' . $saugoti;
				print_r ( $_POST ); 
				die ("---");
			*/
			return ( $this -> id_nuorodos == '0' ) && ( $this -> saugoti == 'Saugoti' );
		}
	
		public function arAtsiustaPakoreguotaNuoroda() {
		
			return ( intval ( $this -> id_nuorodos ) >0 ) && ( $this -> saugoti == 'Saugoti' );		
		}
		
		public function issaugotiNuoroda() {
		
			$nuoroda = $_POST [ 'nuoroda' ];
			$pav = $_POST [ 'pav' ];
			$aprasymas = $_POST [ 'aprasymas' ];
			$zymos = $_POST [ 'zymos' ];
			$id_nuorodos = $_POST [ 'id_nuorodos' ];
			/*
			echo $nuoroda;
			die ("---");
			*/
			$this -> nuoroda = new Nuoroda( $nuoroda, $pav, $aprasymas, $zymos, $id_nuorodos );
			
			$this -> nuoroda -> issaugotiDuomenuBazeje();
		}

		public function arNurodytaSalinamaNuoroda() {
		}
		
		public function pasalintiNuoroda() {
		}
	
		public function arUzduotiPaieskosKriterijai() {
		}
		
		public function gautiDuomenis() {
		
			$this -> nuorodos = new Nuorodos ( $this -> paieskos_tekstas );
			$this -> nuorodos -> gautiSarasaIsDuomenuBazes();
		}
		
		public function pateikti() {
		}		
	}