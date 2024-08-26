
@extends('layouts.app')



@section('content')
    <section class="d-flex align-items-center bg-grey bd-bottom bd-top">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    {{ __('Users') }}
                </div>
                <div class="card-body">
                    @if(session()->get('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div><br />
                    @endif
                    @auth
                        <table id="user_table" class="table table-striped create-form "  >
                            <thead>
                            <th>ID</th>
                            <th>{{ __('User Name') }}</th>
                            <th>{{ __('Email') }}</th>
                            <th>{{ __('Role') }}</th>
                            <th colspan="2">{{ __('Actions') }}</th>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{$user->id}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>
                                        @if(!empty($user->getRoleNames()))
                                            @foreach($user->getRoleNames() as $role)
                                                <label class="badge text-bg-success">{{ $role }}</label>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->id != 1 || Auth::user()->id == 1)
                                            <div class="btn-group create-form" >
                                                <a href="{{ route('edit.user',$user->id)}}" class="btn btn-info " >{{ __('Edit') }}</a>
                                                <form action="{{ route('delete.user', $user->id)}}" method="post">
                                                    @csrf
                                                    @method('POST')
                                                    <button class="btn btn-danger " type="submit">{{ __('Delete') }}</button>
                                                </form>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="create-form">
                            <a href="{{ route('create.user')}}" class="btn btn-success">{{ __('Add User') }}</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </section>
@endsection
