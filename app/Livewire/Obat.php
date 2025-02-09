<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Obat as ModelObat;
use App\Models\Satuan;
use App\Models\Categorie;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use App\Models\Price as ModelPrice;
use Illuminate\Support\Facades\DB;

class Obat extends Component
{
    use WithPagination; 
    use WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';
    public $nama;
    public $obat;
    public $pemakaian;
    public $satuan;
    public $harga;
    public $berat;
    public $kategori;
    public $stharga;
    public $enharga;
    public $hgobat;
    public $pilihanMenu = 'lihat';
    public $penggunaTerpilih;
    public function pilihMenu($menu)
    {
        $this->pilihanMenu = $menu;
    }
    public function simpanSatuan()
    {
        $simpan = new Satuan();
        $simpan->nama = $this->nama;
        $simpan->save();
       $this->reset(['nama']);
       $this->pilihanMenu = 'lihat';
    }
    public function simpanKategori()
    {
        $simpan = new Categorie();
        $simpan->kategori = $this->kategori;
        $simpan->save();
       $this->reset(['kategori']);
       $this->pilihanMenu = 'lihat';
    }
    public function simpan()
    {
        $this->validate([
            'obat' => 'required',
            'pemakaian' => 'required',
            'berat' => 'required',
           

        ],[
            'obat.required' => 'Nama obat harus diisi',
            'pemakaian.required' => 'pemakaian harus diisi',
            'berat.required' => 'berat harus diisi',
            
            
            

        ]);
        $simpan = new ModelObat();
        $simpan->obat = $this->obat;
        $simpan->pemakaian = $this->pemakaian;
        $simpan->satuan_id = $this->satuan;
        $simpan->berat = $this->berat;
        $simpan->kategori_id = $this->kategori;
        $simpan->save();
       $this->reset(['kategori', 'obat', 'pemakaian', 'satuan', 'berat']);
       $this->pilihanMenu = 'lihat';
    }
    public function hrgobat($id)
    {
        $this->penggunaTerpilih = ModelObat::findOrfail($id);
        
        $this->pilihanMenu = 'updhrga';
    }
    public function setharga()
    {
        $simpan = new ModelPrice();
        $simpan->obat_id = $this->penggunaTerpilih->id;
        $simpan->harga = $this->hgobat;
        $simpan->tanggal_berlaku = $this->stharga;
        $simpan->tanggal_akhir = $this->enharga;
        $simpan->save();
        $this->reset(['penggunaTerpilih']);
        $this->pilihanMenu = 'lihat';

    }
    public function render()
    {
        $oobaat = DB::table('obats')->join('prices', 'obats.id', '=', 'prices.obat_id')
        ->join('categories', 'obats.kategori_id', '=', 'categories.id')
        ->join('satuans', 'obats.satuan_id', '=', 'satuans.id')
        ->select('obats.id as idob','categories.kategori as namkat', 'satuans.nama as namsat','obats.obat as obat', 'prices.harga as harga', 'obats.pemakaian as pemakaian', 'obats.berat as berat')
        ->where('prices.tanggal_akhir', '>' , date("Y-m-d"))->paginate(1);
        $arid = [];
        foreach($oobaat as $vat){
            array_push($arid, $vat->idob);
            
        }
        $obbatt = DB::table('obats')->join('categories', 'obats.kategori_id', '=', 'categories.id')
        ->join('satuans', 'obats.satuan_id', '=', 'satuans.id')
        ->select('obats.id as idob','categories.kategori as namkat', 'satuans.nama as namsat','obats.obat as obat', 'obats.pemakaian as pemakaian', 'obats.berat as berat')
        ->whereNotIn('obats.id', $arid)->paginate(2);
        
        //$oobaat = DB::table('obats')->join('prices', 'obats.id', '=', 'prices.obat_id')
        //->select('obats.obat as obat', 'prices.harga as harga')->where('tanggal_akhir', '>' , date("Y-m-d"))->first();
        
        return view('livewire.obat',  ['oobat' => $oobaat , 'obbat' => $obbatt,
        'saatuan' => Satuan::count(), 
        'kategor' => Categorie::count(), 
        'stuan' => Satuan::all(), 
        'kateg' => Categorie::all()]);
    }
}
