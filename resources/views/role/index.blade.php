
@extends('layouts.app')
@auth
    @section('content')
        <section class="d-flex align-items-center bg-grey bd-bottom bd-top">
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        {{ __('Roles') }}
                    </div>
                    <div class="card-body">
                        @if(session()->get('success'))
                            <div class="alert alert-success">
                                {{ session()->get('success') }}
                            </div><br />
                        @endif
                        <table id="role_table" class="table table-striped"  >
                            <thead>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th colspan="2">{{ __('Actions') }}</th>
                            </thead>
                            <tbody>
                            @foreach($roles as $role)
                                <tr>
                                    <td>{{$role->id}}</td>
                                    <td>{{$role->name}}</td>
                                    <td>
                                        @if($role->name != "superAdmin" && $role->name != "admin")
                                            <div class="btn-group create-form" >
                                                <a href="{{ route('edit.role',$role->id)}}" class="btn btn-info " >{{ __('Edit') }}</a>
                                                <form action="{{ route('delete.role', $role->id)}}" method="post">
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
                            <a href="{{ route('add.role')}}" class="btn btn-success">{{ __('Add Role') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endsection
@endauth
