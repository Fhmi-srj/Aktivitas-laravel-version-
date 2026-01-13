{{-- Skeleton Loader Components --}}
@props(['type' => 'text', 'count' => 3])

@switch($type)
    @case('card')
        <div class="skeleton-card">
            <div class="d-flex align-items-center mb-3">
                <div class="skeleton skeleton-avatar me-3"></div>
                <div class="flex-grow-1">
                    <div class="skeleton skeleton-text short"></div>
                    <div class="skeleton skeleton-text" style="width: 40%; height: 0.75rem;"></div>
                </div>
            </div>
            <div class="skeleton skeleton-text"></div>
            <div class="skeleton skeleton-text medium"></div>
            <div class="skeleton skeleton-text short"></div>
        </div>
        @break

    @case('table')
        <div class="skeleton-table">
            @for($i = 0; $i < $count; $i++)
                <div class="skeleton-table-row">
                    <div class="skeleton skeleton-table-cell" style="flex: 0.5;"></div>
                    <div class="skeleton skeleton-table-cell"></div>
                    <div class="skeleton skeleton-table-cell"></div>
                    <div class="skeleton skeleton-table-cell" style="flex: 0.7;"></div>
                    <div class="skeleton skeleton-table-cell" style="flex: 0.5;"></div>
                </div>
            @endfor
        </div>
        @break

    @case('stat')
        <div class="skeleton-card">
            <div class="d-flex align-items-center">
                <div class="skeleton skeleton-avatar me-3" style="border-radius: 12px;"></div>
                <div class="flex-grow-1">
                    <div class="skeleton skeleton-stat"></div>
                    <div class="skeleton skeleton-text short" style="margin-top: 0.5rem; height: 0.75rem;"></div>
                </div>
            </div>
        </div>
        @break

    @case('form')
        <div class="mb-3">
            <div class="skeleton skeleton-text" style="width: 100px; height: 0.75rem; margin-bottom: 0.5rem;"></div>
            <div class="skeleton" style="height: 38px; width: 100%; border-radius: 8px;"></div>
        </div>
        <div class="mb-3">
            <div class="skeleton skeleton-text" style="width: 80px; height: 0.75rem; margin-bottom: 0.5rem;"></div>
            <div class="skeleton" style="height: 38px; width: 100%; border-radius: 8px;"></div>
        </div>
        <div class="skeleton skeleton-button"></div>
        @break

    @default
        @for($i = 0; $i < $count; $i++)
            <div class="skeleton skeleton-text {{ $i == $count - 1 ? 'short' : ($i == 0 ? '' : 'medium') }}"></div>
        @endfor
@endswitch
