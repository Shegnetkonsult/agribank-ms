function showCreateFarmerProfile() {
    const content = `
        <h4>Create Farmer Profile</h4>
        <form>
            <!-- form fields for personal and farm-related information -->
            <div class="form-group">
                <label for="farmerName">Name:</label>
                <input type="text" class="form-control" id="farmerName" required>
            </div>
            <div class="form-group">
                <label for="farmLocation">Farm Location:</label>
                <input type="text" class="form-control" id="farmLocation" required>
            </div>
            <!-- more fields as needed -->
            <button type="submit" class="btn btn-success">Create Profile</button>
        </form>
    `;
    document.getElementById('account-management-content').innerHTML = content;
}

function showOpenAccount() {
    const content = `
        <h4>Open Savings/Current Account</h4>
        <form>
            <!-- form fields for opening account -->
            <div class="form-group">
                <label for="initialDeposit">Initial Deposit:</label>
                <input type="number" class="form-control" id="initialDeposit" required>
            </div>
            <div class="form-group">
                <label for="accountType">Account Type:</label>
                <select class="form-control" id="accountType" required>
                    <option value="Savings">Savings</option>
                    <option value="Current">Current</option>
                </select>
            </div>
            <!-- more fields as needed -->
            <button type="submit" class="btn btn-success">Open Account</button>
        </form>
    `;
    document.getElementById('account-management-content').innerHTML = content;
}

function showUpdateAccount() {
    const content = `
        <h4>Update Account Information</h4>
        <form>
            <!-- form fields for updating account information -->
            <div class="form-group">
                <label for="updateName">Name:</label>
                <input type="text" class="form-control" id="updateName" required>
            </div>
            <div class="form-group">
                <label for="updateLocation">Farm Location:</label>
                <input type="text" class="form-control" id="updateLocation" required>
            </div>
            <!-- more fields as needed -->
            <button type="submit" class="btn btn-success">Update Information</button>
        </form>
    `;
    document.getElementById('account-management-content').innerHTML = content;
}

function showApplyForLoan() {
    const content = `
        <h4>Apply for Loan</h4>
        <form>
            <!-- form fields for applying for a loan -->
            <div class="form-group">
                <label for="loanAmount">Loan Amount:</label>
                <input type="number" class="form-control" id="loanAmount" required>
            </div>
            <div class="form-group">
                <label for="loanType">Loan Type:</label>
                <select class="form-control" id="loanType" required>
                    <option value="Farm Startup">Farm Startup</option>
                    <option value="Expansion">Expansion</option>
                </select>
            </div>
            <!-- more fields as needed -->
            <button type="submit" class="btn btn-success">Apply</button>
        </form>
    `;
    document.getElementById('loan-management-content').innerHTML = content;
}

function showApproveRejectLoan() {
    const content = `
        <h4>Approve/Reject Loan</h4>
        <!-- form or table for approving/rejecting loans -->
        <p>Loan approval/rejection functionality here.</p>
    `;
    document.getElementById('loan-management-content').innerHTML = content;
}

function showDisburseLoan() {
    const content = `
        <h4>Disburse Loan</h4>
        <!-- form or table for disbursing loans -->
        <p>Loan disbursement functionality here.</p>
    `;
    document.getElementById('loan-management-content').innerHTML = content;
}

function showRepaymentSchedule() {
    const content = `
        <h4>Repayment Schedule</h4>
        <!-- form or table for repayment schedule -->
        <p>Repayment schedule functionality here.</p>
    `;
    document.getElementById('loan-management-content').innerHTML = content;
}

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

function showDeposit() {
    const content = `
        <h4>Deposit</h4>
        <form>
            <!-- form fields for deposit -->
            <div class="form-group">
                <label for="depositAmount">Deposit Amount:</label>
                <input type="number" class="form-control" id="depositAmount" required>
            </div>
            <!-- more fields as needed -->
            <button type="submit" class="btn btn-success">Deposit</button>
        </form>
    `;
    document.getElementById('transaction-management-content').innerHTML = content;
}

function showWithdrawal() {
    const content = `
        <h4>Withdrawal</h4>
        <form>
            <!-- form fields for withdrawal -->
            <div class="form-group">
                <label for="withdrawalAmount">Withdrawal Amount:</label>
                <input type="number" class="form-control" id="withdrawalAmount" required>
            </div>
            <!-- more fields as needed -->
            <button type="submit" class="btn btn-success">Withdraw</button>
        </form>
    `;
    document.getElementById('transaction-management-content').innerHTML = content;
}

function showTransfer() {
    const content = `
        <h4>Transfer</h4>
        <form>
            <!-- form fields for transfer -->
            <div class="form-group">
                <label for="transferAmount">Transfer Amount:</label>
                <input type="number" class="form-control" id="transferAmount" required>
            </div>
            <div class="form-group">
                <label for="beneficiaryAccount">Beneficiary Account:</label>
                <input type="text" class="form-control" id="beneficiaryAccount" required>
            </div>
            <!-- more fields as needed -->
            <button type="submit" class="btn btn-success">Transfer</button>
        </form>
    `;
    document.getElementById('transaction-management-content').innerHTML = content;
}

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
