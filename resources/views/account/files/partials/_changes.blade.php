<article class="message is-primary">
    <div class="message-header">
        <p>We're currently reviewing the following changes</p>
    </div>
    <div class="message-body">
        <div class="content">
            @unless ($approval->title === $file->title)
                <strong>Title</strong>
                <p>{{ $approval->title }}</p>
            @endunless

            @unless ($approval->overview_short === $file->overview_short)
                <strong>Short Overview</strong>
                <p>{{ $approval->overview_short }}</p>
            @endunless

            @unless ($approval->overview === $file->overview)
                <strong>Overview</strong>
                <p>{{ $approval->overview }}</p>
            @endunless

            @if (($uploads = $file->uploads()->unapproved()->get())->count())
                <strong>Uploads</strong>
                @foreach ($uploads as $upload)
                    <p>{{ $upload->filename }}</p>
                @endforeach
            @endif
        </div>
    </div>
</article>