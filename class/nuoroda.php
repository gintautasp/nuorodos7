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
		
			if ( intval ( $this -> id ) > 0  ) {

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
				/*
					echo $qw_nuorodos_duomenu_pakeitimas;
					die ( "---" );
				*/					
				$this -> db -> uzklausa ( 
					$qw_nuorodos_duomenu_pakeitimas 
				);						
						
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
				/*
					echo $qw_iterpimas_i_nuorodu_lentele;
					die ( "---" );
				*/
				$this -> db -> uzklausa ( 
					$qw_iterpimas_i_nuorodu_lentele
				);						
			}
		}
	}
?>