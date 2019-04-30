<?php include 'inc/db.inc.php'; ?>
	
<!DOCTYPE html>
<html lang="de">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Wasserqualität</title>

	<link rel="stylesheet" href="/templates/t3_bs3_blank/css/bootstrap.css" />
	<link rel="stylesheet" href="css/wasser.css" />

	<script src="js/jquery-1.12.1.min.js"></script>
	<script src="js/bowser.min.js"></script>
	<script src="js/js.cookie.js"></script>
	<script src="js/jquery.total-storage.min.js"></script>
	<script src="js/functions.js"></script>
	<script>
				
		jQuery().ready(function() {
			window.location = "wasser-ie8.php";
			//if (bowser.msie && bowser.version <= 9 || bowser.safari) window.location = "wasser-ie8.php";
		});
		
		/*
		*	beim ersten aufruf im browser werden die ganzen daten (JSON) via AJAX (getJSON.php) geladen.
		*	das ganze JSON wird im browser auf LOCALSTORAGE gespeichert, gleichzeitig wird
		*	ein cookie gespeichert das nach 30 tagen abläuft. wenn cookie nicht mehr gültig ist,
		*	wird das ganze JSON-PACKET neu via AJAX geladen und wieder auf LOCALSTORAGE gespeichert.
		*/
		
		var data;
		
		jQuery(document).ready(function() {
														
			data = jQuery.totalStorage('wasserData');

			// falls noch keine daten in localstorage sind oder das cookie expired ist
			if ( data==null || Cookies.get('wasser')==undefined ) {	
					
				jQuery.ajax({
					type:			'POST',
					dataType:		'json',
					timeout: 		60000,
					url:			'/app-wasser/getJSON.php',
					success:		function(d) {
						data = d;
						if ( isMobile()==false ) {
							jQuery.totalStorage('wasserData', data);
							Cookies.set('wasser', Date(), {expires: 30, path: '/'});
						}
						console.log('lade json von php');
						//console.log(data);
						start();
					},
					error: 			function(e) {
						console.log('error');
						console.log(e);				
					}
				});

			} else {

				console.log('laden json von localstorage');
				//console.log(data);
				start();

			}

		});
		
		
		function start() {
			// as soon as everything is ready, fadeIn the container
			jQuery('#container').fadeIn(1000);
			
			var opt_strasse = jQuery('.opt_strasse');
			var selected_strasse = 'empty';
			
			var opt_haus_nr = jQuery('.opt_haus_nr');
			var selected_haus_nr = 'empty';
		
			// strasse into groups
			var group_strasse = [];
			
			var haus_nummern = [];
						
			jQuery.each(data, function(index, val){
				if ( jQuery.inArray(val.strasse, group_strasse)==-1) {
					group_strasse.push(val.strasse);
				}
			});
			
			// sort this array alphabetically
			group_strasse.sort(stringComparison);
			
			// create option-nodes
			jQuery.each(group_strasse, function(index, val) {
				var opt = "<option value='" + val + "'>" + val + "</option>";
				opt_strasse.append(opt);
			});
		
			opt_strasse.on('change', function() {
				selected_strasse = this.value;	
				updateHausNr(selected_strasse);
				fade_out();
			});
			
			
			function updateHausNr( v ) {
				
				haus_nummern = [];
				
				//remove first all entries except firs
				jQuery('.opt_haus_nr option:not(:first)').remove();

				
				jQuery.each(data, function(index, val) {
					if (val.strasse==v) {
						haus_nummern.push( val.haus_nr );
					}
				})
				haus_nummern.sort();
				
				jQuery.each(haus_nummern, function(index, val) {
					var opt = "<option value='" + val + "'>" + val + "</option>";
					opt_haus_nr.append(opt);
				});
			}
		
			opt_haus_nr.on('change', function() {
				selected_haus_nr = this.value;
				renderResult();
			});
			
			function renderResult() {
				var result = data.filter(function(e) {
					if ( e.strasse==selected_strasse && e.haus_nr==selected_haus_nr ) {
						jQuery('.objekt').html( e.strasse +" "+ e.haus_nr +"<br />"+ e.gemeinde);
						jQuery('.link').attr('href', e.link );
						jQuery('.assekuranz_nr').text( e.assekuranz_nr );
						jQuery('.druckzone').text( e.druckzone );
						jQuery('.druckangabe').text( e.druckangabe );
						jQuery('.druckschwankungen_netz').text( e.druckschwankungen_netz );
						jQuery('.wasserhaerte').text( e.wasserhaerte );
						jQuery('.calzium_gehalt').text( e.calzium_gehalt );
						jQuery('.magnesium_gehalt').text( e.magnesium_gehalt );
						jQuery('.sulfat_gehalt').text( e.sulfat_gehalt );
						jQuery('.nitrat_gehalt').text( e.nitrat_gehalt );
						jQuery('.natrium_gehalt').text( e.natrium_gehalt );
						jQuery('.trinkwasser').text( e.trinkwasser );
						jQuery('.herkunft').text( e.herkunft );
						jQuery('.aufbereitung').text( e.aufbereitung );
						jQuery('.hinweis').text( e.hinweis );
						jQuery('.hinweis_reglement').text( e.hinweis_reglement );
												
						fade_in();
					} else {
						// console.log('%%%%%%%');
					}
				})
			}
			function fade_out() {
				jQuery('.result').animate({ opacity:0 });
			}
			function fade_in() {
				jQuery('.result').animate({ opacity:1 });
			}
		}
		
	</script>

