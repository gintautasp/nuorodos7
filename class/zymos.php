<?php

	class Zymos extends ModelDbSarasas {
	
		public $list_zymos = array();
	
		public function __construct( $list_zymos ) {
		
			parent::__construct();		
		
			$this -> list_zymos = $list_zymos;
		}
		
		public function sukurtiNaujasZymasArbaPadidintiKiekiEsamu() {
		
			if ( $this -> list_zymos ) {

				$qw_iterpimas_i_zymu_lentele = 
						"
					INSERT INTO `zymos` (
						`zyma`
					) VALUES (
						'" . implode ( "'), ('", $this -> list_zymos ) . "'
					)
					ON DUPLICATE KEY UPDATE kiek_kartojasi=kiek_kartojasi+1
						";
				/*
					echo $qw_iterpimas_i_zymu_lentele;
					die ( "---" );
				*/							
				$this -> db -> uzklausa ( 
					$qw_iterpimas_i_zymu_lentele
				);
			}
		}		
		
		public function sumazintiBuvusiuPriesRedagavimaZymuKieki( $list_senos_zymos ) {

			$qw_zymu_kiekio_mazinimas =
					"
				UPDATE `zymos` SET `kiek_kartojasi`=`kiek_kartojasi`-1 WHERE `zymos`.`zyma` IN ( '" . implode (  "', '", $list_senos_zymos  ) . "' )
					";
			/*		
					echo $qw_zymu_kiekio_mazinimas;
					die ( "---" );
			*/	
									
			$this -> db -> uzklausa ( 
				$qw_zymu_kiekio_mazinimas
			);
		}
		
		public function gautiSarasaIsDuomenuBazes() {
		
			$qw_pasiimti_zymas = 
					"
				SELECT 
					* 
				FROM 
					`zymos`
				WHERE
					`kiek_kartojasi` > 0
				ORDER BY 
					`kiek_kartojasi` DESC
					";
			/*	
				echo $qw_pasiimti_nuorodas;
				die( '---' );
			*/
			$res = $this -> db -> uzklausa ( $qw_pasiimti_zymas );
			
			while ( $row = mysqli_fetch_assoc ( $res ) ) {
			
				$this -> sarasas[] = $row;
			}		
		}
		
	}