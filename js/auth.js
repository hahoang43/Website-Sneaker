// Tự động xác định đường dẫn tới giỏ hàng
let gioHangLink = '';
if (window.location.pathname.includes('/page/')) {
  gioHangLink = '/Website-Sneaker/page/giohang.php';
} else {
  gioHangLink = '/Website-Sneaker/page/giohang.php';
}

window.addEventListener('DOMContentLoaded', () => {
  (async () => {
    try {
      const res = await fetch('/Website-Sneaker/backend/auth/check_login.php', {
  credentials: 'include'
});

      if (!res.ok) throw new Error(`HTTP error ${res.status}`);
      const result = await res.json();

      const signDiv = document.querySelector('.sign');
      if (!signDiv) return;

      if (result.loggedIn) {
      if (result.role === 'admin') {
      return;
}
// giao diện user khi đăng nhập 
let dropdownItems = `
    <li><a class="dropdown-item" href="profile.html"><i class="fa-solid fa-user"></i> Trang tài khoản</a></li>
    <li><a class="dropdown-item" href="#" id="logout-btn"><i class="fa-solid fa-right-from-bracket"></i> Đăng xuất</a></li>
  `;


        signDiv.innerHTML = `
          <div class="user-dropdown-wrapper">
            <div class="user-dropdown">
              <button class="cart-btn user-icon" id="toggleDropdown">
                <i class="fa-solid fa-user"></i>
              </button>
              <div class="username">${result.fullname}</div>
              <ul class="dropdown-menu" id="dropdownMenu">
                ${dropdownItems}
              </ul>
            </div>
          </div>
          <a href="giohang.php" class="cart-btn"><i class="fa-solid fa-cart-shopping"></i></a>
        `;

        // Đăng xuất
        document.getElementById('logout-btn').addEventListener('click', async (e) => {
          e.preventDefault();
          await fetch('/Website-Sneaker/backend/auth/logout.php',{ 
           method: 'GET',
    credentials: 'include', 
          });
          alert('Đăng xuất thành công!');
          window.location.href = 'dangnhap.php';
        });

        // Toggle dropdown bằng click
        const toggleBtn = document.getElementById('toggleDropdown');
        const dropdownMenu = document.getElementById('dropdownMenu');

        toggleBtn.addEventListener('click', (e) => {
          e.stopPropagation();
          dropdownMenu.classList.toggle('show');
        });

        // Click ngoài dropdown → đóng menu
        document.addEventListener('click', (e) => {
          if (!dropdownMenu.contains(e.target) && !toggleBtn.contains(e.target)) {
            dropdownMenu.classList.remove('show');
          }
        });

      } else {
        // Nếu chưa đăng nhập
        signDiv.innerHTML = `
          <a href="dangnhap.php" class="cart-btn"><i class="fa-solid fa-user"></i></a>

          <a href="giohang.php" class="cart-btn"><i class="fa-solid fa-cart-shopping"></i></a>
        `;
      }
    } catch (err) {
      console.error('❌ Lỗi khi gọi check_login.php:', err);
    }
  })();
});
