/**
 * Dient als Comparator für die Methode Array.sort und
 * definiert, wie Characters verglichen werden sollen.
 * Ignoriert Groß- Kleinschreibung und sortiert Umlaute
 * zu den entsprtechenden Selbstlauten.
 * (ä == a, ß == s, usw.)
 * @param a erstes Argument
 * @param b zweites Argument
 * @return  0, wenn beide Argumente gleich sind
 *  	-1, wenn a größer als b ist
 *  	 1, sonst
 */
function stringComparison(a, b)	{
	a = a.toLowerCase();
	a = a.replace(/ä/g,"a");
	a = a.replace(/ö/g,"o");
	a = a.replace(/ü/g,"u");
	a = a.replace(/ß/g,"s");

	b = b.toLowerCase();
	b = b.replace(/ä/g,"a");
	b = b.replace(/ö/g,"o");
	b = b.replace(/ü/g,"u");
	b = b.replace(/ß/g,"s");

	return(a==b)?0:(a>b)?1:-1;
}


/**
* check for mobile device
*/
function isMobile() {
	var counter = 0;
	if ( bowser.mobile==true ) counter++;
	if ( bowser.tablet==true ) counter++;
		
	if ( counter==0 ) {
		//alert("isMobile() " + "false");
		return false;
	} else {
		//alert("isMobile() " + "true");
		return true;
	}
	
}
