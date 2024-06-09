@extends('dashboard.layout.master')
@section('title', $title)
@section('parentPageTitle', $parentPageTitle)
@section('page-style')
    <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/plugins/dropify/css/dropify.min.css')}}"/>
@stop
@section('content')
    <div class="row justify-content-center align-items-center clearfix" style="height: 100%">
        <div class="body col-md-6" >
            <div class="row clearfix">
                <form class="col-md-12" method="POST" action="{{  route('dashboard.languages.update',$language->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <div class="card">
                            <div class="header">
                            </div>
                            <div class="body">
                                <input type="file" name="flag" class="dropify"
                                       id="dropify-event"
                                       data-url-remove="{{route('dashboard.languages.removeImage',$language->id)}}"
                                       data-default-file="{{$language->getMedia('images')->first()?->getUrl()}}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="label">Name</label>
                        <input type="text" name="name" value="{{ $language->name }}" class="form-control" placeholder="Name" />
                    </div>

                    <div class="form-group">
                        <label class="label">Code</label>
                        <input type="text" name="code" value="{{ $language->code }}" class="form-control" placeholder="Code" />
                    </div>

                    <div class="form-group">
                        <label class="label mx-4">Is RTL</label>
                        <input type="checkbox" class="form-check-input" name="is_rtl" placeholder="Is RTL"
                        {{  $language->is_rtl == "on" ? 'checked' : '' }}
                        />
                    </div>

                    <button type="submit" class="btn btn-primary w-100" >Submit</button>
                </form>
            </div>
        </div>
        @endsection
        @section('page-script')
            <script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
            <script src="{{asset('assets/plugins/dropify/js/dropify.min.js')}}"></script>
            <script src="{{asset('assets/js/pages/forms/dropify.js')}}"></script>
@stop
