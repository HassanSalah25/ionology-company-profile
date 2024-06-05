@extends('dashboard.layouts.app')

@section('content')
    <div class="container">
        <h1>Settings</h1>

        <table class="table">
            <thead>
            <tr>
                <th>Key</th>
                <th>Value Type</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($settings as $setting)
                <tr>
                    <td>{{ $setting->key }}</td>
                    @if(json_decode($setting->value_type)->name === 'text')

                        <td><input class="form-control" type="text" ></td>
                    @elseif(json_decode($setting->value_type)->name === 'number')
                        <td><input class="form-control" type="number" ></td>

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
@endsection
