<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Kasir</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.10.2/dist/cdn.min.js" defer></script>
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        .menu-scroll {
            max-height: 600px; /* Sesuaikan tinggi maksimum menu */
            overflow-y: auto; /* Aktifkan scroll jika konten lebih tinggi dari kontainer */
        }
        .invoice-scroll {
            max-height: 300px; /* Sesuaikan tinggi maksimum invoice */
            overflow-y: auto; /* Aktifkan scroll jika konten lebih tinggi dari kontainer */
        }
        .card:hover {
            transform: scale(1.02);
        }
    </style>
</head>
<body>
    @auth
    <div class="container mt-4" x-data="kasir()">
        <div class="row">
            <!-- Bagian Kiri: Menu -->
            <div class="col-md-8 bg-white p-4 rounded shadow-sm">
                <h2 class="h4 font-weight-bold mb-4" style="color: #727D73">Menu</h2>
                <div class="row mb-4 position-sticky top-0 bg-white py-3 z-index-1">
                    <div class="col-8 position-relative">
                        <input type="text" class="form-control" placeholder="Search..." x-model="search">
                        <button class="btn btn-sm btn-outline-danger position-absolute top-50 end-0 translate-middle-y me-3" x-show="search" @click="search = ''">x</button>
                    </div>
                    <div class="col-4">
                        <select class="form-select bg-primary text-white" x-model="selectedCategory">
                            <option value="">All Categories</option>
                            <template x-for="category in categories" :key="category.id">
                                <option :value="category.id" x-text="category.name"></option>
                            </template>
                        </select>
                    </div>
                </div>
                {{-- <div class="position-fixed bottom-0 end-0 m-4">
                    <button class="btn btn-danger btn-lg" @click="resetTransaction">Cancel</button>
                </div> --}}
                <div class="row menu-scroll">
                    <template x-for="menu in filteredMenus" :key="menu.id">
                        <div class="col-6 col-lg-3 mb-4">
                            <div class="card h-100">
                                <img :src="'{{ Storage::url('') }}' + menu.image" :alt="menu.name" class="card-img-top" style="height: 10rem; object-fit: cover;">
                                <div class="card-body">
                                    <h6 class="card-title" x-text="menu.name"></h6>
                                    <p class="card-text" x-text="formatRupiah(menu.price)"></p>

                                    <!-- Button when item is not in cart -->
                                    <template x-if="!isInCart(menu.id)">
                                        <div class="d-flex justify-content-between mx-2" x-show="!isInCart(menu.id)" x-transition>
                                            <button class="btn btn-primary w-100" @click="addToCart(menu.id, menu.name, menu.price)">Tambahkan</button>
                                        </div>
                                    </template>

                                    <!-- Buttons when item is already in the cart -->
                                    <template x-if="isInCart(menu.id)">
                                        <div class="d-flex justify-content-between mx-2">
                                            <button class="btn btn-light" @click="removeFromCart(menu.id)">-</button>
                                            <span x-text="getCartItem(menu.id).quantity"></span>
                                            <button class="btn btn-primary" @click="addToCart(menu.id, menu.name, menu.price)">+</button>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Bagian Kanan: Receipt (Keranjang) -->
            <div class="col-md-4 bg-white p-4 rounded shadow-sm position-sticky top-0">
                <h2 class="h4 font-weight-bold text-center mb-4">Invoice</h2>
                <div>
                    <div class="invoice-scroll">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Qty</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="item in cart" :key="item.id">
                                    <tr>
                                        <td><span class="badge bg-primary rounded-pill" x-text="item.quantity"></span></td>
                                        <td x-text="item.name"></td>
                                        <td x-text="formatRupiah(item.price * item.quantity)"></td>
                                    </tr>
                                </template>
                                <template x-if="cart.length === 0">
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">Keranjang kosong</td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <strong>Sub total:</strong>
                        <span class="h5 font-weight-bold" x-text="formatRupiah(total)"></span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <strong>PPN(11%):</strong>
                        <span class="h6 font-weight-bold" x-text="formatRupiah(total * 0.11)"></span>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <label for="promotion" class="form-label">Promo Code</label>
                        <select class="form-select" id="promotion" x-model="selectedPromotion" @change="applyPromotion">
                            <option value="">Select Promo</option>
                            <template x-for="promotion in promotions" :key="promotion.id">
                                <option :value="promotion.id" x-text="promotion.name"></option>
                            </template>
                        </select>
                    </div>
                    <template x-if="selectedPromotion">
                        <div class="d-flex justify-content-between align-items-center">
                            <strong>Discount:</strong>
                            <span class="h6 font-weight-bold text-danger" x-text="'-' + formatRupiah(discount)"></span>
                        </div>
                    </template>
                    <div class="d-flex justify-content-between align-items-center">
                        <strong>Total:</strong>
                        <span class="h4 font-weight-bold" x-text="formatRupiah(finalTotal)"></span>
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        <button class="btn me-2" :class="paymentMethod === 'digital' ? 'btn-success' : 'btn-outline-success'" @click="togglePaymentMethod('digital')">
                            <i class="bi bi-qr-code-scan"></i><br>Bayar Qris
                        </button>
                        <button class="btn" :class="paymentMethod === 'cash' ? 'btn-warning' : 'btn-outline-warning'" @click="togglePaymentMethod('cash')">
                            <i class="bi bi-cash"></i><br>Bayar Tunai
                        </button>
                    </div>
                    <template x-if="paymentMethod === 'cash'">
                        <div>
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" placeholder="Masukkan jumlah uang tunai" x-model="cashAmount" @input="calculateChange">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <strong>Kembalian:</strong>
                                <span class="h5 font-weight-bold" x-text="formatRupiah(change)"></span>
                            </div>
                        </div>
                    </template>
                    <div class="d-flex justify-content-between mt-4">
                        <button class="btn btn-primary btn-lg w-100" @click="processPayment">Bayar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="container mt-4">
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Akses Ditolak',
                    text: 'Anda harus login untuk mengakses halaman ini.',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/';
                    }
                });
            });
        </script>
    </div>
    @endauth

    <script>
    function kasir() {
        return {
            cart: [],
            total: 0,
            finalTotal: 0,
            discount: 0,
            formattedTotal: '',
            search: '',
            selectedCategory: '',
            selectedPromotion: '',
            paymentMethod: '',
            cashAmount: 0,
            change: 0,
            menus: @json($menus),
            categories: @json($categories),
            promotions: @json($promotions),
            get filteredMenus() {
                let filtered = this.menus;
                if (this.search !== '') {
                    filtered = filtered.filter(menu => menu.name.toLowerCase().includes(this.search.toLowerCase()));
                }
                if (this.selectedCategory !== '') {
                    filtered = filtered.filter(menu => menu.category_id == this.selectedCategory);
                }
                return filtered;
            },
            addToCart(id, name, price) {
                let item = this.cart.find(item => item.id === id);
                if (item) {
                    item.quantity++;
                } else {
                    this.cart.push({ id, name, price, quantity: 1 });
                }
                this.updateTotal();
            },
            removeFromCart(id) {
                let item = this.cart.find(item => item.id === id);
                if (item && item.quantity > 1) {
                    item.quantity--;
                } else {
                    this.cart = this.cart.filter(item => item.id !== id);
                }
                this.updateTotal();
            },
            updateTotal() {
                this.total = this.cart.reduce((carry, item) => carry + (item.price * item.quantity), 0);
                this.applyPromotion();
            },
            applyPromotion() {
                this.discount = 0;
                if (this.selectedPromotion) {
                    let promotion = this.promotions.find(promo => promo.id == this.selectedPromotion);
                    if (promotion) {
                        if (promotion.discount_type === 'percentage') {
                            this.discount = this.total * (promotion.discount_value / 100);
                        } else if (promotion.discount_type === 'flat') {
                            this.discount = promotion.discount_value;
                        }
                    }
                }
                this.finalTotal = Math.max(0, this.total + (this.total * 0.11) - this.discount);
                this.formattedTotal = this.formatRupiah(this.finalTotal);
            },
            isInCart(id) {
                return this.cart.some(item => item.id === id);
            },
            getCartItem(id) {
                return this.cart.find(item => item.id === id) || { quantity: 0 };
            },
            togglePaymentMethod(method) {
                this.paymentMethod = method;
            },
            calculateChange() {
                this.change = Math.max(0, this.cashAmount - this.finalTotal);
            },
            async processPayment() {
                if (!this.paymentMethod) {
                    Swal.fire('Error', 'Pilih metode pembayaran terlebih dahulu', 'error');
                    return;
                }
                if (this.paymentMethod === 'cash') {
                    if (this.cashAmount < this.finalTotal) {
                        Swal.fire('Error', 'Jumlah uang tunai kurang', 'error');
                        return;
                    }
                    try {
                        const response = await fetch('/process-payment', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                cart: this.cart,
                                total: this.total,
                                discount: this.discount,
                                finalTotal: this.finalTotal,
                                paymentMethod: this.paymentMethod,
                                promotionId: this.selectedPromotion
                            })
                        });

                        if (response.ok) {
                            Swal.fire('Success', 'Pembayaran berhasil', 'success');
                            this.resetTransaction();
                        } else {
                            const errorData = await response.json();
                            Swal.fire('Error', errorData.message || 'Pembayaran gagal', 'error');
                            console.error('Payment processing error:', errorData);
                        }
                    } catch (error) {
                        Swal.fire('Error', 'Terjadi kesalahan saat memproses pembayaran', 'error');
                        console.error('Payment processing error:', error);
                    }
                    return;
                }
                // Process digital payment
                try {
                    const response = await fetch('/process-payment', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            cart: this.cart,
                            total: this.total,
                            discount: this.discount,
                            finalTotal: this.finalTotal,
                            paymentMethod: this.paymentMethod,
                            promotionId: this.selectedPromotion
                        })
                    });

                    if (response.ok) {
                        Swal.fire('Success', 'Pembayaran berhasil', 'success');
                        this.resetTransaction();
                    } else {
                        const errorData = await response.json();
                        Swal.fire('Error', errorData.message || 'Pembayaran gagal', 'error');
                        console.error('Payment processing error:', errorData);
                    }
                } catch (error) {
                    Swal.fire('Error', 'Terjadi kesalahan saat memproses pembayaran', 'error');
                    console.error('Payment processing error:', error);
                }
            },
            resetTransaction() {
                this.cart = [];
                this.total = 0;
                this.finalTotal = 0;
                this.discount = 0;
                this.paymentMethod = '';
                this.cashAmount = 0;
                this.change = 0;
                this.selectedPromotion = '';
            },
            formatRupiah(value, locale = 'id-ID', currency = 'IDR') {
                return new Intl.NumberFormat(locale, {
                    style: 'currency',
                    currency,
                }).format(value);
            }
        };
    }
    </script>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>