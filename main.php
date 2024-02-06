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
	include 'class/nuorodu_sistema.php';
	
	$nuorodu_sistema = new NuoroduSistema();
	
	if ( $nuorodu_sistema -> patikrinkArAtsiustaNaujaNuoroda() ) {
	
		$nuorodu_sistema -> issaugotiNuoroda();
	}
	
	if ( $nuorodu_sistema -> patikrinkArAtsiustaPakoreguotaNuoroda() ) {
	
		$nuorodu_sistema -> issaugotiNuoroda();
	}

	if ( $nuorodu_sistema -> patikrinkArNurodytaSalinamaNuoroda() ) {
	
		$nuorodu_sistema -> pasalintiNuoroda();
	}
	
	if ( $nuorodu_sistema -> patikrinkArUzduotiPaieskosKriterijai() ) {
	
		$nuorodu_sistema -> pasiimtiPaieskosKriterijus();
		
		$nuorodu_sistema -> atrinkNuorodasPagalPaieskosKriterijus();
		
	} else {
	
		$nuorodu_sistema -> atrinkNuorodas();
	}
	
	include 'main.html.php';
		