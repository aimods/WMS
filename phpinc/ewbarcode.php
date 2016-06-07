<?php
define("EW_IS_WINDOWS", (strtolower(substr(PHP_OS, 0, 3)) === 'win'), TRUE); // Is Windows OS
define("EW_PATH_DELIMITER", ((EW_IS_WINDOWS) ? "\\" : "/"), TRUE); // Physical path delimiter
define("EW_TMP_IMAGE_FONT", "DejaVuSans", TRUE); // Font for temp files
$encode = @$_GET["encode"];
$barnumber = @$_GET["data"];
$format = @$_GET["format"];
if ($format == "") $format = "png";
$height = @$_GET["height"];
if ($height == "") $height = 0;
$color = @$_GET["color"];
$scale = @$_GET["scale"];
$bgcolor = @$_GET["bgcolor"];
if ($encode == "DATAMATRIX" || $encode == "QRCODE") {
	include_once "tcpdf_barcodes_2d.php";
	$dm = new TCPDF2DBarcode($barnumber, $encode);
	$ar = $dm->getBarcodeArray();
	if ($height == 0) $height = 60; // Default height
	$h = $height / $ar["num_rows"];
	$c = $color ? array(hexdec(substr($color,1,2)), hexdec(substr($color,3,2)), hexdec(substr($color,5,2))) : array(0,0,0);
	$dm->getBarcodePNG($h, $h, $c);
} else {
	include_once "barcode.inc.php";
	$bar = new BARCODE();
	if ($bar == FALSE)
		die($bar->error());
	$font = @$_GET["font"];
	if ($font == "") $font = EW_TMP_IMAGE_FONT;
	$bar->setSymblogy($encode);
	if ($height > 0)
		$bar->setHeight($height);
	if (strrpos($font, '.') === FALSE)
		$font .= '.ttf';
	$font = realpath('../phpfont') . EW_PATH_DELIMITER . $font; // Always use full path
	$bar->setFont($font);
	if ($scale <> "")
		$bar->setScale($scale);
	if ($color <> "" && $bgcolor <> "")
		$bar->setHexColor($color, $bgcolor);
	$return = $bar->genBarCode($barnumber, $format);
	if ($return == FALSE)
		$bar->error(TRUE);
}
?>
