function login() {
  const email = document.getElementById('email').value;
  const password = document.getElementById('password').value;

  fetch('http://api.local/local/api/login.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: new URLSearchParams({
      email,
      password
    }),
    credentials: 'include' // ВАЖНО ДЛЯ BITRIX
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      document.getElementById('result').innerText = 'Успешный вход';
      window.location.href = 'profile.html';
    } else {
      document.getElementById('result').innerText = data.error;
    }
  });
}
