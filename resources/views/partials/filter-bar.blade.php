{{--
    Filter Bar Component
    Filter controls for tours page (static UI for Phase 1)
    Props: $filterType (current selected filter)
--}}

<div class="bg-white border-bottom shadow-sm sticky-top" style="top: 56px;">
    <div class="container py-3">
        {{-- Tour Type Selector --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">Tour Type</label>
            <div class="btn-group d-flex flex-wrap gap-2" role="group">
                <a href="{{ route('tours.index') }}" class="btn {{ $filterType === 'all' ? 'btn-primary' : 'btn-outline-primary' }}">
                    All Tours
                </a>
                <a href="{{ route('tours.index') }}?type=international" class="btn {{ $filterType === 'international' ? 'btn-primary' : 'btn-outline-primary' }}">
                    International
                </a>
                <a href="{{ route('tours.index') }}?type=domestic" class="btn {{ $filterType === 'domestic' ? 'btn-primary' : 'btn-outline-primary' }}">
                    Domestic
                </a>
            </div>
        </div>

        {{-- Additional Filters (Static UI for Phase 1) --}}
        <div class="row g-3">
            {{-- Duration Filter --}}
            <div class="col-12 col-md-3">
                <label class="form-label small fw-semibold">Duration</label>
                <select class="form-select" disabled>
                    <option>Any Duration</option>
                    <option>1-5 Days</option>
                    <option>6-10 Days</option>
                    <option>10+ Days</option>
                </select>
            </div>

            {{-- Budget Filter --}}
            <div class="col-12 col-md-3">
                <label class="form-label small fw-semibold">Budget</label>
                <select class="form-select" disabled>
                    <option>Any Budget</option>
                    <option>Under $500</option>
                    <option>$500 - $1500</option>
                    <option>$1500 - $3000</option>
                    <option>$3000+</option>
                </select>
            </div>

            {{-- Month Filter --}}
            <div class="col-12 col-md-3">
                <label class="form-label small fw-semibold">Month</label>
                <select class="form-select" disabled>
                    <option>Any Month</option>
                    <option>January - March</option>
                    <option>April - June</option>
                    <option>July - September</option>
                    <option>October - December</option>
                </select>
            </div>

            {{-- Search --}}
            <div class="col-12 col-md-3">
                <label class="form-label small fw-semibold">Search</label>
                <input type="text" class="form-control" placeholder="Search tours..." disabled>
            </div>
        </div>

        <p class="text-muted small mb-0 mt-2">
            <i class="bi bi-info-circle me-1"></i>
            Advanced filters will be functional in Phase 2
        </p>
    </div>
</div>
