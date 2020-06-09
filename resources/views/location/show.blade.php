@extends('layouts/contentLayoutMaster')

@section('title', '位置详情')

@section('content')
    <!-- gmaps Examples section start -->
    <section id="maps">
        <div class="row">
        <div class="col-xl-4 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <h4 class="card-title">位置信息</h4>
                        <p class="card-text">在这里展示当前位置信息的详情，包括经纬度，记录时间，记录设备等</p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <span class="badge badge-primary float-right">{{ $location->updated_at }}</span>
                            更新时间
                        </li>
                        <li class="list-group-item">
                            <span class="badge badge-primary float-right">{{ $location->created_at }}</span>
                            创建时间
                        </li>
                        <li class="list-group-item">
                            <span class="badge badge-secondary float-right">{{ $device->phone }}</span>
                            设备手机号
                        </li>
                        <li class="list-group-item">
                            <span class="badge badge-secondary float-right">{{ $device->name }}</span>
                            设备名
                        </li>
                        <li class="list-group-item">
                            <span class="badge badge-success float-right">{{ number_format($location['longitude'], 6, '.', '') }}</span>
                            经度
                        </li>
                        <li class="list-group-item">
                            <span class="badge badge-success float-right">{{ number_format($location['latitude'], 6, '.', '') }}</span>
                            纬度
                        </li>
                    </ul>
                    <div class="card-body">
{{--                        <a href="#" class="card-link">Card link</a>--}}
{{--                        <a href="#" class="card-link">Another link</a>--}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">地图展示</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">

                        <p class="card-text">使用百度地图 JavaScript 3.0 进行展示 <strong>支持移动端&电脑端</strong> 。</p>

                        <div id="basic-map" class="height-400"></div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

    <!-- gmaps Examples section End -->
@endsection

@section('vendor-script')
    <!-- vendor files -->
    <script type="text/javascript" src="//api.map.baidu.com/api?v=3.0&ak=Q8xLPZsNKQvOjboqAYK2cKVs5DTjC25y"></script>
@endsection
@section('page-script')
    <!-- Page js files -->
    <script type="text/javascript">
        // 百度地图API功能
        var map = new BMap.Map("basic-map");
        var point = new BMap.Point({{ $location->longitude }}, {{ $location->latitude }});
        map.centerAndZoom(point, 15);
        var marker = new BMap.Marker(point);  // 创建标注
        map.addOverlay(marker);               // 将标注添加到地图中
        marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
    </script>
@endsection
