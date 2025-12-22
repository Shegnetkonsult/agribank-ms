document.getElementById('loginForm').addEventListener('submit', function (e) {
    e.preventDefault();

    let formData = new FormData(this);

    fetch('php/login.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById('loginMessage').textContent = data;
        if (data.includes("success")) {
            window.location.href = 'dashboard.php';  // Redirect to dashboard on successful login
        }
    })
    .catch(error => console.error('Error:', error));
});



