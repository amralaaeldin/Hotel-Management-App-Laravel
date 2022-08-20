@extends('layouts.form')

@section('title', 'Edit - Manager')



@section('form-attributes', 'method=POST enctype=multipart/form-data')
@section('route', route('managers.update', $manager->id))
@section('fields')
    @method('PUT')
    <x-auth-validation-errors class="mb-4 text-danger" :errors="$errors" />

    <div class="mb-3">
        <img style="width:75px; object-fit:cover; height:75px; border-radius:50%" alt="avatar"
            src="{{ asset($manager->avatar) }}" />
    </div>

    <div class="form-group">
        <label for="name">Name</label>
        <input required value="{{ $manager->name ?? '' }}" type="text" class="form-control" id="name" name="name"
            placeholder="Enter Name">
    </div>
    <div class="form-group">
        <label for="national_id">National Id</label>
        <input required value="{{ $manager->national_id ?? '' }}" type="number" class="form-control" name="national_id"
            id="national_id" placeholder="Enter email">
    </div>
    <div class="form-group">
        <label for="email">Email address</label>
        <input required value="{{ $manager->email ?? '' }}" type="email" class="form-control" name="email" id="email"
            placeholder="Enter email">
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
@endsection
@section('submit-word', 'Edit')
