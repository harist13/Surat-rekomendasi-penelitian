<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Data Responden Survei</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 10pt;
            line-height: 1.4;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 18pt;
            margin-bottom: 0;
            color: #004aad;
        }
        .header p {
            margin-top: 5px;
            color: #666;
        }
        .stats-container {
            display: flex;
            margin-bottom: 20px;
        }
        .stats-box {
            background-color: #f0f4f8;
            border-radius: 5px;
            padding: 10px;
            margin: 5px;
            width: 23%;
            float: left;
        }
        .stats-box-title {
            font-size: 8pt;
            color: #666;
            margin-bottom: 5px;
        }
        .stats-box-value {
            font-size: 14pt;
            font-weight: bold;
            color: #004aad;
        }
        .chart-container {
            margin: 20px 0;
            text-align: center;
        }
        .chart-title {
            font-size: 12pt;
            font-weight: bold;
            margin-bottom: 10px;
            color: #004aad;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 9pt;
        }
        th {
            background-color: #004aad;
            color: white;
            padding: 8px;
            text-align: left;
        }
        td {
            border-bottom: 1px solid #ddd;
            padding: 8px;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .footer {
            margin-top: 30px;
            font-size: 8pt;
            text-align: center;
            color: #666;
        }
        .legend {
            margin-top: 20px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .legend-title {
            font-weight: bold;
            margin-bottom: 10px;
            text-align: center;
        }
        .rating-distribution {
            width: 100%;
            margin: 0 auto;
        }
        .rating-column {
            width: 48%;
            float: left;
            padding: 1%;
        }
        .rating-item {
            background-color: #f0f4f8;
            border-radius: 5px;
            margin-bottom: 10px;
            padding: 10px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .rating-label {
            font-weight: bold;
            color: #004aad;
        }
        .rating-description {
            color: #666;
            margin-top: 2px;
        }
        .page-break {
            page-break-after: always;
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>DATA RESPONDEN SURVEI KEPUASAN PELAYANAN</h1>
        <p>Tanggal: {{ date('d-m-Y') }}</p>
    </div>
    
    <div class="stats-container clearfix">
        <div class="stats-box">
            <div class="stats-box-title">Total Responden</div>
            <div class="stats-box-value">{{ $uniqueEmails }}</div>
        </div>
        
        <div class="stats-box">
            <div class="stats-box-title">Rating Terendah</div>
            <div class="stats-box-value">{{ $lowestRating == 6 ? '-' : $lowestRating }}</div>
        </div>
        
        <div class="stats-box">
            <div class="stats-box-title">Rating Tertinggi</div>
            <div class="stats-box-value">{{ $highestRating ?: '-' }}</div>
        </div>
        
        <div class="stats-box">
            <div class="stats-box-title">Rata-rata Rating</div>
            <div class="stats-box-value">{{ $averageRating }}</div>
        </div>
    </div>
    
    <div class="chart-container">
        <div class="chart-title">Distribusi Rating</div>
        <img src="{{ $chartUrl }}" alt="Distribusi Rating" style="max-width: 100%;">
    </div>
    
    <!-- Two-column rating distribution -->
    <div class="legend">
        <div class="legend-title">DISTRIBUSI SKALA PENILAIAN</div>
        <div class="rating-distribution clearfix">
            <div class="rating-column">
                <div class="rating-item">
                    <div class="rating-label">1</div>
                    <div class="rating-description">Sangat Tidak Setuju</div>
                    <div class="rating-count">{{ $ratingStats[1] }} responden ({{ $totalRatings > 0 ? round(($ratingStats[1] / $totalRatings) * 100, 1) : 0 }}%)</div>
                </div>
                <div class="rating-item">
                    <div class="rating-label">2</div>
                    <div class="rating-description">Tidak Setuju</div>
                    <div class="rating-count">{{ $ratingStats[2] }} responden ({{ $totalRatings > 0 ? round(($ratingStats[2] / $totalRatings) * 100, 1) : 0 }}%)</div>
                </div>
                <div class="rating-item">
                    <div class="rating-label">3</div>
                    <div class="rating-description">Kurang Setuju</div>
                    <div class="rating-count">{{ $ratingStats[3] }} responden ({{ $totalRatings > 0 ? round(($ratingStats[3] / $totalRatings) * 100, 1) : 0 }}%)</div>
                </div>
            </div>
            <div class="rating-column">
                <div class="rating-item">
                    <div class="rating-label">4</div>
                    <div class="rating-description">Setuju</div>
                    <div class="rating-count">{{ $ratingStats[4] }} responden ({{ $totalRatings > 0 ? round(($ratingStats[4] / $totalRatings) * 100, 1) : 0 }}%)</div>
                </div>
                <div class="rating-item">
                    <div class="rating-label">5</div>
                    <div class="rating-description">Sangat Setuju</div>
                    <div class="rating-count">{{ $ratingStats[5] }} responden ({{ $totalRatings > 0 ? round(($ratingStats[5] / $totalRatings) * 100, 1) : 0 }}%)</div>
                </div>
            </div>
        </div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>No HP</th>
                <th>Jenis Kelamin</th>
                <th>Usia</th>
                <th>Layanan</th>
            </tr>
        </thead>
        <tbody>
            @php $count = 1; @endphp
            @foreach($groupedResponses as $email => $userResponses)
                @php $firstResponse = $userResponses->first(); @endphp
                <tr>
                    <td>{{ $count++ }}</td>
                    <td>{{ $firstResponse->nama }}</td>
                    <td>{{ $email }}</td>
                    <td>{{ $firstResponse->no_hp }}</td>
                    <td>{{ $firstResponse->jenis_kelamin }}</td>
                    <td>{{ $firstResponse->usia }}</td>
                    <td>{{ $firstResponse->jenis_layanan }}</td>
                </tr>
            @endforeach
            
            @if($groupedResponses->count() == 0)
                <tr>
                    <td colspan="7" style="text-align: center;">Tidak ada data responden yang ditemukan</td>
                </tr>
            @endif
        </tbody>
    </table>
    
    <div class="footer">
        Dokumen ini digenerate otomatis pada {{ date('d-m-Y H:i:s') }}
    </div>
</body>
</html>