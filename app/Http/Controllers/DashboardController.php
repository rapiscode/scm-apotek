<?php

namespace App\Http\Controllers;

use App\Services\FirestoreService;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct(protected FirestoreService $firestore) {}
    public function index()
    {
        $produks=$this->firestore->all('produks');
        $penjualans=$this->firestore->all('penjualans')->where('status','!=','draft');
        $totalPenjualan=$penjualans->sum(fn($p)=>(float)($p->total_penjualan??0));
        $returPenjualan=0; $penjualanTertolak=0; $databasePelanggan=0; $databaseSupplier=0; $databaseProduk=$produks->count(); $databaseDokter=0;
        $berpotensiRugi=1; $stokNegatif=$produks->filter(fn($p)=>(int)($p->stok??0)<0)->count(); $dekatKadaluarsa=1; $sudahKadaluarsa=0;
        $tipeProdukChart=['Obat'=>$produks->where('tipe_produk','Obat')->count(),'Alkes'=>$produks->where('tipe_produk','Alkes')->count(),'Umum'=>$produks->where('tipe_produk','Umum')->count()];
        $jamLabels=[]; $jamData=[]; for($i=0;$i<24;$i++){ $jamLabels[]=str_pad($i,2,'0',STR_PAD_LEFT).':00'; $jamData[]=$penjualans->filter(function($item)use($i){ $d=$item->created_at??$item->tanggal??null; return $d && Carbon::parse($d)->gte(now()->subDays(6)) && (int)Carbon::parse($d)->format('H')===$i; })->count(); }
        $hariOrder=['Monday'=>'Sen','Tuesday'=>'Sel','Wednesday'=>'Rab','Thursday'=>'Kam','Friday'=>'Jum','Saturday'=>'Sab','Sunday'=>'Min']; $hariDataMap=['Sen'=>0,'Sel'=>0,'Rab'=>0,'Kam'=>0,'Jum'=>0,'Sab'=>0,'Min'=>0];
        foreach($penjualans as $item){ $d=$item->created_at??$item->tanggal??null; if($d && Carbon::parse($d)->gte(now()->subWeeks(4))){ $hariDataMap[$hariOrder[Carbon::parse($d)->format('l')]??'Sen']++; }}
        $hariLabels=array_keys($hariDataMap); $hariData=array_values($hariDataMap);
        return view('Dashboard.index',compact('totalPenjualan','returPenjualan','penjualanTertolak','databasePelanggan','databaseSupplier','databaseProduk','databaseDokter','berpotensiRugi','stokNegatif','dekatKadaluarsa','sudahKadaluarsa','tipeProdukChart','jamLabels','jamData','hariLabels','hariData'));
    }
}
