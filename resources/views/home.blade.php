@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="hero-section" style="background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.2)), url('{{ asset('images/hero_bg.png') }}');">
    <div class="hero-container">
        <div class="hero-content">
            <span class="hero-badge">
                <i class="fa-solid fa-utensils"></i> Authentic Home Kitchen
            </span>
            <h1 class="hero-title">Nostalgia in Every <em>Bite.</em></h1>
            <p class="hero-subtitle">
                Rasakan kehangatan masakan ibu, diantarkan langsung ke depan pintu Anda. Hidangan olahan koki dengan cita rasa Nusantara yang dibuat penuh cinta, tradisi, serta bahan-bahan segar pilihan.
            </p>
            <div class="hero-buttons">
                <a href="#menu-section" class="order-btn">Order Now</a>
                <button class="custom-request-btn" id="hero-custom-request">Custom Request</button>
            </div>
        </div>
    </div>
</section>

<!-- Today's Specials Section -->
<section class="specials-section" id="menu-section">
    <div class="section-header">
        <div>
            <h2 class="section-title">Today's Specials</h2>
            <p class="section-subtitle">Freshly prepared recipes for today only.</p>
        </div>
        <div class="carousel-controls">
            <button class="carousel-control-btn prev" id="carousel-prev" aria-label="Previous Menu">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            <button class="carousel-control-btn next" id="carousel-next" aria-label="Next Menu">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        </div>
    </div>

    <!-- Carousel Container -->
    <div class="menu-carousel-wrapper">
        <div class="menu-carousel" id="menu-carousel">
            @forelse($menus as $menu)
                <div class="menu-card" data-id="{{ $menu->id }}">
                    <div class="card-image-wrapper">
                        @if($menu->badge)
                            <span class="card-badge {{ Str::slug($menu->badge) }}">{{ $menu->badge }}</span>
                        @endif
                        <img src="{{ $menu->image_path }}" alt="{{ $menu->name }}" class="menu-image">
                    </div>
                    <div class="card-content">
                        <div class="card-title-price">
                            <h3 class="menu-name">{{ $menu->name }}</h3>
                            <span class="menu-price">IDR {{ number_format($menu->price * 1000, 0, ',', '.') }}</span>
                        </div>
                        <div class="menu-tags">
                            @if($menu->tags)
                                @foreach($menu->tags as $tag)
                                    <span class="tag-badge {{ Str::slug($tag) }}">{{ $tag }}</span>
                                @endforeach
                            @endif
                        </div>
                        <p class="menu-description">{{ $menu->description }}</p>
                        <button class="quick-add-btn" data-id="{{ $menu->id }}" data-name="{{ $menu->name }}" data-price="{{ $menu->price * 1000 }}" data-image="{{ $menu->image_path }}">Quick Add</button>
                    </div>
                </div>
            @empty
                <div class="no-menu">
                    <p>Menu tidak tersedia hari ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Simplicity at Your Table Section -->
<section class="simplicity-section">
    <div class="simplicity-header">
        <h2 class="simplicity-title">Simplicity at Your Table</h2>
        <p class="simplicity-subtitle">From our heart to your hearth in three simple steps.</p>
    </div>
    
    <div class="steps-grid">
        <div class="step-card">
            <div class="step-icon-wrapper order-color">
                <i class="fa-solid fa-arrow-pointer"></i>
            </div>
            <h3 class="step-title">1. Order</h3>
            <p class="step-desc">Browse our curated daily menu or request a custom meal for your family gathering.</p>
        </div>
        
        <div class="step-card">
            <div class="step-icon-wrapper cook-color">
                <i class="fa-solid fa-fire-burner"></i>
            </div>
            <h3 class="step-title">2. Cook</h3>
            <p class="step-desc">Our Bunda Chefs prepare your meal using traditional techniques and zero preservatives.</p>
        </div>
        
        <div class="step-card">
            <div class="step-icon-wrapper deliver-color">
                <i class="fa-solid fa-truck-fast"></i>
            </div>
            <h3 class="step-title">3. Deliver</h3>
            <p class="step-desc">Carefully packed in eco-friendly containers and delivered hot to your doorstep.</p>
        </div>
    </div>