</head>
<body>
	
	<div id="container">

		<select name="strasse" class="opt_strasse" size="1">
			<option value="empty" selected="selected">Strasse wählen...</option>
		</select>
		<br class="visible-xs"/><br class="visible-xs"/>
		<select name="nr" class="opt_haus_nr" size="1">
			<option value="empty" selected="selected">Hausnummer wählen...</option>
		</select>
		
		<div class="result">
			<p class="h1_schwarz">Ihre Wasserqualität</p>
			<table class="table standardtext">
				<tbody>
					<tr>
						<td class="col-xs-12 col-sm-3" style="width:170px;">Objekt:</td>
						<td class="col-xs-12 col-sm-9">
							<span class="objekt"></span>
							<br />
							<a target="_blank" class="link" href="#">>> Objekt auf Karte anzeigen</a>
						</td>
					</tr>
					<tr>
						<td class="col-xs-12 col-sm-3">Assekuranz Nummer:</td>
						<td class="col-xs-12 col-sm-9 assekuranz_nr"></td>
					</tr>
					<tr>
						<td class="col-xs-12 col-sm-3">Druckzone:</td>
						<td class="col-xs-12 col-sm-9 druckzone"></td>
					</tr>
					<tr>
						<td class="col-xs-12 col-sm-3" style="word-spacing:-2px;">Druckangabe (Überlaufkote Reservoir):</td>
						<td class="col-xs-12 col-sm-9 druckangabe"></td>
					</tr>
					<tr>
						<td class="col-xs-12 col-sm-3">Druckschwankungen Netz:</td>
						<td class="col-xs-12 col-sm-9 druckschwankungen_netz"></td>
					</tr>
					<tr>
						<td class="col-xs-12 col-sm-3">Wasserhärte:</td>
						<td class="col-xs-12 col-sm-9 wasserhaerte"></td>
					</tr>
					<tr>
						<td class="col-xs-12 col-sm-3">Calzium Gehalt:</td>
						<td class="col-xs-12 col-sm-9 calzium_gehalt"></td>
					</tr>
					<tr>
						<td class="col-xs-12 col-sm-3">Magnesium Gehalt:</td>
						<td class="col-xs-12 col-sm-9 magnesium_gehalt"></td>
					</tr>
					<tr>
						<td class="col-xs-12 col-sm-3">Sulfat Gehalt:</td>
						<td class="col-xs-12 col-sm-9 sulfat_gehalt"></td>
					</tr>
					<tr>
						<td class="col-xs-12 col-sm-3">Natrium Gehalt:</td>
						<td class="col-xs-12 col-sm-9 natrium_gehalt"></td>
					</tr>
					<tr>
						<td class="col-xs-12 col-sm-3">Nitrat Gehalt:</td>
						<td class="col-xs-12 col-sm-9 nitrat_gehalt"></td>
					</tr>
					<tr>
						<td class="col-xs-12 col-sm-3">Trinkwasser:</td>
						<td class="col-xs-12 col-sm-9 trinkwasser"></td>
					</tr>
					<tr>
						<td class="col-xs-12 col-sm-3">Herkunft:</td>
						<td class="col-xs-12 col-sm-9 herkunft"></td>
					</tr>
					<tr>
						<td class="col-xs-12 col-sm-3">Aufbereitung:</td>
						<td class="col-xs-12 col-sm-9 aufbereitung"></td>
					</tr>
					<tr>
						<td class="col-xs-12 col-sm-3">Hinweis:</td>
						<td class="col-xs-12 col-sm-9 hinweis"></td>
					</tr>
					<tr>
						<td class="col-xs-12 col-sm-3">Hinweis Reglement:</td>
						<td class="col-xs-12 col-sm-9 hinweis_reglement"></td>
					</tr>
				</tbody>
			</table>
		</div><!-- END .result -->

	</div> <!-- END #container -->

</body>
</html>