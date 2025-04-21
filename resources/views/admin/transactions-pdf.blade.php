<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi {{ $user->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin-bottom: 5px;
        }
        .user-info {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .negative {
            color: #e53e3e;
        }
        .positive {
            color: #38a169;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Transaksi</h1>
        <p>Dompet Digital</p>
    </div>

    <div class="user-info">
        <table>
            <tr>
                <td width="150">Nama</td>
                <td>: {{ $user->name }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>: {{ $user->email }}</td>
            </tr>
            <tr>
                <td>Saldo</td>
                <td>: Rp {{ number_format($user->saldo, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Tanggal Laporan</td>
                <td>: {{ now()->format('d F Y') }}</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Tipe</th>
                <th>Keterangan</th>
                <th>Jumlah</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transactions as $transaction)
            <tr>
                <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ ucfirst($transaction->type) }}</td>
                <td>
                    @if($transaction->type === 'transfer')
                        @if($transaction->user_id === $user->id)
                            Transfer ke {{ $transaction->target->name }}
                        @else
                            Terima dari {{ $transaction->user->name }}
                        @endif
                    @elseif($transaction->type === 'topup')
                        Top Up Saldo
                    @else
                        Withdraw
                    @endif
                </td>
                <td>
                    @if(($transaction->type === 'transfer' && $transaction->user_id === $user->id) || $transaction->type === 'withdraw')
                        <span class="negative">- Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                        @elseif(($transaction->type === 'topup' && $transaction->status === 'rejected'))
                        <span>-</span>
                    @else
                        <span class="positive">+ Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                    @endif
                </td>
                <td>
                    {{ ucfirst($transaction->status) }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center;">Tidak ada transaksi</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d F Y H:i:s') }}</p>
    </div>
</body>
</html>
