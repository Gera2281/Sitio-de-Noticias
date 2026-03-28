<div class="carta h-100 border-1 shadow-sm" style="border-radius: 8px; overflow: hidden;">
    <div style="height: 200px; overflow: hidden;">
        <img src="{{ $image ?? 'https://via.placeholder.com/300x200' }}" 
             class="w-100 h-100" 
             alt="{{ $title }}" 
             style="object-fit: cover;">
    </div>
    
    <div class="carta-body d-flex flex-column p-3">
        <h5 class="fw-bold mb-1" style="font-size: 1.1rem; color: #333;">
            {{ $title }}
        </h5>
        
        <p class="text-muted mb-3" style="font-size: 0.95rem;">
            {{ $content }}
        </p>

        <hr class="my-2" style="opacity: 0.1;">

        <div class="d-flex flex-column gap-2 mb-3">
            <a href="#" class="text-decoration-none text-dark small">Editar</a>
            <hr class="my-0" style="opacity: 0.05;">
            <a href="#" class="text-decoration-none text-dark small">Eliminar</a>
            <hr class="my-0" style="opacity: 0.05;">
            <a href="#" class="text-decoration-none text-dark small">Compartir</a>
        </div>

        <hr class="my-2" style="opacity: 0.1;">

        <div class="d-flex justify-content-start gap-3 mt-2">
            <a href="#" class="text-primary fw-bold text-decoration-none small">Llamar</a>
            <a href="#" class="text-primary fw-bold text-decoration-none small">Mensaje</a>
        </div>
    </div>
</div>