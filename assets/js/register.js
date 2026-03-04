const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 1200,
    timerProgressBar: true,
});

document.addEventListener('DOMContentLoaded', function () {
    const registerForm = document.getElementById('register-form');

    if (registerForm) {
        registerForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            fetch('register.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        Toast.fire({
                            icon: 'success',
                            title: data.message
                        }).then(() => {
                            window.location.href = 'login.php';
                        });
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: data.message
                        });
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    }
});