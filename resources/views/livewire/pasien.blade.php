
<div>
    <div class="container">
        <div class="row my-2">
            <div class="col-12">
                
                    <button wire:click="pilihMenu('lihat')" 
                    class="btn {{ $pilihanMenu=='lihat' ? 'btn-primary' : 'btn-outline-primary' }}">
                        Data Pasien
                    </button>
                    <button wire:click="pilihMenu('tambah')" 
                    class="btn {{ $pilihanMenu=='tambah' ? 'btn-primary' : 'btn-outline-primary' }}">
                        Tambah Pasien
                    </button>
                    <button wire:click="pilihMenu('tambahin')" 
                    class="btn {{ $pilihanMenu=='tambahin' ? 'btn-primary' : 'btn-outline-primary' }}">
                        Jadwal Checkup
                    </button>
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
                       <h3>Table Pasien</h3> 
                    </div>
                    <div class="card-body">
                        <div class="mb-2 col-2">
                            <label > search</label>
                            <input type="text" wire:model.live='search'  class="form-control border-black" />
                        </div>
                        
                        <table id="example" class="table table-striped nowrap">
                            <thead class="table-dark">
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Jenis Kelamin</th>
                                <th>Tanggal lahir</th>
                                <th>Umur</th>
                                <th>Data</th>
                            </thead>
                            <tbody>
                                @foreach ($semuaPengguna as $pengguna)
                                    <tr
                                    class="{{ $loop->iteration % 2 == 0 ? 'table-danger' : 'table-primary' }}">
                                        <td>{{ $pengguna->nik }}</td>
                                        <td>{{ $pengguna->nama }}</td>
                                        <td>{{ $pengguna->email }}</td>
                                        <td>{{ $pengguna->telepone }}</td>
                                        <td>{{ $pengguna->jk }}</td>
                                        <td>{{ $pengguna->tanggal_lahir }}</td>
                                        <td>{{ date_diff(date_create($pengguna->tanggal_lahir), now())->y }}</td>
                                        <td>
                                            <button wire:click="daftrch({{ $pengguna->id }})" 
                                                class="btn {{ $pilihanMenu=='daftar' ? 'btn-success' : 'btn-outline-success' }}">
                                                     Daftar Checkup
                                                </button>
                                        </td>
                                            
                                    </tr>
                                @endforeach
                                
                            </tbody>
                            
                        </table>
                        
                    </div>
                    <p class="text-center">{{ $semuaPengguna->links() }}</p>
                </div>
                @elseif ($pilihanMenu=='tambah')
                        <div class="card border-primary col-md-6">
                            <div class="card-header">Form Pasien</div>
                            <div class="card-body">
                                <form wire:submit='simpan'>
                                    @csrf
                                        <div class="mb-2 mt-2">
                                            <label class="text-bold">Nama</label>
                                            <input type="text"  class="form-control col-md-6 border-black" wire:model.live='nama'/>
                                            @error('nama')
                                                <span class="text-danger mb-2">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-2 mt-2">
                                            <label class="text-bold">NIK</label>
                                        <input type="text"  class="form-control col-md-6 border-black" wire:model.live='nik'/>
                                        @error('nik')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        </div>
                                        <div class="mb-2 mt-2">
                                            <label>Email</label>
                                        <input type="email"  class="form-control col-md-6 border-black" wire:model='email'/>
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        </div>
                                        <div class="mb-2 mt-2">
                                            <label class="text-bold">Phone</label>
                                        <input type="text"  class="form-control col-md-6 border-black" wire:model.live='telepone'/>
                                        @error('telepone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        </div>
                                        <div class="mb-2 mt-2">
                                            <label>Jenis Kelamin</label>
                                        <select class="form-control border-black" wire:model.live='jk'>
                                            <option >==Jenis Kelamin==</option>
                                            <option value="laki">Laki-laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                        </div>
                                        <div class="mb-2 mt-3">
                                            <label>Tanggal lahir</label>
                                        <input class="form-control col-md-6 border-black" type="date" id="umur" name="umur" wire:model.live='umur'>
                                        </div>
                                        
                                        <button type="submit" class="btn btn-danger mt-3">Simpan</button>
                                </form>
                            </div>
                        </div>
                @elseif ($pilihanMenu=='daftar')
                <div class="card border-primary col-md-6">
                    <div class="card-header">
                       <h3>Form Daftar Checkup Pasien</h3> 
                    </div>
                    <div class="card-body">
                       <form wire:submit='dftrchkup'>
                        @csrf
                        <p>Nama Pasien: {{ $penggunaTerpilih->nama }}</p>
                            <input type="text" hidden value="{{ $penggunaTerpilih->id }}" class="form-control col-md-6 border-black" wire:model.live='nampas'/>
                            <div class="mb-2 mt-2">
                                <label>Dokter</label>
                            <select class="form-control border-black" wire:model='dtrjaga'>
                               
                                <option >==pilih dokter==</option>
                                 @foreach ($dokterjaga as $dktrjg )
                                    <option value="{{ $dktrjg->id }}">{{ $dktrjg->name }}</option>
                                @endforeach
                            </select>
                            </div>
                            <div class="mb-2 mt-3">
                                <label>Tanggal checkup</label>
                            <input class="form-control col-md-6 border-black" type="date" id="umur" name="umur" wire:model.live='tgldaftar'>
                            </div>
                            <button type="submit" class="btn btn-danger mt-3">Simpan</button>
                       </form>
                    </div>
                </div>
                @elseif ($pilihanMenu=='tambahin')
                <div class="card border-primary">
                    <div class="card-header">
                       <h3>Jadwal Checkup</h3> 
                    </div>
                        <table id="example" class="table table-striped nowrap">
                            <thead class="table-dark">
                                <th>Nama Pasien</th>
                                <th>Nama Dokter</th>
                                <th>Nomor Pendaftaran</th>
                                <th>Status</th>
                                <th>Tanggal jadwal Checkups</th>
                                <th>Data</th>
                            </thead>
                            <tbody>
                                
                                @foreach ($chp as $pasien)
                                <tr
                                class="{{ $loop->iteration % 2 == 0 ? 'table-danger' : 'table-primary' }}">
                                        
                                        <td>{{ $pasien->nampas }}</td>
                                        <td>{{ $pasien->dokter }}</td>
                                        <td>{{ $pasien->npd }}</td>
                                        <td>{{ $pasien->stats }}</td>
                                        <td>{{ $pasien->tanggal }}</td>
                                        <td>
                                            <button wire:click="ubhjad({{ $pasien->iad }})" 
                                                class="btn {{ $pilihanMenu=='taxc' ? 'btn-success' : 'btn-outline-success' }}">
                                                    Ubah Jadwal
                                                </button>
                                                @if ($pasien->stats != 'batal')
                                                    <button wire:click="btlc({{ $pasien->iad }})" 
                                                class="btn {{ $pilihanMenu=='taxd' ? 'btn-success' : 'btn-outline-danger' }}">
                                                    Batalkan Check Up
                                                </button> 
                                                @endif 
                                                
                                        </td>
                                        
                                       
                                        
                                    </tr>
                                    @endforeach
                            </tbody>
                            
                        </table>
                        
                    </div>
                    <p class="text-center">{{ $chp->links() }}</p>
                </div>
                @elseif ($pilihanMenu=='tambahen')
                
                <div class="card border-primary col-md-6">
                    <div class="card-header">
                       <h3>Form Daftar Checkup Pasien</h3> 
                    </div>
                    <div class="card-body">
                       <form wire:submit='dftrchkupz'>
                        @csrf
                        <p>Nama Pasien: {{ $this->mencret->pasien->nama }}</p>
                        <p>Nama Dokter: {{ $this->dtrjaga[0]->name}}</p>
                            
                            <div class="mb-2 mt-3">
                                <label>Tanggal checkup</label>
                            <input class="form-control col-md-6 border-black" type="date"   wire:model.live='tgldaftar'>
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
