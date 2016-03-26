<?php

	// include ayodonor.php
	require("curl/ayodonor.php");
	
	// Data
	// Example: http://anu.kom/stok_detail.php?detail_id=3471
	$detail_id = (!empty($_GET["detail_id"]) ? $_GET["detail_id"] : "3471");
	
	// call function and return array print_r($data);	
	// Detail stok komponen darah berdasarkan detail_id
	$data = stok_detail($detail_id);
	
	// JSON
	header('Content-Type: application/json');
	
	// mengijinkan semua host/domain/ip untuk menggunakan data JSON ini bila menggunakan AJAX
	// atau rubah tanda * menjadi domain yg di tentukan
	header('Access-Control-Allow-Origin: *');
	
	// convert array to JSON
	echo preg_replace("/\\\\u([a-f0-9]{4})/e", "_", json_encode($data, JSON_PRETTY_PRINT));
	
?>
