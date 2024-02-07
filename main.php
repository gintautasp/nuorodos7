<?php

	/*
	nuorodų sistema patikrink ar vartotojas atsiuntė naują nuorodą
	
		jei atsiuntė naują nuorodą tai nuorodu sistema išsaugok ją
		
	nuorodų sistema patikrink ar vartotojas atsiuntė pakoreguota esamą nuorodą ir jos duomenis
	
		jei atsiuntė pakoreguota esamą nuorodą ir jos duomenis, nuorodu sistema  išsaugok naujus nuorodos duomenis
		
	nuorodų sistema patikrink ar vartotojas nurodė pašalinti nuorodą
	
		jei nurodė tai nuorodų sistema pašalink nuorodą
		
	nuorodų sistema patikrink ar vartotojas uždavė paieškos kriterijus
	
		jei uždavė tai 
		
			nuorodų sistema pasiimk paieškos kriterijus
		
			nuorodu sistema atrink nuorodas pagal paieškos kriterijus
		
		jei neuždavė

			nuorodų sistema pasiimk pradinį nuorodų sarašą
	*/
	$dir_bendram = realpath ( __DIR__ . '/../bendram' ) . '/';
	
	include $dir_bendram . 'duomenu_baze.class.php';
	
	$db = new DuomenuBaze ( 'nuorodos7' );
	
	include $dir_bendram . 'model_db.class.php';
	include $dir_bendram . 'model_db_irasas.class.php';
	include 'class/nuoroda.php';	
	
	include $dir_bendram . 'controller.class.php';
	include 'class/nuorodu_sistema.php';
	
	$nuorodu_sistema = new NuoroduSistema();
	
	$nuorodu_sistema -> tikrintiUzklausuDuomenis();
	
	if ( $nuorodu_sistema -> arAtsiustaNaujaNuoroda() ) {
	
		// die ( "nuoroda atsiųsta" );
	
		$nuorodu_sistema -> issaugotiNuoroda();
	}
	
	if ( $nuorodu_sistema -> arAtsiustaPakoreguotaNuoroda() ) {
	
		$nuorodu_sistema -> issaugotiNuoroda();
	}

	if ( $nuorodu_sistema -> arNurodytaSalinamaNuoroda() ) {
	
		$nuorodu_sistema -> pasalintiNuoroda();
	}
	
	$nuorodu_sistema -> gautiDuomenis();
	
	include 'main.html.php';
		