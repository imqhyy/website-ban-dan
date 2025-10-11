{
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1600,
        timerProgressBar: true,
        customClass: { popup: 'my-swal-popup' },
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        
        const currentUserJSON = sessionStorage.getItem('currentUser');
        
        // --- BẢO VỆ TRANG ---
        if (!currentUserJSON) {
            Swal.fire({
                icon: 'warning',
                title: 'Yêu cầu đăng nhập',
                text: 'Bạn cần đăng nhập để truy cập trang này.',
                confirmButtonText: 'Đến trang đăng nhập',
                allowOutsideClick: false,
                customClass: {
                    popup: 'my-swal-popup',
                    title: 'my-swal-title',
                    htmlContainer: 'my-swal-html-container',
                    confirmButton: 'my-swal-confirm-button'
                }
            }).then(() => {
                window.location.href = 'login.html';
            });
            return; 
        }
        document.body.classList.remove('page-loading');

        const currentUser = JSON.parse(currentUserJSON);

        // --- Lấy các phần tử HTML ---
        const userDisplayName = document.getElementById('user-display-name');
        const firstNameInput = document.getElementById('firstName');
        const lastNameInput = document.getElementById('lastName');
        const emailInput = document.getElementById('email');
        const phoneInput = document.getElementById('phone');
        const settingsForm = document.getElementById('account-settings-form');
        const passwordUpdateForm = document.getElementById('password-update-form');
        const logoutLink = document.querySelector('.logout-link');

        // --- HIỂN THỊ THÔNG TIN NGƯỜI DÙNG ---
        if (currentUser) {
            if (userDisplayName) userDisplayName.textContent = currentUser.fullName;
            
            const nameParts = currentUser.fullName.split(' ');
            const firstName = nameParts.shift();
            const lastName = nameParts.join(' ');

            if (firstNameInput) firstNameInput.value = firstName;
            if (lastNameInput) lastNameInput.value = lastName;
            if (emailInput) emailInput.value = currentUser.email;
            if (phoneInput) {
            phoneInput.value = currentUser.phone || '';
        }
        }

        // --- XỬ LÝ LƯU THÔNG TIN CÁ NHÂN ---
        if (settingsForm) {
            settingsForm.addEventListener('submit', function(event) {
                event.preventDefault();
                const newFirstName = firstNameInput.value;
                const newLastName = lastNameInput.value;
                const newFullName = (newFirstName + ' ' + newLastName).trim();
                const newEmail = emailInput.value;
                const newPhone = phoneInput.value;
                let allUsers = JSON.parse(localStorage.getItem('users')) || [];
                const userIndex = allUsers.findIndex(user => user.email === currentUser.email);
                if (userIndex !== -1) {
                    allUsers[userIndex].fullName = newFullName;
                    allUsers[userIndex].email = newEmail;
                    allUsers[userIndex].phone = newPhone; 
                    localStorage.setItem('users', JSON.stringify(allUsers));
                }
                const updatedCurrentUser = { ...currentUser, fullName: newFullName, email: newEmail,phone: newPhone };
                sessionStorage.setItem('currentUser', JSON.stringify(updatedCurrentUser));
                if (userDisplayName) userDisplayName.textContent = newFullName;
                Toast.fire({ icon: 'success', title: 'Cập nhật thông tin thành công!' });
            });
        }

        // --- XỬ LÝ ĐỔI MẬT KHẨU ---
        if (passwordUpdateForm) {
            passwordUpdateForm.addEventListener('submit', function(event) {
                event.preventDefault();
                const currentPassword = document.getElementById('currentPassword').value;
                const newPassword = document.getElementById('newPassword').value;
                const confirmNewPassword = document.getElementById('confirmPassword').value;
                if (currentPassword !== currentUser.password) { Toast.fire({ icon: 'error', title: 'Mật khẩu hiện tại không đúng!' }); return; }
                if (!newPassword) { Toast.fire({ icon: 'error', title: 'Vui lòng nhập mật khẩu mới!' }); return; }
                if (newPassword !== confirmNewPassword) { Toast.fire({ icon: 'error', title: 'Mật khẩu xác nhận không khớp!' }); return; }
                let allUsers = JSON.parse(localStorage.getItem('users')) || [];
                const userIndex = allUsers.findIndex(user => user.email === currentUser.email);
                if (userIndex !== -1) {
                    allUsers[userIndex].password = newPassword;
                    localStorage.setItem('users', JSON.stringify(allUsers));
                    currentUser.password = newPassword;
                    sessionStorage.setItem('currentUser', JSON.stringify(currentUser));
                    Toast.fire({ icon: 'success', title: 'Đổi mật khẩu thành công!' });
                    passwordUpdateForm.reset();
                }
            });
        }
        
        // --- XỬ LÝ NÚT ĐĂNG XUẤT ---
        if (logoutLink) {
            logoutLink.addEventListener('click', function(event) {
                event.preventDefault();
                // ... (toàn bộ code xử lý đăng xuất giữ nguyên)
                sessionStorage.removeItem('currentUser');
                Toast.fire({ icon: 'success', title: 'Đăng xuất thành công!' })
                .then(() => {
                    window.location.href = 'index.html';
                });
            });
        }
    });

} 