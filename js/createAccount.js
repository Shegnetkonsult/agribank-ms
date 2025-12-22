document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('account-management-content').addEventListener('submit', function(event) {
        // Prevent the form from submitting the default way
        event.preventDefault();

        // Get the form data
        const formData = new FormData(document.getElementById('account-form'));

        // Create an AJAX request
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'php/createAccount.php', true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                // Handle the response from the PHP script
                document.getElementById('account_creation_msg').innerHTML = xhr.responseText;
            } else {
                // Handle errors here
                document.getElementById('account_creation_msg').innerHTML = '<div class="alert alert-danger">An error occurred while creating the account.</div>';
            }
        };

        // Send the form data
        xhr.send(formData);
    });
});
