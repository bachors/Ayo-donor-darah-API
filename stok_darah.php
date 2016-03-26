<?php

	// include ayodonor.php
	require("curl/ayodonor.php");
	
	// Data
	// Example: http://anu.kom/stok_darah.php?gol_darah=O+Neg&kode_propinsi=51&page=1
	$gol_darah = (!empty($_GET["gol_darah"]) ? $_GET["gol_darah"] : "0"); // golongan darah 0 == all
	$propinsi = (!empty($_GET["kode_propinsi"]) ? $_GET["kode_propinsi"] : "0"); // kode propinsi 0 == all
	$page = (!empty($_GET["page"]) ? $_GET["page"] : "1");
	
	// call function and return array print_r($data);
	// Menampilkan data stok darah berdasarkan golongan darah atau kode propinsi */
	$data = stok_darah($gol_darah, $propinsi, $page);
	
	// JSON
	header('Content-Type: application/json');
	
	// mengijinkan semua host/domain/ip untuk menggunakan data JSON ini bila menggunakan AJAX
	// atau rubah tanda * menjadi domain yg di tentukan
	header('Access-Control-Allow-Origin: *');
	
	// convert array to JSON
	echo preg_replace("/\\\\u([a-f0-9]{4})/e", "_", json_encode($data, JSON_PRETTY_PRINT));
	
?>
