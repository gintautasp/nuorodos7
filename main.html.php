<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Nuorodų projektas</title>
	<style>
		body {
			background-color: rgb(196,220,175);
		}
		section, menu, aside {
			display: block;
			padding: 7px;
			margin: 7px;
			width: 62%;
			border: 1px solid rgb(185,122,87);
		}
		section:after { 	/* https://stackoverflow.com/questions/16568272/why-doesnt-the-height-of-a-container-element-increase-if-it-contains-floated-el */
			clear: both;
			content: "";
			display: table;			
		}
		.menu_item {
			display: inline-block;
			padding: 7px;
			margin: 7px;		
		}
		aside {
			width: 32%;
			float: right;
		}
		label {
			display: block;
			width: 100%;
			padding: 3px 0;
			margin: 7px 0 3px 0;		
		}
		input[type=text], textarea {
			width: calc( 100% - 6px );
			border: 3px solid black;
			-webkit-border-radius: 4px;
			-moz-border-radius: 4px;
			border-radius: 4px;
			background-color:  rgb(255,241,193);
		}
		.formos_veiksmai, .redaguoti_nuoroda {
			float: right;
			margin: 7px 12px 7px 12px;
			padding: 4px 7px;
			border: 3px solid black;	
			-webkit-border-radius: 4px;
			-moz-border-radius: 4px;
			border-radius: 4px;
			background-color: rgb(255,201,14);
		}
		.redaguoti_nuoroda  {
			margin: 0;
		}
		.menu_item, .menu_item a {
			font-weight: bold;
			color: rgb(185,122,87);
		}
		#salinti {
			background-color: rgb(255,0,0);
		}
		#ieskoti, #ieskoti_detaliai {
			background-color: rgb(0,155,255);
		}
		#saugoti {
			background-color: rgb(25,201,14);
		}
		a {
			text-decoration: none;
		}
		a:hover {
			text-decoration: underline;	
			color: rgb(0,0,0);			
		}
	</style>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">	
	<link rel="stylesheet" href="https://jqueryui.com/resources/demos/style.css">
	<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>	
	<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
	<script>
		$( document ).ready( function() {
		

			// stabdyti_forma = false;		
		
			patvirtinimo_dialogas = $( "#dialog-confirm" ).dialog({
				resizable: false,
				height: "auto",
				width: 400,
				modal: true,
				 autoOpen: false,
				buttons: {
					"Pašalinti nuorodą": function() {
						
						$( "#nuorodos_duomenys" ).submit();
						$( this ).dialog( "close" );
					},
					"Atšaukti": function() {
						$( this ).dialog( "close" );
					}
				}
			});

		
			$( '#nuorodos_laukeliai' ).hide();
			$( '#pilna_paieska' ).hide();
			
			function nuorodos_duomenu_ivedimo_forma() {

				$( '#nuorodos_laukeliai' ).show();
				$( '#salinti' ).show();
				$( '#saugoti' ).show();
				$( '#ieskoti_detaliai' ).hide();
			}
			
			function nuorodos_duomenu_formos_isvalymas() {
			
				$( '#nuorodos_duomenys' ).trigger( "reset" );
				$( '#aprasymas' ).html ( '' );
				$( '#id_nuorodos' ).val ( '0' );
			}				
			
			$( '#pradzia' ).click(  function() {

				$( '#paieska_pagal' ).val( '' );
				$( '#pilnos_paieskos_forma' ).submit();
			});
			
			$( '#paieska_pilna' ).click( function() {
			
				$( '#pilna_paieska' ).show();
				$( '#nuorodos_laukeliai' ).hide();
			});
			$( '#paieska_detali' ).click( function() {
			
				$( '#nuorodos_laukeliai' ).show();
				$( '#salinti' ).hide();
				$( '#saugoti' ).hide();
				$( '#ieskoti_detaliai' ).show();
				$( '#pilna_paieska' ).hide();
				nuorodos_duomenu_formos_isvalymas();
			});
			
			$( '#salinti' ).click( function( e ) {
		
				$( "#salinti_buves_submit" ).val ( 'Šalinti' );
				// var result = confirm( "Ar tikrai norite pašalinti nuorodą?", "Taip", "Ne" );
				patvirtinimo_dialogas.dialog( 'open' );
				
				return false;
			});
			
			$( '#nauja_nuoroda' ).click( function() {

				nuorodos_duomenu_formos_isvalymas();
				nuorodos_duomenu_ivedimo_forma();
				$( '#pilna_paieska' ).hide();
			});
/*			
			$( "#nuorodos_duomenys" ).submit ( function(e) {
				
				return  ! stabdyti_forma;
			});
*/
			$( '.redaguoti_nuoroda' ).each ( function() {
			
				$( this ).click ( function() {
				
					id = $( this ).data ( 'id' );
																						// alert ( 'pasirinkta redaguoti ' + id + ' nuoroda' );
					var jqxhr = $.get( 'nuorodos_informacija.php?i=' +id, function() {
																						// alert( 'sujungimas pavyko' );
					})
					.done ( function( data ) {
					
						nuorodos_informacija = JSON.parse ( data );
						
						$( '#nuoroda' ).val ( nuorodos_informacija.nuoroda );
						$( '#pav' ).val ( nuorodos_informacija.pav );
						$( '#zymos' ).val ( nuorodos_informacija.zymos );
						$( '#aprasymas' ).html ( nuorodos_informacija.aprasymas );
						$( '#id_nuorodos' ).val ( id );
						nuorodos_duomenu_ivedimo_forma();
											
						// alert ( JSON.stringify ( nuorodos_informacija ) );
					})
					.fail ( function() {
						alert ( 'įvyko klaida' );
					});
																						/*.always ( function() { alert ( 'pabaigta' ); }); */
				});
			});
		});
	</script>
