document.getElementById('accountForm').addEventListener('submit', function(e) {
    e.preventDefault();

    let formData = new FormData(this);

    fetch('php/create_account.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById('result').innerHTML = data;
        this.reset();
    })
    .catch(error => console.error('Error:', error));
});
