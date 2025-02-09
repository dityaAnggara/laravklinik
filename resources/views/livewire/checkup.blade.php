<div class="container">
    <div class="row my-2">
        <div class="col-12">
           
                <button wire:click="pilihMenu('lihat')" 
                class="btn {{ $pilihanMenu=='lihat' ? 'btn-primary' : 'btn-outline-primary' }}">
                    Data Jadwal Checkup
                </button>
          @if ( Auth::user()->role == 'apoteker')
             <button wire:click="pilihMenu('lihatch')" 
                class="btn {{ $pilihanMenu=='lihatch' ? 'btn-primary' : 'btn-outline-primary' }}">
                    Resep
                </button>
          @endif
            
        
                <button wire:loading class="btn btn-danger">
                loading.....
                </button>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            @if($pilihanMenu=='lihat')
            <div class="card border-primary">
                <div class="card-header">
                   <h3>Jadwal Checkup</h3> 
                </div>
                    <table id="example" class="table table-striped nowrap">
                        <thead class="table-dark">
                            <th>Nama Pasien</th>
                            <th>Jenis Kelamin</th>
                            <th>Tanggal lahir</th>
                            <th>Umur</th>
                            <th>Tanggal jadwal Checkups</th>
                            <th>Data</th>
                        </thead>
                        <tbody>
                            
                            @foreach ($pasiencheck as $pasien)
                            <tr
                            class="{{ $loop->iteration % 2 == 0 ? 'table-danger' : 'table-primary' }}">
                                    
                                    <td>{{ $pasien->pasien->nama }}</td>
                                    <td>{{ $pasien->pasien->jk }}</td>
                                    <td>{{ $pasien->pasien->tanggal_lahir }}</td>
                                    <td>{{ date_diff(date_create($pasien->pasien->tanggal_lahir), now())->y }}</td>
                                    <td>{{ $pasien->tanggalcheckups }}</td>
                                    <td>
                                        <button wire:click="mulaicheck({{ $pasien->id }})" 
                                            class="btn {{ $pilihanMenu=='tam' ? 'btn-success' : 'btn-outline-success' }}">
                                                Mulai Ceckup
                                            </button> 
                                    </td>
                                    
                                   
                                    
                                </tr>
                                @endforeach
                        </tbody>
                        
                    </table>
                    
                </div>
                
            </div>
            @elseif ($pilihanMenu=='tambah')
            <form >
                <input type="file" wire:model="photo">
                <input type="text" >
             <button type="submit">Save Photo</button>
            </form>
            @elseif ($pilihanMenu=='tam')
           
            <div class="card border-primary col-md-12">
                <div class="card-header">
                   <h3>Form Daftar Checkup Pasien</h3> 
                </div>
                <div class="card-body">
                    <form wire:submit='savex' class="row g-3">
                        @csrf
                        <div class="col-md-2">
                            <label for="inputEmail4" class="form-label">Nomor Pendaftaran</label>
                            <input type="text" wired:model="nmrpdf" value="{{ $penggunaTerpilih->nomor_pendaftaran}}" class="form-control border-success" id="inputEmail4">
                          </div>
                        <div class="col-md-3">
                          <label for="inputEmail4" class="form-label">Nama Pasien</label>
                          <input type="text" disabled value="{{ $penggunaTerpilih->pasien->nama}}" class="form-control border-success" id="inputEmail4">
                        </div>
                        <div class="col-md-1">
                          <label for="inputPassword4" class="form-label">Usia</label>
                          <input type="text" disabled value="{{ date_diff(date_create($penggunaTerpilih->pasien->tanggal_lahir), now())->y }}" class="form-control border-success" id="inputPassword4">
                        </div>
                        <div class="col-md-1">
                            <label for="inputPassword4" class="form-label">Tinggi</label>
                            <input type="text"  wire:model.live='tngi' class="form-control border-success" >
                          </div>
                          <div class="col-md-1">
                            <label for="inputPassword4" class="form-label">Berat</label>
                            <input type="text" value="{{ $tampll[0]->berat }}" wire:model.live='brrt' class="form-control border-success">
                          </div>
                          <div class="col-md-2">
                            <label for="inputPassword4" class="form-label">Jenis Kelamin</label>
                            <input type="text" disabled value="{{ $penggunaTerpilih->pasien->jk }}" class="form-control border-success" id="inputPassword4">
                          </div>
                          <div class="col-md-2">
                            <label for="inputPassword4" class="form-label">Tanggal</label>
                            <input type="text" disabled value="{{ date("d-m-Y") }}" class="form-control border-success" id="inputPassword4">
                          </div>
                        <div class="form-floating">
                            <textarea rows="5" wire:model.live="cttn" class="form-control border-success" placeholder="Leave a comment here" id="floatingTextarea">value="{{ $tampll[0]->note }}"</textarea>
                            <label for="floatingTextarea">Catatan</label>
                          </div>
                        <div class="col-12">
                          <label for="inputAddress2" class="form-label">Berkas</label>
                          <input type="file" wire:model="photo">
                        </div>
                        <div class="col-12">
                           <span >
                            @foreach ($bkas as $kks)
                            <a href="{{ $kks->path }}" target="_blank">{{ $kks->path }}</a>
                            <br>
                            @endforeach
                           </span>
                          </div>
                        <div class="col-md-6">
                          <label for="inputCity" class="form-label">Dokter</label>
                          <input type="text" disabled value="{{ Auth::user()->name }}" class="form-control border-success" id="inputCity">
                        </div>
                        <div class="col-md-4">
                          <label for="inputState" class="form-label">State</label>
                          <select id="inputState" class="form-select" wire:model.live='kode'>
                            <option selected>Pilih Obat</option>
                            @foreach ($oobat as $obat )
                            <option value="{{ $obat->idob }}">{{ $obat->obat }}</option>
                        @endforeach
                          </select>
                        </div>
                        <div class="col-12">
                            <table id="example" class="table table-striped nowrap">
                                <thead class="table-dark">
                                    <th>Nama Obat</th>
                                    <th>Pemakaian</th>
                                    <th>kategori</th>
                                    <th>satuan</th>
                                    <th>Note</th>
                                    <th>Data</th>
                                    
                                </thead>
                                <tbody>
                                    @foreach ($batt as $obat)
                                    <tr
                                    class="{{ $loop->iteration % 2 == 0 ? 'table-danger' : 'table-primary' }}">
                                        <td>{{ $obat->obat }}</td>
                                        <td>{{ $obat->pemakaian }}</td>
                                        <td>{{ $obat->namkat }}</td>
                                        <td>{{ $obat->namsat }}</td>
                                        <td><textarea wire:model='notb.{{ $obat->idob }}' cols="20" rows="2"></textarea></td>
                                        <td><button class="btn btn-danger" wire:click="hapusP({{ $obat->idob }})">hapus</button></td>
                                       
                                    </tr>
                                @endforeach
                                    
                                </tbody>
                                
                            </table>
                        </div>
                        <div class="col-12">
                          <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                      </form>
                </div>
            </div>
            @elseif ($pilihanMenu=='lihatch')
            <div class="card border-primary">
                <div class="card-header">
                   <h3>Lihat Resep</h3> 
                </div>
                    <table id="example" class="table table-striped nowrap">
                        <thead class="table-dark">
                            <th>Nama Dokter</th>
                            <th>Nama Pasien</th>
                            <th>Tanggal jadwal Checkups</th>
                            <th>Data</th>
                        </thead>
                        <tbody>
                            
                            @foreach ($pasiencheckk as $pasien)
                            <tr
                            class="{{ $loop->iteration % 2 == 0 ? 'table-danger' : 'table-primary' }}">
                                    
                                    <td>{{ $pasien->dokter->name }}</td>
                                    <td>{{ $pasien->pasien->nama }}</td>
                                    <td>{{ $pasien->tanggalcheckups }}</td>
                                    <td>
                                        <button wire:click="resepcheck({{ $pasien->id }})" 
                                            class="btn {{ $pilihanMenu=='tamm' ? 'btn-success' : 'btn-outline-success' }}">
                                                lihat resep
                                            </button> 
                                    </td>
                                    
                                   
                                    
                                </tr>
                                @endforeach
                        </tbody>
                        
                    </table>
                    
                </div>
                
            </div>
            @elseif ($pilihanMenu=='tamm')
                <div class="card border-primary">
                    <div class="card-header">
                        <h3>List Obat</h3> 
                    </div>
                    <div class="card-body">
                        <table id="example" class="table table-striped nowrap">
                            <thead class="table-dark">
                                <th>Nama Obat</th>
                                <th>Pemakaian</th>
                                <th>kategori</th>
                                <th>satuan</th>
                            </thead>
                            <tbody>
                                @foreach ($batt as $obat)
                                <tr
                                class="{{ $loop->iteration % 2 == 0 ? 'table-danger' : 'table-primary' }}">
                                    <td>{{ $obat->obat }}</td>
                                    <td>{{ $obat->pemakaian }}</td>
                                    <td>{{ $obat->namkat }}</td>
                                    <td>{{ $obat->namsat }}</td>
                                </tr>
                            @endforeach
                                
                            </tbody>
                            
                        </table>
                        <button class="btn btn-success" wire:click="hapusZ({{ $this->penggunaTerpilih->id }})">dibayar</button>
                        <button class="btn btn-warning" wire:click="printZ({{ $this->penggunaTerpilih->id }})">cetak</button>
                    </div>
                </div>
            @endif
        </div>
    </div>
   
</div>