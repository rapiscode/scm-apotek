<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Bantuan</title>
</head>
<body style="font-family: Arial, sans-serif; color: #1f2937;">
    <h2>Laporan Bantuan Baru</h2>

    <p><strong>Subjek:</strong> {{ $data['subjek'] }}</p>
    <p><strong>Kategori:</strong> {{ $data['kategori'] }}</p>
    <p><strong>Detail Masalah:</strong></p>
    <p>{{ $data['detail'] }}</p>
</body>
</html>