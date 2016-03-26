# Ayo-donor-darah-API
cURL website pmi.or.id and return ARRAY or JSON :)
<h3>Install:</h3>
<pre>// include ayodonor.php
require("curl/ayodonor.php");</pre>
<h3>Example call function and return ARRAY:</h3>
<h4>Menampilkan semua daftar golongan darah untuk query</h4>
<pre>$data = list_darah();</pre>
<h4>Menampilkan semua daftar kode propinsi untuk query</h4>
<pre>$data = list_propinsi();</pre>
<h4>Menampilkan data stok darah berdasarkan golongan darah atau kode propinsi</h4>
<pre>$data = stok_darah($gol_darah, $kode_propinsi, $page);</pre>
<h4>Menampilkan detail stok komponen darah berdasarkan detail_id</h4>
<pre>$data = stok_detail($detail_id);</pre>
<h3>Convert ARRAY to JSON:</h3>
<pre>echo json_encode($data);</pre>
<h3><a href="http://ibacor.com" target="_BLANK">DEMO</a></h3>
