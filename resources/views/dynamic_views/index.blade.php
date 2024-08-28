@extends('layouts.app')

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                {{ __($modelName) }}
            </div>
            <div class="card-body">
                @if(session()->get('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div><br/>
                @endif

                @if(isset($isArchive))
                    <x-modelTable :isArchive="$isArchive" :childTable="$childTable" :hasChildren="$hasChildren" :isDetail="false" :parentId="$parentId" :modelName="strtolower($modelName)" :fillable="$fillable" :model="$model" id="$modelName"></x-ModelTable>
                @else
                    <x-modelTable :isDetail="false" :parentId="$parentId" :modelName="strtolower($modelName)" :fillable="$fillable" :model="$model" id="$modelName"></x-ModelTable>
                @endif
                {{ $model->appends($_GET)->links() }}
            </div>
        </div>
    </div>
@endsection
