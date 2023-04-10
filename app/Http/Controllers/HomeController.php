<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $date_absensi = date("Y-m-d");
        $user_id = Auth::user()->id;
        $presensi = Absen::where(['date_absensi' => $date_absensi, 'user_id' => $user_id])->latest()->first();
        return view('home.index', compact('presensi'));
    }

    public function create(Absen $absen)
    {
        $date_absensi = date("Y-m-d");
        $user_id = Auth::user()->id;
        $absens = Absen::where(['date_absensi'=> $date_absensi, 'user_id' => $user_id])->count();
        return view('home.create', compact('absens'));
    }

    public function store(Request $request)
    {
        $user_id = Auth::user()->id;
        $date_absensi = date("Y-m-d");
        $time_in = date("H:i:s");

        $latitudeKantor = -1.4510862330048337;
        $longitudeKantor = 122.37980866211892;

        $lokasi = $request->lokasi;
        $lokasiUser = explode(",", $lokasi);
        $latitudeUser = $lokasiUser[0];
        $longitudeUser = $lokasiUser[1];

        $jarak = $this->distance($latitudeKantor, $longitudeKantor, $latitudeUser, $longitudeUser);
        $radius = round($jarak["meters"]);

        $check = Absen::where(['date_absensi'=> $date_absensi, 'user_id' => $user_id])->count();
        if($check > 0){
            $ket = "out";
        }else{
            $ket = 'in';
        }

        $image = $request->image;
        $folderPath = "public/uploads/absensi/";
        $formatName = $user_id . "-" . $date_absensi . "-" . $ket;
        $image_parts = explode(";base64", $image);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $formatName . ".png";
        $file = $folderPath . $fileName;
        $absens = Absen::where(['date_absensi'=> $date_absensi, 'user_id' => $user_id])->count();
        if($radius > 200000000000){
            echo "error|Maaf Anda Berada di luar Radius, Jarak Anda ".$radius." meter dari Kantor|radius";
        }else{
            if($absens > 0){
                $data_pulang=[
                    'time_out' => $time_in,
                    'photo_out' => $fileName,
                    'location_out' => $lokasi
                ];
            $update = Absen::where(['date_absensi'=> $date_absensi, 'user_id' => $user_id])->update($data_pulang);
                if($update){
                    echo "success|Terima Kasih, Hati-Hati di jalan|out";
                    Storage::put($file, $image_base64);
                }else{
                    echo "error|Maaf Anda gagal Absen. Hubungi Admin|out";
                }
            }else{
                $data_masuk=[
                    'user_id' => $user_id,
                    'date_absensi' => $date_absensi,
                    'time_in' => $time_in,
                    'photo_in' => $fileName,
                    'location_in' => $lokasi
                ];
            $save = Absen::create($data_masuk);
                if($save){
                    echo "success|Terima Kasih, Selamat Bekerja|in";
                    Storage::put($file, $image_base64);
                }else{
                    echo "error|Maaf Anda gagal Absen. Hubungi Admin|in";
                    }
                }
            }

    }

    //Menghitung Jarak
    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }
}
