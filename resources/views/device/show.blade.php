
@extends('layouts/contentLayoutMaster')

@section('title', '设备详情')

@section('vendor-style')
    {{-- vendor files --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/datatables.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/file-uploaders/dropzone.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/extensions/dataTables.checkboxes.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection
@section('page-style')
    {{-- Page css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/plugins/file-uploaders/dropzone.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/pages/data-list-view.css')) }}">
@endsection

@section('content')
    {{-- Data list view starts --}}
    <section id="data-list-view" class="data-list-view-header">
        {{--    <div class="action-btns d-none">--}}
        {{--      <div class="btn-dropdown mr-1 mb-1">--}}
        {{--        <div class="btn-group dropdown actions-dropodown">--}}
        {{--          <button type="button" class="btn btn-white px-1 py-1 dropdown-toggle waves-effect waves-light"--}}
        {{--                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
        {{--            Actions--}}
        {{--          </button>--}}
        {{--          <div class="dropdown-menu">--}}
        {{--            <a class="dropdown-item" href="#"><i class="feather icon-trash"></i>Delete</a>--}}
        {{--            <a class="dropdown-item" href="#"><i class="feather icon-archive"></i>Archive</a>--}}
        {{--            <a class="dropdown-item" href="#"><i class="feather icon-file"></i>Print</a>--}}
        {{--            <a class="dropdown-item" href="#"><i class="feather icon-save"></i>Another Action</a>--}}
        {{--          </div>--}}
        {{--        </div>--}}
        {{--      </div>--}}
        {{--    </div>--}}

        {{-- DataTable starts --}}
        <div class="table-responsive">
            <table class="table data-list-view">
                <thead>
                <tr>
                    <th></th>
                    <th>创建时间</th>
                    <th>经度</th>
                    {{--          <th>最后更新</th>--}}
                    <th>纬度</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($locations as $location)
                    {{--          @if($product["order_status"] === 'delivered')--}}
                    {{--              <?php $color = "success" ?>--}}
                    {{--          @elseif($product["order_status"] === 'pending')--}}
                    {{--              <?php $color = "primary" ?>--}}
                    {{--          @elseif($product["order_status"] === 'on hold')--}}
                    {{--              <?php $color = "warning" ?>--}}
                    {{--          @elseif($product["order_status"] === 'canceled')--}}
                    {{--              <?php $color = "danger" ?>--}}
                    {{--          @endif--}}
                    {{--          <?php--}}
                    {{--          $arr = array('success', 'primary', 'info', 'warning', 'danger');--}}
                    {{--          ?>--}}

                    <tr>
                        <td></td>
                        <td class="product-create">{{ $location['created_at'] }}</td>
                        <td class="product-longitude">{{ number_format($location['longitude'], 6, '.', '') }}</td>
                        {{--            <td class="product-update">{{ $device['updated_at'] }}</td>--}}
                        <td class="product-latitude">{{ number_format($location['latitude'], 6, '.', '') }}</td>
                        <td class="product-action">
              <span>
                  <a type="button" class="btn btn-icon btn-outline-success mr-1 mb-1 waves-effect waves-light" href="{{ route('location.show', $location->id) }}">
                      <i class="feather icon-search"></i>
                  </a>
              </span>
                            <span>
                  <form action="{{ route('location.destroy', $location->id) }}" method="POST">
                      @csrf
                      {{ method_field('DELETE') }}
                      <button type="submit" class="btn btn-icon btn-outline-primary mr-1 mb-1 waves-effect waves-light">
                            <i class="feather icon-trash"></i>
                      </button>
                  </form>
              </span>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{-- DataTable ends --}}

        {{-- add new sidebar starts --}}
        <div class="add-new-data-sidebar">
            <div class="overlay-bg"></div>
            <div class="add-new-data">
                <form action="{{ route('location.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="device" value="{{ $device->id }}">
                    <div class="div mt-2 px-2 d-flex new-data-title justify-content-between">
                        <div>
                            <h4 class="text-uppercase">新增位置信息</h4>
                        </div>
                        <div class="hide-data-sidebar">
                            <i class="feather icon-x"></i>
                        </div>
                    </div>
                    <div class="data-items pb-3">
                        <div class="data-fields px-2 mt-1">
                            <div class="row">

                                <div class="col-sm-12 data-field-col">
                                    <label for="data-longitude">经度</label>
                                    <input type="text" class="form-control" name="longitude" id="data-longitude">
                                </div>
                                <div class="col-sm-12 data-field-col">
                                    <label for="data-latitude">纬度</label>
                                    <input type="text" class="form-control" name="latitude" id="data-latitude">
                                </div>
                                {{--                <div class="col-sm-12 data-field-col">--}}
                                {{--                  <label for="data-price">Price</label>--}}
                                {{--                  <input type="text" class="form-control" name="price" id="data-price">--}}
                                {{--                </div>--}}
                                {{--                <div class="col-sm-12 data-field-col">--}}
                                {{--                  <label for="data-popularity">Popularity</label>--}}
                                {{--                  <input type="number" class="form-control" name="popularity" id="data-popularity">--}}
                                {{--                </div>--}}
                                {{--                <div class="col-sm-12 data-field-col data-list-upload">--}}
                                {{--                  <div class="dropzone dropzone-area" action="#" id="dataListUpload" name="img">--}}
                                {{--                    <div class="dz-message">Upload Image</div>--}}
                                {{--                  </div>--}}
                                {{--                </div>--}}
                            </div>
                        </div>
                    </div>
                    <div class="add-data-footer d-flex justify-content-around px-3 mt-2">
                        <div class="add-data-btn">
                            <input type="submit" class="btn btn-primary" value="新增">
                        </div>
                        <div class="cancel-data-btn">
                            <input type="reset" class="btn btn-outline-danger" value="取消">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        {{-- add new sidebar ends --}}
    </section>
    {{-- Data list view end --}}
@endsection
@section('vendor-script')
    {{-- vendor js files --}}
    <script src="{{ asset(mix('vendors/js/extensions/dropzone.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.bootstrap4.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.bootstrap.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.select.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.checkboxes.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/polyfill.min.js')) }}"></script>
@endsection
@section('page-script')
    {{-- Page js files --}}
    <script src="{{ asset(mix('js/scripts/ui/data-list-view.js')) }}"></script>
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
