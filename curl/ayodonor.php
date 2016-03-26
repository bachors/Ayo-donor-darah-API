<?php
####### code by iBacor.com 2016 #######

// Menyembunyikan pesan error karena proses DOM yang tidak sempurna 
error_reporting(0);

function stok_darah($gol_darah = 0, $propinsi = 0, $page = 1){

	// data query untuk mengirim request POST
	$query = '&gol_darah='.$gol_darah.'&propinsi='.$propinsi;

	//# ayocurl('url', 'no page', 'query POST', 'user agent'); ##############################
    $html = ayocurl('http://ayodonor.pmi.or.id/page/stok/', $page, $query);
		
	// Initial ARRAY yang nanti akan dijadikan JSON	
	$rows = array();
	
	if($html == "offline"){
		
		// website yg di curl sedang offline
		$rows['status'] = "offline";
	}else{
		
		// website yg di curl sedang online maka lanjutkan
		$rows['status'] = "online";
		
		// query golongan darah
		$rows['query']['gol_darah'] = $gol_darah;
		
		// query kode propinsi
		$rows['query']['kode_propinsi'] = $propinsi;
		
		// query nomer page
		$rows['query']["page"] = intval($page);
	
		//####################################### START DOM ##############################################
		$dom = new DOMDocument;
		$dom->loadHTML($html);
		
		$i = 0;
		foreach ($dom->getElementsByTagName('tr') as $tr) {
			if($i > 3){
				
				foreach ($tr->getElementsByTagName('td') as $key => $value) {
					if($key == 1){

						// Nama lokasi donor
						$lokasi = str_replace("\t",'', $value->nodeValue);
						$lokasi = str_replace("\n",'', $lokasi);
						$lokasi = str_replace("\r",'', $lokasi);
						$stokdet = explode("stokdet/", $value->getElementsByTagName('a')->item(0)->getAttribute('href'));
						
					}else if($key == 2){
						
						// Golongan darah
						$gol_darah = $value->nodeValue;
						
					}else if($key == 3){
						
						// Jumlah stok darah
						$jum_stok = $value->nodeValue;
						
					}
				}
				
				$cells = array(
							'lokasi' => $lokasi,
							'gol_darah' => $gol_darah,
							'jum_stok' => $jum_stok,
							'detail_id' => $stokdet[1]
						);
				$rows['data'][] = $cells;
			}
			$i++;
		}
		
		// Memasukan data pagging sebelumnya yaitu dengan cara dikurang 10 (kelipatan sepuluh)
		$rows['page']["prev_page"] = ($page <= 1 ? null : $page - 1);
		// Memasukan data pagging selanjutnya yitu dengan cara ditambah 10 (kelipatan sepuluh)
		$next_page = (count($rows["data"]) < 10 ? null : $page + 1);
		// Memasukan data next_page kedalam ARRAY
		$rows['page']["next_page"] = $next_page;
	}
		
	return $rows;
}

function stok_detail($detail_id){

	//# ayocurl('url', 'detail_id'); ##############################
    $html = ayocurl('http://ayodonor.pmi.or.id/page/stokdet/', $detail_id);
		
	// Initial ARRAY yang nanti akan dijadikan JSON	
	$rows = array();
	
	if($html == "offline"){
		
		// website yg di curl sedang offline
		$rows['status'] = "offline";
	}else{
		
		// website yg di curl sedang online maka lanjutkan
		$rows['status'] = "online";
		
		// query berdasarkan detail_id
		$rows['detail_id'] = $detail_id;
	
		//####################################### START DOM ##############################################
		$dom = new DOMDocument;
		$dom->loadHTML($html);
		
		$i = 0;
		foreach ($dom->getElementsByTagName('tr') as $tr) {
			if($i > 0){
				
				foreach ($tr->getElementsByTagName('td') as $key => $value) {
					if($key == 1){
						$produk = str_replace("\t",'', $value->nodeValue);
						$produk = str_replace("\n",'', $produk);
						$produk = str_replace("\r",'', $produk);
						$produk = str_replace(" ",'', $produk);					
					}else if($key == 2){
						$komponen = $value->nodeValue;						
					}else if($key == 3){
						$a_positif = $value->nodeValue;						
					}else if($key == 4){
						$b_positif = $value->nodeValue;						
					}else if($key == 5){
						$ab_positif = $value->nodeValue;						
					}else if($key == 6){
						$o_positif = $value->nodeValue;						
					}else if($key == 7){
						$a_negatif = $value->nodeValue;						
					}else if($key == 8){
						$b_negatif = $value->nodeValue;						
					}else if($key == 9){
						$ab_negatif = $value->nodeValue;						
					}else if($key == 10){
						$o_negatif = $value->nodeValue;						
					}
				}
				
				$cells = array(
							'produk' => $produk,
							'komponen' => $komponen,
							'stok_darah' => array(
								'a_positif' => $a_positif,
								'b_positif' => $b_positif,
								'ab_positif' => $ab_positif,
								'o_positif' => $o_positif,
								'a_negatif' => $a_negatif,
								'b_negatif' => $b_negatif,
								'ab_negatif' => $ab_negatif,
								'o_negatif' => $o_negatif
							)
						);
				$rows['data'][] = $cells;
			}
			$i++;
		}
	}
		
	return $rows;
}

function list_darah(){

	// Run cURL
    $html = ayocurl('http://ayodonor.pmi.or.id/page/stok/');
		
	// Initial ARRAY yang nanti akan dijadikan JSON	
	$rows = array();
	
	if($html == "offline"){
		
		// website yg di curl sedang offline
		$rows['status'] = "offline";
	}else{
		
		// website yg di curl sedang online maka lanjutkan
		$rows['status'] = "online";
	
		//####################################### START DOM ##############################################
		$dom = new DOMDocument;
		$dom->loadHTML($html);
		
		$i = 0;
		foreach ($dom->getElementsByTagName('select') as $select) {
			if($i == 0){
				
				foreach ($select->getElementsByTagName('option') as $option) {			
				
					$rows['data'][] = $option->getAttribute('value');

				}
			}
			$i++;
		}
	}
		
	return $rows;
}

function list_propinsi(){

	// Run cURL
    $html = ayocurl('http://ayodonor.pmi.or.id/page/stok/');
		
	// Initial ARRAY yang nanti akan dijadikan JSON	
	$rows = array();
	
	if($html == "offline"){
		
		// website yg di curl sedang offline
		$rows['status'] = "offline";
	}else{
		
		// website yg di curl sedang online maka lanjutkan
		$rows['status'] = "online";
	
		//####################################### START DOM ##############################################
		$dom = new DOMDocument;
		$dom->loadHTML($html);
		
		$i = 0;
		foreach ($dom->getElementsByTagName('select') as $select) {
			if($i == 1){
				
				foreach ($select->getElementsByTagName('option') as $option) {			
				
					$rows['data'][] = array(
										'propinsi' => str_replace("Pilih Propinsi", "All", $option->nodeValue),
										'kode' => $option->getAttribute('value')
									);

				}
			}
			$i++;
		}
	}
		
	return $rows;
}

function ayocurl($url, $get = "", $post = "", $user_agent = "Googlebot/2.1 (http://www.googlebot.com/bot.html)") {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url.$get);
	
	if(!empty($post)){
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	}
		
	// Gagal ngecURL
    if(!$site = curl_exec($ch)){
		return 'offline';
	}
	
	// Sukses ngecURL
	else{
		return $site;
	}
	
	curl_close($ch);
}
