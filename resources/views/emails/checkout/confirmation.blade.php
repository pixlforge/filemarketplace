@extends ('emails.layouts.default')

@section ('content')
    <p>
        {{ $sale->user->name }},
    </p>
    <p>
        Thank you for your interest in the free file <strong>{{ $sale->file->title }}</strong> from {{ config('app.name') }}.
    </p>
    <p>
        <a href="{{ route('files.download', [$sale->file, $sale]) }}">Download your file</a>
    </p>
    <p>
        Or, copy and paste this link into your browser directly:
        <br>
        {{ route('files.download', [$sale->file, $sale]) }}
    </p>
@endsection