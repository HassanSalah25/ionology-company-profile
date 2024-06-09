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
                <form class="col-md-12" method="POST" action="{{  route('dashboard.users.store') }}">
                    @csrf
                    <div class="form-group">
                        <label class="label">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Name" />
                    </div>

                    <div class="form-group">
                        <label class="label">Email</label>
                        <input type="text" name="email" class="form-control" placeholder="Email" />
                    </div>

                    <div class="form-group">
                        <label class="label">User Type</label>
                            <select class="form-control show-tick ms select2" name="user_type"  data-placeholder="Select">
                                @foreach(\App\Enum\UserType::cases() as $case)
                                    <option value="{{$case->value}}">{{strtolower($case->name)}}</option>
                                @endforeach
                            </select>
                    </div>

                    <div class="form-group">
                        <label class="label">Role</label>
                        <select class="form-control show-tick ms select2" name="role_id"  data-placeholder="Select">
                              <option value="1">Super Admin</option>

                        </select>
                    </div>

                    <div class="form-group">
                        <label class="label">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Password" />
                    </div>

                    <div class="form-group">
                        <label class="label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control"
                               placeholder="Confirm Password" />
                    </div>

                    <button type="submit" class="btn btn-primary w-100" >Submit</button>
                </form>
        </div>
    </div>
@endsection
        @section('page-script')
            <script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
@stop
