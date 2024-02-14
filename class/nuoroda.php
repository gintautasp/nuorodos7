<?php

	class Nuoroda extends ModelDbIrasas {
	
		public $nuoroda, $pav, $aprasymas, $zymos, $list_zymos = array(), $id;
	
		public function __construct( $nuoroda, $pav, $aprasymas, $zymos, $id = 0 ) {
		
			$this -> nuoroda = $nuoroda;
			$this -> pav = $pav; 
			$this -> aprasymas = $aprasymas;
			$this -> zymos = $zymos;
			
			$this -> list_zymos = array_map ( "trim", explode (',' , $this -> zymos ) );
			$this -> id = $id;
		
			parent::__construct();
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
	
		public function issaugotiDuomenuBazeje() {
		
			if ( intval ( $this -> id ) > 0  ) {
			
				$qw_gauti_nuoroda = 
						"
					SELECT * FROM `nuorodos` WHERE `id`=" . $this -> id . "
						";			
			
				if ( $res = $this -> db -> uzklausa ( $qw_gauti_nuoroda ) ) {
					
					$nuoroda_buvusi = mysqli_fetch_object ( $res );
				}
					
				$list_senos_zymos = array_map ( "trim", explode (',' , $nuoroda_buvusi -> zymos ) );			

				$qw_nuorodos_duomenu_pakeitimas = 
						"
					UPDATE `nuorodos` 
					SET
						`nuoroda`='" . mysqli_real_escape_string ( $this -> db -> ercl_db, $this -> nuoroda ) . "'
						, `pav`='" . mysqli_real_escape_string ( $this -> db -> ercl_db, $this -> pav ) . "'
						, `aprasymas`='" . mysqli_real_escape_string ( $this -> db -> ercl_db, $this -> aprasymas ) . "'
						, `zymos`='" . mysqli_real_escape_string ( $this -> db -> ercl_db, $this -> zymos ) . "'
					WHERE
						`id`=" . $this -> id . "
						";
				if ( 
					$this -> db -> uzklausa ( 
						$qw_nuorodos_duomenu_pakeitimas 
					)
				) {
					// turim sumažinti esamu žymų skaičių - gražinam į pradinę būseną
				

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

					$this -> sukurtiNaujasZymasArbaPadidintiKiekiEsamu ();
				}
						
			} elseif ( intval ( $this -> id ) == 0  )   {
		
				$qw_iterpimas_i_nuorodu_lentele = 
						"
					INSERT INTO `nuorodos` (
						`nuoroda`
						, `pav`
						, `aprasymas`
						, `zymos`
					) VALUES (
						'" . mysqli_real_escape_string ( $this -> db -> ercl_db, $this -> nuoroda ). "'
						, '" . mysqli_real_escape_string ( $this -> db -> ercl_db, $this -> pav ) . "'
						, '" . mysqli_real_escape_string ( $this -> db -> ercl_db, $this -> aprasymas ) . "'
						, '" . mysqli_real_escape_string ( $this -> db -> ercl_db, $this -> zymos ) . "'					
					)
						";

				if ( 
					$this -> db -> uzklausa ( 
						$qw_iterpimas_i_nuorodu_lentele
					)
				) {
					$this -> sukurtiNaujasZymasArbaPadidintiKiekiEsamu ();
				}
			}
		}
	}
?>