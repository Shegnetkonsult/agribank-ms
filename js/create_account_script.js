document.getElementById('accountForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const form = document.getElementById('accountForm');
    const passportInput = document.getElementById('passport');
    const messageDiv = document.getElementById('message');
    const file = passportInput.files[0];

    // Reset messageDiv content
    messageDiv.style.display = 'none';
    messageDiv.className = '';

    if (file) {
        const maxSize = 100 * 1024; // 100KB
        const img = new Image();
        const objectUrl = URL.createObjectURL(file);

        img.onload = function () {
            URL.revokeObjectURL(objectUrl);

            if (file.size > maxSize) {
                showMessage('File size must be less than 100KB.', 'error');
                return;
            }

            if (this.width > 150 || this.height > 150) {
                showMessage('Image dimensions must be 150x150 pixels or smaller.', 'error');
                return;
            }

            // If validation passes, submit the form via AJAX
            submitForm(form);
        };

        img.src = objectUrl;
    } else {
        // Submit the form if no file upload is required
        submitForm(form);
    }
});

function submitForm(form) {
    const formData = new FormData(form);
    fetch('php/create_account.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        showMessage(data, 'success');
    })
    .catch(error => {
        console.error('Error:', error);
        showMessage('An error occurred while creating the account.', 'error');
    });
}

function showMessage(message, type) {
    const messageDiv = document.getElementById('message');
    messageDiv.innerHTML = message;
    messageDiv.className = 'message ' + type;
    messageDiv.style.display = 'block';
}
