<div class="row mt-5 dashboard-grid">

    <!-- Áreas -->
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm dashboard-card">
            <div class="card-body text-center">
                <h5 class="card-title">Áreas</h5>
                <p class="card-text">Gestiona las áreas del SENA.</p>
                <a href="{{ route('areas.index') }}" class="btn btn-success">Ver Áreas</a>
            </div>
        </div>
    </div>

    <!-- Centros de formación -->
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm dashboard-card">
            <div class="card-body text-center">
                <h5 class="card-title">Centros de formación</h5>
                <p class="card-text">Gestiona los centros de formación.</p>
                <a href="{{ route('training_centers.index') }}" class="btn btn-success">Ver Centros</a>
            </div>
        </div>
    </div>

    <!-- Computadores -->
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm dashboard-card">
            <div class="card-body text-center">
                <h5 class="card-title">Computadores</h5>
                <p class="card-text">Gestiona los computadores.</p>
                <a href="{{ route('computers.index') }}" class="btn btn-success">Ver Computadores</a>
            </div>
        </div>
    </div>

</div>