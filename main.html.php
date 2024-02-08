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
	<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
	<script>
		$( document ).ready( function() {
		
			$( '#nuorodos_laukeliai' ).hide();
			$( '#pilna_paieska' ).hide();
			
			function nuorodos_duomenu_ivedimo_forma() {

				$( '#nuorodos_laukeliai' ).show();
				$( '#salinti' ).show();
				$( '#saugoti' ).show();
				$( '#ieskoti_detaliai' ).hide();
			}
			
			$( '#pradzia' ).click(  function() {
			
				$( '#pilna_paieska' ).hide();
				$( '#nuorodos_laukeliai' ).hide();
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
			});
			$( '#nauja_nuoroda' ).click( function() {
			
				$( '#nuorodos_duomenys' ).trigger( "reset" );
				$( '#aprasymas' ).html ( '' );
				$( '#id_nuorodos' ).val ( '0' );				
				nuorodos_duomenu_ivedimo_forma();
				$( '#pilna_paieska' ).hide();
			});

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
	<h1>Žymos</h1>
	<a href="?tag=programavimas">programavimas</a>
	, <a href="?tag=filmai">filmai</a>
	, <a href="?tag=rinkodara">rinkodara</a>
	, <a href="?tag=prekės">prekės</a>
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
<form method="POST" action="">
<label>Paieška</label>
<input type="text" name="paieska_pagal">
<input type="submit" id="ieskoti" class="formos_veiksmai" value="Ieškoti">
</form>
</section>
<section id="nuorodos_laukeliai">
<form id="nuorodos_duomenys" method="POST" action="">
<label>Nuoroda</label>
<input type="text" name="nuoroda" id="nuoroda">
<label>Pavadinimas</label>
<input type="text" name="pav" id="pav">
<label>Žymos</label>
<input type="text" name="zymos" id="zymos">
<label>Aprašymas</label>
<textarea name="aprasymas" id="aprasymas"></textarea>
<input type="hidden" name="id_nuorodos" id="id_nuorodos" value="0">
<input type="submit" id="ieskoti_detaliai" name="ieskoti_detaliai" class="formos_veiksmai" value="Ieškoti">
<input type="submit" id="salinti" name="salinti" class="formos_veiksmai" value="Šalinti">
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
</body>
</html>