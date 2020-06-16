
@extends('layouts/contentLayoutMaster')

@section('title', '定位')

@section('page-style')
    <!-- Page css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection
@section('content')
    {{-- Nav Centered And Nav End Starts --}}
    <section>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card overlay-img-card text-white">
                    <img src="{{ asset('images/pages/card-image-5.jpg') }}" class="card-img" alt="card-img-6">
                    <div class="card-img-overlay overlay-black">
                        <h5 class="font-medium-5 text-white text-center mt-4" id="location-title">定位中</h5>
                        <p class="text-white text-center">每30秒刷新位置</p>
                        <div class="card-content">
                            <div class="d-flex justify-content-around mt-2">
                                <div class="icon">
                                    <i class="feather icon-map-pin font-large-5"></i>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between mt-4">
                                    <div class="precipitation">
                                        <span class="font-medium-3">经度</span>
                                    </div>
                                    <div class="degree">
                                        <span class="font-medium-3" id="longitude">0</span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between my-2">
                                    <div class="humidity">
                                        <span class="font-medium-3">纬度</span>
                                    </div>
                                    <div class="degree">
                                        <span class="font-medium-3" id="latitude">0</span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between my-2">
                                    <div class="wind">
                                        <span class="font-medium-3">时间</span>
                                    </div>
                                    <div class="degree">
                                        <span class="font-medium-3" id="time">0000/0/0 00:00:00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Nav Centered And Nav End Ends --}}
@endsection

@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script type="text/javascript" src="//api.map.baidu.com/api?v=3.0&ak=Q8xLPZsNKQvOjboqAYK2cKVs5DTjC25y"></script>
    <script type="text/javascript" src="//api.map.baidu.com/api?v=1.0&type=webgl&ak=Q8xLPZsNKQvOjboqAYK2cKVs5DTjC25y"></script>
    <script type="text/javascript" src="//api.map.baidu.com/library/TrackAnimation/src/TrackAnimation_min.js"></script>

@endsection
@section('page-script')
    <!-- Page js files -->
    <script>
        $(document).ready(function () {
            getLocation();
            timeout = setInterval(getLocation, 30000);
        });


        function stopLocation() {
            clearInterval(timeout);
        }

        function getLocation() {
            var geolocation = new BMap.Geolocation();
            geolocation.getCurrentPosition(function(r){
                if(this.getStatus() == BMAP_STATUS_SUCCESS){
                    updateHtml(r.point.lng, r.point.lat);
                    upload(r.point.lng, r.point.lat);
                }
                else {
                    Swal.fire({
                        title: this.getStatus(),
                        type: "error",
                        confirmButtonClass: 'btn btn-primary',
                        buttonsStyling: false,
                    });
                }
            },{enableHighAccuracy: true})
        }

        function updateHtml(longitude, latitude) {
            var myGeo = new BMap.Geocoder({extensions_town: true});
            myGeo.getLocation(new BMap.Point(longitude, latitude), function(result){
                if (result){
                    $('#location-title').text(result.address);
                    $('#longitude').text(longitude);
                    $('#latitude').text(latitude);
                    $('#time').text(Date());
                }
            });
        }

        function upload(longitude, latitude){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'POST',
                url:'{{ route('location.store') }}',
                data:{
                    longitude: longitude,
                    latitude: latitude,
                    device: {{ $device->id }}
                },
                success:function(data){
                    Swal.fire({
                        title: "定位上报成功",
                        type: "success",
                        confirmButtonClass: 'btn btn-primary',
                        buttonsStyling: false,
                    });
                }
            });
        }
    </script>
@endsection
