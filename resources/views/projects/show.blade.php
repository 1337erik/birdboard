@extends( 'layouts.app' )


@section( 'content' )

    <header class="flex items-end justify-between mb-3 py-4">

        <p class="text-gray-500 text-sm font-normal">
            <a href="/projects">My Projects</a> / {{ $project->title }}
        </p>
        <a class="button" href="{{ $project->path() . '/edit' }}">Edit Project</a>
    </header>

    <main>

        <div class="md:flex -mx-3">

            <div class="md:w-3/4 px-3 mb-4 md:mb-0">

                <div class="mb-8">

                    <h2 class="text-lg text-gray-500 font-normal mb-3">Tasks</h2>
                    {{-- task list goes here when rdy --}}
                    @forelse ( $project->tasks as $task )

                        <div class="card mb-3">

                            <form method="post" action="{{ $task->path() }}">
                                @method( 'PATCH' )
                                @csrf

                                <div class="flex">

                                    <input class="w-full {{ $task->completed ? 'text-gray-500' : '' }}" type="text" name="body" value="{{ $task->body }}" />
                                    <input type="checkbox" name="completed" {{ $task->completed ? 'checked' : '' }} onChange=" this.form.submit() " />
                                </div>
                            </form>
                        </div>
                    @empty

                        <div class="card mb-3 text-gray-500">

                            No Tasks!
                        </div>
                    @endforelse
                    <div class="card">

                        <form action="{{ $project->path() . '/tasks' }}" method="post">
                            @csrf

                            <input class="w-full" type="text" placeholder="Add New task.." name="body" />
                        </form>
                    </div>
                </div>
                <div>

                    <h2 class="text-lg text-gray-500 font-normal mb-3">General Notes</h2>
                    <form action="{{ $project->path() }}" method="POST">
                        @method( 'PATCH' )
                        @csrf

                        <textarea class="card w-full mb-4" style="min-height: 200px" placeholder="enter notes.." name="notes">{{ $project->notes }}</textarea>

                        <button type="submit" class="button">Save</button>
                    </form>
                </div>
            </div>
            <div class="md:w-1/4 px-3 md:py-8">

                @include( 'projects.card' )

                <div class="card mt-3">

                    <ul class="list-reset text-xs">

                        @foreach( $project->activity as $activity )

                            <li class="{{ $loop->last ? '' : 'mb-1' }}">

                                @include( "projects.activity.{$activity->description}" )
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </main>
@endsection