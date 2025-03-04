function showCustomAlert(config, message = '', type = 'success') {
    // Handle object configuration style
    if (typeof config === 'object') {
        return Swal.fire({
            title: `<div class="custom-title">${config.title || 'Alert'}</div>`,
            html: `<div class="custom-message">
                    <i class="bi bi-${config.icon === 'warning' ? 'exclamation-circle-fill error-icon' : 'check-circle-fill success-icon'}"></i>
                    <p>${config.text || ''}</p>
                   </div>`,
            showConfirmButton: true,
            showCancelButton: config.showCancelButton || false,
            confirmButtonText: config.confirmButtonText || 'Continue',
            confirmButtonColor: config.confirmButtonColor || '#094168',
            cancelButtonText: (config.buttons && config.buttons[0]) || 'Cancel',
            buttonsStyling: false,
            customClass: {
                popup: 'custom-popup',
                confirmButton: 'custom-confirm-button',
                cancelButton: 'custom-cancel-button'
            }
        });
    }

    // Handle simple parameter style
    const iconClass = type === 'success' ? 'check-circle-fill success-icon' : 'exclamation-circle-fill error-icon';
    
    return Swal.fire({
        title: `<div class="custom-title">${config}</div>`,
        html: `<div class="custom-message">
                <i class="bi bi-${iconClass}"></i>
                <p>${message}</p>
               </div>`,
        showConfirmButton: true,
        confirmButtonText: 'continue',
        buttonsStyling: false,
        customClass: {
            popup: 'custom-popup',
            confirmButton: 'custom-confirm-button'
        },
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
}