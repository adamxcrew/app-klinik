@extends('layouts.app')
@section('title','Tambah Obat')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    {!! Form::open(['route'=>'obat.store']) !!}
                    @include('validation_error')
                    @include('obat.form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
