import Swal from "sweetalert2";


document.addEventListener('click', async (e) => {
    const link = e.target.closest('.toastLink')
    if (!link) return

    e.preventDefault()

    try {
        const response = await fetch(link.dataset.url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
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
            link.closest('tr').remove()
        }

    } catch (error) {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: 'Something went wrong',
            showConfirmButton: false,
            timer: 2500,
        })
    }
})