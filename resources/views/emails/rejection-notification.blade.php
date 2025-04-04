<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Notifikasi Pengajuan Penelitian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 700px;
            margin: 0 auto;
            background: #fff;
            padding: 0;
            border: 1px solid #ddd;
        }
        .header {
            padding: 20px;
            border-bottom: 4px double #000;
            display: flex;
            align-items: center;
        }
        .logo {
            width: 80px;
            height: 80px;
            margin-right: 20px;
        }
        .header-text {
            flex: 1;
        }
        .header-text h1 {
            font-size: 18px;
            font-weight: bold;
            margin: 0 0 5px 0;
            text-align: center;
        }
        .header-text h2 {
            font-size: 16px;
            font-weight: bold;
            margin: 0 0 5px 0;
            text-align: center;
        }
        .header-text p {
            font-size: 12px;
            margin: 0 0 2px 0;
            text-align: center;
        }
        .content {
            padding: 30px 20px;
            white-space: pre-line;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            padding: 15px 20px;
            border-top: 1px solid #ddd;
            font-size: 0.8em;
            color: #777;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ $message->embed(public_path('assets/images/logo.png')) }}" alt="Logo Kaltim" class="logo">
            <div class="header-text">
                <h1>PEMERINTAH PROVINSI KALIMANTAN TIMUR</h1>
                <h2>BADAN KESATUAN BANGSA DAN POLITIK</h2>
                <p>Jalan Jenderal Sudirman Nomor 1, Samarinda, Kalimantan Timur 75121</p>
                <p>Telepon (0541) 733333; Faksimile (0541) 733453</p>
                <p>Pos-el kesbangpolkaltim@gmail.com; Laman http://kesbangpol.kaltimprov.go.id</p>
            </div>
        </div>
        
        <div class="content">
            {{ $pesan_email }}
        </div>
        
        <div class="footer">
            <p>Ini adalah email otomatis, mohon jangan membalas email ini.</p>
            <p>&copy; {{ date('Y') }} Badan Kesatuan Bangsa dan Politik Provinsi Kalimantan Timur</p>
        </div>
    </div>
</body>
</html>