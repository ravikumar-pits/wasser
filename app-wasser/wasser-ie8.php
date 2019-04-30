<?php 

include 'inc/db.inc.php';

$result = dbQuery("SELECT * FROM `D5_WasserhaerteWEB`");

$i=0;
foreach($result as $val) {
    $data['bfsnr'] = $val['C_BFSNR'];
    $data['id'] = $val['I_ID'];
    $data['layername'] = formatToValidString( $val['C_LAYERNAME']);
    $data['link'] = $val['C_LINK'];
    $data['gemeinde'] = formatToValidString($val['C_GEMEINDE']);
    $data['assekuranz_nr'] = formatToValidString($val['C_ASSEKNR']);
    $data['strasse'] = formatToValidString($val['C_STRASSE']);
    $data['haus_nr'] = formatToValidString($val['C_HAUSNUMMER']);
    $data['druckzone'] = formatToValidString($val['C_DRUCKZONE']);
    $data['druckangabe'] = formatToValidString($val['C_DRUCKANGABE']);
    $data['druckschwankungen_netz'] = formatToValidString($val['C_DRUCKSCHWANKUNGEN_NETZ']);
    $data['wasserhaerte'] = formatToValidString($val['C_WASSERHAERTE']);
    $data['calzium_gehalt'] = formatToValidString($val['C_CALZIUM_GEHALT']);
    $data['magnesium_gehalt'] = formatToValidString($val['C_MAGNESIUM_GEHALT']);
    $data['sulfat_gehalt'] = formatToValidString($val['C_SULFAT_GEHALT']);
    $data['nitrat_gehalt'] = formatToValidString($val['C_NITRAT_GEHALT']);
    $data['natrium_gehalt'] = formatToValidString($val['C_NATRIUM_GEHALT']);
    $data['trinkwasser'] = formatToValidString($val['C_TRINKWASSER']);
    $data['herkunft'] = formatToValidString($val['C_HERKUNFT']);
    $data['aufbereitung'] = formatToValidString($val['C_AUFBEREITUNG']);
    $data['hinweis'] = formatToValidString($val['C_HINWEIS']);
    $data['hinweis_reglement'] = formatToValidString($val['C_HINWEIS_REGLEMENT']);
    
    $formatedArray[] = $data;
    
}

$json = json_encode($formatedArray);

?>

<?php
	/*************/
	/* FUNCTIONS */
	/*************/
	function formatToValidString( $s ) {
		$find = array( "\n", "\r" );
		$s = str_replace( $find, "", $s );
                
                return mb_convert_encoding($s, 'UTF-8', 'UTF-8');
	}
?>
<!DOCTYPE html>
<html lang="de">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Wasserqualität</title>

	<link rel="stylesheet" href="css/wasser-IE8.css" />

	<!-- fix filter-function in IE8 -->
	<!--[if lte IE 8]>
	<script type="text/javascript" src="js/ie8-fixes/es5-shim-master/html5shiv.min.js"></script>
	<script type="text/javascript" src="js/ie8-fixes/es5-shim-master/es5-shim.min.js"></script>
	<script type="text/javascript" src="js/ie8-fixes/es5-shim-master/es5-sham.min.js"></script>
	<![endif]-->

	<script src="js/jquery-1.12.1.min.js" type="text/javascript"></script>
	<script src="js/functions.js" type="text/javascript"></script>
</head>
<body>
	
	<div id="container">
		
		<select name="strasse" class="opt_strasse" size="1">
			<option value="empty" selected="selected">Strasse wählen...</option>
		</select>
		<select name="nr" class="opt_haus_nr" size="1">
			<option value="empty" selected="selected">Hausnummer wählen...</option>
		</select>
	
		<div class="result" style="margin-left:0;">
			<p class="h1_schwarz">Ihre Wasserqualität</p>
			<table class="standardtext">
				<tbody>
					<tr>
						<td style="width:170px;">Objekt:</td>
						<td class="">
							<span class="objekt"></span>
							<br />
							<a target="_blank" class="link" href="#">>> Objekt auf Karte anzeigen</a>
						</td>
					</tr>
					<tr>
						<td>Assekuranz Nummer:</td>
						<td class="assekuranz_nr"></td>
					</tr>
					<tr>
						<td>Druckzone:</td>
						<td class="druckzone"></td>
					</tr>
					<tr>
						<td style="word-spacing:-2px;">Druckangabe (Überlaufkote Reservoir):</td>
						<td class="druckangabe"></td>
					</tr>
					<tr>
						<td>Druckschwankungen Netz:</td>
						<td class="druckschwankungen_netz"></td>
					</tr>
					<tr>
						<td>Wasserhärte:</td>
						<td class="wasserhaerte"></td>
					</tr>
					<tr>
						<td>Calzium Gehalt:</td>
						<td class="calzium_gehalt"></td>
					</tr>
					<tr>
						<td>Magnesium Gehalt:</td>
						<td class="magnesium_gehalt"></td>
					</tr>
					<tr>
						<td>Sulfat Gehalt:</td>
						<td class="sulfat_gehalt"></td>
					</tr>
					<tr>
						<td>Natrium Gehalt:</td>
						<td class="natrium_gehalt"></td>
					</tr>
					<tr>
						<td>Nitrat Gehalt:</td>
						<td class="nitrat_gehalt"></td>
					</tr>
					<tr>
						<td>Trinkwasser:</td>
						<td class="trinkwasser"></td>
					</tr>
					<tr>
						<td>Herkunft:</td>
						<td class="herkunft"></td>
					</tr>
					<tr>
						<td>Aufbereitung:</td>
						<td class="aufbereitung"></td>
					</tr>
					<tr>
						<td>Hinweis:</td>
						<td class="hinweis"></td>
					</tr>
					<tr>
						<td>Hinweis Reglement:</td>
						<td class="hinweis_reglement"></td>
					</tr>
				</tbody>
			</table>
		</div>
	
	</div> <!-- END #container -->
	
	<!-- <img class="loader" src="css/loader.svg" width="198" height="198" alt="loader" /> -->

	<script>
		jQuery(document).ready(function() {
			//jQuery('.loader').fadeIn(300).delay(2000).fadeOut(1000);
			jQuery('#container').delay(500).fadeIn(400);
		});
		
                var data = <?php echo $json; ?>;

		
		jQuery(document).ready(function() {
		
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
						//console.log('%%%%%%%');
					}
				})
			}
			function fade_out() {
				jQuery('.result').animate({ opacity:0 });
			}
			function fade_in() {
				jQuery('.result').animate({ opacity:1 });
			}
		
		});
		
	</script>

</body>
</html>