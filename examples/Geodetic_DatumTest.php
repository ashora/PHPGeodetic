<?php

include('../classes/Geodetic_Autoloader.php');

$datumNames = '';
while (empty($datumNames)) {
	echo 'Enter Datum Name (or "LIST" to list all): ';
	$datumNames = strtoupper(trim(fgets(STDIN)));

	if ($datumNames == 'EXIT') {
		die();
	}
	if ($datumNames == 'LIST') {
		foreach(Geodetic_Datum::getDatumNames() as $key => $datum) {
   			echo $key , ' => ' , $datum , PHP_EOL;
		}
		$datumNames = '';
	}
}
$datumList = explode(',',$datumNames);


$ref = new Geodetic_Datum();
foreach($datumList as $datum) {
    echo 'Datum: ' , $datum , PHP_EOL;
	try {
	    $ref->setDatum($datum);
	    echo '    Reference Ellipsoid ...................... ' ,
	         $ref->getReferenceEllipsoidName() , PHP_EOL;
	    echo '        Semi-Major Axis (Equatorial Radius) .. ' ,
	         $ref->getReferenceEllipsoid()->getSemiMajorAxis(Geodetic_Distance::KILOMETRES) ,
	         ' ' , Geodetic_Distance::KILOMETRES ,
	         PHP_EOL;
	    echo '        Semi-Minor Axis (Polar Radius) ....... ' ,
	         $ref->getReferenceEllipsoid()->getSemiMinorAxis(Geodetic_Distance::KILOMETRES) ,
	         ' ' , Geodetic_Distance::KILOMETRES ,
	         PHP_EOL;
	    echo '        Flattening ........................... ' ,
	         $ref->getReferenceEllipsoid()->getFlattening() , PHP_EOL;
	    echo '        Inverse Flattening ................... ' ,
	         $ref->getReferenceEllipsoid()->getInverseFlattening() , PHP_EOL;
	    echo '        First Eccentricity ................... ' ,
	         $ref->getReferenceEllipsoid()->getFirstEccentricity() , PHP_EOL;
	    echo '        First Eccentricity Squared ........... ' ,
	         $ref->getReferenceEllipsoid()->getFirstEccentricitySquared() , PHP_EOL;
	    echo '        Second Eccentricity .................. ' ,
	         $ref->getReferenceEllipsoid()->getSecondEccentricity() , PHP_EOL;
	    echo '        Second Eccentricity Squared .......... ' ,
	         $ref->getReferenceEllipsoid()->getSecondEccentricitySquared() , PHP_EOL;

	    echo '    Regions' , PHP_EOL;
	    foreach(Geodetic_Datum::getRegionNamesForDatum($datum) as $region) {
	        echo '        ' , $region , PHP_EOL;
	    }
	    echo '    Default Region ........................... ' , $ref->getRegionName() , PHP_EOL;

	    echo '    Bursa-Wolf Parameters for the Helmert Transformation' , PHP_EOL;
	    echo '        Translation Vectors',PHP_EOL;
	    echo '            X ................................ ' ,
	         $ref->getBursaWolfParameters()->getTranslationVectors()->getX()->getValue(Geodetic_Distance::METRES) ,
	         ' ' , Geodetic_Distance::METRES ,
	         PHP_EOL;
	    echo '            Y ................................ ' ,
	         $ref->getBursaWolfParameters()->getTranslationVectors()->getY()->getValue(Geodetic_Distance::METRES) ,
	         ' ' , Geodetic_Distance::METRES ,
	         PHP_EOL;
	    echo '            Z ................................ ' ,
	         $ref->getBursaWolfParameters()->getTranslationVectors()->getZ()->getValue(Geodetic_Distance::METRES) ,
	         ' ' , Geodetic_Distance::METRES ,
	         PHP_EOL;
	    echo '        Scale Factor ......................... ' ,
	         $ref->getBursaWolfParameters()->getScaleFactor() , ' ppm' , PHP_EOL;
	    echo '        Rotation Matrix' , PHP_EOL;
	    echo '            X ................................ ' ,
	         $ref->getBursaWolfParameters()->getRotationMatrix()->getX()->getValue(Geodetic_Angle::ARCSECONDS) ,
	         ' ' , Geodetic_Angle::ARCSECONDS ,
	         PHP_EOL;
	    echo '            Y ................................ ' ,
	         $ref->getBursaWolfParameters()->getRotationMatrix()->getY()->getValue(Geodetic_Angle::ARCSECONDS) ,
	         ' ' , Geodetic_Angle::ARCSECONDS ,
	         PHP_EOL;
	    echo '            Z ................................ ' ,
	         $ref->getBursaWolfParameters()->getRotationMatrix()->getZ()->getValue(Geodetic_Angle::ARCSECONDS) ,
	         ' ' , Geodetic_Angle::ARCSECONDS ,
	         PHP_EOL;
	} catch (Exception $e) {
		echo $e->getMessage();
	}

    echo PHP_EOL;
}

