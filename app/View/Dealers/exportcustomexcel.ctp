<?php
/*#for cvs
if (!empty($all))
{
	echo "Dealer_Number, Dealer_BusinessName, Dealer_Address1, Dealer_City, Dealer_State, Dealer_Country, Dealer_Zip, Dealer_Phone, Dealer_Fax, Dealer_Email, Dealer_WebSite, Dealer_Publish, Dealer_Approved\n";
	foreach ($all as $dealerID=>$dealer)
	{
		if (!empty($dealer['Dealer']['phone']) && $dealer['Dealer']['phone']{0} == "+")
		{
			$dealer['Dealer']['phone'] = " ".$dealer['Dealer']['phone'];
		}
		elseif (!empty($dealer['Dealer']['phone']) && is_numeric($dealer['Dealer']['phone']))
		{
			$dealer['Dealer']['phone'] = substr($dealer['Dealer']['phone'],0,2)." ".substr($dealer['Dealer']['phone'],2,3)." ".substr($dealer['Dealer']['phone'], 3);
		}
		if (!empty($dealer['Dealer']['fax']) && is_numeric($dealer['Dealer']['fax']))
		{
			$dealer['Dealer']['fax'] = substr($dealer['Dealer']['fax'],0,2)." ".substr($dealer['Dealer']['fax'],2,3)." ".substr($dealer['Dealer']['fax'], 3);
		}
		elseif (!empty($dealer['Dealer']['fax']) && $dealer['Dealer']['fax']{0} == "+")
		{
			$dealer['Dealer']['fax'] = " ".$dealer['Dealer']['fax'];
		}
		echo '"'.$dealer['Dealer']['dealer_number'].'","'.$dealer['Dealer']['name'].'","'.$dealer['Dealer']['address1'].'","';
		echo $dealer['Dealer']['city'].'","'.$dealer['State']['abbreviation'].'","'.$dealer['Country']['name'].'","';
		echo $dealer['Dealer']['zip'].'","'.$dealer['Dealer']['phone'].'","'.$dealer['Dealer']['fax'].'","';
		echo $dealer['Dealer']['email'].'","'.$dealer['Dealer']['website'].'","'.$dealer['Dealer']['published'].'","';
		echo $dealer['Dealer']['approved'].'"'."\n";
	}
}*/
?>
<?php
#for xls
require_once 'Spreadsheet/Excel/Writer.php';

// Creating a workbook
$workbook = new Spreadsheet_Excel_Writer();

// sending HTTP headers
$workbook->send($fileName);
$workbook->setVersion(8); // Excel 97/2000 version

// Creating a worksheet with all the Dealers' info
$worksheet =& $workbook->addWorksheet('Dealers');

#Bold
$format_bold =& $workbook->addFormat();
$format_bold->setBold();

// The actual data
if (!empty($all))
{
	$worksheet->writeString(0, 0, 'Dealer_Number', $format_bold);
	$worksheet->writeString(0, 1, 'Dealer_BusinessName', $format_bold);
	$worksheet->writeString(0, 2, 'Dealer_Address1', $format_bold);
	$worksheet->writeString(0, 3, 'Dealer_City', $format_bold);
	$worksheet->writeString(0, 4, 'Dealer_State', $format_bold);
	$worksheet->writeString(0, 5, 'Dealer_Country', $format_bold);
	$worksheet->writeString(0, 6, 'Dealer_Zip', $format_bold);
	$worksheet->writeString(0, 7, 'Dealer_RegionNum', $format_bold);
	$worksheet->writeString(0, 8, 'Dealer_Phone', $format_bold);
	$worksheet->writeString(0, 9, 'Dealer_Fax', $format_bold);
	$worksheet->writeString(0, 10, 'Dealer_Email', $format_bold);
	$worksheet->writeString(0, 11, 'Dealer_WebSite', $format_bold);
	$worksheet->writeString(0, 12, 'Custom_Content_Y_N', $format_bold);
	$worksheet->writeString(0, 13, 'More_Than_150_words', $format_bold);
	$worksheet->writeString(0, 14, 'Last_Modified', $format_bold);
	
	$i = 1;
	foreach ($all as $dealerID=>$dealer)
	{
		$count_words = count(str_word_count(strip_tags(strtolower($dealer['Dealer']['about_body'])), 1));
		
		$greater_t = 'N';
		$custom_content = 'N';
		if($count_words > 0)
		{
			$custom_content = 'Y';
			if($count_words >= 150)
			{
				$greater_t = 'Y';
			}	
		}
		
		$worksheet->writeString($i, 0, $dealer['Dealer']['dealer_number']);
		$worksheet->writeString($i, 1, $dealer['Dealer']['name']);
		$worksheet->writeString($i, 2, $dealer['Dealer']['address1']);
		$worksheet->writeString($i, 3, $dealer['Dealer']['city']);
		$worksheet->writeString($i, 4, $dealer['State']['abbreviation']);
		$worksheet->writeString($i, 5, $dealer['Country']['name']);
		$worksheet->writeString($i, 6, $dealer['Dealer']['zip']);
		$worksheet->writeString($i, 7, $dealer['Dealer']['region_num']);
		$worksheet->writeString($i, 8, $dealer['Dealer']['phone']);
		$worksheet->writeString($i, 9, $dealer['Dealer']['fax']);
		$worksheet->writeString($i, 10, $dealer['Dealer']['email']);
		$worksheet->writeString($i, 11, $dealer['Dealer']['website']);
		$worksheet->writeString($i, 12, $greater_t);
		$worksheet->writeString($i, 13, $custom_content);
		$worksheet->writeString($i, 14, $dealer['Dealer']['updated']);
		
		$i++;
	}
}

