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
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name"  required autocomplete="name" autofocus>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="name" class=" text-md-right">{{ __('Description') }}</label>
                                <textarea id="description" type="checkbox"  class="form-control" name="description"></textarea>
                            </div>
                            <div class="form-group ">
                                <input value="1" id="sharable" type="checkbox"  name="is_sharable"  >
                                <label for="name" class=" text-md-right">{{ __('Is Sharable') }}</label>
                            </div>
                            <div class="form-group row mb-0 mt-2">
                                <div class="col-md-6 offset-md-4">
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
