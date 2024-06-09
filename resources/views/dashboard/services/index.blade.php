@extends('dashboard.layout.master')
@section('title', $title)
@section('parentPageTitle', $parentPageTitle)
@section('page-style')
    <link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/plugins/sweetalert/sweetalert.css')}}"/>
@stop
@section('content')
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2>{{$title}}</h2>
                    @can('create services')
                        <ul class="header-dropdown">
                            <li class="dropdown">
                                <a href="{{route('dashboard.services.create')}}">Add New</a>
                            </li>
                        </ul>
                    @endcan

                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Category</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Category</th>
                                <th>Actions</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            @foreach($services as $service)
                                <tr>
                                    <td>{{$service->name}}</td>
                                    <td> <img class="rounded thumbnail" width="15" height="15"
                                    src="{{$service->getMedia('images')->first()?->getUrl()}}"></td>
                                    <td>{{$service->category->name}}</td>
                                    <td class="js-sweetalert">
                                        <a class="btn btn-primary text-light"
                                           href="{{ route('dashboard.services.edit',$service->id) }}"
                                        ><span class="ti-pencil"></span></a>

                                        <button class="btn btn-raised btn-danger waves-effect"
                                                data-url-remove="{{route('dashboard.services.destroy',$service->id)}}"
                                                data-type="confirm"
                                        >
                                            <i class="zmdi zmdi-hc-fw"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
    <script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
    <script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.flash.min.js')}}"></script>
    <script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
    <script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
    <script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
    <script src="{{asset('assets/plugins/sweetalert/sweetalert.min.js')}}"></script>
    <script src="{{asset('assets/js/pages/ui/sweetalert.js')}}"></script>
@stop
