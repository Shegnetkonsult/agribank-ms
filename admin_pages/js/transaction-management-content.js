document.addEventListener('DOMContentLoaded', function () {
    // Attach event listener after forms are dynamically inserted

    const transactionManagementContent = document.getElementById('transaction-management-content');

    // Function to handle form submissions
    function handleFormSubmission(formId, phpFile, messageDivId) {
        transactionManagementContent.addEventListener('submit', function (e) {
            if (e.target && e.target.id === formId) {
                e.preventDefault();  // Prevent form from submitting the traditional way

                const form = document.getElementById(formId);
                if (!form) {
                    console.error(`${formId} not found`);
                    return;
                }

                const formData = new FormData(form);
                const xhr = new XMLHttpRequest();

                xhr.open('POST', phpFile, true);

                xhr.onload = function () {
                    if (xhr.status === 200) {
                        document.getElementById(messageDivId).innerHTML = xhr.responseText;
                    } else {
                        document.getElementById(messageDivId).innerHTML = 'Error: ' + xhr.status;
                    }
                };

                xhr.send(formData);
            }
        });
    }

    // Add event listeners for each form
    handleFormSubmission('deposit-form', 'php/recordDeposit.php', 'deposit_msg');
    handleFormSubmission('withdrawal-form', 'php/recordWithdrawal.php', 'withdrawal_msg');
    handleFormSubmission('transfer-form', 'php/recordTransfer.php', 'transfer_msg');
    handleFormSubmission('set-user-profile-form', 'php/setProfiles.php', 'set_profiles_msg');

    // Additional logic if necessary...
});
