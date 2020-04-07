<html>
<head>
	<title></title>
</head>
<body>
 
	<h3>Data pelamar</h3>
 
	<a href="/ms_pelamar"> Kembali</a>
	
	<br/>
	<br/>
 
	<form action="/ms_pelamar/store" method="post" enctype="multipart/form-data">
		{{ csrf_field() }}
		Nama Pelamar <input type="text" name="pel_nama"> <br/>
		Jenis Kelamin <input name="pel_gender" type="radio" value="Laki-Laki">Laki-Laki</input> <input name="pel_gender" type="radio" value="Perempuan">Perempuan</input> <br/>
		Email Pelamar <input type="email" name="pel_email"> <br/>
		Username <input type="text" name="pel_username"> <br/>
		Alamat Pelamar <textarea name="pel_alamat"></textarea> <br/>
        Image <input type="file" name="pel_image"><br/>
		<input type="submit" value="Simpan Data">
	</form>
		
 
 
</body>
</html>