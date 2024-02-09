<?php
	
	class Nuorodos extends ModelDbSarasas {
	
		public $paieskos_tekstas = '';
		
		public function __construct ( $paieskos_tekstas ) {
		
			parent::__construct();		
		
			$this -> paieskos_tekstas = $paieskos_tekstas;
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