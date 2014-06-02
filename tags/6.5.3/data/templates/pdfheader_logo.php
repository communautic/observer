if ( isset($pdf) ) {
	$font = Font_Metrics::get_font("arial", "bold");

if($GLOBALS['STATIONARY'] == 1) {
	$header = $pdf->open_object();
	$w = $pdf->get_width();
	$h = $pdf->get_height();

	$img_w = 482; // 2 inches, in points
	$img_h = 48; // 1 inch, in points -- change these as required

    $pdf->image(CO_PATH_BASE . "/data/".$GLOBALS['HEADERIMG'], "png", 57, 12, $img_w, $img_h);
    
	// Close the object (stop capture)
	$pdf->close_object();
	$pdf->add_object($header, "all");
    }
}