</head>
<body>
<header>
<aside>
	<a style="float: right" href="<?= $svetaine ?>">be žymų</a>
	<h1 style="width: 80%">Žymos</h1>
<?php	
		$kablelis = '';

		foreach ( $nuorodu_sistema -> zymos -> sarasas as $zyma ) {
		
?><?= $kablelis ?><a href="?tag=<?= $zyma [ 'zyma' ] ?>"><?= $zyma [ 'zyma' ] . ' (' . $zyma [ 'kiek_kartojasi' ] . ')' ?></a><?php

			$kablelis = ', ';
		}
?>
</aside>
<menu>
	<div class="menu_item">
		<a href="javascript:void(0)" id="pradzia">Pradžia</a>
	</div>
	<div class="menu_item">
		<a href="javascript:void(0)" id="paieska_pilna">Paieška pilna</a>
	</div>
	<div class="menu_item">
		<a href="javascript:void(0)" id="paieska_detali">Paieška detali</a>
	</div>
	<div class="menu_item">
		<a href="javascript:void(0)" id="nauja_nuoroda">Nauja nuoroda</a>
	</div>	
</menu>
</header>
<section id="pilna_paieska">
<form  id="pilnos_paieskos_forma" method="POST" action="">
<label>Paieška</label>
<input type="text" name="paieska_pagal" id="paieska_pagal" value="<?= $nuorodu_sistema -> nuorodos ->paieskos_tekstas ?>">
<input type="submit" id="ieskoti"  name="ieskoti" class="formos_veiksmai" value="Ieškoti">
</form>
</section>
<section id="nuorodos_laukeliai">
<form id="nuorodos_duomenys" method="POST" action="">
<label>Nuoroda</label>
<input type="text" name="nuoroda" id="nuoroda" value="<?= ( ! is_null ( $nuorodu_sistema -> nuorodos -> nuoroda_paieskai ) ? $nuorodu_sistema -> nuorodos -> nuoroda_paieskai -> nuoroda : '' ) ?>">
<label>Pavadinimas</label>
<input type="text" name="pav" id="pav" value="<?= ( ! is_null ( $nuorodu_sistema -> nuorodos -> nuoroda_paieskai  ) ? $nuorodu_sistema -> nuorodos -> nuoroda_paieskai -> pav : '' ) ?>">
<label>Žymos</label>
<input type="text" name="zymos" id="zymos" value="<?= ( ! is_null ( $nuorodu_sistema -> nuorodos -> nuoroda_paieskai  ) ? $nuorodu_sistema -> nuorodos -> nuoroda_paieskai -> zymos : '' ) ?>">
<label>Aprašymas</label>
<textarea name="aprasymas" id="aprasymas"><?= ( ! is_null ( $nuorodu_sistema -> nuorodos -> nuoroda_paieskai  ) ? $nuorodu_sistema -> nuorodos -> nuoroda_paieskai -> aprasymas : '' ) ?></textarea>
<input type="hidden" name="id_nuorodos" id="id_nuorodos" value="0">
<input type="submit" id="ieskoti_detaliai" name="ieskoti_detaliai" class="formos_veiksmai" value="Ieškoti">
<input type="button" id="salinti" class="formos_veiksmai" value="Šalinti">
<input type="hidden" id="salinti_buves_submit" name="salinti" value="Nešalinti">
<input type="submit" id="saugoti" name="saugoti" class="formos_veiksmai" value="Saugoti">
</form>
</section>
<section id="nuorodu_sarasas">
<table>
<?php
	
	foreach ( $nuorodu_sistema -> nuorodos -> sarasas as $nuoroda ) {
?>
	<tr>
		<td><a href="<?= $nuoroda [ 'nuoroda' ] ?>"><?= $nuoroda [ 'pav' ] ?></a></td>
		<td><input type="button" class="redaguoti_nuoroda" data-id="<?= $nuoroda [ 'id' ] ?>" value="redaguoti" class="formos_veiksmai"></td>		
	</tr>
<?php
	}
?>
</table>
</section>
<div id="dialog-confirm" title="Ar pašalinti šią nuorodą?">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>Pasirinkta nuoroda bus pašalinta. Ar tikrai norite tai atlikti?</p>
</div>
</body>
</html>