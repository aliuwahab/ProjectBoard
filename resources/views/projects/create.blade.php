@extends('layouts.app')

@section('content')

    <h3 class="text-center text-info">Create  Project</h3>

    <form id="login-form" class="form" action="{{ route("store.project") }}" method="post">
        @csrf

       @include('partials.project-form', ['project' => new App\Project(), 'buttonText' => 'Create Project'])

    </form>


@endsection

