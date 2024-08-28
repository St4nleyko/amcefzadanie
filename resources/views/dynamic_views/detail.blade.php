@extends('layouts/layoutMaster')

@section('content')
    <section class="d-flex align-items-center bg-grey bd-bottom bd-top">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row ">
                <div class="col-lg-6 mb-4">
                    <div class="card ">
                        <div class="card-header">
                            <h2>{{ __('Detail') }}: <strong>{{$parentModel->name}}</strong></h2>
                        </div>
                        <div class="card-body">
                            <h4>{{ __('Description') }}:</h4>
                            <p>{!!$parentModel->description!!}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card  mb-4">
                <div class="card-body">
                    @if($hasChildren)
                        <hr>{{ __('Child Table') }}: {{$modelName}}</hr>
                        <div class="childrenTable">
                            <x-modelTable :parentModelName="$parentModelName" :isDetail="true" :parentId="$parentId" :modelName="strtolower($modelName)" :fillable="$fillable" :model="$model" id="$modelName"> </x-ModelTable>
                            <br>
                            {{ $model->appends($_GET)->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
