<div class="card h-100 border-0 shadow-sm">
    <div class="d-flex align-items-center justify-content-center p-3" style="height: 200px;">

        <img src="{{ $image }}" 
             class="img-fluid" 
             alt="{{ $title }}" 
             style="max-height: 100%; object-fit: contain;">
    </div>
    
    <div class="card-body d-flex flex-column pt-0">
        <h5 class="card-title text-primary mb-1" style="font-size: 0.9rem; line-height: 1.2; height: 2.4em; overflow: hidden;">
            {{ $title }}
        </h5>
        
        <p class="card-text text-muted small mb-2" style="height: 3em; overflow: hidden;">
            {{ $content }}
        </p>
        
        <div class="mt-auto">
            <p class="fw-bold mb-2" style="font-size: 1.2rem;">
                ${{ $price ?? '0.00' }}
            </p>
            <a href="#" class="btn btn-primary btn-sm w-100">Comprar</a>
        </div>
    </div>
</div>