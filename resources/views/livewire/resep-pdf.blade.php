<!DOCTYPE html>
<html>
<head>
<style>
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tbody tr:nth-of-type(even){background-color: hsla(184, 96%, 52%, 0.884);}

#customers tr:hover {background-color: yellow;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #04AA6D;
  color: white;
}
#hj {
  border: 1px solid black;
  margin: 50px 40px 75px;
  background-color: lightblue;
}
</style>
</head>
<body>

<div class="container">
    <div class="row my-2">
        <h4>Nama Dokter : {{ $batu[0]->doknam }}</h4>
    
    <h4>Nama Pasien : {{ $batu[0]->nampas }}</h4><h4 text-align="right">Tanggal Checkups : {{ $batu[0]->tanggalc }}</h4>
    <table id="customers"  class="table table-striped nowrap">
        <thead class="table-dark">
            <th>Nama Obat</th>
            <th>Pemakaian</th>
            <th>kategori</th>
            <th>satuan</th>
            <th>Catatan</th>
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
                <td>{{ $obat->nots }}</td>
                <td>{{ $obat->harga }}</td>
                
            </tr>
            @php
                $sum+=$obat->harga
            @endphp
        @endforeach
            
        </tbody>
        
    </table>
    <div id="hj">
         <span>Total : {{ $sum }}</span>
    </div>
   
    
    </div>
</div>
    
</body>
</html>