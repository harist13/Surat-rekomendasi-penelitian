<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Keterangan Penelitian</title>
    <style>
        @page {
            margin: 2cm;
        }
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            position: relative;
        }
        /* Watermark that uses base64 encoded image */
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/images/logo.png'))) }}');
            background-repeat: no-repeat;
            background-position: center center;
            background-size: 70%; /* Larger size */
            opacity: 0.07; /* Slightly more visible */
            z-index: -1;
        }
        .header {
            display: table;
            width: 100%;
            margin-bottom: 20px;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
        }
        .logo-cell {
            display: table-cell;
            width: 100px;
            vertical-align: middle;
        }
        .text-cell {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
        }
        .logo {
            width: 80px;
        }
        .header-title {
            font-size: 14pt;
            font-weight: bold;
            margin: 0;
        }
        .header-address {
            font-size: 11pt;
            margin: 0;
        }
        .title {
            text-align: center;
            font-weight: bold;
            font-size: 14pt;
            margin: 20px 0 5px;
        }
        .nomor {
            text-align: center;
            margin-bottom: 30px;
        }
        .section-title {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .indent {
            margin-left: 30px;
            text-align: justify;
        }
        .applicant-info {
            width: 100%;
            margin: 20px 0;
        }
        .applicant-info td {
            vertical-align: top;
            padding: 3px 0;
            line-height: 1.4;
        }
        .applicant-info td:first-child {
            width: 200px;
            font-weight: normal;
        }
        .applicant-info td:nth-child(2) {
            width: 15px;
            text-align: center;
        }
        .applicant-info td:nth-child(3) {
            text-align: left;
        }
        .ketentuan {
            margin-left: 20px;
            padding-left: 20px;
        }
        .signature {
            margin-top: 30px;
            text-align: right;
        }
        .signature-content {
            display: inline-block;
            text-align: left;
            width: 300px;
        }
        .signature-name {
            margin-top: 70px;
            font-weight: bold;
            text-decoration: underline;
        }
        .tembusan {
            margin-top: 50px;
        }
        .tembusan ol {
            margin-left: 20px;
            padding-left: 20px;
        }
    </style>
</head>
<body>
    <!-- Header with logo and institution name -->
    <div class="header">
        <div class="logo-cell">
            <!-- Using base64 encoded image for reliable rendering -->
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/images/logo.png'))) }}" alt="Logo" class="logo">
        </div>
        <div class="text-cell">
            <p class="header-title">PEMERINTAH PROVINSI KALIMANTAN TIMUR</p>
            <p class="header-title">BADAN KESATUAN BANGSA DAN POLITIK</p>
            <p class="header-address">Jalan Jenderal Sudirman Nomor 1, Samarinda, Kalimantan Timur 75121</p>
            <p class="header-address">Telepon (0541) 733333; Faksimile (0541) 733453</p>
            <p class="header-address">Pos-el kesbangpol.kaltim@gmail.com; Laman http://kesbangpol.kaltimprov.go.id</p>
        </div>
    </div>

    <!-- Letter title and reference number -->
    <div class="title">SURAT KETERANGAN PENELITIAN</div>
    <div class="nomor">Nomor: {{ $surat->nomor_surat }}</div>

    <!-- Letter content -->
    <div>
        <div class="section-title">a. Dasar</div>
        <div class="indent">
            1. Peraturan Menteri Dalam Negeri Nomor 3 Tahun 2018 tentang Penerbitan Surat Keterangan Penelitian (Berita Negara Republik Indonesia Tahun 2018 Nomor 122);<br>
            2. Peraturan Gubernur Kalimantan Timur Nomor 43 Tahun 2023 tentang Kedudukan, Susunan Organisasi, Tugas, Fungsi, dan Tata Kerja Perangkat Daerah (Berita Daerah Provinsi Kalimantan Timur Tahun 2023 Nomor 46);
        </div>
        
        <div class="section-title" style="margin-top: 15px;">b. Menimbang</div>
        <div class="indent">
            @if ($surat->menimbang)
                {{ $surat->menimbang }}
            @else
                1. Surat a.n Dekan, Wakil Dekan Bidang Akademik, Kemahasiswaan dan Alumni, {{ $peneliti->nama_instansi }} tentang Surat Pengantar Penelitian.
            @endif
        </div>
        
        <div style="margin-top: 15px; font-weight: bold;">Kepala Badan Kesbang dan Politik Prov. Kaltim, memberikan rekomendasi kepada :</div>
        
        <!-- Restructured applicant information to match the image -->
        <table class="applicant-info" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>{{ $peneliti->nama_lengkap }}</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td>
                    @if ($surat->jenis_surat === 'mahasiswa')
                        Mahasiswa Peneliti / NIM. {{ $peneliti->nim }}
                        @if(!empty($peneliti->no_hp))
                        /HP. {{ $peneliti->no_hp }}
                        @endif
                    @else
                        {{ $jabatan }}
                        @if(!empty($peneliti->no_hp))
                        /HP. {{ $peneliti->no_hp }}
                        @endif
                    @endif
                </td>
            </tr>
            <tr>
                <td>Tempat Tinggal</td>
                <td>:</td>
                <td>{{ $peneliti->alamat_peneliti }}</td>
            </tr>
            <tr>
                <td>Nama Lembaga / Alamat</td>
                <td>:</td>
                <td>{{ $peneliti->nama_instansi }}/{{ $peneliti->alamat_instansi }}</td>
            </tr>
            <tr>
                <td>Judul Proposal</td>
                <td>:</td>
                <td>{{ $peneliti->judul_penelitian }}</td>
            </tr>
            <tr>
                <td>Bidang Penelitian</td>
                <td>:</td>
                <td>{{ $bidang }}</td>
            </tr>
            <tr>
                <td>Status Penelitian</td>
                <td>:</td>
                <td>{{ ucfirst($surat->status_penelitian) }}</td>
            </tr>
            @if (!empty($anggotaText))
            <tr>
                <td>Anggota</td>
                <td>:</td>
                <td>{!! nl2br(e($anggotaText)) !!}</td>
            </tr>
            @endif
            <tr>
                <td>Lokasi Penelitian</td>
                <td>:</td>
                <td>{{ $peneliti->lokasi_penelitian }}</td>
            </tr>
            <tr>
                <td>Waktu/Lama Penelitian</td>
                <td>:</td>
                <td>{{ $waktuPenelitian }}</td>
            </tr>
            <tr>
                <td>Tujuan Peneliti</td>
                <td>:</td>
                <td>{{ $peneliti->tujuan_penelitian }}</td>
            </tr>
        </table>
        
        <div class="section-title">Dengan Ketentuan</div>
        <ol class="ketentuan">
            <li>Yang bersangkutan berkewajiban menghormati dan mentaati peraturan dan tata tertib yang berlaku diwilayah kegiatan;</li>
            <li>Tidak dibenarkan melakukan penelitian yang tidak sesuai/tidak ada kaitannya dengan judul penelitian dimaksud;</li>
            <li>Setelah selesai penelitian agar menyampaikan 1 (satu) Eksemplar laporan kepada Gubernur Kalimantan Timur Cq. Kepala Badan Kesatuan Bangsa dan Politik Provinsi Kalimantan Timur.</li>
        </ol>
        
        <div style="margin-top: 15px;">Demikian rekomendasi ini dibuat untuk dipergunakan seperlunya.</div>
        
        <div class="signature">
            <div class="signature-content">
                <div>Samarinda, {{ $tanggalSurat }}</div>
                <div>a.n. Kepala</div>
                <div>Badan Kewaspadaan Nasional</div>
                <div>dan Penanganan Konflik</div>
                <div class="signature-name">Wildan Taufik, S.Pd, M.Si</div>
                <div>Pembina IV/b</div>
                <div>NIP. 19750412200212 1 005</div>
            </div>
        </div>
        
        <div class="tembusan">
            <div class="section-title">Tembusan Yth:</div>
            <ol>
                <li>Gubernur Kalimantan Timur (sebagai laporan)</li>
                <li>Kepala Balitbangda Prov. Kaltim</li>
                <li>Kepala Badan Kesbangpol. Kota Samarinda</li>
                <li>Yang Bersangkutan</li>
            </ol>
        </div>
    </div>
</body>
</html>