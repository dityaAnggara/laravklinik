<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=1, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h2>Nama Dokter : {{ $batu[0]->doknam }}</h2>
    <h2>Nama Pasien : {{ $batu[0]->nampas }}</h2>
    <h2>Tanggal Checkups : {{ $batu[0]->tanggalc }}</h2>
    <table id="example" class="table table-striped nowrap">
        <thead class="table-dark">
            <th>Nama Obat</th>
            <th>Pemakaian</th>
            <th>kategori</th>
            <th>satuan</th>
            <th>Harga</th>
           
        </thead>
        <tbody>
            @php
                $sum=0;
            @endphp
            @foreach ($batu as $obat)
            <tr
            class="{{ $loop->iteration % 2 == 0 ? 'table-danger' : 'table-primary' }}">
                <td>{{ $obat->obat }}</td>
                <td>{{ $obat->pemakaian }}</td>
                <td>{{ $obat->namkat }}</td>
                <td>{{ $obat->namsat }}</td>
                <td>{{ $obat->harga }}</td>
                
            </tr>
            @php
                $sum+=$obat->harga
            @endphp
        @endforeach
            
        </tbody>
        
    </table>
    <span>Total : {{ $sum }}</span>
</body>
</html>