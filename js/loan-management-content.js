document.addEventListener('DOMContentLoaded', function () {
    const accountManagementContent = document.getElementById('loan-management-content');

    // Function to handle form submissions
    function handleFormSubmission(formId, phpFile, messageDivId) {
        accountManagementContent.addEventListener('submit', function (e) {
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
                        const response = JSON.parse(xhr.responseText);
                        document.getElementById(messageDivId).innerHTML = response.message;
                    } else {
                        document.getElementById(messageDivId).innerHTML = 'Error: ' + xhr.status;
                    }
                };

                xhr.send(formData);
            }
        });
    }

    // Add event listeners for each form
    handleFormSubmission('loan-application-form', 'php/loanApplication.php', 'loan_application_msg');
    handleFormSubmission('loan-status-form', 'php/getLoanStatus.php', 'loan_status_msg');
    handleFormSubmission('loan-repayment-form', 'php/repayLoan.php', 'loan_repayment_msg');

    // Additional logic if necessary...
});
