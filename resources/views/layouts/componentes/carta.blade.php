<div class="card h-100 border-0 shadow-sm">
    <div style="height: 180px; overflow: hidden;">
        <img src="{{ $image ?? 'https://via.placeholder.com/300x200' }}"
             class="w-100 h-100"
             alt="{{ $title }}"
             style="object-fit: cover;">
    </div>

    <div class="card-body d-flex flex-column p-3">
        <h5 class="fw-bold mb-1" style="font-size: 1rem; color: #333;">
            {{ $title }}
        </h5>

        <p class="text-muted mb-3" style="font-size: 0.9rem;">
            <i class="bi bi-telephone me-1"></i> {{ $content }}
        </p>

        <hr class="my-2">

        <div class="d-flex gap-2 mt-auto">
            <a href="tel:{{ $content }}" class="btn btn-sm btn-primary flex-fill">Llamar</a>
            <a href="#" class="btn btn-sm btn-outline-secondary flex-fill">Mensaje</a>
        </div>
    </div>
</div>
