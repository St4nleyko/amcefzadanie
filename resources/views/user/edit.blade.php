<!-- edit.blade.php -->

@extends('layouts.app')
@section('content')
    @if($user->id == 1 && Auth::user()->id != 1)
        <script>window.location = "/users";</script>
    @else
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
                            </div>
                        @endif
                        <form method="post" action="{{ route('update.user', $user->id) }}" >
                            <div class="form-group  ">
                                @csrf
                                @method('POST')
                                <label for="name">{{ __('Name')}}:</label>
                                <input type="text" class="form-control" name="name" value="{{$user->name}}"/>
                            </div>
                            <div class="form-group  ">
                                <label for="password">{{ __('Password')}}:</label>
                                <input type="password" class="form-control" name="password" value=""/>
                            </div>
                            @foreach($roles as $role)
                                @if($role == 'superAdmin' && Auth::user()->id != 1)
                                @else
                                    <div class="form-group">
                                        <label>
                                            <input type="checkbox" class="form"  <?php if($user->hasRole($role)) {
                                                echo 'checked'; }?>  value="{{$role}}" name="roles[]"/>
                                            {{$role}}
                                        </label>
                                    </div>
                                @endif
                            @endforeach
                            <div class="form-group create-form">
                                <button type="submit" class="btn btn-info">{{ __('Edit User') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
