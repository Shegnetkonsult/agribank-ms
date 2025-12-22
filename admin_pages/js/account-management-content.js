document.addEventListener('DOMContentLoaded', function () {
    // Attach event listener after forms are dynamically inserted

    const accountManagementContent = document.getElementById('account-management-content');

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
    handleFormSubmission('user-profile-form', 'php/createUserProfile.php', 'user_profile_msg');
    handleFormSubmission('farm-profile-form', 'php/createFarmProfile.php', 'farm_profile_msg');
    handleFormSubmission('account-profile-form', 'php/createAccount.php', 'account_profile_msg');
    handleFormSubmission('set-user-profile-form', 'php/setProfile.php', 'set_profile_msg');
    handleFormSubmission('set-search_accounts-form', 'php/searchAccounts.php', 'set_search_account_msg');

    // Additional logic if necessary...
});
