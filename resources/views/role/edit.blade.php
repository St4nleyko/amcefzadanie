<!-- edit.blade.php -->

@extends('layouts.app')

@section('content')
    <section class="d-flex align-items-center bg-grey bd-bottom bd-top">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    {{ __('Edit Role')}}
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div><br />
                    @endif
                    <form method="post" action="{{ route('update.role', $role->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="form-group  ">
                            <label for="name">{{ __('Role Name')}}:</label>
                            <input type="text" class="form-control" name="name" value="{{$role->name}}"/>
                        </div>
                        </br>
                        <div class="form-group create-form">
                            <button type="submit" class="btn-success btn">{{ __('Edit Role') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
