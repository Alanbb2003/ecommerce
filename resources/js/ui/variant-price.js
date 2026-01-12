
document.addEventListener('change', (e) => {
    if (!e.target.matches('input[name="variant_id"]')) return;

    const price = e.target.dataset.price;

    const priceEl = document.getElementById('product-price');
    if (!priceEl) return;

    priceEl.textContent = `Rp ${Number(price).toLocaleString('id-ID')}`;
});