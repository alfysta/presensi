@extends('layouts.master')

@section('content')

<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="/home" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">E-Presensi</div>
    <div class="right"></div>
</div>

<div id="appCapsule">
    <div class="section full mt-2">
        <div class="section-title">Title</div>
        <div class="wide-block pt-2 pb-2">
            <input type="hidden" id="lokasi">
            <div class="webcam-capture">
            </div>
        </div>
        <div class="row justify-content-center align-items-center ">
            @if ($absens > 0)
                <button id="takeabsen" class="btn btn-danger my-2">
                    <ion-icon name="camera-outline"></ion-icon>
                    Absen Pulang
                </button>
            @else
                <button id="takeabsen" class="btn btn-primary my-2">
                    <ion-icon name="camera-outline"></ion-icon>
                    Absen Masuk
                </button>
            @endif

        </div>
        <div class="row">
            <div class="col-md-6">
                <div id="map"></div>
            </div>
        </div>
    </div>
</div>

<style>
    .webcam-capture,
    .webcam-capture video{
        display: inline-block;
        width: 100% !important;
        margin: auto;
        height: auto !important;
        border-radius: 15px;
    }

    #map{
        height: 180px;
        }
</style>
<audio id="notifikasi_in">
    <source src="{{asset('assets/sound/notifikasi_in.mp3')}}" type="audio/mpeg">
</audio>
<audio id="notifikasi_out">
    <source src="{{asset('assets/sound/notifikasi_out.mp3')}}" type="audio/mpeg">
</audio>
<audio id="radius">
    <source src="{{asset('assets/sound/radius.mp3')}}" type="audio/mpeg">
</audio>
@endsection


@push('myscript')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
<script>
    var notifikasi_in = document.getElementById('notifikasi_in')
    var notifikasi_out = document.getElementById('notifikasi_out')
    var radius = document.getElementById('radius')
    Webcam.set({
        height:480,
        widht:640,
        image_format:'jpeg',
        jpeg_quality:80,
    });

    Webcam.attach('.webcam-capture');

    var lokasi = document.getElementById('lokasi');
        if(navigator.geolocation){
        navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
        }

function successCallback(position){
    lokasi.value = position.coords.latitude +","+ position.coords.longitude;
    var map = L.map('map').setView([position.coords.latitude, position.coords.longitude],18);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {maxZoom: 19, attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'}).addTo(map);

    var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
    var circle = L.circle([-1.4510862330048337, 122.37980866211892], {
        color: 'red',
        fillColor: '#f03',
        fillOpacity: 0.5,
        radius: 20
    }).addTo(map);

}

function errorCallback(){

}

</script>
<script>
$("#takeabsen").click(function(e){
    Webcam.snap(function(uri){
        image = uri;
    });
    var lokasi = $("#lokasi").val();
    $.ajax({
        type: 'POST',
        url: '/home/store',
        data:{
            _token:"{{csrf_token()}}",
            image: image,
            lokasi: lokasi
        },
        cache:false,
        success:function(respond){
            var status = respond.split("|");
            if(status[0] == "success"){
                if(status[2] == 'in'){
                    notifikasi_in.play();
                }else{
                    notifikasi_out.play();
                }
                Swal.fire({
                    title: 'Success',
                    text: status[1],
                    icon: status[0],
                    })
                    setTimeout("location.href='/home'", 2000)
            }else{
                if(status[2] == 'radius'){
                    radius.play();
                }
                Swal.fire({
                    title: 'Error !',
                    text: status[1],
                    icon: status[0],
                    })
            }
        }
    });
});

</script>
@endpush
