@component ('files.partials._file', compact('file'))
    @slot ('links')
        <div class="level">
            <div class="level-left">
                <p class="level-item">
                    {{ $file->isFree() ? 'Free' : "CHF $file->price" }}
                </p>
                @unless ($file->approved)
                    <p class="level-item">
                        Pending approval
                    </p>
                @endunless
                <p class="level-item">
                    {{ $file->isLive() ? 'Live' : 'Not live' }}
                </p>
                <a href="{{ route('account.files.edit', $file) }}" class="level-item">Make changes</a>
            </div>
        </div>
    @endslot
@endcomponent