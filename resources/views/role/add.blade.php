<!-- create.blade.php -->

@extends('layouts.app')

@section('content')
    <section class="d-flex align-items-center bg-grey bd-bottom bd-top">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    {{ __('Add Role') }}
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="post" action="{{ route('store.role')}}">
                        @csrf
                        <div class="form-group">
                            <label for="name">{{ __('Role Name') }}:</label>
                            <input type="text" class="form-control" name="name"/>
                        </div>
                        </br>
                        <div class="form-group create-form">
                            <button type="submit" class="btn btn-success">{{ __('Add Role') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
