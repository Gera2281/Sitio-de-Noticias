@props(['image', 'title', 'content', 'link' => '#'])

<a href="{{ $link }}" class="text-decoration-none news-card-link">
    <div class="news-card">
        <div class="news-card-img" style="--card-bg: url('{{ asset('storage/' . $image) }}');">
            <div class="news-card-overlay"></div>
            <div class="news-card-body">
                <span class="news-card-category news-cat-clima">Clima</span>
                <h5 class="news-card-title">{{ $title }}</h5>
                <p class="news-card-text">{{ Str::limit($content, 80) }}</p>
            </div>
        </div>
    </div>
</a>