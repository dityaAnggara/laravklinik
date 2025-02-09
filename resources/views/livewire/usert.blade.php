<div>
    <div class="container">
        <div class="row my-2">
            <div class="col-12">
                
                    <button wire:click="pilihMenu('lihat')" 
                    class="btn {{ $pilihanMenu=='lihat' ? 'btn-primary' : 'btn-outline-primary' }}">
                        Data Staff
                    </button>
                    <button wire:click="pilihMenu('tambah')" 
                    class="btn {{ $pilihanMenu=='tambah' ? 'btn-primary' : 'btn-outline-primary' }}">
                        Tambah Staff
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
                       <h3>Table Staff</h3> 
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead class="table-dark">
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Jenis Kelamin</th>
                                <th>Role</th>
                                <th>Data</th>
                            </thead>
                            <tbody>
                                @foreach ($semuaPengguna as $pengguna)
                                    <tr
                                    class="{{ $loop->iteration % 2 == 0 ? 'table-danger' : 'table-primary' }}">
                                        <td>{{ $pengguna->nik }}</td>
                                        <td>{{ $pengguna->name }}</td>
                                        <td>{{ $pengguna->email }}</td>
                                        <td>{{ $pengguna->telepone }}</td>
                                        <td>{{ $pengguna->jk }}</td>
                                        <td>{{ $pengguna->role }}</td>
                                        <td></td>
                                            
                                    </tr>
                                @endforeach
                                
                            </tbody>
                            
                        </table>
                        
                    </div>
                    <p class="text-center">{{ $semuaPengguna->links() }}</p>
                </div>
                @elseif ($pilihanMenu=='tambah')
                <div class="card border-primary col-md-6">
                    <div class="card-header">Form Staff</div>
                    <div class="card-body">
                        <form wire:submit='simpan'>
                            @csrf
                                <div class="mb-2 mt-2">
                                    <label class="text-bold">Nama</label>
                                    <input type="text"  class="form-control col-md-6 border-black" wire:model.live='name'/>
                                    @error('name')
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
                                    <label class="text-bold">Password</label>
                                <input type="password"  class="form-control col-md-6 border-black" wire:model.live='password'/>
                                @error('password')
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
                                <div class="mb-2 mt-2">
                                    <label>Role</label>
                                <select class="form-control border-black" wire:model.live='role'>
                                    <option >==Role==</option>
                                    <option value="admin">Admin</option>
                                    <option value="dokter">Dokter</option>
                                    <option value="apoteker">Apoteker</option>
                                </select>
                                @error('role')
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
