@extends( 'layouts.app' )

@section( 'content' )
    <h3>Edit Project {{ $project->id }}</h3>

    <form method="POST" action="{{ $project->path() }}">
        @csrf
        @method( 'PATCH' )

        <input name="title" value="{{ $project->title }}" type="text" />
        <input name="description" value="{{ $project->description }}" type="text" />

        <button type="submit">Update</button>
        <a href="{{ $project->path() }}">Cancel</a>

        <div>

            @if( $errors->any() )

                @foreach( $errors->all() as $error )

                    <p>{{ $error }}</p>
                @endforeach
            @endif
    </form>
@endsection