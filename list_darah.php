<?php

	// include ayodonor.php
	require("curl/ayodonor.php");
	
	// call function and return array print_r($data);
	// Mendapatkan semua daftar golongan darah untuk query
	$data = list_darah();
	
	// JSON
	header('Content-Type: application/json');
	
	// mengijinkan semua host/domain/ip untuk menggunakan data JSON ini bila menggunakan AJAX
	// atau rubah tanda * menjadi domain yg di tentukan
	header('Access-Control-Allow-Origin: *');
	
	// convert array to JSON
	echo preg_replace("/\\\\u([a-f0-9]{4})/e", "_", json_encode($data, JSON_PRETTY_PRINT));
	
?>
