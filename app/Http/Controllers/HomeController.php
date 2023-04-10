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

        return view('home.index');
    }

    public function create(Absen $absen)
    {
        $date_absensi = date("Y-m-d");
        $user_id = Auth::user()->id;
        $absens = Absen::where(['date_absensi'=> $date_absensi, 'user_id' => $user_id])->count();
        return view('home.create', compact('absens'));
    }

    public function store(Request $request, Absen $absen)
    {
        $user_id = Auth::user()->id;
        $date_absensi = date("Y-m-d");
        $time_in = date("H:i:s");
        $lokasi = $request->lokasi;
        $image = $request->image;
        $folderPath = "public/uploads/absensi/";
        $formatName = $user_id . "-" . $date_absensi;
        $image_parts = explode(";base64", $image);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $formatName . ".png";
        $file = $folderPath . $fileName;
        $absens = Absen::where(['date_absensi'=> $date_absensi, 'user_id' => $user_id])->count();
        if($absens > 0){
            $data_pulang=[
                'time_out' => $time_in,
                'photo_out' => $fileName,
                'location_out' => $lokasi
            ];
         $update = Absen::where(['date_absensi'=> $date_absensi, 'user_id' => $user_id])->update($data_pulang);
            if($update){
                echo "success|Terima Kasih, hati-hati di jalan|out";
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
