const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 1000,
    timerProgressBar: true,
    customClass: {
        popup: 'my-swal-popup'
    },
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.getElementById('login-form');
    const emailInput = document.getElementById('email');

    if (emailInput) {
        emailInput.addEventListener('blur', function () {
            const emailValue = emailInput.value;
            if (emailValue.length > 0 && !emailValue.includes('@')) {
                emailInput.value = emailValue + '@gmail.com';
            }
        });
    }

    loginForm.addEventListener('submit', function (event) {
        event.preventDefault();

        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        if (!email || !password) {
            Toast.fire({
                icon: 'error',
                title: 'Vui lòng nhập thông tin!'
            });
            return;
        }

        let users = JSON.parse(localStorage.getItem('users')) || [];
        const validUser = users.find(user => user.email === email && user.password === password);

        let allUsers = JSON.parse(localStorage.getItem('users')) || [];
        const testUserEmail = "test@gmail.com";

        let testUserAccount = allUsers.find(user => user.email === testUserEmail);

        if (!testUserAccount) {
            testUserAccount = {
                fullName: "Admin",
                email: "admin@gmail.com",
                password: "admin",
                phone: "0123456789",
                orders: []
            };
            allUsers.push(testUserAccount);
            localStorage.setItem('users', JSON.stringify(allUsers));
        }

        Toast.fire({
            icon: 'success',
            title: 'Đăng nhập thành công!'
        }).then(() => {
            sessionStorage.setItem('currentUser', JSON.stringify(testUserAccount));
            window.location.href = 'admin.php';
        });
    });

    const passwordInput = document.getElementById('password');
    const toggleButton = document.querySelector('.password-toggle');
    const eyeIcon = toggleButton.querySelector('i');

    toggleButton.addEventListener('click', function () {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('bi-eye');
            eyeIcon.classList.add('bi-eye-slash');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('bi-eye-slash');
            eyeIcon.classList.add('bi-eye');
        }
    });
});