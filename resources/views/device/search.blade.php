
@extends('layouts/contentLayoutMaster')

@section('title', '时间序列位置展示')

@section('page-style')
    <!-- Page css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection
@section('content')
    {{-- Nav Centered And Nav End Starts --}}
    <section>
        <div class="row">
            <div class="col-xl-4 col-md-5 col-sm-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <h4 class="card-title mb-1">时间范围</h4>
                            <div class="form-group">
                                <label for="feedback1" class="sr-only">时间段</label>
                                <input type="text" id="datetime-start" class="form-control" placeholder="开始时间">
                            </div>
                            <div class="form-group">
                                <label for="feedback1" class="sr-only">时间段</label>
                                <input type="text" id="datetime-end" class="form-control" placeholder="结束时间">
                            </div>
                            <button class="btn btn-outline-primary waves-effect waves-light" id="datetime-search">查询</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 col-md-7 col-sm-12">
                <div class="card overflow-hidden">
                    <div class="card-header">
                        <h4 class="card-title">轨迹</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            @if($startTime && $endTime)
                                <p>从 <code>{{ $startTime->diffForHumans() }}</code> 到 <code>{{ $endTime->diffForHumans() }}</code> 的记录</p>
                            @else
                                <p>需要选择时间段</p>
                            @endif
                            <ul class="nav nav-tabs justify-content-center" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="line-tab-center" data-toggle="tab" href="#line-center"
                                       aria-controls="line-center" role="tab" aria-selected="true">时间线</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="map-tab-center" data-toggle="tab" href="#map-center"
                                       aria-controls="map-center" role="tab" aria-selected="false">交互地图</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="line-center" aria-labelledby="line-tab-center" role="tabpanel">
                                    @if($startTime && $endTime)
                                        <ul class="activity-timeline timeline-left list-unstyled">
                                            @foreach($locations as $key => $location)
                                                <li>
                                                    @if($key === 0)
                                                    <div class="timeline-icon bg-primary">
                                                        <i class="feather icon-plus font-medium-2"></i>
                                                    </div>
                                                    @elseif($key === count($locations)-1)
                                                        <div class="timeline-icon bg-success">
                                                            <i class="feather icon-check font-medium-2"></i>
                                                        </div>
                                                    @else
                                                        <div class="timeline-icon bg-warning">
                                                            <i class="feather icon-alert-circle font-medium-2"></i>
                                                        </div>
                                                    @endif
                                                    <div class="timeline-info">
                                                        <p class="font-weight-bold" id="location-{{ $key }}">地理位置解析中</p>
                                                        <span>经纬 ({{ number_format($location->longitude, 6, '.', '') }},{{ number_format($location->latitude, 6, '.', '') }})</span>
                                                    </div>
                                                    <small class="">{{ $location->created_at->diffForHumans() }}</small>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                                <div class="tab-pane" id="map-center" aria-labelledby="map-tab-center" role="tabpanel">
                                    @if($startTime && $endTime)
                                        <div id="line-map" class="height-400"></div>
                                    @endif
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
    <script src="{{ asset(mix('js/scripts/laydate/laydate.js')) }}"></script>

    @if($startTime && $endTime)
        <script>
            var myGeo = new BMap.Geocoder({extensions_town: true});
            @foreach($locations as $key => $location)
                myGeo.getLocation(new BMap.Point({{ $location->longitude }}, {{ $location->latitude }}), function(result){
                    if (result){
                        $('#location-{{ $key }}').text(result.address);
                    }
                });
            @endforeach
        </script>

        <script>
            var bmap = new BMapGL.Map("line-map");
            bmap.centerAndZoom(new BMapGL.Point({{ $locations[0]->longitude }}, {{ $locations[0]->latitude }}), 15);
            bmap.enableScrollWheelZoom(false);
            var path = [
            @foreach($locations as $key => $location)
                {
                    'lng': {{ $location->longitude }},
                    'lat': {{ $location->latitude }},
                },
            @endforeach
            ];
            var point = [];
            for (var i = 0; i < path.length; i++) {
                point.push(new BMapGL.Point(path[i].lng, path[i].lat));
            }
            var pl = new BMapGL.Polyline(point);

            var trackAni = new BMapGLLib.TrackAnimation(bmap, pl, {
                overallView: true, // 动画完成后自动调整视野到总览
                tilt: 55,          // 轨迹播放的角度，默认为55
                duration: 10000,   // 动画持续时长，默认为10000，单位ms
                delay: 3000        // 动画开始的延迟，默认0，单位ms
            });

            $("#map-tab-center").click(function () {
                trackAni.start();
            });

            $("#line-tab-center").click(function () {
                trackAni.cancel();
            });
        </script>
{{--        <script type="text/javascript">--}}
{{--            // GL版命名空间为BMapGL--}}
{{--            // 按住鼠标右键，修改倾斜角和角度--}}
{{--            $("#map-tab-center").click(function () {--}}
{{--                var bmap = new BMapGL.Map("line-map");    // 创建Map实例--}}
{{--                bmap.centerAndZoom(new BMapGL.Point(116.297611, 40.047363), 17);  // 初始化地图,设置中心点坐标和地图级别--}}
{{--                bmap.enableScrollWheelZoom(true);     // 开启鼠标滚轮缩放--}}

{{--                var path = [--}}
{{--                        @foreach($locations as $key => $location)--}}
{{--                    {--}}
{{--                        'lng': {{ $location->longitude }},--}}
{{--                        'lat': {{ $location->latitude }},--}}
{{--                    },--}}
{{--                    @endforeach--}}
{{--                ];--}}
{{--                var point = [];--}}
{{--                for (var i = 0; i < path.length; i++) {--}}
{{--                    point.push(new BMapGL.Point(path[i].lng, path[i].lat));--}}
{{--                }--}}
{{--                var pl = new BMapGL.Polyline(point);--}}
{{--                setTimeout('start()', 3000);--}}
{{--                function start () {--}}
{{--                    trackAni = new BMapGLLib.TrackAnimation(bmap, pl, {--}}
{{--                        overallView: true,--}}
{{--                        tilt: 30,--}}
{{--                        duration: 20000,--}}
{{--                        delay: 300--}}
{{--                    });--}}
{{--                    trackAni.start();--}}
{{--                }--}}
{{--            });--}}
{{--        </script>--}}
    @endif

    <script type="text/javascript">
        laydate.render({
            elem: '#datetime-start',
            type: 'datetime',
            value: '{{ $startTime }}',
            range: false,
        });

        laydate.render({
            elem: '#datetime-end',
            type: 'datetime',
            value: '{{ $endTime }}',
            range: false,
        });

        $("#datetime-search").click(function () {
            var start = $('#datetime-start').val();
            var end = $('#datetime-end').val();
            window.location.replace(encodeURI("{{ route('device.search', $device->id) }}/"+start+'/'+end));
        });
    </script>
    <script>
        @foreach (['error', 'warning', 'success', 'info'] as $msg)
        @if(session()->has($msg))
        $(document).ready(function () {
            Swal.fire({
                title: "{{ ucfirst($msg) }}",
                text: "{{ session()->get($msg) }}",
                type: "{{ $msg }}",
                confirmButtonClass: 'btn btn-primary',
                buttonsStyling: false,
            });
        });
            @endif
            @endforeach

            @if (count($errors) > 0)
        var message = '';
        @foreach($errors->all() as $error)
            message += "<p>{{ $error }}</p>";
        @endforeach
        $(document).ready(function () {
            Swal.fire({
                title: "Error",
                html: message,
                type: "error",
                confirmButtonClass: 'btn btn-primary',
                buttonsStyling: false,
            });
        });
        @endif
    </script>
@endsection
