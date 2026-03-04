
document.addEventListener('DOMContentLoaded', function () {
    const registerForm = document.getElementById('register-form');

    if (registerForm) {
        registerForm.addEventListener('submit', function (e) {
            e.preventDefault();

            // --- 1. KIỂM TRA RỖNG VÀ TỰ FOCUS TẠI FRONTEND ---
            const fullname = document.getElementById('fullname');
            const username = document.getElementById('username');
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('confirmPassword');

            if (fullname.value.trim() === '') {
                Toast.fire({ icon: 'warning', title: 'Bạn chưa nhập Họ và Tên' });
                fullname.focus(); // Tự trỏ chuột vào ô Họ tên
                return;
            }
            if (username.value.trim() === '') {
                Toast.fire({ icon: 'warning', title: 'Bạn chưa nhập Tên đăng nhập' });
                username.focus();
                return;
            }
            if (email.value.trim() === '') {
                Toast.fire({ icon: 'warning', title: 'Bạn chưa nhập Email' });
                email.focus();
                return;
            }
            if (password.value.trim() === '') {
                Toast.fire({ icon: 'warning', title: 'Bạn chưa nhập Mật khẩu' });
                password.focus();
                return;
            }
            if (confirmPassword.value.trim() === '') {
                Toast.fire({ icon: 'warning', title: 'Bạn chưa xác nhận Mật khẩu' });
                confirmPassword.focus();
                return;
            }
            // -------------------------------------------------

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

                        // TỰ FOCUS VÀO Ô BỊ LỖI THEO BIẾN 'field' TỪ PHP TRẢ VỀ ---
                        if (data.field) {
                            const errorInput = document.getElementById(data.field);
                            if (errorInput) {
                                errorInput.focus();
                            }
                        }
                        // -----------------------------------------------------------------
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    }
});