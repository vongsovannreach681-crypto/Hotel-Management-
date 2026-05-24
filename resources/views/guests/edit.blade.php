@extends('layouts.app')

@section('page_title', 'Edit Guest')

@section('content')
    <div class="panel card">
        <div class="card-header">
            <h2>Edit Guest: {{ $guest->name }}</h2>
        </div>

        <form action="{{ route('guests.update', $guest) }}" method="POST">
            @method('PUT')
            @include('guests.form', ['buttonText' => 'Save Changes', 'guest' => $guest])
        </form>
    </div>
@endsection
