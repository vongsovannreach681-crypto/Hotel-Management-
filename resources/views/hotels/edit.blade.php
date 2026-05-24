@extends('layouts.app')

@section('page_title', 'Edit Hotel')
@section('page_title_key', 'page.edit_hotel')

@section('content')
    <div class="panel card">
        <div class="card-header">
            <h2><span data-i18n="room.edit">Edit</span> {{ $hotel->name }}</h2>
        </div>

        <form action="{{ route('hotels.update', $hotel) }}" method="POST">
            @method('PUT')
            @include('hotels.form', ['buttonText' => 'Save Changes', 'hotel' => $hotel, 'submitKey' => 'form.save_changes'])
        </form>
    </div>
@endsection