</section>

<!-- The Bunda Promise Section -->
<section class="promise-section" id="promise-section">
    <div class="promise-container">
        <div class="promise-image-col">
            <img src="https://images.unsplash.com/photo-1556910103-1c02745aae4d?auto=format&fit=crop&w=600&q=80" alt="Bunda Chef cooking in kitchen" class="promise-img">
        </div>
        <div class="promise-content-col">
            <span class="promise-label">THE BUNDA PROMISE</span>
            <h2 class="promise-title">Where Hygiene Meets Home-Taste</h2>
            <p class="promise-text">
                Kami percaya bahwa makanan terbaik lahir dari kasih sayang dan ketelitian. Berbeda dari dapur komersial berskala besar, Dapur Bunda mempertahankan kehangatan dan keintiman masakan rumahan dengan tetap mematuhi standar higienitas kelas dunia.
            </p>
            
            <ul class="promise-list">
                <li>
                    <span class="check-circle"><i class="fa-solid fa-check"></i></span>
                    100% MSG & Preservative Free
                </li>
                <li>
                    <span class="check-circle"><i class="fa-solid fa-check"></i></span>
                    Locally Sourced Organic Produce
                </li>
                <li>
                    <span class="check-circle"><i class="fa-solid fa-check"></i></span>
                    Daily Kitchen Sanitization Protocols
                </li>
            </ul>
            
            <div class="promise-social-proof">
                <div class="customer-avatars">
                    <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=100&h=100&q=80" alt="Avatar 1">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=100&h=100&q=80" alt="Avatar 2">
                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&h=100&q=80" alt="Avatar 3">
                </div>
                <div class="proof-text">
                    <p class="join-text">Join 2,000+ Happy Families</p>
                    <div class="rating-stars">
                        <span class="stars">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </span>
                        <span class="rating-score">4.9/5 Rating</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Customer Reviews Section -->
<section class="reviews-section" id="reviews-section" style="padding: 80px 24px; background: var(--cream); border-top: 1px solid var(--border-color);">
    <div style="max-width: 1200px; margin: 0 auto;">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 40px; flex-wrap: wrap; gap: 20px;">
            <div>
                <span style="font-size: 12px; font-weight: 700; color: var(--brand-orange); text-transform: uppercase; letter-spacing: 0.1em; display: block; margin-bottom: 8px;">TESTIMONI</span>
                <h2 style="font-family: 'Playfair Display', serif; font-size: 36px; font-weight: 700; color: var(--text-dark); line-height: 1.2;">Ulasan Pelanggan</h2>
                <p style="font-size: 14px; color: var(--text-muted); margin-top: 6px;">Apa kata mereka yang telah merasakan kelezatan menu Dapur Bunda.</p>
            </div>
            <button class="order-btn" id="btn-tulis-ulasan" style="border-radius: 30px; display: inline-flex; align-items: center; gap: 8px; font-weight: 600; padding: 12px 28px;">
                <i class="fa-solid fa-pen-nib"></i> Tulis Ulasan
            </button>
        </div>

        <!-- Success Alert -->
        @if(session('success'))
            <div style="background: #eef9f2; border: 1px solid #c9ebd4; color: #2d7a46; padding: 16px 20px; border-radius: 12px; margin-bottom: 30px; display: flex; align-items: center; gap: 10px; font-weight: 500; font-size: 14.5px;">
                <i class="fa-solid fa-circle-check" style="font-size: 18px;"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(360px, 1fr)); gap: 24px;">
            @forelse($reviews as $review)
                @php
                    $initial = strtoupper(substr($review->name, 0, 1));
                    $colors = ['#e6c8b0', '#c8dcd0', '#d8c8d8', '#c8d4e6', '#ecd4bc'];
                    $bg = $colors[$loop->index % count($colors)];
                @endphp
                <div style="background: #fff; border-radius: 16px; padding: 28px; box-shadow: 0 4px 20px rgba(44,36,22,0.03); border: 1px solid rgba(200, 180, 160, 0.15); display: flex; flex-direction: column; transition: transform .3s, box-shadow .3s;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 10px 30px rgba(44,36,22,0.06)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(44,36,22,0.03)'">
                    <!-- Rating & Date -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                        <div style="display: flex; gap: 3px; color: #f59f00;">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fa-{{ $i <= $review->rating ? 'solid' : 'regular' }} fa-star" style="font-size: 13.5px;"></i>
                            @endfor
                        </div>
                        <span style="font-size: 11.5px; color: var(--text-muted);">{{ $review->created_at->diffForHumans() }}</span>
                    </div>

                    <!-- Comment -->
                    <p style="font-size: 14px; color: var(--text-dark); line-height: 1.6; font-style: italic; flex: 1; margin-bottom: 20px; font-weight: 400;">
                        "{{ $review->comment }}"
                    </p>

                    <!-- Profile Info -->
                    <div style="display: flex; align-items: center; gap: 12px; border-top: 1px dashed rgba(200, 180, 160, 0.2); padding-top: 16px;">
                        <div style="width: 40px; height: 40px; border-radius: 50%; background: {{ $bg }}; color: #2c2416; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 15px;">
                            {{ $initial }}
                        </div>
                        <div>
                            <h4 style="font-size: 14.5px; font-weight: 700; color: var(--text-dark); margin: 0;">{{ $review->name }}</h4>
                            <span style="font-size: 11.5px; color: var(--text-muted); display: block; margin-top: 1px;">Customer Terverifikasi</span>
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 60px; color: var(--text-muted); background: #fff; border-radius: 16px; border: 1px dashed rgba(200, 180, 160, 0.3);">
                    <i class="fa-regular fa-comments" style="font-size: 40px; color: var(--brand-orange); margin-bottom: 12px;"></i>
                    <p style="font-size: 15px; font-weight: 500;">Belum ada ulasan yang masuk saat ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Review Modal -->
