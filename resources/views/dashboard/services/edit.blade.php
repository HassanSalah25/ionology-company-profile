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
        <div class="body col-md-9">
            <div class="row clearfix">
                <form class="col-md-12" method="POST" action="{{  route('dashboard.services.update',$service->id) }}"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <div class="card">
                            <div class="header">
                                <h2>Image</h2>
                            </div>
                            <div class="body">
                                <input type="file" name="image" class="dropify"
                                       id="dropify-event"
                                       data-url-remove="{{route('dashboard.services.removeImage',$service->id)}}"
                                       data-default-file="{{$service->getMedia('images')->first()?->getUrl()}}">
                            </div>
                        </div>
                    </div>

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs p-0 mb-3">
                        @foreach(\App\Models\Language::all() as $language)
                            <li class="nav-item"><a class="nav-link {{$loop->first ? 'active' : ''}}" data-toggle="tab"
                                                    href="#{{$language->code}}">{{$language->name}}</a></li>
                        @endforeach
                    </ul>
                    <div class="tab-content">
                        @foreach(\App\Models\Language::all() as $language)
                            <div role="tabpanel" class="tab-pane in {{$loop->first ? 'active' : ''}}"
                                 id="{{$language->code}}">
                                <div class="form-group">
                                    <label class="label">Name</label>
                                    <input type="text" name="name[{{$language->code}}]" class="form-control"
                                           value="{{$service->getTranslation('name', $language->code)}}"
                                           placeholder="Name"/>
                                </div>
                                <div class="form-group">
                                    <label class="label">Description</label>
                                    <textarea class="ckeditor" name="description[{{$language->code}}]"
                                              placeholder="Description"/>{{$service->getTranslation('description', $language->code)}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label class="label">Category</label>
                                    <select class="form-control show-tick ms select2" name="category_id"  data-placeholder="Select">
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}"
                                            {{$service->category_id == $category->id ? ' selected="selected"' : ''}}
                                            >{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <hr/>
                                <h4>SEO Information</h4>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="label">Meta Title</label>
                                        <input type="text" name="meta_title[{{$language->code}}]" class="form-control"
                                               value="{{$service->seo->getTranslation('meta_title', $language->code)}}"
                                               placeholder="Meta Title"/>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="label">Meta Keywords</label>
                                        <input type="text" name="meta_keywords[{{$language->code}}]" class="form-control"
                                               value="{{$service->seo->getTranslation('meta_keywords', $language->code)}}"
                                               placeholder="Meta Keywords"/>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="label">Canonical</label>
                                        <input type="text" name="canonical[{{$language->code}}]" class="form-control"
                                               value="{{$service->seo->getTranslation('canonical', $language->code)}}"
                                               placeholder="Canonical"/>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="label">Alt Image</label>
                                        <input type="text" name="alt_image[{{$language->code}}]" class="form-control"
                                               value="{{$service->seo->getTranslation('alt_image', $language->code)}}"
                                               placeholder="Alt Image"/>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class="label">Meta Description</label>
                                        <textarea class="ckeditor" name="meta_description[{{$language->code}}]"
                                                  class="form-control"
                                                  placeholder="Meta Description"/>{{$service->seo->getTranslation('meta_description', $language->code)}}</textarea>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                </form>
            </div>
        </div>
        @endsection
        @section('page-script')
            <script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
            <script src="{{asset('assets/plugins/dropify/js/dropify.min.js')}}"></script>
            <script src="{{asset('assets/js/pages/forms/dropify.js')}}"></script>
            <script src="{{asset('assets/plugins/ckeditor/ckeditor.js')}}"></script>
            <script src="{{asset('assets/js/pages/forms/editors.js')}}"></script>
@stop
