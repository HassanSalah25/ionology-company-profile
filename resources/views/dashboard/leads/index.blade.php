@extends('dashboard.layout.master')
@section('title', 'Leads')
@section('parentPageTitle', 'Leads')
@section('page-style')
    <link rel="stylesheet" href="{{asset('assets/plugins/footable-bootstrap/css/footable.bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/plugins/footable-bootstrap/css/footable.standalone.min.css')}}" />
@stop
@section('content')
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="table-responsive contact">
                    <table class="table table-hover mb-0 c_list c_table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th data-breakpoints="xs">Phone</th>
                            <th data-breakpoints="xs">Email</th>
                            <th data-breakpoints="xs sm md">Service</th>
                            <th data-breakpoints="xs sm md">Status</th>
                            <th data-breakpoints="xs sm md">By User</th>
                            <th data-breakpoints="xs sm md">Message</th>
                            <th data-breakpoints="xs">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($leads as $lead)
                            <tr>
                                <td>
                                    <p class="c_name">{{$lead->name}}</p>
                                </td>
                                <td>
                                    <span class="phone"><i class="zmdi zmdi-whatsapp mr-2"></i>{{$lead->phone}}</span>
                                </td>
                                <td>
                                    <span class="email"><a href="mailto:{{$lead->email}}" title="">{{$lead->email}}</a></span>
                                </td>
                                <td>
                                    <span><i class="zmdi zmdi-book mx-2"></i>{{ $lead->service->name }}</span>
                                </td>
                                <td>
                                    <span><i class="zmdi zmdi-case mx-2"></i>{{ \App\Enum\LeadStatus::from($lead->status) }}</span>
                                </td>
                                <td>
                                    <span><i class="zmdi zmdi-account mx-2"></i>{{ $lead->user->name }}</span>
                                </td>
                                <td>
                                    <span><i class="zmdi zmdi-text-format mx-2"></i>{{ $lead->message }}</span>
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm"><i class="zmdi zmdi-edit"></i></button>
                                    <button class="btn btn-danger btn-sm"><i class="zmdi zmdi-delete"></i></button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
@section('page-script')
    <script src="{{asset('assets/bundles/footable.bundle.js')}}"></script>
    <script src="{{asset('assets/js/pages/tables/footable.js')}}"></script>
@stop
