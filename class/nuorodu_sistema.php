<?php

	class NuoroduSistema extends Controller {
	
		public $nuoroda = null, $nuoroda_paieskai = null, $nuorodos, $id_nuorodos, $saugoti, $salinti, $ieskoti, $paieskos_tekstas = '', $zymos, $zyma_paieskai = '', $is_formos;
	
		public function __construct() {
		
			$this -> is_formos = new stdClass;
		}
		
		public function tikrintiUzklausuDuomenis() {
		
			$this -> id_nuorodos = isset ( $_POST [ 'id_nuorodos' ] ) ? $_POST [ 'id_nuorodos' ] : -1;
			$this -> saugoti =  isset ( $_POST [ 'saugoti' ] ) ? $_POST [ 'saugoti' ] : 'nesaugoti';
			$this -> salinti =  isset ( $_POST [ 'salinti' ] ) ? $_POST [ 'salinti' ] : 'nesalinti';			
					
			$this -> ieskoti =  isset ( $_POST [ 'ieskoti' ] ) ? $_POST [ 'ieskoti' ] : 'neieškoti';
			
			if ( $this -> ieskoti == 'Ieškoti' ) {
			
				$this -> paieskos_tekstas = $_POST [ 'paieska_pagal' ]; 
			}
			
			$this -> ieskoti_detaliai =  isset ( $_POST [ 'ieskoti_detaliai' ] ) ? $_POST [ 'ieskoti_detaliai' ] : 'neieškoti';
			
			$this -> is_formos -> nuoroda =  isset ( $_POST [ 'nuoroda' ] ) ? $_POST [ 'nuoroda' ] : '';
			$this -> is_formos -> pav =  isset ( $_POST [ 'pav' ] ) ? $_POST [ 'pav' ] : '';
			$this -> is_formos -> aprasymas =  isset ( $_POST [ 'aprasymas' ] ) ? $_POST [ 'aprasymas' ] : '';
			$this -> is_formos -> zymos =  isset ( $_POST [ 'zymos' ] ) ? $_POST [ 'zymos' ] : '';
			
			if ( $this -> ieskoti_detaliai == 'Ieškoti' ) {
	
				$this -> nuoroda_paieskai = new Nuoroda( $this -> is_formos -> nuoroda, $this -> is_formos -> pav, $this -> is_formos -> aprasymas, $this -> is_formos -> zymos, '0' );
			} 

			$this -> zyma_paieskai = isset ( $_GET [ 'tag' ] ) ? $_GET [ 'tag' ] : '';
			
			/*
			print_r ( $_POST );
			die ( "---" );
			*/			
		}		
	
		public function arAtsiustaNaujaNuoroda() {
		
			return ( $this -> id_nuorodos == '0' ) && ( $this -> saugoti == 'Saugoti' );
		}
	
		public function arAtsiustaPakoreguotaNuoroda() {
		
			return ( intval ( $this -> id_nuorodos ) >0 ) && ( $this -> saugoti == 'Saugoti' );		
		}
		
		public function issaugotiNuoroda() {

			$this -> nuoroda = new Nuoroda( $this -> is_formos -> nuoroda, $this -> is_formos -> pav, $this -> is_formos -> aprasymas, $this -> is_formos -> zymos, $this -> id_nuorodos );
			
			$this -> nuoroda -> issaugotiDuomenuBazeje();
		}

		public function arNurodytaSalinamaNuoroda() {
		
			return ( intval ( $this -> id_nuorodos ) > 0 ) && ( $this -> salinti == 'Šalinti' );		
		}
		
		public function pasalintiNuoroda() {
		
			$this -> nuoroda = new Nuoroda( $this -> is_formos -> nuoroda, $this -> is_formos -> pav, $this -> is_formos -> aprasymas, $this -> is_formos -> zymos, $this -> id_nuorodos );
			
			$this -> nuoroda -> pasalinti();			
		}
		
		public function gautiDuomenis() {
		
			$this -> nuorodos = new Nuorodos ( $this -> paieskos_tekstas, $this -> nuoroda_paieskai, $this -> zyma_paieskai );
			$this -> nuorodos -> gautiSarasaIsDuomenuBazes();
			
			$this -> zymos = new Zymos( array() );
			$this -> zymos -> gautiSarasaIsDuomenuBazes();			
		}
		
		public function pateikti() {
		}		
	}