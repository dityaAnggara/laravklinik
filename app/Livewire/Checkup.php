<?php

namespace App\Livewire;

use Livewire\WithFileUploads;
use Livewire\Component;
use App\Models\Checkup as ModelCheckup;
use App\Models\Daftarcheckup as Daftar;
use App\Models\Berkas as Bks;
use App\Models\Resep;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Request;
use Tymon\JWTAuth\Http\Middleware\Check as MiddlewareCheck;

class Checkup extends Component
{
    use WithFileUploads;
 
    public $photo;
    public $kode;
    public $pilihanMenu = 'lihat';
    public $penggunaTerpilih;
    public $otb = "";
    public $ottb;
    public $cttn;
    public $brrt;
    public $tngi;
    public $nmrpdf;
    public $notb = array();
    public $tampll;
    public $bkas;
    public $lainvar;
    public function pilihMenu($menu)
    {
        $this->pilihanMenu = $menu;
    }
    public function savex()
    {
        //dd($this->notb);
        foreach($this->notb as $key => $value)
        {
             Resep::where([
                'daftar_id' => $this->penggunaTerpilih->id,
                'obat_id' => $key
             ])->update(['note_obat' => $value]);
            //echo $key;
        }
        $te = DB::table('daftarcheckups')->join('pasiens', 'daftarcheckups.pasien_id', '=', 'pasiens.id')
        ->select('pasiens.nik as nikk')->where('daftarcheckups.id', '=', $this->penggunaTerpilih->id)->get();
        $tu = DB::table('checkups')
        ->select('id')
        ->where('daftar_id', '=', $this->penggunaTerpilih->id)->get();

        $mpun = ModelCheckup::find($tu[0]->id);
        $mpun->note = $this->cttn;
        $mpun->berat = $this->brrt;
        $mpun->tinggi = $this->tngi;
        $mpun->save();
        
       
       //dd($this->tampll);
        $this->validate([
             'photo' => 'file|mimes:png,jpg,pdf,txt|max:1024', // 1MB Max
         ]);
        
        $org = $this->photo->getClientOriginalName();
 
        $this->photo->storeAs($te[0]->nikk, $org);
        $this->photo->storeAs($te[0]->nikk, $org);
        $baseUrl = Request::root();
        $mpan = new Bks();
        $mpan->nik = $te[0]->nikk;
        $mpan->path = $baseUrl.'/storage/'.$te[0]->nikk.'/'.$org;
        $mpan->save();
        
       $this->reset(['brrt', 'tngi', 'cttn', 'notb']);
        $this->pilihanMenu = 'lihat';
    }
    public function updatedKode()
    {
        $spin = new Resep();
        $spin->obat_id = $this->kode;
        $spin->daftar_id = $this->penggunaTerpilih->id;
        $spin->save();
        $this->reset('kode');
       
    }
    public function hapusP($id)
    {
        $ty = Resep::where([
            ['obat_id', '=', $id],
            ['daftar_id', '=', $this->penggunaTerpilih->id]
        ]);
        $ty->delete();
    }
    public function hapusZ($id)
    {
        $ty = Daftar::find($id);
        $ty->status = "sudah";
        $ty->save();
        $this->pilihanMenu = 'lihatch';
        //$this->reset(['penggunaTerpilih']);
    }
    public function printZ($id)
    {
        $this->penggunaTerpilih = Daftar::findOrfail($id);
        $this->otb = DB::table('reseps')->join('obats', 'obats.id', '=', 'reseps.obat_id')
        ->join('categories', 'obats.kategori_id', '=', 'categories.id')
        ->join('satuans', 'obats.satuan_id', '=', 'satuans.id')
        ->join('daftarcheckups', 'reseps.daftar_id', '=', 'daftarcheckups.id')
        ->join('pasiens', 'pasiens.id', '=', 'daftarcheckups.pasien_id')
        ->join('users', 'users.id', '=', 'daftarcheckups.dokter_id')
        ->join('prices', 'obats.id', '=', 'prices.obat_id')
        ->select('reseps.note_obat as nots','daftarcheckups.tanggalcheckups as tanggalc','pasiens.nama as nampas','users.name as doknam','obats.id as idob', 'prices.harga as harga','categories.kategori as namkat', 'satuans.nama as namsat','obats.obat as obat', 'obats.pemakaian as pemakaian', 'obats.berat as berat')
        ->where([
            ['reseps.daftar_id', '=' , $this->penggunaTerpilih->id],
            ['prices.tanggal_akhir', '>' , date("Y-m-d")],
        ])->get();

        $data = [
            'batu' => $this->otb,
        ];

            $pdf = Pdf::loadView('livewire/resep-pdf', $data);
            return response()->streamDownload(function() use($pdf){
                echo $pdf->stream();
            }, 'resep.pdf');
    }
    public function mulaicheck($id)
    {
        $ty = ModelCheckup::where('daftar_id', '=', $id)->count();
        $cev = new ModelCheckup();
        $cev->daftar_id = $id;
        if($ty < 1){
            $cev->save();
        }
        
        $this->penggunaTerpilih = Daftar::findOrfail($id);
        $this->bkas = DB::table('berkas')
        ->select('path')
        ->where('nik', '=', $this->penggunaTerpilih->pasien->nik)->get();
        $this->tampll = ModelCheckup::where('daftar_id', '=', $id)->get();
        $this->lainvar = Resep::where('daftar_id', '=', $id)->get();
       // dd(count($this->lainvar));
        $jmjum = count($this->lainvar);
        if($jmjum != 0)
        {
            for($kol = 0; $kol < $jmjum; $kol++)
            {
                $this->notb[$this->lainvar[$kol]->obat_id] = $this->lainvar[$kol]->note_obat;
            }
        }
        //
        $this->tngi = $this->tampll[0]->tinggi;
        $this->brrt =  $this->tampll[0]->berat;
        $this->cttn = $this->tampll[0]->note;
        $this->pilihanMenu = 'tam';
    }
    public function resepcheck($id)
    {
       
        $this->penggunaTerpilih = Daftar::findOrfail($id);
        
        $this->pilihanMenu = 'tamm';
    }
    public function render()
    {
        $oobaat = DB::table('obats')->join('prices', 'obats.id', '=', 'prices.obat_id')
        ->join('categories', 'obats.kategori_id', '=', 'categories.id')
        ->join('satuans', 'obats.satuan_id', '=', 'satuans.id')
        ->select('obats.id as idob','categories.kategori as namkat', 'satuans.nama as namsat','obats.obat as obat', 'prices.harga as harga', 'obats.pemakaian as pemakaian', 'obats.berat as berat')
        ->where('prices.tanggal_akhir', '>' , date("Y-m-d"))->get();
        if($this->penggunaTerpilih !=""){
            $this->otb = DB::table('reseps')->join('obats', 'obats.id', '=', 'reseps.obat_id')
        ->join('categories', 'obats.kategori_id', '=', 'categories.id')
        ->join('satuans', 'obats.satuan_id', '=', 'satuans.id')
        ->join('daftarcheckups', 'reseps.daftar_id', '=', 'daftarcheckups.id')
        ->select('reseps.note_obat as nobat','obats.id as idob','categories.kategori as namkat', 'satuans.nama as namsat','obats.obat as obat', 'obats.pemakaian as pemakaian', 'obats.berat as berat')
        ->where('reseps.daftar_id', '=' , $this->penggunaTerpilih->id)->get();
        }
        
        return view('livewire.checkup',['yup' => $this->tampll, 'batt' => $this->otb,'oobat' => $oobaat, 'pasiencheck' => Daftar::where([
            ['tanggalcheckups', date("Y-m-d")],
            ['dokter_id',  Auth::user()->id],
            ['status', '=', 'belum']])->get(), 'pasiencheckk' => Daftar::where([
                ['tanggalcheckups', date("Y-m-d")],
                ['status', '=', 'belum']])->get()
        ]);
    }
}
