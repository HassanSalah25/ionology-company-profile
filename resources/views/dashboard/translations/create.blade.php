@extends('dashboard.layout.master')
@section('title', $title)
@section('parentPageTitle', $parentPageTitle)
@section('page-style')
    <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.css')}}"/>
@stop
@section('content')
    <div class="row justify-content-center align-items-center clearfix" style="height: 100%">
        <div class="body col-md-6" >
            <div class="row clearfix">
                <form class="col-md-12" method="POST" action="{{  route('dashboard.translations.store') }}">
                    @csrf
                    <div class="form-group">
                        <label class="label">Language</label>
                        <select class="form-control show-tick ms select2" name="locale"  data-placeholder="Select">
                            @foreach(\App\Models\Language::all() as $language)
                                <option value="{{$language->code}}">{{$language->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="label">Key</label>
                        <input type="text" name="key" class="form-control" placeholder="Key" />
                    </div>

                    <div class="form-group">
                        <label class="label">Value</label>
                        <input type="text" name="value" class="form-control" placeholder="Value" />
                    </div>

                    <button type="submit" class="btn btn-primary w-100" >Submit</button>
                </form>
            </div>
        </div>
        @endsection
        @section('page-script')
            <script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
@stop
