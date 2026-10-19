document.addEventListener('DOMContentLoaded', () => {
    // ==========================================
    // TOAST NOTIFICATION SYSTEM
    // ==========================================
    const toastContainer = document.getElementById('toast-container');

    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        
        const icon = type === 'success' 
            ? '<i class="fa-solid fa-circle-check"></i>' 
            : '<i class="fa-solid fa-circle-exclamation"></i>';
            
        toast.innerHTML = `${icon} <span>${message}</span>`;
        toastContainer.appendChild(toast);
        
        // Remove toast after 4 seconds
        setTimeout(() => {
            toast.style.animation = 'fadeOut 0.3s forwards';
            toast.addEventListener('animationend', () => {
                toast.remove();
            });
        }, 4000);
    }

    // Add CSS rule for fadeOut programmatically if not in file
    const style = document.createElement('style');
    style.innerHTML = `
        @keyframes fadeOut {
            to { opacity: 0; transform: translateY(10px); }
        }
    `;
    document.head.appendChild(style);

    // ==========================================
    // MOBILE NAVIGATION TOGGLE
    // ==========================================
    const mobileToggleBtn = document.getElementById('mobile-toggle-btn');
    const navLinks = document.querySelector('.nav-links');

    if (mobileToggleBtn && navLinks) {
        mobileToggleBtn.addEventListener('click', () => {
            navLinks.classList.toggle('active');
            const icon = mobileToggleBtn.querySelector('i');
            if (navLinks.classList.contains('active')) {
                icon.className = 'fa-solid fa-xmark';
            } else {
                icon.className = 'fa-solid fa-bars';
            }
        });

        // Close menu when clicking link
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', () => {
                navLinks.classList.remove('active');
                mobileToggleBtn.querySelector('i').className = 'fa-solid fa-bars';
            });
        });
    }

    // ==========================================
    // CAROUSEL SLIDER FOR TODAY'S SPECIALS
    // ==========================================
    const menuCarousel = document.getElementById('menu-carousel');
    const prevBtn = document.getElementById('carousel-prev');
    const nextBtn = document.getElementById('carousel-next');

    if (menuCarousel && prevBtn && nextBtn) {
        const getScrollAmount = () => {
            const card = menuCarousel.querySelector('.menu-card');
            if (!card) return 340;
            const style = window.getComputedStyle(menuCarousel);
            const gap = parseFloat(style.gap) || 30;
            return card.offsetWidth + gap;
        };

        nextBtn.addEventListener('click', () => {
            menuCarousel.scrollBy({ left: getScrollAmount(), behavior: 'smooth' });
        });

        prevBtn.addEventListener('click', () => {
            menuCarousel.scrollBy({ left: -getScrollAmount(), behavior: 'smooth' });
        });

        // Update button visibility based on scroll position
        const updateBtnState = () => {
            prevBtn.style.opacity = menuCarousel.scrollLeft <= 0 ? '0.4' : '1';
            const atEnd = menuCarousel.scrollLeft + menuCarousel.clientWidth >= menuCarousel.scrollWidth - 4;
            nextBtn.style.opacity = atEnd ? '0.4' : '1';
        };

        menuCarousel.addEventListener('scroll', updateBtnState);
        updateBtnState();
    }

    // ==========================================
    // SHOPPING CART SYSTEM (LOCALSTORAGE)
    // ==========================================
    let cart = JSON.parse(localStorage.getItem('dapur_bunda_cart')) || [];
    
    const cartTrigger = document.getElementById('cart-trigger');
    const cartClose = document.getElementById('cart-close');
    const cartDrawer = document.getElementById('cart-drawer');
    const cartItemsContainer = document.getElementById('cart-items-container');
    const cartCount = document.getElementById('cart-count');
    const cartTotalPrice = document.getElementById('cart-total-price');
    const cartCheckoutBtn = document.getElementById('cart-checkout-btn');

    // Toggle Drawer
    if (cartTrigger && cartDrawer && cartClose) {
        cartTrigger.addEventListener('click', () => cartDrawer.classList.add('active'));
        cartClose.addEventListener('click', () => cartDrawer.classList.remove('active'));
        
        // Close drawer when clicking backdrop
        cartDrawer.addEventListener('click', (e) => {
            if (e.target === cartDrawer) {
                cartDrawer.classList.remove('active');
            }
        });
    }

    // Update LocalStorage and UI
    function saveCart() {
        localStorage.setItem('dapur_bunda_cart', JSON.stringify(cart));
        renderCart();
    }

    // Render cart items
    // Render cart items
    function renderCart() {
        if (!cartItemsContainer) return;

        // Update badge count
        const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
        cartCount.textContent = totalItems;

        if (cart.length === 0) {
            cartItemsContainer.innerHTML = '<p class="empty-cart-message">Keranjang Anda masih kosong.</p>';
            cartTotalPrice.textContent = 'IDR 0';
            cartCheckoutBtn.disabled = true;
            cartCheckoutBtn.style.opacity = '0.5';
            return;
        }

        cartCheckoutBtn.disabled = false;
        cartCheckoutBtn.style.opacity = '1';

        let cartHTML = '';
        let totalCost = 0;

        cart.forEach(item => {
            const itemTotal = item.price * item.quantity;
            totalCost += itemTotal;
            
            cartHTML += `
                <div class="cart-item" data-id="${item.id}">
                    <img src="${item.image}" alt="${item.name}" class="cart-item-img">
                    <div class="cart-item-details">
                        <h4 class="cart-item-name">${item.name}</h4>
                        <span class="cart-item-price">IDR ${Number(item.price).toLocaleString('id-ID')} × ${item.quantity} = IDR ${(item.price * item.quantity).toLocaleString('id-ID')}</span>
                        <div class="cart-item-qty">
                            <button class="qty-btn dec-qty" data-id="${item.id}"><i class="fa-solid fa-minus"></i></button>
                            <span class="qty-val">${item.quantity}</span>
                            <button class="qty-btn inc-qty" data-id="${item.id}"><i class="fa-solid fa-plus"></i></button>
                        </div>
                    </div>
                    <button class="cart-item-remove" data-id="${item.id}"><i class="fa-regular fa-trash-can"></i></button>
                </div>
            `;
        });

        cartItemsContainer.innerHTML = cartHTML;
        cartTotalPrice.textContent = `IDR ${totalCost.toLocaleString('id-ID')}`;

        // Attach event listeners for quantity adjustment and removal
        cartItemsContainer.querySelectorAll('.dec-qty').forEach(btn => {
            btn.addEventListener('click', () => adjustQuantity(btn.dataset.id, -1));
        });

        cartItemsContainer.querySelectorAll('.inc-qty').forEach(btn => {
            btn.addEventListener('click', () => adjustQuantity(btn.dataset.id, 1));
        });

        cartItemsContainer.querySelectorAll('.cart-item-remove').forEach(btn => {
            btn.addEventListener('click', () => removeFromCart(btn.dataset.id));
        });
    }

    // Format number (kept for legacy support or other parts if needed)
    function numberWithK(x) {
        if (x >= 1000) {
            return (x / 1000) + 'k';
        }
        return x.toString();
    }

    // Add item to cart
    function addToCart(id, name, price, image) {
        const existingItem = cart.find(item => item.id === id);
        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            cart.push({ id, name, price: parseInt(price), image, quantity: 1 });
        }
        saveCart();
        showToast(`${name} telah ditambahkan ke keranjang!`);
        
        // Automatically open cart drawer to delight user
        if (cartDrawer) {
            cartDrawer.classList.add('active');
        }
    }

    // Adjust quantity
    function adjustQuantity(id, amount) {
        const item = cart.find(item => item.id === id);
        if (item) {
            item.quantity += amount;
            if (item.quantity <= 0) {
                removeFromCart(id);
            } else {
                saveCart();
            }
        }
    }

    // Remove item
    function removeFromCart(id) {
        const itemIndex = cart.findIndex(item => item.id === id);
        if (itemIndex > -1) {
            const name = cart[itemIndex].name;
            cart.splice(itemIndex, 1);
            saveCart();
            showToast(`${name} dihapus dari keranjang.`, 'error');
        }
    }

    // Attach click events on Today's Specials cards
    document.querySelectorAll('.quick-add-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const name = btn.dataset.name;
            const price = btn.dataset.price;
            const image = btn.dataset.image;
            addToCart(id, name, price, image);
        });
    });

    // Checkout Order Simulation
    if (cartCheckoutBtn) {
        cartCheckoutBtn.addEventListener('click', () => {
            showToast('Pesanan Anda sedang diproses! Terima kasih telah membeli dari Dapur Bunda.');
            cart = [];
            saveCart();
            setTimeout(() => {
                if (cartDrawer) cartDrawer.classList.remove('active');
            }, 1000);
        });
    }

    // Initialize cart layout
    renderCart();

    // ==========================================
    // CUSTOM ORDER MODAL TRIGGERS & FORM
    // ==========================================
    const customOrderModal = document.getElementById('custom-order-modal');
    const customOrderTriggerNav = document.getElementById('nav-custom-order');
    const customOrderTriggerHero = document.getElementById('hero-custom-request');
    const modalClose = document.getElementById('modal-close');
    const modalCancel = document.getElementById('modal-cancel');
    const customOrderForm = document.getElementById('custom-order-form');
    const submitBtn = document.getElementById('modal-submit-btn');

    // Open Modal function
    function openCustomModal() {
        if (customOrderModal) {
            customOrderModal.classList.add('active');
            // Prevent body scroll when modal is open
            document.body.style.overflow = 'hidden';
            
            // Set min date of delivery date field to today
            const dateInput = document.getElementById('delivery_date');
            if (dateInput) {
                const today = new Date().toISOString().split('T')[0];
                dateInput.setAttribute('min', today);
            }
        }
    }

    // Close Modal function
    function closeCustomModal() {
        if (customOrderModal) {
            customOrderModal.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    if (customOrderTriggerNav) customOrderTriggerNav.addEventListener('click', openCustomModal);
    if (customOrderTriggerHero) customOrderTriggerHero.addEventListener('click', openCustomModal);
    if (modalClose) modalClose.addEventListener('click', closeCustomModal);
    if (modalCancel) modalCancel.addEventListener('click', closeCustomModal);
    
    // Close modal when clicking backdrop
    if (customOrderModal) {
        customOrderModal.addEventListener('click', (e) => {
            if (e.target === customOrderModal) {
                closeCustomModal();
            }
        });
    }

    // Form Submission handler (AJAX)
    if (customOrderForm) {
        customOrderForm.addEventListener('submit', (e) => {
            e.preventDefault();
            
            // Disable submit button and add loading text
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Mengirim...';
            submitBtn.disabled = true;

            const formData = new FormData(customOrderForm);
            const actionUrl = customOrderForm.getAttribute('action');

            fetch(actionUrl, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Terjadi kesalahan jaringan atau validasi gagal.');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showToast(data.message, 'success');
                    customOrderForm.reset();
                    closeCustomModal();
                } else {
                    showToast('Ada masalah dalam pengolahan permintaan Anda.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast(error.message || 'Gagal mengirim permintaan. Periksa inputan Anda.', 'error');
            })
            .finally(() => {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            });
        });
    }

    // ==========================================
    // FLOATING CHAT BUTTON SIMULATION
    // ==========================================
    const floatingChatBtn = document.getElementById('floating-chat');
    const chatTriggerNav = document.getElementById('chat-trigger');

    function simulateChat() {
        showToast('Bunda sedang sibuk di dapur menyiapkan pesanan, hubungi via WhatsApp: +62 812-3456-7890', 'success');
    }

    if (floatingChatBtn) floatingChatBtn.addEventListener('click', simulateChat);
    if (chatTriggerNav) chatTriggerNav.addEventListener('click', simulateChat);

    // ==========================================
    // CUSTOM ORDER BUILDER SYSTEM (GET ROUTE)
    // ==========================================
    const customOrderContainer = document.querySelector('.custom-order-page-container');
    if (customOrderContainer) {
        // Selections State
        let selectedDish = "Artisan Noodles";
        let selectedIngredients = ["Farm Fresh Veggies", "Wild Mushrooms"];
        let selectedPortion = "Family Gathering";
        let selectedSpice = "Mild";

        // Pricing Models (in IDR)
        const dishPrices = {
            "Traditional Nasi": 35000,
            "Artisan Noodles": 45000,
            "Savory Pastry": 40000
        };

        const ingredientPrices = {
            "Farm Fresh Veggies": 15000,
            "Wagyu Beef": 50000,
            "Exotic Spices": 10000,
            "Wild Mushrooms": 20000
        };

        const portionMultipliers = {
            "Single Portion": 1.0,
            "Couple Pack": 1.9,
            "Family Gathering": 3.07,
            "Party Pack": 6.8
        };

        // DOM Elements
        const baseDishCards = document.querySelectorAll('.base-dish-card');
        const ingredientCards = document.querySelectorAll('.ingredient-select-card');
        const portionSelect = document.getElementById('portion-select');
        const spiceBtns = document.querySelectorAll('.spice-btn');
        const instructionsTextarea = document.getElementById('custom-instructions');
        
        const summaryPillsContainer = document.getElementById('summary-badge-pills-container');
        const originalPriceDisplay = document.getElementById('original-price-display');
        const discountedPriceDisplay = document.getElementById('discounted-price-display');
        const reviewBtn = document.getElementById('summary-review-order-btn');
        
        // Checkout Modal DOM
        const checkoutModal = document.getElementById('checkout-custom-modal');
        const checkoutModalClose = document.getElementById('checkout-modal-close');
        const checkoutModalCancel = document.getElementById('checkout-modal-cancel');
        const hiddenDetailsInput = document.getElementById('hidden-compiled-order-details');
        const customCheckoutForm = document.getElementById('custom-checkout-details-form');

        // Chat DOM
        const chatFeed = document.getElementById('chat-messages-container');
        const chatForm = document.getElementById('custom-chat-input-form');
        const chatInput = document.getElementById('chat-user-message-input');
        const typingBubble = document.getElementById('chat-typing-bubble');

        // Helper: Format to IDR rupiah formatting
        function formatRupiah(num) {
            return 'IDR ' + num.toLocaleString('id-ID');
        }

        // Live calculation and summary pill renderer
        function updateSummary() {
            // Render summary badges
            let pillsHTML = `<span class="summary-pill pill-dish">${selectedDish}</span>`;
            selectedIngredients.forEach(ing => {
                pillsHTML += `<span class="summary-pill pill-ingredient">${ing}</span>`;
            });
            pillsHTML += `<span class="summary-pill pill-portion">${selectedPortion}</span>`;
            pillsHTML += `<span class="summary-pill pill-spice">${selectedSpice} Spice</span>`;
            
            summaryPillsContainer.innerHTML = pillsHTML;

            // Calculations
            const baseCost = dishPrices[selectedDish] || 40000;
            let ingCost = 0;
            selectedIngredients.forEach(ing => {
                ingCost += ingredientPrices[ing] || 0;
            });
            const multiplier = portionMultipliers[selectedPortion] || 1.0;

            const discountedPrice = Math.round(((baseCost + ingCost) * multiplier) / 500) * 500;
            const originalPrice = Math.round((discountedPrice * 1.16) / 500) * 500;

            discountedPriceDisplay.textContent = formatRupiah(discountedPrice);
            originalPriceDisplay.textContent = formatRupiah(originalPrice);
        }

        // 1. Base Dish selector handler
        baseDishCards.forEach(card => {
            card.addEventListener('click', () => {
                baseDishCards.forEach(c => c.classList.remove('selected'));
                card.classList.add('selected');
                selectedDish = card.dataset.dish;
                updateSummary();
            });
        });

        // 2. Ingredients toggler handler
        ingredientCards.forEach(card => {
            card.addEventListener('click', () => {
                const ing = card.dataset.ingredient;
                card.classList.toggle('selected');
                
                if (card.classList.contains('selected')) {
                    if (!selectedIngredients.includes(ing)) {
                        selectedIngredients.push(ing);
                    }
                } else {
                    selectedIngredients = selectedIngredients.filter(item => item !== ing);
                }
                updateSummary();
            });
        });

        // 3. Portion size select handler
        if (portionSelect) {
            portionSelect.addEventListener('change', () => {
                // Parse mapping value
                if (portionSelect.value === "Single Portion") selectedPortion = "Single Portion";
                else if (portionSelect.value === "Couple Pack") selectedPortion = "Couple Pack";
                else if (portionSelect.value === "Family Gathering") selectedPortion = "Family Gathering";
                else if (portionSelect.value === "Party Pack") selectedPortion = "Party Pack";
                updateSummary();
            });
        }

        // 4. Spice level buttons handler
        spiceBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                spiceBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                selectedSpice = btn.dataset.spice;
                updateSummary();
            });
        });

        // ==========================================
        // MAMA BUNDA CHAT BOT SIMULATION
        // ==========================================
        function appendMessage(text, senderClass, timestamp) {
            const msgDiv = document.createElement('div');
            msgDiv.className = `chat-message ${senderClass}`;
            
            msgDiv.innerHTML = `
                <div class="msg-bubble">${text}</div>
                <span class="msg-timestamp">${timestamp}</span>
            `;
            
            // Append before typing indicator bubble if it's there, else to end
            if (typingBubble) {
                chatFeed.insertBefore(msgDiv, typingBubble);
            } else {
                chatFeed.appendChild(msgDiv);
            }
            
            // Auto scroll to bottom
            chatFeed.scrollTop = chatFeed.scrollHeight;
        }

        if (chatForm && chatInput) {
            chatForm.addEventListener('submit', (e) => {
                e.preventDefault();
                const text = chatInput.value.trim();
                if (!text) return;

                const now = new Date();
                const timestamp = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
                
                // Append User bubble
                appendMessage(text, 'user-msg', timestamp);
                chatInput.value = '';

                // Trigger Mama Bunda typing simulation
                if (typingBubble) {
                    typingBubble.style.display = 'flex';
                    chatFeed.scrollTop = chatFeed.scrollHeight;
                }

                setTimeout(() => {
                    if (typingBubble) typingBubble.style.display = 'none';

                    // Pick reply contextually
                    let reply = "Aduh manis sekali request-nya, Bunda catat ya detail tambahannya. Bunda pastikan dimasak dengan cinta!";
                    const lowerText = text.toLowerCase();
                    
                    if (lowerText.includes('jamur') || lowerText.includes('mushroom')) {
                        reply = "Jamur tiram segar gunung buatan kakek ini rasanya khas sekali, Bunda tambahkan porsi melimpah ya!";
                        // Sync UI selection automatically for fun!
                        const mushroomCard = document.querySelector('[data-ingredient="Wild Mushrooms"]');
                        if (mushroomCard && !mushroomCard.classList.contains('selected')) {
                            mushroomCard.click();
                        }
                    } else if (lowerText.includes('pedas') || lowerText.includes('spice') || lowerText.includes('cabe')) {
                        reply = "Bunda kurangi cabainya agar anak-anak tidak kepedasan ya. Kita buat ramah anak!";
                    } else if (lowerText.includes('daging') || lowerText.includes('beef') || lowerText.includes('wagyu')) {
                        reply = "Pilihan wagyu premium memang mantap, Bunda potong tebal-tebal ya!";
                        const wagyuCard = document.querySelector('[data-ingredient="Wagyu Beef"]');
                        if (wagyuCard && !wagyuCard.classList.contains('selected')) {
                            wagyuCard.click();
                        }
                    } else if (lowerText.includes('porsi') || lowerText.includes('banyak') || lowerText.includes('portion')) {
                        reply = "Siap sayang, Bunda lebihkan porsi nasinya agar semua keluarga kenyang.";
                    }

                    const chefNow = new Date();
                    const chefTimestamp = chefNow.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
                    
                    appendMessage(reply, 'chef-msg', chefTimestamp);
                }, 1500);
            });
        }

        // ==========================================
        // REVIEW & PLACE ORDER DATABASE TRIGGER
        // ==========================================
        if (reviewBtn && checkoutModal) {
            reviewBtn.addEventListener('click', () => {
                // Compile custom details string
                const notes = instructionsTextarea ? instructionsTextarea.value.trim() : 'None';
                const compiledDetails = `Base Dish: ${selectedDish} | Ingredients: ${selectedIngredients.join(', ')} | Portion: ${selectedPortion} | Spice: ${selectedSpice} | Special Request: ${notes}`;
                
                if (hiddenDetailsInput) {
                    hiddenDetailsInput.value = compiledDetails;
                }
                
                // Open checkout details modal
                checkoutModal.classList.add('active');
                document.body.style.overflow = 'hidden';
            });
        }

        function closeCheckoutModal() {
            if (checkoutModal) {
                checkoutModal.classList.remove('active');
                document.body.style.overflow = '';
            }
        }

        if (checkoutModalClose) checkoutModalClose.addEventListener('click', closeCheckoutModal);
        if (checkoutModalCancel) checkoutModalCancel.addEventListener('click', closeCheckoutModal);
        
        if (checkoutModal) {
            checkoutModal.addEventListener('click', (e) => {
                if (e.target === checkoutModal) {
                    closeCheckoutModal();
                }
            });
        }

        // AJAX submit handler
        if (customCheckoutForm) {
            customCheckoutForm.addEventListener('submit', (e) => {
                e.preventDefault();
                const submitBtn = document.getElementById('checkout-modal-submit-btn');
                const originalText = submitBtn.textContent;
                submitBtn.textContent = 'Memproses...';
                submitBtn.disabled = true;

                const formData = new FormData(customCheckoutForm);
                const actionUrl = customCheckoutForm.getAttribute('action');

                fetch(actionUrl, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) throw new Error('Terjadi kesalahan jaringan atau validasi.');
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        showToast(data.message, 'success');
                        customCheckoutForm.reset();
                        closeCheckoutModal();
                    } else {
                        showToast('Ada masalah memproses pesanan Anda.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast(error.message || 'Gagal mengirim pesanan kustom.', 'error');
                })
                .finally(() => {
                    submitBtn.textContent = originalText;
                    submitBtn.disabled = false;
                });
            });
        }

        // Initial setup run
        updateSummary();
    }
});

