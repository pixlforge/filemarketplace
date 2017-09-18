<section class="hero is-primary">
    <div class="hero-body">
        <div class="level">
            <div class="level-item has-text-centered">
                <div>
                    <p class="heading">Files</p>
                    <p class="title">{{ $fileCount }}</p>
                </div>
            </div>
            <div class="level-item has-text-centered">
                <div>
                    <p class="heading">Sales</p>
                    <p class="title">{{ $saleCount }}</p>
                </div>
            </div>
            <div class="level-item has-text-centered">
                <div>
                    <p class="heading">Sales this month</p>
                    <p class="title">CHF {{ number_format($thisMonthEarned, 2) }}</p>
                </div>
            </div>
            <div class="level-item has-text-centered">
                <div>
                    <p class="heading">Sales total</p>
                    <p class="title">CHF {{ number_format($lifetimeEarned, 2) }}</p>
                </div>
            </div>
        </div>
    </div>
</section>