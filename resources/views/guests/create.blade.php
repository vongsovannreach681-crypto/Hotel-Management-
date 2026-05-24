@extends('layouts.app')

@section('page_title', 'Create Guest')

@section('content')
    <div class="panel card">
        <div class="card-header">
            <h2>Create Guest</h2>
        </div>

        <form action="{{ route('guests.store') }}" method="POST">
            @include('guests.form', ['buttonText' => 'Create Guest', 'guest' => null])
        </form>
    </div>
@endsection
