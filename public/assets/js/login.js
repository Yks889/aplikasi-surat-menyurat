$(document).ready(function() {
    // Form validation
    $('#login-form').validate({
        rules: {
            username: {
                required: true,
                minlength: 3
            },
            password: {
                required: true,
                minlength: 6
            }
        },
        messages: {
            username: {
                required: "Username harus diisi",
                minlength: "Username minimal 3 karakter"
            },
            password: {
                required: "Password harus diisi",
                minlength: "Password minimal 6 karakter"
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.input-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function(form) {
            // Show loading indicator
            const submitButton = $(form).find('button[type="submit"]');
            const originalText = submitButton.html();
            submitButton.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...');
            submitButton.prop('disabled', true);
            
            // Simulate AJAX call
            setTimeout(function() {
                form.submit();
            }, 1000);
            
            // Prevent actual form submission for demo
            return false;
        }
    });
    
    // Toggle password visibility
    $('#toggle-password').on('click', function() {
        const passwordInput = $('#password');
        const icon = $(this).find('i');
        
        if (passwordInput.attr('type') === 'password') {
            passwordInput.attr('type', 'text');
            icon.removeClass('bi-eye').addClass('bi-eye-slash');
        } else {
            passwordInput.attr('type', 'password');
            icon.removeClass('bi-eye-slash').addClass('bi-eye');
        }
    });
    
    // Handle remember me checkbox
    $('#remember').on('change', function() {
        if ($(this).is(':checked')) {
            localStorage.setItem('rememberUsername', $('#username').val());
        } else {
            localStorage.removeItem('rememberUsername');
        }
    });
    
    // Check if username was remembered
    const rememberedUsername = localStorage.getItem('rememberUsername');
    if (rememberedUsername) {
        $('#username').val(rememberedUsername);
        $('#remember').prop('checked', true);
    }
    
    // Social login buttons
    $('.btn-social').on('click', function(e) {
        e.preventDefault();
        const provider = $(this).data('provider');
        
        Swal.fire({
            title: 'Login dengan ' + (provider === 'facebook' ? 'Facebook' : 'Google'),
            text: 'Fitur ini akan diimplementasikan kemudian',
            icon: 'info',
            confirmButtonText: 'OK'
        });
    });
});