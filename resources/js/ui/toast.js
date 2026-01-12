import Swal from 'sweetalert2';

document.addEventListener('submit', async (e) => {
    const form = e.target;

    if (!form.matches('form[data-ajax]')) return;

    e.preventDefault();

    const formData = new FormData(form);

    try {
        const response = await fetch(form.action, {
            method: form.method || 'POST',
            headers: {
                'X-CSRF-TOKEN': document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute('content'),
            },
            body: formData,
        });

        const data = await response.json();

        if (!response.ok) throw data;

        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: data.message ?? 'Success',
            showConfirmButton: false,
            timer: 3000,
        });

    } catch (error) {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: error.message ?? 'Something went wrong',
            showConfirmButton: false,
            timer: 3000,
        });
    }
});
