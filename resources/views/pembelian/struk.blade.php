<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 15px; }
        .member-info { margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        th, td { border: 1px solid #ddd; padding: 5px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .footer { margin-top: 20px; text-align: center; font-size: 10px; }
        .divider { border-top: 1px dashed #000; margin: 10px 0; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Indo April</h2>
    </div>
    
    <div class="member-info">
        <p><strong>Member Status</strong> : Member</p>
        <p><strong>No. HP</strong> : {{ $member['no_telp'] }}</p>
        <p><strong>Bergabung Sejak</strong> : {{ $member['join_date'] }}</p>
        <p><strong>Poin Member</strong> : {{ number_format($member['poin'], 0) }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>QTy</th>
                <th>Harga</th>
                <th>Sub Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product['nama'] }}</td>
                <td>{{ $product['qty'] }}</td>
                <td>Rp. {{ number_format($product['harga'], 0) }}</td>
                <td>Rp. {{ number_format($product['sub_total'], 0) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="text-right">
        <p><strong>Total Harga</strong><br>
        Rp. {{ number_format($transaction['total_harga'], 0) }}</p>
        
        <p><strong>Harga Setelah Poin</strong><br>
        Rp. {{ number_format($transaction['harga_setelah_poin'], 0) }}</p>
        
        <p><strong>Total Kembalian</strong><br>
        Rp. {{ number_format($transaction['kembalian'], 0) }}</p>
    </div>
    
    <div class="divider"></div>
    
    <div class="footer">
        <p>{{ $transaction['tanggal'] }} | {{ $transaction['petugas'] }}</p>
        <p><strong>Terima kasih atas pembelian Anda</strong></p>
    </div>
</body>
</html>