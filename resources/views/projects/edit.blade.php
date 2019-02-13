@extends('layouts.app')

@section('content')

    <h3 class="text-center text-info">Edit  Project</h3>

    <form id="login-form" class="form" action="{{ route("update.project", $project) }}" method="post">
    @csrf

    @method('PATCH')
    @include('partials.project-form', ['buttonText' => 'Update Project'])

    </form>
@endsection

