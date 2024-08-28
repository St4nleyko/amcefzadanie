@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit ToDo Item') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('todoitem.update',$toDoItem) }}">
                            @csrf
                            <div class="form-group ">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                                <div class="">
                                    <input value="{{$toDoItem->name}}" id="name" type="text" class="form-control" name="name"  required autocomplete="name" autofocus>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="description" class=" text-md-right">{{ __('Description') }}</label>
                                <textarea value="{{$toDoItem->description}}" id="description"  class="form-control" name="description">{{$toDoItem->description}}
                                </textarea>
                            </div>
                            @if($canEditUsers)
                                <div class="form-group ">
                                    <label for="users" class="col-md-4 col-form-label text-md-right">{{ __('Users') }}</label>
                                    <div class="">
                                        <select class="form-select" multiple name="users[]" id="userSelect">
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}"
                                                        @if(in_array($user->id, $selectedUserIds)) selected @endif>
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif
                            <div class="form-group ">
                                <input id="completed" type="checkbox"  name="is_completed" value="1" @if($toDoItem->is_completed) checked @endif >
                                <label for="is_completed" class=" text-md-right">{{ __('Is Completed') }}</label>
                            </div>
                            <div class="form-group row mb-0 mt-2">
                                <div class=" offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Update') }}
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