<div class="modal-backdrop" id="review-write-modal" style="align-items: center; padding: 20px;">
    <div class="modal-card" style="max-width: 500px; width: 100%; border-radius: 16px; overflow: hidden; background: #fff;">
        <div class="modal-header" style="background: #2c2416; color: #fff; padding: 18px 24px; display: flex; align-items: center; justify-content: space-between;">
            <h3 style="color:#fff; font-size:16px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-star" style="color: #f59f00;"></i>
                Bagikan Pengalaman Anda
            </h3>
            <button class="close-modal" id="review-modal-close" style="color:#fff; background:rgba(255,255,255,.15); border-radius:50%; width:30px; height:30px; display:flex; align-items:center; justify-content:center; border:none; cursor:pointer;">&times;</button>
        </div>
        <form action="{{ route('reviews.store') }}" method="POST" style="margin:0;">
            @csrf
            <div class="modal-body" style="padding: 24px; display: flex; flex-direction: column; gap: 16px;">
                
                <!-- Interactive Rating Star Selector -->
                <div style="text-align: center; margin-bottom: 6px;">
                    <label style="font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-bottom: 8px;">Penilaian Anda</label>
                    <div style="display: inline-flex; gap: 8px; flex-direction: row-reverse;">
                        <input type="radio" id="star-5" name="rating" value="5" style="display:none;" required />
                        <label for="star-5" class="rating-star-icon" data-value="5"><i class="fa-regular fa-star"></i></label>

                        <input type="radio" id="star-4" name="rating" value="4" style="display:none;" />
                        <label for="star-4" class="rating-star-icon" data-value="4"><i class="fa-regular fa-star"></i></label>

                        <input type="radio" id="star-3" name="rating" value="3" style="display:none;" />
                        <label for="star-3" class="rating-star-icon" data-value="3"><i class="fa-regular fa-star"></i></label>

                        <input type="radio" id="star-2" name="rating" value="2" style="display:none;" />
                        <label for="star-2" class="rating-star-icon" data-value="2"><i class="fa-regular fa-star"></i></label>

                        <input type="radio" id="star-1" name="rating" value="1" style="display:none;" />
                        <label for="star-1" class="rating-star-icon" data-value="1"><i class="fa-regular fa-star"></i></label>
                    </div>
                    <span id="rating-text-hint" style="display:block; font-size:12.5px; font-weight:700; color:var(--brand-orange); margin-top:8px;">Pilih Bintang</span>
                </div>

                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label for="customer_name" style="font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em;">Nama Lengkap</label>
                    <input type="text" id="customer_name" name="name" style="width: 100%; padding: 11px 14px; border: 1.5px solid var(--border-color); border-radius: 8px; font-size: 14px; outline: none;" placeholder="Contoh: Andini Putri" required>
                </div>

                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label for="customer_email" style="font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em;">Email (Opsional)</label>
                    <input type="email" id="customer_email" name="email" style="width: 100%; padding: 11px 14px; border: 1.5px solid var(--border-color); border-radius: 8px; font-size: 14px; outline: none;" placeholder="email@contoh.com">
                </div>

                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label for="review_comment" style="font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em;">Ulasan Makanan & Tempat</label>
                    <textarea id="review_comment" name="comment" rows="4" style="width: 100%; padding: 11px 14px; border: 1.5px solid var(--border-color); border-radius: 8px; font-size: 14px; outline: none; resize: vertical;" placeholder="Tulis pendapat jujur Anda tentang masakan kami dan kebersihan dapur/tempat kami..." required></textarea>
                </div>
            </div>
            <div style="background: #faf8f5; padding: 16px 24px; display: flex; justify-content: flex-end; border-top: 1px solid var(--border-color);">
                <button type="submit" class="order-btn" style="border-radius: 8px; padding: 10px 24px; font-weight: 700; font-size: 14px;">
                    Kirim Ulasan
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.rating-star-icon {
    font-size: 28px;
    color: #cbd5e1;
    cursor: pointer;
    transition: color 0.15s, transform 0.1s;
}
.rating-star-icon:hover {
    transform: scale(1.15);
}
.rating-star-icon.active {
    color: #f59f00;
}
.rating-star-icon.active i::before {
    content: "\f005";
    font-family: "Font Awesome 6 Free";
    font-weight: 900;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // ─── Modal Toggle ──────────────────────────────────────────
    const reviewModal = document.getElementById('review-write-modal');
    const btnTulis = document.getElementById('btn-tulis-ulasan');
    const btnClose = document.getElementById('review-modal-close');

    if (btnTulis && reviewModal) {
        btnTulis.addEventListener('click', () => {
            reviewModal.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    }

    if (btnClose && reviewModal) {
        btnClose.addEventListener('click', () => {
            reviewModal.classList.remove('active');
            document.body.style.overflow = '';
        });
    }

    if (reviewModal) {
        reviewModal.addEventListener('click', (e) => {
            if (e.target === reviewModal) {
                reviewModal.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    }

    // ─── Interactive Star Rating Selection ──────────────────────
    const stars = document.querySelectorAll('.rating-star-icon');
    const ratingHint = document.getElementById('rating-text-hint');
    const ratingLabels = {
        1: 'Sangat Buruk 😞',
        2: 'Kurang Baik 😐',
        3: 'Cukup Memuaskan 🙂',
        4: 'Sangat Enak & Bersih! 😋',
        5: 'Luar Biasa, Sempurna! 😍'
    };

    stars.forEach(star => {
        star.addEventListener('click', () => {
            const val = parseInt(star.dataset.value);
            
            // Set radio checked
            const radio = document.getElementById('star-' + val);
            if (radio) radio.checked = true;

            // Update text hint
            ratingHint.textContent = ratingLabels[val];

            // Toggle active stars class
            stars.forEach(s => {
                const sVal = parseInt(s.dataset.value);
                if (sVal <= val) {
                    s.classList.add('active');
                } else {
                    s.classList.remove('active');
                }
            });
        });

        // Hover Effect
        star.addEventListener('mouseenter', () => {
            const val = parseInt(star.dataset.value);
            stars.forEach(s => {
                const sVal = parseInt(s.dataset.value);
                if (sVal <= val) {
                    s.style.color = '#ffc04d';
                }
            });
        });

        star.addEventListener('mouseleave', () => {
            stars.forEach(s => {
                s.style.color = ''; // reset to class styling
            });
        });
    });
});
</script>
@endsection
