import Swal from "sweetalert2";


document.addEventListener('click', async (e) => {
    const btn = e.target.closest('.remove-cart')
    if (!btn) return

    e.preventDefault()

    const id = btn.dataset.id

    const response = await fetch(`/cart/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document
                .querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        },
    })

    const data = await response.json()

    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: data.status === 'success' ? 'success' : 'error',
        title: data.message,
        showConfirmButton: false,
        timer: 2500,
    })

    if (data.status === 'success') {
        btn.closest('tr').remove()
    }
})