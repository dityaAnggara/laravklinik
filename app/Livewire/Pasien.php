<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Pasien as ModelPasien;
use App\Models\User;
use App\Models\Daftarcheckup as ModelDaftar;
use Illuminate\Support\Facades\DB;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Pasien extends Component
{
    use WithPagination; 
    use WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';
    public $nama;
    public $nik;
    public $email;
    public $telepone;
    public $jk;
    public $umur;
    public $nampas;
    public $tgldaftar;
    public $dtrjaga;
    public $search = "";
    public $pilihanMenu = 'lihat';
    public $penggunaTerpilih;
    public $mencret;
    public function simpan()
    {
        //dd($this->nama);
        $this->validate([
            'nama' => 'required',
            'nik' => ['required', 'numeric', 'unique:pasiens,nik', 'min_digits:10'],
            'telepone' => ['required', 'numeric', 'unique:pasiens,telepone', 'min_digits:10'],
            'email' => ['required', 'email', 'unique:pasiens,email'],
           

        ],[
            'nama.required' => 'Nama harus diisi',
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
            'telepone.min_digits' => 'telepone minimal 16 angka',
            

        ]);
        $simpan = new ModelPasien();
        $simpan->nama = $this->nama;
        $simpan->nik = $this->nik;
        $simpan->email = $this->email;
        $simpan->telepone = $this->telepone;
        $simpan->password = $this->telepone;
        $simpan->jk = $this->jk;
        $simpan->tanggal_lahir = $this->umur;
        $simpan->save();
        $simpret = new User();
        $simpret->name = $this->nama;
        $simpret->nik = $this->nik;
        $simpret->email = $this->email;
        $simpret->telepone = $this->telepone;
        $simpret->jk = $this->jk;
        $simpret->role = "pasien";
        $simpret->email = $this->email;
        $simpret->password = bcrypt($this->telepone);
        $simpret->save();
       $this->reset(['nama', 'nik', 'email', 'telepone', 'jk']);
       $this->pilihanMenu = 'lihat';
    }
    public function daftrch($id)
    {
        $this->penggunaTerpilih = ModelPasien::findOrfail($id);
        $this->pilihanMenu = 'daftar';
    }
    public function btlc($id)
    {
        $wrt = ModelDaftar::where('id', $id)->update(['status' => 'batal']);
        
        $this->pilihanMenu = 'tambahin';
    }
    public function ubhjad($id)
    {
        $this->mencret = ModelDaftar::findorfail($id);
        $this->dtrjaga = User::where('id', $this->mencret->dokter_id)->get();
        $this->tgldaftar = $this->mencret->tanggalcheckups;
        $this->pilihanMenu = 'tambahen';
    }
    public function dftrchkup()
    {
        $simpan = new ModelDaftar();
        $simpan->pasien_id = $this->penggunaTerpilih->id;
        $simpan->dokter_id = $this->dtrjaga;
        $simpan->status = 'belum';
        $simpan->tanggalcheckups = $this->tgldaftar;
        $simpan->nomor_pendaftaran = strval($this->penggunaTerpilih->id) . "/" . strval($this->dtrjaga) . " " . date("d/m/Y");
        $simpan->save();
       $this->reset(['penggunaTerpilih']);
       $this->pilihanMenu = 'lihat';

    }
    public function dftrchkupz()
    {
      
        $d = ModelDaftar::find($this->mencret->id);
        //$d->dokter_id = $this->dtrjaga;
        $d->status = 'belum';
        $d->tanggalcheckups = $this->tgldaftar;
        $d->save();
        $this->pilihanMenu = 'lihat';
    }
    public function pilihMenu($menu)
    {
        $this->pilihanMenu = $menu;
    }
    public function render()
    {
        $dftrck = DB::table('daftarcheckups')->join('users', 'daftarcheckups.dokter_id', '=', 'users.id')
        ->join('pasiens', 'pasiens.id', '=', 'daftarcheckups.pasien_id')
        ->select('daftarcheckups.id as iad','pasiens.nama as nampas', 'users.name as dokter', 'daftarcheckups.status as stats', 'daftarcheckups.nomor_pendaftaran as npd', 'daftarcheckups.tanggalcheckups as tanggal')->paginate(2);
        return view('livewire.pasien',['chp' => $dftrck,'semuaPengguna' => ModelPasien::search($this->search)->paginate(2), 
        'dokterjaga' => User::where('role', 'dokter')->get()]);
    }
}
