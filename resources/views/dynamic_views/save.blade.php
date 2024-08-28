@extends('layouts.app')

@section('content')
    @php $btnModelName = lcfirst($modelName);@endphp
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Save') }} {{ __($btnModelName) }}</div>

                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div>{{__($error)}}</div>
                        @endforeach
                    @endif

                    <div class="card-body">
                        <form enctype="multipart/form-data" method="POST" action="{{ route('store.'.strtolower($modelName).'',['view',$id])}}">
                            @csrf
                            @if(isset($parentId))
                                <input type="hidden" name="parentId" value="{{$parentId}}">
                            @endif
                            @if(isset($selectedParent->id))
                                <input type="hidden" name="selectedParent" value="{{$selectedParent->id}}">
                            @endif
                            @foreach($modelInputsConfigs as $inputName => $inputConfig)
                                <x-inputs :lastPriority="$lastPriority" :modelName="$modelName" :parentName="$parentName" :parentId="$parentId" :selectedParent="$selectedParent" :multipleSelectBoxes="$multipleSelectBoxes" :checkBoxOptions="$checkBoxOptions" :selectOptions="$selectOptions" :inputValue="$inputConfig['value']" :inputName="$inputName" :inputConfig="$inputConfig" :inputType="$inputConfig['type']"></x-inputs>
                            @endforeach
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4 mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Save') }} {{ __($btnModelName) }}
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
