@extends( 'layouts.app' )


@section( 'content' )

    <header class="flex items-end justify-between mb-3 py-4">

        <p class="text-gray-500 text-sm font-normal">
            <a href="/projects">My Projects</a> / {{ $project->title }}
        </p>
        <a class="button" href="/projects/create">New Project</a>
    </header>

    <main>

        <div class="md:flex -mx-3">

            <div class="md:w-3/4 px-3 mb-4 md:mb-0">

                <div class="mb-8">

                    <h2 class="text-lg text-gray-500 font-normal mb-3">Tasks</h2>
                    {{-- task list goes here when rdy --}}
                    @forelse ( $project->tasks as $task )

                        <div class="card mb-3">

                            {{ $task->body }}
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
                    </div>
                </div>
                <div>

                    <h2 class="text-lg text-gray-500 font-normal mb-3">General Notes</h2>
                    <textarea class="card w-full" style="min-height: 200px">Lorem Ipsum</textarea>
                </div>
            </div>
            <div class="md:w-1/4 px-3">

                <div>

                    @include( 'projects.card' )
                </div>
            </div>
        </div>
    </main>
@endsection