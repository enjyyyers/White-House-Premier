<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Data Admin - White House Premiere</title>
    <style>
        @page { margin: 20px; }
        body {
            font-family: 'Courier New', monospace;
            font-size: 11px;
            color: #333;
            padding: 10px;
        }
        .header {
            text-align: center;
            border-bottom: 3px double #1e40af;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 20px;
            font-weight: bold;
            color: #1e3a5f;
            margin: 0 0 5px 0;
            text-transform: uppercase;
            letter-spacing: 3px;
        }
        .header h2 {
            font-size: 14px;
            font-weight: normal;
            color: #555;
            margin: 0;
        }
        .header p {
            font-size: 10px;
            color: #888;
            margin: 5px 0 0 0;
        }
        .summary {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            gap: 10px;
        }
        .summary-item {
            flex: 1;
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
            border-radius: 4px;
        }
        .summary-item .label {
            font-size: 9px;
            text-transform: uppercase;
            color: #888;
            letter-spacing: 1px;
        }
        .summary-item .value {
            font-size: 22px;
            font-weight: bold;
            color: #1e3a5f;
            margin-top: 3px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        th {
            background: #1e3a5f;
            color: white;
            padding: 8px 6px;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-align: left;
        }
        td {
            padding: 6px;
            border-bottom: 1px solid #eee;
            font-size: 10px;
        }
        tr:nth-child(even) { background: #f9fafb; }
        .code {
            font-weight: bold;
            color: #1d4ed8;
            letter-spacing: 0.5px;
        }
        .gender {
            display: inline-block;
            padding: 1px 8px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: bold;
        }
        .gender-P { background: #fce7f3; color: #be185d; }
        .gender-L { background: #dbeafe; color: #1d4ed8; }
        .footer {
            text-align: center;
            font-size: 9px;
            color: #aaa;
            border-top: 1px solid #ddd;
            padding-top: 10px;
            margin-top: 10px;
        }
        .ttd {
            margin-top: 30px;
            display: flex;
            justify-content: flex-end;
        }
        .ttd div {
            text-align: center;
            width: 200px;
        }
        .ttd .line {
            margin-top: 50px;
            border-top: 1px solid #333;
            padding-top: 5px;
            font-size: 11px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>White House Premiere</h1>
        <h2>Laporan Data Admin</h2>
        <p>Periode: {{ now()->translatedFormat('d F Y') }}</p>
    </div>

    <div class="summary">
        <div class="summary-item">
            <div class="label">Total Admin</div>
            <div class="value">{{ $totalAdmin }}</div>
        </div>
        <div class="summary-item">
            <div class="label">Laki-laki</div>
            <div class="value">{{ $totalPria }}</div>
        </div>
        <div class="summary-item">
            <div class="label">Perempuan</div>
            <div class="value">{{ $totalWanita }}</div>
        </div>
        <div class="summary-item">
            <div class="label">Belum Diatur</div>
            <div class="value">{{ $belumSet }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Admin</th>
                <th>Nama Admin</th>
                <th>JK</th>
                <th>Tahun</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @forelse($admins as $index => $admin)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td class="code">{{ $admin->kode_admin ?? '-' }}</td>
                <td>{{ $admin->name }}</td>
                <td>
                    @if($admin->jenis_kelamin)
                        <span class="gender gender-{{ $admin->jenis_kelamin }}">
                            {{ $admin->jenis_kelamin == 'P' ? 'P' : 'L' }}
                        </span>
                    @else
                        -
                    @endif
                </td>
                <td>{{ $admin->created_at ? $admin->created_at->format('Y') : '-' }}</td>
                <td>{{ $admin->email }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center; padding:30px; color:#999;">
                    Belum ada admin terdaftar.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <p style="font-size:9px; color:#888;">
        <strong>Format Kode:</strong> WHP-ADM-{INISIAL}-{JK}{TAHUN}-{URUTAN}<br>
        <em>Contoh: WHP-ADM-GW-P26-001 (Giescha Wiwenar, Perempuan, 2026)</em>
    </p>

    <div class="ttd">
        <div>
            <p>Jakarta, {{ now()->translatedFormat('d F Y') }}</p>
            <div class="line">( {{ auth()->user()->name }} )</div>
        </div>
    </div>

    <div class="footer">
        White House Premiere - Laporan digenerate pada {{ now()->translatedFormat('d F Y H:i:s') }}
    </div>
</body>
</html>
