<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan</title>
    <style>
        @page {
            margin: 1.5cm;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #1e293b;
            line-height: 1.5;
            font-size: 11pt;
        }
        .header {
            border-bottom: 2px solid #3b82f6;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header table {
            width: 100%;
        }
        .brand {
            font-size: 24pt;
            font-weight: bold;
            color: #2563eb;
            margin: 0;
        }
        .sub-brand {
            font-size: 10pt;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: bold;
        }
        .report-title {
            text-align: right;
            font-size: 14pt;
            font-weight: bold;
            color: #475569;
        }
        .report-date {
            text-align: right;
            font-size: 10pt;
            color: #94a3b8;
        }
        .summary-container {
            margin-bottom: 30px;
        }
        .summary-table {
            width: 100%;
            border-collapse: collapse;
        }
        .summary-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
        }
        .summary-label {
            font-size: 9pt;
            color: #64748b;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .summary-value {
            font-size: 14pt;
            font-weight: bold;
        }
        .income { color: #10b981; }
        .expense { color: #ef4444; }
        .balance { color: #3b82f6; }

        .table-container {
            margin-top: 20px;
        }
        table.main-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10pt;
        }
        table.main-table th {
            background-color: #f1f5f9;
            color: #475569;
            font-weight: bold;
            text-align: left;
            padding: 12px 10px;
            border-bottom: 1px solid #cbd5e1;
            text-transform: uppercase;
            font-size: 8pt;
            letter-spacing: 1px;
        }
        table.main-table td {
            padding: 10px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            font-size: 8pt;
            color: #94a3b8;
            text-align: center;
            border-top: 1px solid #f1f5f9;
            padding-top: 10px;
        }
        .badge {
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 8pt;
            font-weight: bold;
        }
        .badge-income { background-color: #dcfce7; color: #166534; }
        .badge-expense { background-color: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>
    <div class="header">
        <table>
            <tr>
                <td>
                    <h1 class="brand">DanaCermat</h1>
                    <div class="sub-brand">Catatan Keuangan</div>
                </td>
                <td>
                    <div class="report-title">Laporan Arus Kas</div>
                    <div class="report-date">{{ $startDate->translatedFormat('d F Y') }} - {{ $endDate->translatedFormat('d F Y') }}</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="summary-container">
        <table style="width: 100%;">
            <tr>
                <td style="width: 32%; padding-right: 10px;">
                    <div class="summary-card">
                        <div class="summary-label">Total Pemasukan</div>
                        <div class="summary-value income">Rp {{ number_format($totalIncome, 0, ',', '.') }}</div>
                    </div>
                </td>
                <td style="width: 32%; padding: 0 5px;">
                    <div class="summary-card">
                        <div class="summary-label">Total Pengeluaran</div>
                        <div class="summary-value expense">Rp {{ number_format($totalExpense, 0, ',', '.') }}</div>
                    </div>
                </td>
                <td style="width: 32%; padding-left: 10px;">
                    <div class="summary-card">
                        <div class="summary-label">Sisa Dana</div>
                        <div class="summary-value balance">Rp {{ number_format($balance, 0, ',', '.') }}</div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="summary-container" style="margin-top: 20px;">
        <div style="font-size: 10pt; font-bold; margin-bottom: 10px; color: #475569; text-transform: uppercase; letter-spacing: 1px;">Ringkasan per Metode</div>
        <table class="main-table" style="margin-bottom: 0;">
            <thead>
                <tr>
                    <th style="width: 40%;">Metode Pembayaran</th>
                    <th style="width: 30%; text-align: right;">Total Masuk</th>
                    <th style="width: 30%; text-align: right;">Total Keluar</th>
                </tr>
            </thead>
            <tbody>
                @foreach($methodBreakdown as $method => $amounts)
                <tr>
                    <td class="font-bold">{{ $method }}</td>
                    <td class="text-right income">Rp {{ number_format($amounts['income'], 0, ',', '.') }}</td>
                    <td class="text-right expense">Rp {{ number_format($amounts['expense'], 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="table-container">
        <table class="main-table">
            <thead>
                <tr>
                    <th style="width: 15%;">Tanggal</th>
                    <th style="width: 35%;">Keterangan</th>
                    <th style="width: 20%;">Kategori / Metode</th>
                    <th style="width: 10%; text-align: center;">Tipe</th>
                    <th style="width: 20%; text-align: right;">Nominal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $trx)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($trx->transaction_date)->translatedFormat('d/m/Y') }}</td>
                    <td>
                        <div class="font-bold">{{ $trx->description }}</div>
                    </td>
                    <td>
                        @if($trx->payments->count() > 1)
                            @foreach($trx->payments as $payment)
                                <div style="font-size: 8pt; border-bottom: 1px dashed #e2e8f0; padding-bottom: 2px; margin-bottom: 2px;">
                                    <span style="color: #64748b;">{{ $payment->paymentMethod?->name }}:</span>
                                    <span class="font-bold">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        @else
                            <div style="font-size: 9pt;">{{ $trx->paymentMethod?->category?->name ?? '-' }}</div>
                            <div style="font-size: 8pt; color: #64748b;">{{ $trx->paymentMethod?->name ?? '-' }}</div>
                        @endif
                    </td>
                    <td class="text-center">
                        <span class="badge {{ $trx->type == 'income' ? 'badge-income' : 'badge-expense' }}">
                            {{ $trx->type == 'income' ? 'IN' : 'OUT' }}
                        </span>
                    </td>
                    <td class="text-right font-bold {{ $trx->type == 'income' ? 'income' : 'expense' }}">
                        {{ $trx->type == 'income' ? '+' : '-' }} Rp {{ number_format($trx->amount, 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        Dicetak oleh: {{ $user->name }} pada {{ now()->translatedFormat('d F Y H:i') }} | DanaCermat Report
    </div>
</body>
</html>
