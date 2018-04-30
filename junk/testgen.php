<?php
/*  

Generate test data for shop 

*/


$SKUbase = "WT";
$SKUseperator = "-";

$ranges = array(
	"FP" => array("Flat Pack", "0"),
	"RS" => array("Rigid Standard", "10"),
	"RP" => array("Rigid Premium", "15")
	);

$carcasses = array(
	"BA" => array("Base", "0"),
	"WA" => array("Wall", "2"),
	"CO" => array("Corner", "5"),
	"TA" => array("Tall", "5")
	);

$widths = array(
	"150" => array("150mm", "0"),
	"300" => array("300mm", "0"),
	"400" => array("400mm", "0"),
	"500" => array("500mm", "5"),
	"600" => array("600mm", "5"),
	"700" => array("700mm", "5"),
	"800" => array("800mm", "10"),
	"900" => array("900mm", "10"),
	"1000" => array("1000mm", "10")
	);

$colourRanges = array(
	"CB" => array("Budget", "0"),
	"CS" => array("Standard", "5"),
	"CL" =>	array("Luxary", "10")
	);

$basicPrice = "20";

$products = array(
			0 => array(
				"Type",
				"SKU",
				"Name",
				"Published",
				"Visibility in catalogue",
				"Short description",
				"Tax status",
				"Length (cm)",
				"Width (cm)",
				"Height (cm)",
				"Regular price",
				"Categories"
			)
		);


$descriptionSep = ", "; 
$nameSep = " ";
$catSep = ", "; 

$published = 1;
$visibility = "visible";
$taxStatus = "taxable";
$type = "simple";


foreach ( $ranges as $rangeSKU => $rangeArray ) {

	foreach ( $carcasses as $carcassSKU => $carcassArray ) {

		foreach ( $widths as $widthSKU => $widthArray ) {

			foreach ( $colourRanges as $colourRangeSKU => $colourRangeArray ) {

				$unitSKU = $SKUbase;
				$unitPrice = $basicPrice;
	
				$unitSKU .= $SKUseperator.$rangeSKU;
				$unitPrice += $rangeArray[1];
	
				$unitSKU .= $SKUseperator.$carcassSKU;
				$unitPrice += $carcassArray[1];
			
				$unitSKU .= $SKUseperator.$widthSKU;
				$unitPrice += $widthArray[1];

				$unitSKU .= $SKUseperator.$colourRangeSKU;
				$unitPrice += $colourRangeArray[1];

				$unitDescription = $rangeArray[0].$descriptionSep.$carcassArray[0].$descriptionSep.$widthArray[0].$descriptionSep.$colourRangeArray[0];
				$unitName = $rangeArray[0].$nameSep.$carcassArray[0].$nameSep.$widthArray[0].$nameSep.$colourRangeArray[0];

				$unitWidth = $widthSKU;
				$unitHeight = "950";
				$unitDepth = "600";	
				
				$unitCat = $rangeArray[0].$catSep.$carcassArray[0].$catSep.$widthArray[0].$catSep.$colourRangeArray[0];

				$products[] = array(
						$type,
						$unitSKU,
						$unitName,
						$published,
						$visibility,
						$unitDescription,
						$taxStatus,
						$unitDepth,
						$unitWidth,
						$unitHeight,
						$unitPrice,
						$unitCat
					);

			}
		}

	}
	
}
$fp = fopen('file.csv', 'w');

foreach ($products as $fields) {
    fputcsv($fp, $fields, ',', '"');
}

fclose($fp);