// Let's send the file
$workbook->close();
	
	/*function escape_data ($data)
	{
	     if (ini_get('magic_quotes_gpc'))
		 {
	     	$data = stripslashes($data);
	     }
	     return ($data);
	}

	$csv_terminated = "\n";
    $csv_separator = ",";
    $csv_enclosed = '"';
    $csv_escaped = "\\";
    $schema_insert = '';
	$out = '';
	$out2 = '';

	if(!empty($all)) {
		$schema_insert .= 'Dealer_Number,Dealer_BusinessName,Dealer_Address1,Dealer_City,Dealer_State,Dealer_Country,Dealer_Zip,Dealer_RegionNum, Dealer_Phone, Dealer_Fax,Dealer_Email,Dealer_WebSite,Dealer_Published,Dealer_Approved'.$csv_terminated;
		foreach ($all as $dealerID=>$dealer) {
			$data = '';
			$data .= $csv_enclosed . $dealer['Dealer']['dealer_number'] . $csv_enclosed . $csv_separator;
			$data .= $csv_enclosed . $dealer['Dealer']['name'] . $csv_enclosed . $csv_separator;
			$data .= $csv_enclosed . $dealer['Dealer']['address1'] . $csv_enclosed . $csv_separator;
			$data .= $csv_enclosed . $dealer['Dealer']['city'] . $csv_enclosed . $csv_separator;
			$data .= $csv_enclosed . $dealer['State']['abbreviation'] . $csv_enclosed . $csv_separator;
			$data .= $csv_enclosed . $dealer['Country']['name'] . $csv_enclosed . $csv_separator;
			$data .= $csv_enclosed . $dealer['Dealer']['zip'] . $csv_enclosed . $csv_separator;
			$data .= $csv_enclosed . $dealer['Dealer']['region_num'] . $csv_enclosed . $csv_separator;
			$data .= $csv_enclosed . $dealer['Dealer']['phone'] . $csv_enclosed . $csv_separator;
			$data .= $csv_enclosed . $dealer['Dealer']['fax'] . $csv_enclosed . $csv_separator;
			$data .= $csv_enclosed . $dealer['Dealer']['email'] . $csv_enclosed . $csv_separator;
			$data .= $csv_enclosed . $dealer['Dealer']['website'] . $csv_enclosed . $csv_separator;
			$data .= $csv_enclosed . $dealer['Dealer']['published'] . $csv_enclosed . $csv_separator;
			$data .= $csv_enclosed . $dealer['Dealer']['approved'] . $csv_enclosed . $csv_separator;
			
			$l = escape_data($data);
	        $schema_insert .= $l;
	        $schema_insert .= $csv_terminated;
		}
		$out = trim(substr($schema_insert, 0, -1));
	    $out .= $csv_terminated;
	}
	if(!empty($dealers_zips)) {
		$schema_insert = $csv_terminated.'Dealer_Number,Zipcode'.$csv_terminated;
		foreach ($dealers_zips as $dealerID=>$dealer)
		{
			$data = '';
			$data .= $csv_enclosed . $dealer['Dealer']['dealer_number'] . $csv_enclosed . $csv_separator;
			$data .= $csv_enclosed . $dealer['dz']['zipcode_id'] . $csv_enclosed . $csv_separator;
			
			$l = escape_data($data);
	        $schema_insert .= $l;
	        $schema_insert .= $csv_terminated;
		}
		$out2 = trim(substr($schema_insert, 0, -1));
	    $out2 .= $csv_terminated;
	}

	header("Content-type: application/vnd.ms-excel");
	header("Content-Length: " . strlen($out.$out2));
	header("Content-Disposition: attachment; filename=$fileName");
	header("Pragma: no-cache");
	header("Expires: 0");
    echo $out.$csv_terminated.$out2;*/
?>
