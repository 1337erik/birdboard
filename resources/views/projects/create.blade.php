@extends( 'layouts.app' )

@section( 'content' )
    <h3>Create a Project</h3>

    <form method="POST" action="/projects">
        @csrf

        <input name="title" type="text" />
        <input name="description" type="text" />

        <button type="submit">Hello</button>
        <a href="/projects">Cancel</a>
    </form>
@endsection