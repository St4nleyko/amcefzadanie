<!-- edit.blade.php -->

@extends('layouts.app')

@section('content')
    <section class="d-flex align-items-center bg-grey bd-bottom bd-top">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    {{ __('My Profile')}}
                </div>
                <div class="card-body">
                    @if(session()->get('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div><br />
                    @endif
                    @if(session()->get('error'))
                        <div class="alert alert-danger">
                            {{ session()->get('error') }}
                        </div><br />
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="post" action="{{ route('update.myprofile', $user->id) }}" >
                        <div class="form-group  ">
                            @csrf
                            @method('POST')
                            <label for="name">{{ __('Name')}}:</label>
                            <input type="text" class="form-control" name="name" value="{{$user->name}}"/>
                        </div>
                        <div class="form-group  ">
                            <label for="old_password">{{ __('Old Password')}}:</label>
                            <input type="password" class="form-control" name="old_password" value=""/>
                        </div>
                        <div class="form-group  ">
                            <label for="password">{{ __('New Password')}}:</label>
                            <input type="password" class="form-control" name="password" value=""/>
                        </div>
                        </br>
                        <div class="form-group create-form">
                            <button type="submit" class="btn btn-info">{{ __('Update user') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
