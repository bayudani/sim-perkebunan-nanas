<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan {{ $namaBulan }} {{ $tahun }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.5;
            font-size: 12px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #2e7d32;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            color: #2e7d32;
            font-size: 20px;
        }
        .header p {
            margin: 5px 0 0 0;
            font-size: 14px;
        }
        .summary {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        .summary td {
            padding: 15px;
            text-align: center;
            width: 33.33%;
            border: 1px solid #ddd;
        }
        .summary h3 {
            margin: 0 0 5px 0;
            font-size: 14px;
        }
        .summary p {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }
        .text-green { color: #15803d; }
        .text-red { color: #b91c1c; }
        .text-blue { color: #1d4ed8; }
        
        table.details {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table.details th, table.details td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table.details th {
            background-color: #f0fdf4;
            color: #166534;
        }
        .text-right { text-align: right; }
    </style>
</head>
<body>

    <div class="header">
        <h1>LAPORAN KEUANGAN PERKEBUNAN NANAS</h1>
        <p>Periode: {{ $namaBulan }} {{ $tahun }}</p>
    </div>

    <table class="summary">
        <tr>
            <td>
                <h3>Total Pemasukan</h3>
                <p class="text-green">Rp. {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
            </td>
            <td>
                <h3>Total Pengeluaran</h3>
                <p class="text-red">Rp. {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
            </td>
            <td>
                <h3>Saldo Bersih</h3>
                <p class="text-blue">Rp. {{ number_format($saldo, 0, ',', '.') }}</p>
            </td>
        </tr>
    </table>

    <h3 style="color: #2e7d32; border-bottom: 1px solid #ccc; padding-bottom: 5px;">Rincian Pemasukan</h3>
    <table class="details">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Tanggal</th>
                <th width="50%">Keterangan / Sumber</th>
                <th width="25%" class="text-right">Nominal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pemasukans as $index => $masuk)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($masuk->tanggal)->format('d-m-Y') }}</td>
                <td>Penjualan nanas {{ $masuk->hasilPanen ? '('.$masuk->hasilPanen->kualitas.')' : '' }}</td>
                <td class="text-right text-green">+ Rp. {{ number_format($masuk->total_pendapatan, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center;">Tidak ada data pemasukan pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <h3 style="color: #b91c1c; border-bottom: 1px solid #ccc; padding-bottom: 5px;">Rincian Pengeluaran</h3>
    <table class="details">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Tanggal</th>
                <th width="50%">Jenis Biaya</th>
                <th width="25%" class="text-right">Nominal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengeluarans as $index => $keluar)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($keluar->tanggal)->format('d-m-Y') }}</td>
                <td>{{ $keluar->jenis_biaya }} {{ $keluar->keterangan ? ' - '.$keluar->keterangan : '' }}</td>
                <td class="text-right text-red">- Rp. {{ number_format($keluar->jumlah, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center;">Tidak ada data pengeluaran pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <p style="text-align: right; margin-top: 40px; font-size: 12px; color: #666;">
        Dicetak pada: {{ \Carbon\Carbon::now()->format('d-m-Y H:i:s') }}
    </p>

</body>
</html>