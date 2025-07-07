// SweetAlert2 Default Configuration
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

// Show Toast Notification
function showToast(icon, title) {
    Toast.fire({
        icon: icon,
        title: title
    });
}

// Confirm Dialog
function showConfirm(options) {
    const defaultOptions = {
        title: 'Apakah Anda yakin?',
        text: "Anda tidak akan dapat mengembalikan tindakan ini!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, lanjutkan!',
        cancelButtonText: 'Batal'
    };
    
    const mergedOptions = {...defaultOptions, ...options};
    
    return Swal.fire(mergedOptions);
}

// Success Alert
function showSuccess(message, title = 'Sukses!') {
    return Swal.fire({
        title: title,
        text: message,
        icon: 'success',
        confirmButtonText: 'OK'
    });
}

// Error Alert
function showError(message, title = 'Error!') {
    return Swal.fire({
        title: title,
        text: message,
        icon: 'error',
        confirmButtonText: 'OK'
    });
}

// Form Submission Success Handler
function handleFormSuccess(message, redirectUrl = null) {
    Swal.fire({
        title: 'Sukses!',
        text: message,
        icon: 'success',
        confirmButtonText: 'OK'
    }).then((result) => {
        if (result.isConfirmed && redirectUrl) {
            window.location.href = redirectUrl;
        }
    });
}

// Form Submission Error Handler
function handleFormError(errors) {
    let errorMessages = '';
    
    if (typeof errors === 'string') {
        errorMessages = errors;
    } else if (typeof errors === 'object') {
        for (const field in errors) {
            errorMessages += errors[field].join('<br>') + '<br>';
        }
    }
    
    Swal.fire({
        title: 'Error!',
        html: errorMessages,
        icon: 'error',
        confirmButtonText: 'OK'
    });
}