document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.getElementById('adminLoginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const user = document.getElementById('adminUser').value;
            const pass = document.getElementById('adminPass').value;
            const errorDiv = document.getElementById('loginError');

            // Reset error
            errorDiv.textContent = '';

            fetch('/api/admin/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content')
                },
                body: JSON.stringify({
                    username: user,
                    password: pass
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = window.ADMIN_BUILDER_URL;
                    } else {
                        errorDiv.textContent = data.message || 'Credenciales incorrectas';
                    }
                })
                .catch(err => {
                    console.error(err);
                    errorDiv.textContent = 'Error de conexión con el servidor.';
                });
        });
    }
});