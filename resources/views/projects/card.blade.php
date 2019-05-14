
<div class="card">

    <h3 class="text-xl font-normal py-4 mb-3 -ml-5 border-l-4 border-blue-500 pl-4">
        <a href="{{ $project->path() }}">

            {{ $project->title }}
        </a>
    </h3>

    <div class="text-gray-500">{{ str_limit( $project->description, 100 ) }}</div>
</div>
