<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Usulan Fitur Baru</title>
</head>
<body style="font-family: Arial, sans-serif; color: #1f2937;">
    <h2>Usulan Fitur Baru</h2>

    <p><strong>Nama Fitur:</strong> {{ $data['nama_fitur'] }}</p>
    <p><strong>Kategori:</strong> {{ $data['kategori'] }}</p>
    <p><strong>Deskripsi Fitur:</strong></p>
    <p>{{ $data['deskripsi'] }}</p>

    <p><strong>Manfaat:</strong></p>
    <p>{{ $data['manfaat'] }}</p>
</body>
</html>