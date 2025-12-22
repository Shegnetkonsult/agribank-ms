$(document).ready(function() {
    // Other code...

    function fetchLoanApplications() {
        $.ajax({
            url: 'php/fetch_loans.php',
            method: 'GET',
            success: function(data) {
                $('#loan-applications').html(data);
            }
        });
    }

    function updateLoanStatus(loanId, status) {
        $.ajax({
            url: 'php/update_loan_status.php',
            method: 'POST',
            data: { loanId: loanId, status: status },
            success: function(response) {
                alert(response);
                fetchLoanApplications();
            }
        });
    }

    // Event delegation for dynamically added buttons
    $(document).on('click', '.btn-approve', function() {
        const loanId = $(this).data('loan-id');
        updateLoanStatus(loanId, 'Approved');
    });

    $(document).on('click', '.btn-reject', function() {
        const loanId = $(this).data('loan-id');
        updateLoanStatus(loanId, 'Rejected');
    });

    // Load loan applications when the Loans tab is clicked
    $('#loans-tab').on('click', function() {
        fetchLoanApplications();
    });
});
