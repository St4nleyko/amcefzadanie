@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Create ToDo Item') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('todoitem.store') }}">
                            @csrf
                            <div class="form-group ">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                                <div class="">
                                    <input id="name" type="text" class="form-control" name="name"  required autocomplete="name" autofocus>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="name" class=" text-md-right">{{ __('Description') }}</label>
                                <textarea id="description" type="checkbox"  class="form-control" name="description"></textarea>
                            </div>
                            <div class="form-group ">
                                <label for="categories" class="col-md-4 col-form-label text-md-right">{{ __('Categories') }}</label>
                                <div class="">
                                    <select class="form-select" multiple name="categories[]" id="catSelect">
                                        @foreach ($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="users" class="col-md-4 col-form-label text-md-right">{{ __('Users') }}</label>
                                <div class="">
                                    <select class="form-select" multiple name="users[]" id="userSelect">
                                        @foreach ($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row mb-0 mt-2">
                                <div class=" ">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Create') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
