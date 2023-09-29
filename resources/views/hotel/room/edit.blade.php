@extends('layouts.form')

@section('title', 'Edit - Room')



@section('form-attributes', 'method=POST')
@section('route', route('rooms.update', $room->id))
@section('fields')
    @method('PUT')

    <x-auth-validation-errors class="mb-4 text-danger" :errors="$errors" />

    <div class="form-group">
        <label for="number">Room Number</label>
        <input required type="number" value="{{ $room->id ?? '' }}" class="form-control" id="number" name="number"
            placeholder="Enter Unique Number">
    </div>
    <div class="form-group">
        <label for="name">Floor Name</label>
        <select required name="floor_id" id="name" class="form-control">
            @foreach ($floors as $floor)
                <option {{ $floor->id === $room->floor->id ? 'selected' : '' }} value="{{ $floor->id }}">
                    {{ $floor->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="capacity">Capacity</label>
        <input required value="{{ $room->capacity ?? '' }}" type="number" class="form-control" id="capacity"
            name="capacity" placeholder="Enter capacity">
    </div>
    <div class="form-group">
        <label for="price">Price Per Day (In Dollars)</label>
        <input required value="{{ $room->price ?? '' }}" class="form-control" id="price" name="price"
            placeholder="Enter Price Per Day (In Dollars)">
    </div>
@endsection
@section('submit-word', 'Edit')
