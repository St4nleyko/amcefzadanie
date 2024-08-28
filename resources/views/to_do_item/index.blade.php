
@extends('layouts.app')

@section('content')
    <section class="d-flex align-items-center bg-grey bd-bottom bd-top">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    {{ __('ToDoItems') }}
                </div>
                <div class="card-body">
                    @if(session()->get('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div><br />
                    @endif
                        @if(session('errors'))
                            <div class="alert alert-danger">
                                @foreach (session('errors')->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif
                    @auth
                        <table id="toDoItem_table" class="table table-striped create-form "  >
                            <thead>
                            <th>ID</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Categories') }}</th>
                            <th>{{ __('Description') }}</th>
                            <th></th>
                            <th>{{ __('Completed') }}</th>
                            <th colspan="2">{{ __('Actions') }}</th>
                            </thead>
                            <tbody>
                            @foreach($toDoItems as $toDoItem)
                                <tr @if($toDoItem->is_completed) class="text-decoration-line-through" @endif>
                                    <td>{{$toDoItem->id}}</td>
                                    <td>{{$toDoItem->name}}</td>
                                    <td><label class="badge text-bg-info">{{ $toDoItem->categories->pluck('name')->implode(', ') }}</label></td>                                    <td>{{$toDoItem->description}}</td>
                                    <td>
                                        @if($toDoItem->is_shared)
                                            <label class="badge text-bg-info">{{__('Shared') }}</label>
                                        @else
                                            <label class="badge text-bg-primary">{{__('My Item') }}</label>
                                        @endif
                                    </td>
                                    <td>
                                        @if($toDoItem->is_completed)
                                            <label class="badge text-bg-success">{{__('Completed') }}</label>
                                        @else
                                            <label class="badge text-bg-danger">{{ __('Incomplete') }}</label>
                                        @endif

                                    </td>
                                    <td class="d-flex g-1">

                                        @if(!isset($toDoItem->deleted_at))
                                            <a  class="btn btn-info" href="{{ route('todoitem.edit',$toDoItem)}}">
                                                {{__('Edit')}}
                                            </a>
                                            @if(!$toDoItem->is_shared)
                                                <form action="{{ route('todoitem.delete',[$toDoItem,1])}}" method="post" class="inline" onsubmit="return confirm('{{__('Are you sure you want to delete this item?')}}');">
                                                    @csrf
                                                    <button  class="btn btn-danger" type="submit">
                                                        {{__('Delete')}}
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            @if(!$toDoItem->is_shared)

                                                <form action="{{ route('todoitem.delete',[$toDoItem,0])}}" method="post" class="inline" >
                                                    @csrf
                                                    <button  class="btn" type="submit">
                                                        {{__('Undo')}}
                                                    </button>
                                                </form>
                                             @endif
                                        @endif
                                            @if(!$toDoItem->is_completed)

                                                <form action="{{ route('todoitem.complete',$toDoItem)}}" method="post" class="inline" >
                                                    @csrf
                                                    <button  class="btn btn-primary" type="submit">
                                                        {{__('Complete')}}
                                                    </button>
                                                </form>
                                            @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="create-form">
                            <a href="{{ route('todoitem.create')}}" class="btn btn-success">{{ __('Add ToDoItem') }}</a>
                        </div>
                    @endauth
                </div>
                {{$toDoItems->links()}}
            </div>
        </div>
    </section>
@endsection
