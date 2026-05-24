@extends('layouts.app')

@section('page_title', 'Add New Hotel')
@section('page_title_key', 'page.add_new_hotel')

@section('content')
    <div class="panel card">
        <div class="card-header">
            <h2 data-i18n="form.create_room">Create New Room</h2>
        </div>

        <form action="{{ route('hotels.store') }}" method="POST">
            @include('hotels.form', ['buttonText' => 'Create Room', 'hotel' => null, 'submitKey' => 'form.create_room'])
        </form>
    </div>
@endsection
