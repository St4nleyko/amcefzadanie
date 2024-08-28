
@extends('layouts.app')

@section('content')
    <section class="d-flex align-items-center bg-grey bd-bottom bd-top">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    {{ __('Categories') }}
                </div>
                <div class="card-body">
                    @if(session()->get('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div><br />
                    @endif
                    @auth
                        <table id="category_table" class="table table-striped create-form "  >
                            <thead>
                            <th>ID</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Description') }}</th>
                            <th colspan="2">{{ __('Actions') }}</th>
                            </thead>
                            <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>{{$category->id}}</td>
                                    <td>{{$category->name}}</td>
                                    <td>{{$category->description}}</td>

                                    <td class="d-flex g-1">
                                        <a  class="btn btn-info" href="{{ route('category.edit',$category)}}">
                                            {{__('Edit')}}
                                        </a>
                                        <form action="{{ route('category.delete',$category)}}" method="post" class="inline" onsubmit="return confirm('{{__('Are you sure you want to delete this item?')}}');">
                                            @csrf
                                            <button  class="btn btn-danger" type="submit">
                                                {{__('Delete')}}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="create-form">
                            <a href="{{ route('category.create')}}" class="btn btn-success">{{ __('Add Category') }}</a>
                        </div>
                    @endauth
                </div>
                {{$categories->links()}}
            </div>
        </div>
    </section>
@endsection
