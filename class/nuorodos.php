<?php
	
	class Nuorodos extends ModelDbSarasas {
	
		public $paieskos_tekstas = '', $nuoroda_paieskai = null;
		
		public function __construct ( $paieskos_tekstas,  $nuoroda_paieskai = null ) {
		
			parent::__construct();		
		
			$this -> paieskos_tekstas = $paieskos_tekstas;
			$this -> nuoroda_paieskai = $nuoroda_paieskai;
		}
	
		public function gautiSarasaIsDuomenuBazes() {
		
			$paieskos_nurodymai = '';
			
			if ( $this -> paieskos_tekstas != '' ) {
			
				$paieskos_nurodymai =
						"
					AND (
							`nuoroda` LIKE '%" . $this -> paieskos_tekstas . "%'
						OR
							`pav` LIKE '%" . $this -> paieskos_tekstas . "%'
						OR
							`zymos` LIKE '%" . $this -> paieskos_tekstas . "%'
						OR
							`aprasymas` LIKE '%" . $this -> paieskos_tekstas . "%'
					)
						";
			}
			
			if ( ! is_null ( $this -> nuoroda_paieskai ) ) {
			
				$pradzia_nurodymo = 
						"					
					AND (
						";
				if ( $this -> nuoroda_paieskai -> nuoroda != '' ) {
			
					$paieskos_nurodymai .= $pradzia_nurodymo .
							"
							`nuoroda` LIKE '%" . $this -> nuoroda_paieskai -> nuoroda . "%'
							";
					$pradzia_nurodymo = "OR";
				}
				
				if ( $this -> nuoroda_paieskai -> pav != '' ) {
			
					$paieskos_nurodymai .= $pradzia_nurodymo .
							"
							`pav` LIKE '%" . $this -> nuoroda_paieskai -> pav . "%'
							";
					$pradzia_nurodymo = "OR";							
				}
		
				if ( $this -> nuoroda_paieskai -> zymos != '' ) {
			
					$paieskos_nurodymai .= $pradzia_nurodymo .
							"
							`zymos` LIKE '%" . $this -> nuoroda_paieskai -> zymos . "%'
							";
					$pradzia_nurodymo = "OR";							
				}

				if ( $this -> nuoroda_paieskai -> aprasymas != '' ) {
			
					$paieskos_nurodymai .= $pradzia_nurodymo .
							"
							`aprasymas` LIKE '%" . $this -> nuoroda_paieskai -> aprasymas . "%'
							";
					$pradzia_nurodymo = "OR";							
				}
				if ( $pradzia_nurodymo == "OR" ) {
				
					$paieskos_nurodymai .=
							"
						)
							";
				}
			}			
			
			$qw_pasiimti_nuorodas = 
					"
				SELECT 
					* 
				FROM 
					`nuorodos`
				WHERE
					1
				" .  $paieskos_nurodymai . "
					";
			/*	
			echo $qw_pasiimti_nuorodas;
			die( '---' );
			*/
			$res = $this -> db -> uzklausa ( $qw_pasiimti_nuorodas );
			
			while ( $row = mysqli_fetch_assoc ( $res ) ) {
			
				$this -> sarasas[] = $row;
			}
		}	
	}