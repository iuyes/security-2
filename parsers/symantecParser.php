<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>nistParser</title>
    </head>

    <body>

	<?php
	error_reporting(0);

	ini_set('memory_limit', '512M'); // 512 Megabyte memory usage 
	ini_set('max_execution_time', 300); //300 seconds timeout time


	$con = mysql_connect('localhost', 'root', '');
	mysql_select_db('security_r2', $con) or die(mysql_error());

	function getScore($url) {

	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, $url);
	    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($curl, CURLOPT_HEADER, 0);
	    curl_setopt($curl, CURLOPT_PROXY, "proxy.van.sap.corp");
	    curl_setopt($curl, CURLOPT_PROXYPORT, 8080);
	    $buffer = curl_exec($curl);
	    curl_close($curl);

	    if (empty($buffer))
		die("Error: cURL buffer empty from: $url");

	    $dom = new DOMDocument;
	    $dom->loadHTML($buffer);

	    $items = $dom->getElementsByTagName('div');

	    $arrays = array();
	    for ($i = 0; $i < $items->length; $i++) {
		//echo "$i:  ".$items->item($i)->nodeValue . "<br>";
		array_push($arrays, explode(" ",$items->item($i)->nodeValue));
	    }
	    var_dump($arrays);

	    //echo trim($items->item(40)->nodeValue);
	}

	$url = 'http://www.symantec.com/security_response/vulnerability.jsp?bid=50922&om_rssid=sr-advisories';
	getScore($url);
	?>
    </body>
</html>