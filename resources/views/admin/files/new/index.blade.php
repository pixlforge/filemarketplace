@extends ('admin.layouts.default')

@section ('admin.content')
    <h1 class="title">Files to approve</h1>

    @if ($files->count())
        @each ('admin.partials._file_to_approve', $files, 'file')
    @else
        <p>There are no new files waiting for approval.</p>
    @endif
@endsection