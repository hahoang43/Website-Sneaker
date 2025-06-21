window.addEventListener('DOMContentLoaded', () => {
  (async () => {
    try {
      const res = await fetch('/PRJ/Website-Sneaker/backend/auth/check_login.php');
      const result = await res.json();
      const signDiv = document.querySelector('.sign');
      if (!signDiv) return;

      const gioHangLink = '/PRJ/Website-Sneaker/page/giohang.html';

      if (result.loggedIn) {
        signDiv.innerHTML = `
          <div class="user-dropdown-wrapper">
            <div class="user-dropdown position-relative">
              <button class="cart-btn user-icon" id="toggleDropdown">
                <i class="fa-solid fa-user"></i>
              </button>
              <div class="username" style="font-size: 0.9rem; color: #611313;">${result.username}</div>
              <ul class="dropdown-menu position-absolute" id="dropdownMenu" style="display:none; right:0; top:100%;">
                <li><a class="dropdown-item" href="/PRJ/Website-Sneaker/page/profile.html"><i class="fa-solid fa-user"></i> Trang tài khoản</a></li>
                <li><a class="dropdown-item" href="#" id="logout-btn"><i class="fa-solid fa-right-from-bracket"></i> Đăng xuất</a></li>
              </ul>
            </div>
          </div>
          <a href="${gioHangLink}" class="cart-btn"><i class="fa-solid fa-cart-shopping"></i></a>
        `;

        // Toggle dropdown
        const toggleBtn = document.getElementById('toggleDropdown');
        const dropdownMenu = document.getElementById('dropdownMenu');

        toggleBtn.addEventListener('mouseenter', () => {
          dropdownMenu.style.display = 'block';
        });

        toggleBtn.addEventListener('mouseleave', () => {
          setTimeout(() => dropdownMenu.style.display = 'none', 300);
        });

        dropdownMenu.addEventListener('mouseenter', () => {
          dropdownMenu.style.display = 'block';
        });

        dropdownMenu.addEventListener('mouseleave', () => {
          dropdownMenu.style.display = 'none';
        });

        // Logout
        document.getElementById('logout-btn').addEventListener('click', async (e) => {
          e.preventDefault();
          await fetch('/PRJ/Website-Sneaker/backend/auth/logout.php');
          window.location.href = '/PRJ/Website-Sneaker/page/dangnhap.html';
        });

      } else {
        signDiv.innerHTML = `
          <a href="/PRJ/Website-Sneaker/page/dangnhap.html" class="cart-btn"><i class="fa-solid fa-user"></i></a>
          <a href="${gioHangLink}" class="cart-btn"><i class="fa-solid fa-cart-shopping"></i></a>
        `;
      }
    } catch (err) {
      console.error('❌ Lỗi khi gọi check_login.php:', err);
    }
  })();
});
