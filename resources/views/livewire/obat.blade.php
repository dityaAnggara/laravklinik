<div>
   <div class="container">
    <div class="row my-2">
        <div class="col-12">
            
                <button wire:click="pilihMenu('lihat')" 
                class="btn {{ $pilihanMenu=='lihat' ? 'btn-primary' : 'btn-outline-primary' }}">
                    Data Obat
                </button>
                <button wire:click="pilihMenu('tambahsatuan')" 
                class="btn {{ $pilihanMenu=='tambahsatuan' ? 'btn-primary' : 'btn-outline-primary' }}">
                    Form Satuan
                </button>
                <button wire:click="pilihMenu('tambahkategori')" 
                class="btn {{ $pilihanMenu=='tambahkategori' ? 'btn-primary' : 'btn-outline-primary' }}">
                    Form Kategori
                </button>
                @if ($saatuan != 0 && $kategor != 0)
                    <button wire:click="pilihMenu('tambah')" 
                class="btn {{ $pilihanMenu=='tambah' ? 'btn-primary' : 'btn-outline-primary' }}">
                    Form Obat
                </button>
                @endif
                
                <button wire:loading class="btn btn-danger">
                loading.....
                </button>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            @if ($pilihanMenu=='tambahsatuan')
            <div class="card border-primary col-md-6">
                <div class="card-header">
                   <h3>Form Satuan</h3> 
                </div>
                <div class="card-body">
                   <form wire:submit='simpanSatuan'>
                    @csrf
                        <label class="text-bold">Nama</label>
                        <input type="text"  class="form-control col-md-6 border-black" wire:model.live='nama'/>
                        <button type="submit" class="btn btn-danger mt-3">Simpan</button>
                   </form>
                </div>
            </div>
            @elseif ($pilihanMenu=='tambahkategori')
            <div class="card border-primary col-md-6">
            <div class="card-header">
               <h3>Form Kategori</h3> 
            </div>
            <div class="card-body">
               <form wire:submit='simpanKategori'>
                @csrf
                    <label class="text-bold">Nama</label>
                    <input type="text"  class="form-control col-md-6 border-black" wire:model.live='kategori'/>
                    <button type="submit" class="btn btn-danger mt-3">Simpan</button>
               </form>
            </div>
        </div>
        @elseif ($pilihanMenu=='tambah')
        <div class="card border-primary col-md-6">
            <div class="card-header">Form Tambah Obat</div>
            <div class="card-body">
                <form wire:submit='simpan'>
                    @csrf
                        <div class="mb-2 mt-2">
                            <label class="text-bold">Nama</label>
                            <input type="text"  class="form-control col-md-6 border-black" wire:model.live='obat'/>
                            @error('obat')
                                <span class="text-danger mb-2">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-2 mt-2">
                            <label class="text-bold">Pemakaian</label>
                            <select class="form-control border-black" wire:model.live='pemakaian'>
                                <option >==Jenis Pemakaian Obat==</option>
                                <option value="obat luar">Obat Luar</option>
                                <option value="obat minum">Obat Minum</option>
                            </select>
                        @error('pemakaian')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        </div>
                        <div class="mb-2 mt-2">
                            <label>Kategori</label>
                        <select class="form-control border-black" wire:model.live='kategori'>
                           
                            <option >==Kategori==</option>
                             @foreach ($kateg as $kategori )
                                <option value="{{ $kategori->id }}">{{ $kategori->kategori }}</option>
                            @endforeach
                        </select>
                        </div>
                        <div class="mb-2 mt-2">
                            <label>Satuan</label>
                        <select class="form-control border-black" wire:model.live='satuan'>
                           
                            <option >==Satuan==</option>
                             @foreach ($stuan as $satuan )
                                <option value="{{ $satuan->id }}">{{ $satuan->nama }}</option>
                            @endforeach
                        </select>
                        </div>
                        <div class="mb-2 mt-2">
                            <label class="text-bold">Berat</label>
                        <input type="text"  class="form-control col-md-6 border-black" wire:model.live='berat'/>
                        @error('berat')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        </div>
                        <button type="submit" class="btn btn-danger mt-3">Simpan</button>
                </form>
            </div>
        </div>
        @elseif ($pilihanMenu=='lihat')
        <div class="card border-primary">
            <div class="card-header">
               <h3>Table Obat</h3> 
            </div>
            <div class="card-body">
                <div class="mb-2 col-2">
                    <label > search</label>
                    <input type="text"   class="form-control border-black" />
                </div>
                <span>Obat Dengan Harga Terupdate</span>
                <table id="example" class="table table-striped nowrap">
                    <thead class="table-dark">
                        <th>Nomor</th>
                        <th>Id</th>
                        <th>Nama Obat</th>
                        <th>Pemakaian</th>
                        <th>kategori</th>
                        <th>satuan</th>
                        <th>Harga</th>
                        <th>Data</th>
                    </thead>
                    <tbody>
                        @foreach ($oobat as $obat)
                        <tr
                        class="{{ $loop->iteration % 2 == 0 ? 'table-danger' : 'table-primary' }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $obat->idob }}</td>
                            <td>{{ $obat->obat }}</td>
                            <td>{{ $obat->pemakaian }}</td>
                            <td>{{ $obat->namkat }}</td>
                            <td>{{ $obat->namsat }}</td>
                            <td>{{ $obat->harga }}</td>
                            <td>
                                
                            </td>  
                        </tr>
                    @endforeach
                        
                    </tbody>
                    
                </table>
                <p class="text-center">{{ $oobat->links() }}</p>
                <table id="example" class="table table-striped nowrap">
                    <thead class="table-dark">
                        <th>Id</th>
                        <th>Nama Obat</th>
                        <th>Pemakaian</th>
                        <th>kategori</th>
                        <th>satuan</th>
                        <th>Data</th>
                    </thead>
                    <tbody>
                        @foreach ($obbat as $obat)
                        <tr
                        class="{{ $loop->iteration % 2 == 0 ? 'table-danger' : 'table-primary' }}">
                            <td>{{ $obat->idob }}</td>
                            <td>{{ $obat->obat }}</td>
                            <td>{{ $obat->pemakaian }}</td>
                            <td>{{ $obat->namkat }}</td>
                            <td>{{ $obat->namsat }}</td>
                            <td>
                                <button wire:click="hrgobat({{ $obat->idob }})" 
                                    class="btn {{ $pilihanMenu=='updhrga' ? 'btn-success' : 'btn-outline-success' }}">
                                         Update Harga
                                    </button> 
                            </td>  
                        </tr>
                    @endforeach
                        
                    </tbody>
                    
                </table>
                <p class="text-center">{{ $obbat->links() }}</p>
            </div>
            
        </div>
        @elseif ($pilihanMenu=='updhrga')
        <div class="card border-primary col-md-6">
            <div class="card-header">Form Set Harga Obat</div>
            <div class="card-body">
                <form wire:submit='setharga'>
                    @csrf
                    <p>Nama : {{ $penggunaTerpilih->obat }}</p>
                        <div class="mb-2 mt-2">
                            <label class="text-bold">Harga</label>
                            <input type="text"  class="form-control col-md-6 border-black" wire:model.live='hgobat'/>
                            @error('obat')
                                <span class="text-danger mb-2">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-2 mt-2">
                            <label class="text-bold">Start Harga</label>
                        <input type="date"  class="form-control col-md-6 border-black" wire:model.live='stharga'/>
                        @error('stharga')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        </div>
                        <div class="mb-2 mt-2">
                            <label class="text-bold">End Harga</label>
                        <input type="date"  class="form-control col-md-6 border-black" wire:model.live='enharga'/>
                        @error('enharga')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        </div>
                        <button type="submit" class="btn btn-danger mt-3">Simpan</button>
                </form>
            </div>
        </div>
        @endif
      
        </div>
    </div>
    
   </div>
</div>
