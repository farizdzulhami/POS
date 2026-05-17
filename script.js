// Initial State
let products = JSON.parse(localStorage.getItem('pos_products')) || [
    { id: Date.now() + 1, name: 'Kopi Susu Gula Aren', category: 'Minuman', price: 25000, image: 'https://images.unsplash.com/photo-1541167760496-1ae2956f8f29?w=400' },
    { id: Date.now() + 2, name: 'Americano Ice', category: 'Minuman', price: 20000, image: 'https://images.unsplash.com/photo-1551046710-23b0d462bc2d?w=400' },
    { id: Date.now() + 3, name: 'Nasi Goreng Spesial', category: 'Makanan', price: 35000, image: 'https://images.unsplash.com/photo-1512058560566-d8d437bab73c?w=400' },
    { id: Date.now() + 4, name: 'Croissant Butter', category: 'Snack', price: 18000, image: 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=400' }
];

let cart = [];

// DOM Elements
const productList = document.getElementById('product-list');
const cartItemsContainer = document.getElementById('cart-items');
const adminProductTable = document.getElementById('admin-product-table');
const modal = document.getElementById('product-modal');
const receiptModal = document.getElementById('receipt-modal');

// --- Initialization ---
function init() {
    renderProducts();
    renderAdminProducts();
    updateCartUI();
    saveToStorage();
}

// --- Navigation ---
function switchView(view) {
    document.querySelectorAll('.view').forEach(v => v.classList.remove('active'));
    document.querySelectorAll('.nav-btn').forEach(b => b.classList.remove('active'));
    
    document.getElementById(`view-${view}`).classList.add('active');
    document.getElementById(`btn-${view}`).classList.add('active');
}

// --- Product Management (CRUD) ---
function renderProducts(filteredProducts = products) {
    productList.innerHTML = filteredProducts.map(p => `
        <div class="product-card" onclick="addToCart(${p.id})">
            <img src="${p.image || 'https://via.placeholder.com/150'}" class="product-image" alt="${p.name}">
            <span class="category">${p.category}</span>
            <h3>${p.name}</h3>
            <p class="price">Rp ${p.price.toLocaleString()}</p>
        </div>
    `).join('');
}

function renderAdminProducts() {
    adminProductTable.innerHTML = products.map((p, index) => `
        <tr>
            <td><img src="${p.image || 'https://via.placeholder.com/150'}" class="admin-img"></td>
            <td><strong>${p.name}</strong></td>
            <td>${p.category}</td>
            <td>Rp ${p.price.toLocaleString()}</td>
            <td>
                <button class="btn-icon edit" onclick="editProduct(${index})">✏️</button>
                <button class="btn-icon delete" onclick="deleteProduct(${index})">🗑️</button>
            </td>
        </tr>
    `).join('');
}

function openProductModal() {
    document.getElementById('modal-title').innerText = 'Tambah Produk Baru';
    document.getElementById('product-form').reset();
    document.getElementById('edit-index').value = '-1';
    modal.style.display = 'flex';
}

function closeProductModal() {
    modal.style.display = 'none';
}

function saveProduct(e) {
    e.preventDefault();
    const index = parseInt(document.getElementById('edit-index').value);
    const newProduct = {
        id: index === -1 ? Date.now() : products[index].id,
        name: document.getElementById('prod-name').value,
        category: document.getElementById('prod-category').value,
        price: parseInt(document.getElementById('prod-price').value),
        image: document.getElementById('prod-image').value
    };

    if (index === -1) {
        products.push(newProduct);
    } else {
        products[index] = newProduct;
    }

    saveToStorage();
    renderProducts();
    renderAdminProducts();
    closeProductModal();
}

function editProduct(index) {
    const p = products[index];
    document.getElementById('modal-title').innerText = 'Edit Produk';
    document.getElementById('prod-name').value = p.name;
    document.getElementById('prod-category').value = p.category;
    document.getElementById('prod-price').value = p.price;
    document.getElementById('prod-image').value = p.image;
    document.getElementById('edit-index').value = index;
    modal.style.display = 'flex';
}

function deleteProduct(index) {
    if (confirm('Hapus produk ini?')) {
        products.splice(index, 1);
        saveToStorage();
        renderProducts();
        renderAdminProducts();
    }
}

function filterProducts() {
    const query = document.getElementById('search-product').value.toLowerCase();
    const filtered = products.filter(p => p.name.toLowerCase().includes(query) || p.category.toLowerCase().includes(query));
    renderProducts(filtered);
}

// --- Cart Logic ---
function addToCart(productId) {
    const product = products.find(p => p.id === productId);
    const existing = cart.find(item => item.id === productId);

    if (existing) {
        existing.quantity += 1;
    } else {
        cart.push({ ...product, quantity: 1 });
    }
    updateCartUI();
}

function changeQty(productId, delta) {
    const item = cart.find(i => i.id === productId);
    if (!item) return;

    item.quantity += delta;
    if (item.quantity <= 0) {
        cart = cart.filter(i => i.id !== productId);
    }
    updateCartUI();
}

function clearCart() {
    cart = [];
    updateCartUI();
}

function updateCartUI() {
    cartItemsContainer.innerHTML = cart.map(item => `
        <div class="cart-item">
            <div class="cart-item-info">
                <h4>${item.name}</h4>
                <p>Rp ${item.price.toLocaleString()} x ${item.quantity}</p>
            </div>
            <div class="cart-controls">
                <button class="count-btn" onclick="changeQty(${item.id}, -1)">-</button>
                <span>${item.quantity}</span>
                <button class="count-btn" onclick="changeQty(${item.id}, 1)">+</button>
            </div>
        </div>
    `).join('');

    const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    const tax = subtotal * 0.1;
    const total = subtotal + tax;

    document.getElementById('cart-subtotal').innerText = `Rp ${subtotal.toLocaleString()}`;
    document.getElementById('cart-tax').innerText = `Rp ${tax.toLocaleString()}`;
    document.getElementById('cart-total').innerText = `Rp ${total.toLocaleString()}`;
}

// --- Storage ---
function saveToStorage() {
    localStorage.setItem('pos_products', JSON.stringify(products));
}

// --- Checkout & Receipt ---
function checkout() {
    if (cart.length === 0) return alert('Keranjang masih kosong!');
    
    const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    const tax = subtotal * 0.1;
    const total = subtotal + tax;
    const date = new Date().toLocaleString('id-ID');

    let itemsHtml = cart.map(item => `
        <div class="receipt-item">
            <span>${item.name} x${item.quantity}</span>
            <span>Rp ${(item.price * item.quantity).toLocaleString()}</span>
        </div>
    `).join('');

    document.getElementById('receipt-content').innerHTML = `
        <div class="receipt-header">
            <h3>VELOPOS PRO</h3>
            <p>Jl. Sudirman No. 123, Jakarta</p>
            <p>${date}</p>
        </div>
        <div class="receipt-body">
            ${itemsHtml}
            <div class="receipt-divider"></div>
            <div class="receipt-item">
                <span>Subtotal</span>
                <span>Rp ${subtotal.toLocaleString()}</span>
            </div>
            <div class="receipt-item">
                <span>Pajak (10%)</span>
                <span>Rp ${tax.toLocaleString()}</span>
            </div>
            <div class="receipt-divider"></div>
            <div class="receipt-item" style="font-weight:bold; font-size:1.2rem;">
                <span>TOTAL</span>
                <span>Rp ${total.toLocaleString()}</span>
            </div>
        </div>
        <div class="receipt-header" style="margin-top:20px; border:none;">
            <p>Terima Kasih Atas Kunjungan Anda!</p>
        </div>
    `;

    receiptModal.style.display = 'flex';
}

function closeReceipt() {
    receiptModal.style.display = 'none';
    clearCart();
}

// Initialize on Load
init();
