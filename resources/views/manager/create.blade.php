@extends('layouts.form')

@section('title', 'Create - Manager')



@section('form-attributes', 'method=POST enctype=multipart/form-data')
@section('route', route('stuff.store', 'manager'))
@section('fields')
    <x-auth-validation-errors class="mb-4 text-danger" :errors="$errors" />

    <div class="form-group">
        <label for="name">Name</label>
        <input required type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
    </div>
    <div class="form-group">
        <label for="national_id">National Id</label>
        <input required type="number" class="form-control" name="national_id" id="national_id" placeholder="Enter email">
    </div>
    <div class="form-group">
        <label for="email">Email address</label>
        <input required type="email" class="form-control" name="email" id="email" placeholder="Enter email">
    </div>
    <div class="form-group">
        <label for="avatar">Avatar</label>
        <div class="input-group">
            <div class="custom-file">
                <label for="avatar">Choose Image</label>
                <input type="file" name="avatar" id="avatar">
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input required type="password" name="password" class="form-control" id="password" placeholder="Password">
    </div>
    <div class="form-group">
        <label for="password_confirmation">Confirm Password</label>
        <input required type="password" name="password_confirmation" class="form-control" id="password_confirmation"
            placeholder="Password">
    </div>
@endsection
@section('submit-word', 'Create')
