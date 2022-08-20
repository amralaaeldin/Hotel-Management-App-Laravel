@extends('layouts.form')

@section('title', 'Create - Floor')



@section('form-attributes', 'method=POST')
@section('route', route('floors.store'))
@section('fields')
    <x-auth-validation-errors class="mb-4 text-danger" :errors="$errors" />

    <div class="form-group">
        <label for="name">Floor Name</label>
        <input required type="text" class="form-control" id="name" name="name" placeholder="Enter Unique Name">
    </div>
@endsection
@section('submit-word', 'Create')
