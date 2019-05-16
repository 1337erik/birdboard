@extends( 'layouts.app' )

@section( 'content' )

    <header class="flex items-end justify-between mb-3 py-4">

        <h2 class="text-gray-500 text-sm font-normal">My Projects</h2>
        <a class="button" href="/projects/create">New Project</a>
    </header>

    <main class="md:flex md:flex-wrap -mx-3">

        @forelse( $projects as $project )

            <div class="md:w-1/2 lg:w-1/3 px-3 pb-6">

                @include( 'projects.card' )
            </div>
        @empty

            <div class="md:w-1/2 lg:w-1/3 px-3 pb-6">

                <p>No projects yet..</p>
            </div>
        @endforelse
    </main>
@endsection