<html>
<head>
	<title></title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<style>
.page-item{
    display:display: inline-block;
    padding: 10px;
}
</style>
<body>
	<h3>Data Pelamar</h3>
 
	<a href="/ms_pelamar/tambah"> + Tambah Pegawai Baru</a>
	
	<br/>
	<br/>
 
	<table border="1" cellspacing='0'>
		<tr>
            <th>Photo</th>
			<th>Nama</th>
			<th>Jenis Kelamin</th>
			<th>Email</th>
            <th>Username</th>
			<th>Alamat</th>
			<th>Opsi</th>
		</tr>
		@foreach($ms_pelamar as $p)
		<tr>
            <td><img height="50px" src="/public/uploads/{{ $p->pel_image }}" alt=""></td>
			<td>{{ $p->pel_nama }}</td>
			<!-- <td>{{ $p->pel_gender }}</td>
			<td>{{ $p->pel_email }}</td>
			<td>{{ $p->pel_username }}</td>
			<td>{{ $p->pel_alamat }}</td>
			<td>
				<a href="/ms_pelamar/edit/{{ $p->id }}">Edit</a>
				|
				<a href="/ms_pelamar/hapus/{{ $p->id }}">Hapus</a>
			</td> -->
		</tr>
		@endforeach
	</table>
    
</body>
</html>