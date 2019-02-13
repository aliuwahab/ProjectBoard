@extends('layouts.app')

@section('content')




    <main class="lg:flex lg:flex-wrap">

        @forelse($projects as $project)
            <div class="lg:w-1/3 px-3 pb-6">

                @include('projects.project-card')

            </div>

        @empty

            <div>No projects yet!</div>

        @endforelse

    </main>


@endsection


