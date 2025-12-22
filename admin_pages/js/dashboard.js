function showUserProfile() {
    const content = `
        <h4>User Profile</h4>
            <form id="user-profile-form" enctype="multipart/form-data">
                <!-- User Info Fields -->
                <div class="form-group">
                    <label for="bvn">Assign UserName:</label>
                    <input type="text" class="form-control" id  ="Username" name="Username" required>
                </div>
                <div class="form-group">
                    <label for="bvn">Customer FullName:</label>
                    <input type="text" class="form-control" id="FullName" name="FullName" required>
                </div>
                <div class="form-group">
                    <label for="bvn">Customer Email:</label>
                    <input type="text" class="form-control" id="Email" name="Email" required>
                </div>
                <div class="form-group">
                    <label for="bvn">Customer Phone Number:</label>
                    <input type="text" class="form-control" id="PhoneNumber" name="PhoneNumber" required>
                </div>
                <div class="form-group">
                    <label for="bvn">National ID Number:</label>
                    <input type="text" class="form-control" id="NationalID" name="NationalID" required>
                </div>
                <div class="form-group">
                    <label for="bvn">Passport:</label>
                    <input type="file" class="form-control" id="Passport" name="Passport" required>
                </div>
                <div class="form-group">
                    <label for="bvn">Address:</label>
                    <input type="text" class="form-control" id="Address" name="Address" required>
                </div>
                <div class="form-group">
                    <label for="bvn">Password:</label>
                    <input type="text" class="form-control" id="Password" name="Password" required>
                </div>
                <button type="submit" class="btn btn-success">Create User</button>
                <div id='user_profile_msg'></div>
            </form>
    `;
    document.getElementById('account-management-content').innerHTML = content;
}

function showAccountProfile() {
    const content = `
        <h4>Account Profile</h4>
            <form id="account-profile-form">
                <div class="form-group">
                    <label for="bvn">Customer Username:</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="bvn">Bank Verification Number:</label>
                    <input type="number" class="form-control" id="bvn" name="bvn" required>
                </div>
                <div class="form-group">
                    <label for="accountType">Account Type:</label>
                    <select class="form-control" id="accountType" name="accountType" required>
                        <option value="Savings">Savings</option>
                        <option value="Current">Current</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Create Account</button>
                <div id='account_profile_msg'></div>
            </form>
    `;
    document.getElementById('account-management-content').innerHTML = content;
}

function showFarmProfile() {
    const content = `
        <h4>Farm Profile</h4>
            <form id="farm-profile-form">
                <div class="form-group">
                    <label for="bvn">Customer Username:</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="farmSize">Farm Size/Dimension (in Acres):</label>
                    <input type="text" class="form-control" id="farmSize" name="farmSize" required>
                </div>
                <div class="form-group">
                    <label for="farmLocation">Farm Location in Details:</label>
                    <input type="text" class="form-control" id="farmLocation" name="farmLocation" required>
                </div>
                <div class="form-group">
                    <label for="farmType">Farm Type (crop/livestock/mixed):</label>
                    <select class="form-control" id="farmType" name="farmType" required>
                        <option value="Crop">Crop</option>
                        <option value="Livestock">Livestock</option>
                        <option value="Mixed">Mixed</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="cropLists">Lists Crops you farm:</label>
                    <input type="text" class="form-control" id="cropLists" name="cropLists" required>
                </div>
                <div class="form-group">
                    <label for="livestockLists">Lists livestock you raise:</label>
                    <input type="text" class="form-control" id="livestockLists" name="livestockLists" required>
                </div>
                <button type="submit" class="btn btn-success">Enter Details</button>
                <div id='farm_profile_msg'></div>
        </form>
    `;
    document.getElementById('account-management-content').innerHTML = content;
}

function showSetUserProfile() {
    const content = `
        <h4>Set User Profile</h4>
        <form id = "set-user-profile-form">
            <!-- form fields for updating account information -->
            <div class="form-group">
                <label for="bvn">Owner's Account Number:</label>
                <input type="number" class="form-control" id="account_number_1" name="account_number_1" required>
            </div>
            <button type="submit" class="btn btn-success">Set User</button>
            <div id='set_profile_msg'></div>
        </form>
    `;
    document.getElementById('account-management-content').innerHTML = content;
}

