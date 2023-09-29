@extends('layouts.form')

@section('title', 'Edit - Floor')



@section('form-attributes', 'method=POST')
@section('route', route('floors.update', $floor->id))
@section('fields')
    @method('PUT')

    <x-auth-validation-errors class="mb-4 text-danger" :errors="$errors" />

    <div class="form-group">
        <label for="name">Floor Name</label>
        <input required value="{{ $floor->name ?? '' }}" type="text" class="form-control" id="name" name="name"
            placeholder="Enter Unique Name">
    </div>
@endsection
@section('submit-word', 'Edit')
