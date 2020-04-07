<html>
<head>
	<title></title>
</head>
<body>
 
	<h3>Edit Pelamar</h3>
 
	<a href="/ms_pelamar"> Kembali</a>
	
	<br/>
	<br/>
 
	@foreach($ms_pelamar as $p)
	<form action="/ms_pelamar/update" method="post">
		{{ csrf_field() }}
		<input type="hidden" name="id" value="{{ $p->id }}"> <br/>
		Nama <input type="text" required="required" name="pel_nama" value="{{ $p->pel_nama }}"> <br/>
		<input name="pel_gender" type="radio" value="Laki-Laki" required="required">Laki-Laki</input> <input required="required" name="pel_gender" type="radio" value="Perempuan">Perempuan</input> <br/>
		Email <input type="email" required="required" name="pel_email" value="{{ $p->pel_email }}"> <br/>
		Username <input type="text" required="required" name="pel_username" value="{{ $p->pel_username }}"> <br/>
		Alamat <textarea required="required" name="pel_alamat">{{ $p->pel_alamat }}</textarea> <br/>
		<input type="submit" value="Simpan Data">
	</form>
	@endforeach
		
</body>
</html>