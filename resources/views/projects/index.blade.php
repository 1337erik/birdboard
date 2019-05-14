@extends( 'layouts.app' )

@section( 'content' )

    <div class="flex items-center justify-between mb-3">

        <h3>Fucking Birds</h3>
        <a href="/projects/create">New Project</a>
    </div>
    <ul>

        @forelse( $projects as $project )

            <li>

                <a href="{{ $project->path() }}">{{ $project->title }}</a>
            </li>
        @empty

            <li>No projects yet..</li>
        @endforelse
    </ul>
@endsection