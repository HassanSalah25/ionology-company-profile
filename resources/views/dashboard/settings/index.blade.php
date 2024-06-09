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
                    @can('create users')
                        <ul class="header-dropdown">
                            <li class="dropdown">
                                <a href="{{route('dashboard.users.create')}}">Add New</a>
                            </li>
                        </ul>
                    @endcan

                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                            <thead>
                            <tr>
                                <th>Key</th>
                                <th>Value</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($settings as $setting)
                                <tr>
                                    <td>{{ $setting->key }}</td>
                                    @if(json_decode($setting->value_type)->name === 'text')

                                        <td><input class="form-control" type="text"></td>
                                    @elseif(json_decode($setting->value_type)->name === 'number')
                                        <td><input class="form-control" type="number"></td>

                                    @elseif(json_decode($setting->value_type)->name === 'textarea')
                                        <td><textarea class="form-control"></textarea></td>
                                    @elseif(json_decode($setting->value_type)->name === 'select')
                                        <td>
                                            <select class="form-control">
                                                <option value="">Choose Value....</option>
                                                @foreach(json_decode($setting->value_type)->options as $option)
                                                    <option value="{{ $option }}">{{ $option }}</option>
                                                @endforeach
                                            </select>
                                        </td>

                                    @endif
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
