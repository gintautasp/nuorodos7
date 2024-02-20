<?php

	class Nuoroda extends ModelDbIrasas {
	
		public $nuoroda, $pav, $aprasymas, $zymos, $list_zymos = array(), $zymu_sarasas, $id, $nuoroda_buvusi, $list_senos_zymos;
	
		public function __construct( $nuoroda, $pav, $aprasymas, $zymos, $id = 0 ) {
		
			$this -> nuoroda = $nuoroda;
			$this -> pav = $pav; 
			$this -> aprasymas = $aprasymas;
			$this -> zymos = $zymos;

			
			$this -> list_zymos = array_map ( "trim", explode (',' , $this -> zymos ) );
			$this -> zymu_sarasas = new Zymos ( $this -> list_zymos );			
			$this -> id = $id;
		
			parent::__construct();
		}
		
		public function pasiimtiIsDuomenuBazes() {
		
			$qw_gauti_nuoroda = 
					"
				SELECT * FROM `nuorodos` WHERE `id`=" . $this -> id . "
					";			
		
			if ( $res = $this -> db -> uzklausa ( $qw_gauti_nuoroda ) ) {
				
				$this -> nuoroda_buvusi = mysqli_fetch_object ( $res );
			}
				
			$this -> list_senos_zymos = array_map ( "trim", explode (',' , $this -> nuoroda_buvusi -> zymos ) );			
		}
		
		public function pasalinti() {
		
			$this -> pasiimtiIsDuomenuBazes();
			
			$qw_nuorodos_salinimas = 
					"
				DELETE
				FROM 
					`nuorodos` 
				WHERE
					`id`=" . $this -> id . "
					";
			if ( 
				$this -> db -> uzklausa ( 
					$qw_nuorodos_salinimas 
				)
			) {
				// turim sumažinti esamu žymų skaičių - gražinam į pradinę būseną

				$this -> zymu_sarasas -> sumazintiBuvusiuPriesRedagavimaZymuKieki( $this -> list_senos_zymos );			
			}
		}
	
		public function issaugotiDuomenuBazeje() {
		
			if ( intval ( $this -> id ) > 0  ) {
			
				$this -> pasiimtiIsDuomenuBazes();

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

					$this -> zymu_sarasas -> sumazintiBuvusiuPriesRedagavimaZymuKieki( $this -> list_senos_zymos );			

					$this -> zymu_sarasas -> sukurtiNaujasZymasArbaPadidintiKiekiEsamu();
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
					$this -> zymu_sarasas -> sukurtiNaujasZymasArbaPadidintiKiekiEsamu ();
				}
			}
		}
	}
?>