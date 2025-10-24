{{--
    Top Destinations Component
    Showcases popular travel destinations
--}}

<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3">Top Destinations Around the World</h2>
            <p class="lead text-muted">Explore the most sought-after travel spots</p>
        </div>

        <div class="row g-4">
            {{-- Destination Card 1 - Japan --}}
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm overflow-hidden" style="height: 280px; cursor: pointer;">
                    <img src="/images/destinations/japan.jpg" alt="Japan" class="card-img h-100 w-100" style="object-fit: cover;">
                    <div class="card-img-overlay bg-dark bg-opacity-25 d-flex flex-column justify-content-end text-white">
                        <h3 class="card-title fw-bold mb-2">Japan</h3>
                        <p class="card-text small mb-0 opacity-75">Land of the Rising Sun</p>
                    </div>
                </div>
            </div>

            {{-- Destination Card 2 - Northern Pakistan --}}
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm overflow-hidden" style="height: 280px; cursor: pointer;">
                    <img src="/images/destinations/pakistan.jpg" alt="Northern Pakistan" class="card-img h-100 w-100" style="object-fit: cover;">
                    <div class="card-img-overlay bg-dark bg-opacity-25 d-flex flex-column justify-content-end text-white">
                        <h3 class="card-title fw-bold mb-2">Northern Pakistan</h3>
                        <p class="card-text small mb-0 opacity-75">Mountains & Valleys</p>
                    </div>
                </div>
            </div>

            {{-- Destination Card 3 - Europe --}}
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm overflow-hidden" style="height: 280px; cursor: pointer;">
                    <img src="/images/destinations/europe.jpg" alt="Europe" class="card-img h-100 w-100" style="object-fit: cover;">
                    <div class="card-img-overlay bg-dark bg-opacity-25 d-flex flex-column justify-content-end text-white">
                        <h3 class="card-title fw-bold mb-2">Europe</h3>
                        <p class="card-text small mb-0 opacity-75">Historic Cities & Culture</p>
                    </div>
                </div>
            </div>

            {{-- Destination Card 4 - Dubai --}}
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm overflow-hidden" style="height: 280px; cursor: pointer;">
                    <img src="/images/destinations/dubai.jpg" alt="Dubai" class="card-img h-100 w-100" style="object-fit: cover;">
                    <div class="card-img-overlay bg-dark bg-opacity-25 d-flex flex-column justify-content-end text-white">
                        <h3 class="card-title fw-bold mb-2">Dubai</h3>
                        <p class="card-text small mb-0 opacity-75">Luxury & Innovation</p>
                    </div>
                </div>
            </div>

            {{-- Destination Card 5 - Thailand --}}
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm overflow-hidden" style="height: 280px; cursor: pointer;">
                    <img src="/images/destinations/thailand.jpg" alt="Thailand" class="card-img h-100 w-100" style="object-fit: cover;">
                    <div class="card-img-overlay bg-dark bg-opacity-25 d-flex flex-column justify-content-end text-white">
                        <h3 class="card-title fw-bold mb-2">Thailand</h3>
                        <p class="card-text small mb-0 opacity-75">Tropical Paradise</p>
                    </div>
                </div>
            </div>

            {{-- Destination Card 6 - Coastal Pakistan --}}
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm overflow-hidden" style="height: 280px; cursor: pointer;">
                    <img src="/images/destinations/coast.jpg" alt="Coastal Pakistan" class="card-img h-100 w-100" style="object-fit: cover;">
                    <div class="card-img-overlay bg-dark bg-opacity-25 d-flex flex-column justify-content-end text-white">
                        <h3 class="card-title fw-bold mb-2">Coastal Pakistan</h3>
                        <p class="card-text small mb-0 opacity-75">Beaches & Serenity</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
