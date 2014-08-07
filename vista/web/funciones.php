<?php
function slug($string){
	$string = trim($string);    
	$string = str_replace(
	    array('Á', 'À', 'Â', 'Ä'),
	    array('á', 'à', 'ä', 'â'),
	    $string
	);

	$string = str_replace(
	    array('É', 'È', 'Ê', 'Ë'),
	    array('é', 'è', 'ë', 'ê'),
	    $string
	);

	$string = str_replace(
	    array('Í', 'Ì', 'Ï', 'Î'),
	    array('í', 'ì', 'ï', 'î'),
	    $string
	);

	$string = str_replace(
	    array('Ó', 'Ò', 'Ö', 'Ô'),
	    array('ó', 'ò', 'ö', 'ô'),
	    $string
	);

	$string = str_replace(
	    array('Ú', 'Ù', 'Û', 'Ü'),
	    array('ú', 'ù', 'ü', 'û'),
	    $string
	);

	$string = str_replace(
	    array('Ñ', 'Ç', 'Ã±'),
	    array('ñ', 'c', 'n'),
	    $string
	);
	
	return strtolower($string);
    }
?>