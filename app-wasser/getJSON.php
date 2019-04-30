<?php include 'inc/db.inc.php'; ?>
<?php		
	
	$sql = "SELECT * FROM `D5_WasserhaerteWEB`";
        $result = dbQuery("SELECT * FROM `D5_WasserhaerteWEB`");
	
	echo "[";
	
	$i = 0;
	while( $row = mysqli_fetch_array($result) ):
		
		if ($i != 0) {
                    echo ",";
                }
                $i++;
		
		$bfsnr						= $row['C_BFSNR'];
		$id							= $row['I_ID'];
		$layername					= formatToValidString( $row['C_LAYERNAME'] );
		$link						= $row['C_LINK'];
		$gemeinde					= formatToValidString( $row['C_GEMEINDE'] );
		$assekuranz_nr				= formatToValidString( $row['C_ASSEKNR'] );
		$strasse					= formatToValidString( $row['C_STRASSE'] );
		$haus_nr					= formatToValidString( $row['C_HAUSNUMMER'] );
		$druckzone					= formatToValidString( $row['C_DRUCKZONE'] );
		$druckangabe				= formatToValidString( $row['C_DRUCKANGABE'] );
		$druckschwankungen_netz		= formatToValidString( $row['C_DRUCKSCHWANKUNGEN_NETZ'] );
		$wasserhaerte				= formatToValidString( $row['C_WASSERHAERTE'] );
		$calzium_gehalt				= formatToValidString( $row['C_CALZIUM_GEHALT'] );
		$magnesium_gehalt			= formatToValidString( $row['C_MAGNESIUM_GEHALT'] );
		$sulfat_gehalt				= formatToValidString( $row['C_SULFAT_GEHALT'] );
		$nitrat_gehalt				= formatToValidString( $row['C_NITRAT_GEHALT'] );
		$natrium_gehalt				= formatToValidString( $row['C_NATRIUM_GEHALT'] );
		$trinkwasser				= formatToValidString( $row['C_TRINKWASSER'] );
 		$herkunft					= formatToValidString( $row['C_HERKUNFT'] );
		$aufbereitung				= formatToValidString( $row['C_AUFBEREITUNG'] );
		$hinweis					= formatToValidString( $row['C_HINWEIS'] );
		$hinweis_reglement			= formatToValidString( $row['C_HINWEIS_REGLEMENT'] );
		
		
		//echo "\t\t\t";		
		echo "{\"bfsnr\":\"$bfsnr\", \"id\":\"$id\", \"layername\":\"$layername\", \"link\":\"$link\", \"gemeinde\":\"$gemeinde\", \"assekuranz_nr\":\"$assekuranz_nr\", \"strasse\":\"$strasse\", \"haus_nr\":\"$haus_nr\", \"druckzone\":\"$druckzone\", \"druckangabe\":\"$druckangabe\", \"druckschwankungen_netz\":\"$druckschwankungen_netz\", \"wasserhaerte\":\"$wasserhaerte\", \"calzium_gehalt\":\"$calzium_gehalt\", \"magnesium_gehalt\":\"$magnesium_gehalt\", \"sulfat_gehalt\":\"$sulfat_gehalt\", \"nitrat_gehalt\":\"$nitrat_gehalt\", \"natrium_gehalt\":\"$natrium_gehalt\", \"trinkwasser\":\"$trinkwasser\", \"herkunft\":\"$herkunft\", \"aufbereitung\":\"$aufbereitung\", \"hinweis\":\"$hinweis\", \"hinweis_reglement\":\"$hinweis_reglement\"}";	
		
		
	endwhile;
	
	echo "]";
?>
<?php
	/*************/
	/* FUNCTIONS */
	/*************/
	function formatToValidString( $s ) {
		$find = array( "\n", "\r" );
		$s = str_replace( $find, "", $s );
		return $s;
	}
?>


