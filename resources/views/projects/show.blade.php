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
                    <div class="card mb-3">

                        Lorem Ipsum
                    </div>
                    <div class="card mb-3">

                        Lorem Ipsum
                    </div>
                    <div class="card mb-3">

                        Lorem Ipsum
                    </div>
                    <div class="card">

                        Lorem Ipsum
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