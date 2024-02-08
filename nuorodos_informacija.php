<?php

	$dir_bendram = realpath ( __DIR__ . '/../../projects/bendram/' ) . '/';
	/*
		echo $dir_bendram; 
		die ( "-- " );
	*/
	include $dir_bendram . 'duomenu_baze.class.php';
	
	$db = new DuomenuBaze ( 'nuorodos7' );
	
	$nuoroda = new stdClass;

	if ( isset ( $_GET [ 'i' ] ) ) {
		
		$id_nuorodos = intval ( $_GET [ 'i' ] );
		
		if ( $id_nuorodos > 0 ) {
		
			$qw_gauti_nuoroda = 
					"
				SELECT * FROM `nuorodos` WHERE `id`=" . $id_nuorodos . "
					";
			if ( $res = $db -> uzklausa ( $qw_gauti_nuoroda ) ) {
			
				$nuoroda = mysqli_fetch_object ( $res );
			}
		}
	}
	echo json_encode ( $nuoroda ); 