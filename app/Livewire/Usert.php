<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User as ModelUser;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Usert extends Component
{
    public $pilihanMenu = 'lihat';
    use WithPagination; 
    use WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';
    public $name;
    public $nik;
    public $email;
    public $telepone;
    public $jk;
    public $role;
    public $password;
    public function simpan()
    {
        $this->validate([
            'name' => 'required',
            'password' => 'required',
            'role' => 'required',
            'nik' => ['required', 'numeric', 'unique:pasiens,nik', 'min_digits:10'],
            'telepone' => ['required', 'numeric', 'unique:pasiens,telepone', 'min_digits:10'],
            'email' => ['required', 'email', 'unique:pasiens,email'],
           

        ],[
            'name.required' => 'Nama harus diisi',
            'password.required' => 'password harus diisi',
            'role.required' => 'role harus dipilih',
            'nik.required' => 'nik harus diisi',
            'nik.numeric' => 'Format harus angka',
            'nik.unique' => 'nik telah digunakan',
            'nik.min_digits' => 'nik minimal 10 angka',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak sesuai',
            'email.unique' => 'email telah digunakan',
            'telepone.required' => 'telepone harus diisi',
            'telepone.numeric' => 'Format harus angka',
            'telepone.unique' => 'telepone telah digunakan',
            'telepone.min_digits' => 'telepone minimal 10 angka',
            

        ]);
        $simpan = new ModelUser();
        $simpan->name = $this->name;
        $simpan->nik = $this->nik;
        $simpan->email = $this->email;
        $simpan->password = bcrypt($this->password);
        $simpan->telepone = $this->telepone;
        $simpan->jk = $this->jk;
        $simpan->role = $this->role;
        $simpan->save();
       $this->reset(['name', 'email', 'password', 'telepone', 'nik', 'jk', 'role']);
       $this->pilihanMenu = 'lihat';
    }
    public function pilihMenu($menu)
    {
        $this->pilihanMenu = $menu;
    }
    public function render()
    {
        return view('livewire.usert')->with(['semuaPengguna' => ModelUser::where('role', '!=', 'pasien')->paginate(2)]);
    }
}