function showSearchAccountRecords() {
    const content = `
        <h4>Search Accounts</h4>
        <form id = "set-search_accounts-form">
            <div class="form-group">
                <label for="searchCriteria">Search by:</label>
                <select id="searchCriteria" name="searchCriteria">
                    <option value="username">Username</option>
                    <option value="account_number">Account Number</option>
                    <option value="email">Email</option>
                    <option value="phone">Phone Number</option>
                </select>
            </div>
            <div class="form-group">
                <input type="text" id="searchInput" name="searchInput" required>
            </div>
            <button type="submit" class="btn btn-success">Search</button>
            <div id='set_search_account_msg'></div>
        </form>
    `;
    document.getElementById('account-management-content').innerHTML = content;
}

// Function to show loan status and approve/reject loans
function showLoanStatus() {
    const content = `
        <h4>Loan Status</h4>
        <div id="loan-status-table">
            <!-- Table to display loan applications -->
        </div>
    `;
    document.getElementById('loan-management-content').innerHTML = content;
    loadLoanStatus();
}

function loadLoanStatus() {
    $.ajax({
        url: 'php/get_loan_status.php',
        type: 'GET',
        success: function(data) {
            $('#loan-status-table').html(data);
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
}

function approveLoan(loanId) {
    $.ajax({
        url: 'php/approve_loan.php',
        type: 'POST',
        data: { loanId: loanId },
        success: function(response) {
            alert(response);
            loadLoanStatus();
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
}

function rejectLoan(loanId) {
    $.ajax({
        url: 'php/reject_loan.php',
        type: 'POST',
        data: { loanId: loanId },
        success: function(response) {
            alert(response);
            loadLoanStatus();
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
}

// Adding event listeners to approve and reject buttons
document.addEventListener('click', function(event) {
    if (event.target.classList.contains('approve-loan-btn')) {
        const loanId = event.target.dataset.loanId;
        approveLoan(loanId);
    } else if (event.target.classList.contains('reject-loan-btn')) {
        const loanId = event.target.dataset.loanId;
        rejectLoan(loanId);
    }
});

function showDisburseLoan() {
    const content = `
        <h4>Disburse Loan</h4>
        <div id="loan-disbursement-table">
            <!-- Table to display Approved loans that have not been disbursed applications -->
        </div>
    `;
    document.getElementById('loan-management-content').innerHTML = content;
    loadLoandisburseStatus();
}

function loadLoandisburseStatus() {
    $.ajax({
        url: 'php/get_loan_disburse_status.php',
        type: 'GET',
        success: function(data) {
            $('#loan-disbursement-table').html(data);
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
}

function disburseLoan(loanId) {
    $.ajax({
        url: 'php/disburse_loan.php',
        type: 'POST',
        data: { loanId: loanId },
        success: function(response) {
            alert(response);
            loadLoanStatus();
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
}

// Adding event listeners to approve and reject buttons
document.addEventListener('click', function(event) {
    if (event.target.classList.contains('disburse-loan-btn')) {
        const loanId = event.target.dataset.loanId;
        disburseLoan(loanId);
    }
});

/*
function showApplyForInsurance() {
    const content = `
        <h4>Apply for Crop Insurance</h4>
        <form>
            <!-- form fields for applying for crop insurance -->
            <div class="form-group">
                <label for="insuranceType">Insurance Type:</label>
                <select class="form-control" id="insuranceType" required>
                    <option value="Flood">Flood</option>
                    <option value="Drought">Drought</option>
                </select>
            </div>
            <div class="form-group">
                <label for="coverageAmount">Coverage Amount:</label>
                <input type="number" class="form-control" id="coverageAmount" required>
            </div>
            <!-- more fields as needed -->
            <button type="submit" class="btn btn-success">Apply</button>
        </form>
    `;
    document.getElementById('crop-insurance-content').innerHTML = content;
}

function showApproveRejectInsurance() {
    const content = `
        <h4>Approve/Reject Insurance</h4>
        <!-- form or table for approving/rejecting insurance -->
        <p>Insurance approval/rejection functionality here.</p>
    `;
    document.getElementById('crop-insurance-content').innerHTML = content;
}

function showPayPremium() {
    const content = `
        <h4>Pay Premium</h4>
        <!-- form or table for paying premium -->
        <p>Premium payment functionality here.</p>
    `;
    document.getElementById('crop-insurance-content').innerHTML = content;
}

function showClaimSettlement() {
    const content = `
        <h4>Claim Settlement</h4>
        <!-- form or table for claim settlement -->
        <p>Claim settlement functionality here.</p>
    `;
    document.getElementById('crop-insurance-content').innerHTML = content;
}
*/
function showDeposit() {
    const content = `
        <h4>Deposit</h4>
        <form id="deposit-form">
            <!-- form fields for deposit -->
            <div class="form-group">
                <label for="depositAmount">Deposit Amount:</label>
                <input type="number" class="form-control" id="depositAmount" name="depositAmount" required>
            </div>
            <!-- more fields as needed -->
            <button type="submit" class="btn btn-success">Deposit</button>
            <div id='deposit_msg'></div>
        </form>
    `;
    document.getElementById('transaction-management-content').innerHTML = content;
}

function showWithdrawal() {
    const content = `
        <h4>Withdrawal</h4>
        <form id="withdrawal-form">
            <!-- form fields for withdrawal -->
            <div class="form-group">
                <label for="withdrawalAmount">Withdrawal Amount:</label>
                <input type="number" class="form-control" id="withdrawalAmount" name="withdrawalAmount" required>
            </div>
            <!-- more fields as needed -->
            <button type="submit" class="btn btn-success">Withdraw</button>
            <div id='withdrawal_msg'></div>
        </form>
    `;
    document.getElementById('transaction-management-content').innerHTML = content;
}

function showTransfer() {
    const content = `
        <h4>Transfer</h4>
        <form id="transfer-form">
            <!-- form fields for transfer -->
            <div class="form-group">
                <label for="transferAmount">Transfer Amount:</label>
                <input type="number" class="form-control" id="transferAmount" name="transferAmount" required>
            </div>
            <!-- more fields as needed -->
            <button type="submit" class="btn btn-success">Transfer</button>
            <div id='transfer_msg'></div>
        </form>
    `;
    document.getElementById('transaction-management-content').innerHTML = content;
}

function showSetUserProfiles() {
    const content = `
        <h4>Set User Profiles</h4>
        <form id = "set-user-profile-form">
            <!-- form fields for updating account information -->
            <div class="form-group">
                <label for="bvn">Owner's Account Number:</label>
                <input type="number" class="form-control" id="account_number_1" name="account_number_1" required>
            </div>
            <div class="form-group">
                <label for="bvn">Beneficiary's Account Number:</label>
                <input type="number" class="form-control" id="account_number_2" name="account_number_2">
            </div>
            <button type="submit" class="btn btn-success">Set User</button>
            <div id='set_profiles_msg'></div>
        </form>
    `;
    document.getElementById('transaction-management-content').innerHTML = content;
}
/*
function showAccountStatement() {
    const content = `
        <h4>Account Statement</h4>
        <!-- form or table for account statement -->
        <p>Account statement functionality here.</p>
    `;
    document.getElementById('reporting-content').innerHTML = content;
}

function showLoanRepaymentSchedule() {
    const content = `
        <h4>Loan Repayment Schedule</h4>
        <!-- form or table for loan repayment schedule -->
        <p>Loan repayment schedule functionality here.</p>
    `;
    document.getElementById('reporting-content').innerHTML = content;
}

function showCropInsuranceStatus() {
    const content = `
        <h4>Crop Insurance Status</h4>
        <!-- form or table for crop insurance status -->
        <p>Crop insurance status functionality here.</p>
    `;
    document.getElementById('reporting-content').innerHTML = content;
}
*/
