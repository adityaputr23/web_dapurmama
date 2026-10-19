@extends('layouts.app')

@section('content')
<div class="menu-listing-container">
    <div class="menu-listing-layout">
        
        <!-- Left Sidebar: Filters -->
        <aside class="menu-sidebar">
            <form id="filter-form" action="{{ route('menu.index') }}" method="GET">
                <!-- Search term preserved if filtering -->
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif

                <!-- Category Section -->
                <div class="filter-section-group">
                    <h3 class="filter-group-title">CATEGORY</h3>
                    <div class="checkbox-group">
                        <label class="checkbox-container">
                            <input type="checkbox" name="categories[]" value="Daily Favorites" 
                                {{ is_array(request('categories')) && in_array('Daily Favorites', request('categories')) ? 'checked' : '' }}
                                onchange="this.form.submit()">
                            <span class="checkmark"></span>
                            Daily Favorites
                        </label>
                        <label class="checkbox-container">
                            <input type="checkbox" name="categories[]" value="Party Platters"
                                {{ is_array(request('categories')) && in_array('Party Platters', request('categories')) ? 'checked' : '' }}
                                onchange="this.form.submit()">
                            <span class="checkmark"></span>
                            Party Platters
                        </label>
                        <label class="checkbox-container">
                            <input type="checkbox" name="categories[]" value="Healthy Bowls"
                                {{ is_array(request('categories')) && in_array('Healthy Bowls', request('categories')) ? 'checked' : '' }}
                                onchange="this.form.submit()">
                            <span class="checkmark"></span>
                            Healthy Bowls
                        </label>
                    </div>
                </div>

                <!-- Dietary Section -->
                <div class="filter-section-group">
                    <h3 class="filter-group-title">DIETARY</h3>
                    <div class="dietary-pills-group">
                        @foreach(['Vegan', 'Non-Spicy', 'Spicy', 'Gluten-Free'] as $tag)
                            <label class="dietary-pill-label">
                                <input type="checkbox" name="dietary[]" value="{{ $tag }}"
                                    {{ is_array(request('dietary')) && in_array($tag, request('dietary')) ? 'checked' : '' }}
                                    onchange="this.form.submit()" class="dietary-checkbox">
                                <span class="dietary-pill-btn">{{ $tag }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Price Range Section -->
                <div class="filter-section-group">
                    <h3 class="filter-group-title">PRICE RANGE</h3>
                    <div class="price-slider-wrapper">
                        <input type="range" name="price_max" min="5" max="50" step="1" 
                            value="{{ request('price_max', 50) }}" class="price-slider" id="price-range-slider"
                            oninput="document.getElementById('price-max-display').innerText = '$' + this.value + (this.value >= 50 ? '+' : '')"
                            onchange="this.form.submit()">
                        <div class="price-labels">
                            <span>$5</span>
                            <span id="price-max-display">${{ request('price_max', 50) }}{{ request('price_max', 50) >= 50 ? '+' : '' }}</span>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Promocard Banner -->
            <div class="sidebar-promo-card">
                <h4 class="promo-card-title">Host a gathering?</h4>
                <p class="promo-card-text">Request a custom menu for your special occasion.</p>
                <button class="promo-card-btn" id="sidebar-custom-inquiry">Custom Inquiry</button>
            </div>
        </aside>

        <!-- Right Main: Menu Grid -->
        <main class="menu-grid-content">
            
            @if(request('search'))
                <div class="search-results-info">
                    <p>Menampilkan hasil pencarian untuk "<strong>{{ request('search') }}</strong>" 
                    <a href="{{ route('menu.index') }}" class="clear-search-btn"><i class="fa-solid fa-circle-xmark"></i> Bersihkan</a></p>
                </div>
            @endif

            <div class="menu-items-grid">
                @forelse($menus as $index => $menu)
                    <!-- Individual Menu Card -->
                    <div class="menu-list-card" data-id="{{ $menu->id }}">
                        <div class="card-image-container">
                            <!-- Badge Left Wrapper -->
                            <div class="card-badge-left-wrapper">
                                @if($menu->badge)
                                    <span class="card-badge-left {{ Str::slug($menu->badge) }}">{{ $menu->badge }}</span>
                                @endif
                                @if($menu->tags)
                                    @foreach($menu->tags as $tag)
                                        @if(in_array($tag, ['Vegan', 'Spicy', 'Gluten-Free']))
                                            <span class="card-badge-left {{ Str::slug($tag) }}">{{ $tag }}</span>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                            <!-- Rating Right -->
                            @if($menu->rating)
                                <span class="card-rating-badge"><i class="fa-solid fa-star"></i> {{ number_format($menu->rating, 1) }}</span>
                            @endif
                            <img src="{{ $menu->image_path }}" alt="{{ $menu->name }}" class="menu-list-image">
                        </div>
                        <div class="card-body-content">
                            <div class="card-title-price-row">
                                <h3 class="menu-list-name">{{ $menu->name }}</h3>
                                <span class="menu-list-price">IDR {{ number_format($menu->price * 1000, 0, ',', '.') }}</span>
                            </div>
                            <p class="menu-list-desc">{{ $menu->description }}</p>
                            <div class="card-footer-actions">
                                <button class="add-to-cart-btn-row quick-add-btn" 
                                    data-id="{{ $menu->id }}" 
                                    data-name="{{ $menu->name }}" 
                                    data-price="{{ $menu->price * 1000 }}" 
                                    data-image="{{ $menu->image_path }}">
                                    <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                                </button>
                                <button class="wishlist-btn-circle" aria-label="View Details">
                                    <i class="fa-solid fa-list-ul"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Double-span Featured Event Card injected after the 4th item (index 3) on page 1 -->
                    @if($index == 3 && $menus->currentPage() == 1 && !request('search'))
                        <div class="featured-event-card">
                            <div class="featured-event-layout">
                                <div class="featured-event-img-side">
                                    <img src="https://images.unsplash.com/photo-1563729784474-d77dbb933a9e?auto=format&fit=crop&w=600&q=80" alt="Family celebration Indonesian sweets platter">
                                </div>
                                <div class="featured-event-content-side">
                                    <span class="featured-tag">Featured Event Package</span>
                                    <h3 class="featured-title">Family Celebration Set</h3>
                                    <p class="featured-desc">
                                        Hosting 10-15 people? Get our curated selection of 5 mains, 3 appetizers, and our famous dessert tray.
                                    </p>
                                    <div class="featured-price-row">
                                        <span class="featured-price">$189.00</span>
                                        <span class="divider">|</span>
                                        <span class="featured-free-delivery">Free Delivery</span>
                                    </div>
                                    <button class="explore-bundle-btn" id="featured-explore-btn">
                                        Explore Bundle Options <i class="fa-solid fa-arrow-right"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Overlapping Bunda Chat Box Overlay -->
                            <div class="bunda-online-overlay" id="bunda-chat-box">
                                <div class="bunda-avatar-circle">
                                    <img src="https://images.unsplash.com/photo-1556910103-1c02745aae4d?auto=format&fit=crop&w=100&h=100&q=80" alt="Bunda Chef">
                                </div>
                                <div class="bunda-message-content">
                                    <strong>Bunda is online!</strong>
                                    <span>Need help customizing your party tray?</span>
                                </div>
                                <button class="close-bunda-chat" onclick="document.getElementById('bunda-chat-box').remove()">&times;</button>
                            </div>
                        </div>
                    @endif
                @empty
                    <div class="empty-results">
                        <i class="fa-solid fa-utensils"></i>
                        <p>Tidak ada hidangan yang cocok dengan kriteria filter Anda.</p>
                        <a href="{{ route('menu.index') }}" class="reset-filter-btn">Reset Filter</a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination Links -->
            @if($menus->hasPages())
                <div class="menu-pagination-wrapper">
                    {{ $menus->links('pagination::custom-pagination') }}
                </div>
            @endif
        </main>
    </div>
</div>
@endsection
