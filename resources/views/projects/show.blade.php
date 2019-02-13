@extends('layouts.app')


@section('content')

    <header class="flex items-center mb-3 py-4">

        <div class="flex justify-between items-end w-full">
            <p class="text-grey font-normal text-sm">
                <a href="{{ route("projects") }}" class="text-grey font-normal text-sm no-underline">My Projects</a>
                / {{ $project->title }}
            </p>

            <a href="{{ route('edit.project', $project) }}" class="button"> Edit Project</a>

        </div>
    </header>




    <main>
        <div class="lg:flex -mx-3">

            <div class="lg:w-3/4 px-3 mb-6">

                <div class="mb-8">
                    <h2 class="text-lg text-grey font-normals mb-6">Tasks</h2>

                    @forelse($project->tasks as $task)

                        <div class="card mb-3">
                            <form method="post" action="{{ $task->path() }}">

                                @method('PATCH')
                                @csrf

                                <div class="flex">
                                    <input type="text" name="body" value="{{ $task->body }}"
                                           class="w-full {{ $task->completed ? 'text-grey' : '' }}">
                                    <input name="completed" type="checkbox"
                                           onChange="this.form.submit()" {{ $task->completed ? 'checked' : '' }}>
                                </div>

                            </form>
                        </div>

                    @empty

                        {{--<h3>No task created for this project yet!</h3>--}}
                        <div class="card mb-3">
                            <h2>There are no tasks yet, begin adding</h2>
                        </div>
                    @endforelse

                    {{--<h3>No task created for this project yet!</h3>--}}
                    <div class="card mb-3">
                        <form method="post" action="{{ $project->path() . '/tasks' }}">

                            @csrf
                            <input type="text"
                                   placeholder="Add a new task.... Press enter to create a task after adding it"
                                   class="w-full" name="body">
                        </form>
                    </div>

                </div>


                <div>
                    <h2 class="text-lg text-grey font-normals mb-6">See Project Notes</h2>

                    {{--General Notes--}}

                    <form method="post" action="{{ $project->path() }}">

                        @csrf

                        @method('PATCH')

                        <textarea name="notes" class="card w-full mb-4"
                                  style="min-height: 180px"
                                  placeholder="Keep track of some project ideas, directions and pointers with notes">
                            {{ $project->notes }}
                        </textarea>

                        <button class="button" type="submit">Update Project Notes</button>

                    </form>


                    @if ($errors->any())
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    @endif

                </div>

            </div>


            <div class="lg:w-1/4 px-3">

                @include('projects.project-card')
                @include('projects.activity')
            </div>

        </div>
    </main>






@endsection



