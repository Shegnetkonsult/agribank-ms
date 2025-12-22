document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault();
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'php/login.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        var response = JSON.parse(xhr.responseText);
        if (response.success) {
            if (response.twoFactorRequired) {
                document.getElementById('loginSection').style.display = 'none';
                document.getElementById('twoFactorSection').style.display = 'block';
            } else {
                window.location.href = 'dashboard.html'; // Redirect to dashboard
            }
        } else {
            document.getElementById('loginMessage').textContent = response.message;
        }
    };
    xhr.send('username=' + encodeURIComponent(username) + '&password=' + encodeURIComponent(password));
});

document.getElementById('verify2FA').addEventListener('click', function() {
    var twoFactorCode = document.getElementById('twoFactorCode').value;

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'php/verify_2fa.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        var response = JSON.parse(xhr.responseText);
        if (response.success) {
            window.location.href = 'dashboard.html'; // Redirect to dashboard
        } else {
            document.getElementById('twoFactorMessage').textContent = response.message;
        }
    };
    xhr.send('twoFactorCode=' + encodeURIComponent(twoFactorCode));
});
