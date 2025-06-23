
window.addEventListener('DOMContentLoaded', () => {
document.getElementById('show-register').onclick = function(e) {
  e.preventDefault();
  document.getElementById('login-form').style.display = 'none';
  document.getElementById('register-form').style.display = 'block';
  document.getElementById('forgot-form').style.display = 'none';
};
});
window.addEventListener('DOMContentLoaded', () => {
document.getElementById('show-forgot').onclick = function(e) {
  e.preventDefault();
  document.getElementById('login-form').style.display = 'none';
  document.getElementById('register-form').style.display = 'none';
  document.getElementById('forgot-form').style.display = 'block';
};
});
window.addEventListener('DOMContentLoaded', () => {
document.getElementById('back-login1').onclick = function(e) {
  e.preventDefault();
  document.getElementById('login-form').style.display = 'block';
  document.getElementById('register-form').style.display = 'none';
  document.getElementById('forgot-form').style.display = 'none';
};
});
window.addEventListener('DOMContentLoaded', () => {
document.getElementById('back-login2').onclick = function(e) {
  e.preventDefault();
  document.getElementById('login-form').style.display = 'block';
  document.getElementById('register-form').style.display = 'none';
  document.getElementById('forgot-form').style.display = 'none';
};
});
// ✅ XỬ LÝ ĐĂNG NHẬP
document.getElementById('login-form').addEventListener('submit', async function(e) {
  e.preventDefault();

  const email = document.getElementById('login-email').value;
  const password = document.getElementById('login-password').value;

  const response = await fetch('../backend/auth/login.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ email, password })
  });

  const result = await response.json();

  if (result.status === 'success') {
    alert('Đăng nhập thành công!');
    window.location.href = 'index.html';
  } else {
    alert(result.message || 'Đăng nhập thất bại!');
  }
});

// ✅ XỬ LÝ ĐĂNG KÝ
document.getElementById('register-form').addEventListener('submit', async function(e) {
  e.preventDefault();
  const fullname = document.getElementById('register-fullname').value;
  const email = document.getElementById('register-email').value;
  const password = document.getElementById('register-password').value;
  const confirmPassword = document.getElementById('register-password2').value;

  if (password !== confirmPassword) {
    alert('Mật khẩu không khớp!');
    return;
  }

const response = await fetch('../backend/auth/register.php', {
  method: 'POST',
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify({ fullname, email, password })
});

  const result = await response.json();

  if (result.status === 'success') {
    alert('Đăng ký thành công! Bạn có thể đăng nhập ngay.');
    document.getElementById('back-login1').click(); // quay về form login
  } else {
    alert(result.message || 'Đăng ký thất bại!');
  }
});