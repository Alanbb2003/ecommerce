
import Swal from "sweetalert2";

document.addEventListener('click', async (e) => {
    const btn = e.target.closest('.update-cart');

    if (!btn) return
    e.preventDefault();

    const id = btn.dataset.id
    const actionvalue = btn.dataset.action
    const qty = btn.closest('tr').querySelector('.qty-cart');
    try {
        const response = await fetch(`/cart/${id}`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                action: actionvalue
            }),
        });
        if (!response.ok) {
            throw new Error('Request failed');
        }
        const data = await response.json();

        Swal.fire({
            toast: true,
            position: "top-end",
            icon: data.status === 'success' ? 'success' : 'error',
            title: data.message,
            showConfirmButton: false,
            timer: 2500,
        })
        if (data.removed === true) {
            btn.closest('tr').remove();
        }
        if (data.qty !== undefined) {
            qty.textContent = data.qty;
        }
    } catch (err) {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: 'Something went wrong',
            showConfirmButton: false,
            timer: 2000,
        });
    }

})