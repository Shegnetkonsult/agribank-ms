function showCreateFarmerProfile() {
    const content = `
        <h4>Enter Farm Details</h4>
            <form id="farm-form">
                <!-- form fields for personal and farm-related information -->
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

function showOpenAccount() {
    const content = `
        <h4>Open Savings/Current Account</h4>
            <form id="account-form">
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
                <div id='account_creation_msg'></div>
            </form>
    `;
    document.getElementById('account-management-content').innerHTML = content;
}

function showAccountBalances() {
    const content = `
        <h4>Account Balances</h4>
        <form id = "account-balance-form">
            <!-- form fields for updating account information -->
            <button type="submit" class="btn btn-success">Get Balances</button>
            <div id='account_balance_msg'></div>
        </form>
    `;
    document.getElementById('account-management-content').innerHTML = content;
}

function showApplyForLoan() {
    const content = `
        <h4>Apply for Loan</h4>
        <form id="loan-application-form">
            <!-- form fields for applying for a loan -->
            <div class="form-group">
                <label for="loanAmount">Loan Amount:</label>
                <input type="number" class="form-control" id="loanAmount" name="loanAmount" required>
            </div>
            <div class="form-group">
                <label for="loanType">Loan Type:</label>
                <select class="form-control" id="loanType" name="loanType" required>
                    <option value="Farm Startup">Farm Startup</option>
                    <option value="Expansion">Expansion</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Apply</button>
            <div id='loan_application_msg'></div>
        </form>
    `;
    document.getElementById('loan-management-content').innerHTML = content;
}

function showLoanStatus() {
    const content = `
        <h4>Loan Status</h4>
        <!-- form or table for loans Statuses-->
        <form id = "loan-status-form">
            <!-- form fields for updating account information -->
            <button type="submit" class="btn btn-success">Get Loan Status</button>
            <div id='loan_status_msg'></div>
        </form>
    `;
    document.getElementById('loan-management-content').innerHTML = content;
}

function showLoanRepayment() {
    const content = `
        <h4>Loan Repayment</h4>
        <form id="loan-repayment-form">
            <!-- form fields for applying for a loan -->
            <div class="form-group">
                <label for="loanAmount">Loan Amount:</label>
                <input type="number" class="form-control" id="loanAmount" name="loanAmount" required>
            </div>
            <button type="submit" class="btn btn-success">Apply</button>
            <div id='loan_repayment_msg'></div>
        </form>
    `;
    document.getElementById('loan-management-content').innerHTML = content;
}

/*
function showApplyForInsurance() {
    const content = `
        <h4>Apply for Crop Insurance</h4>
        NOT AVAILABLE RIGHT NOW AS ATM FUNCTIONALITY CANT BE INCORPORATED YET
    `;
    document.getElementById('crop-insurance-content').innerHTML = content;
}
    const content = `
        <h4>Apply for Crop Insurance</h4>
        NOT AVAILABLE RIGHT NOW AS ATM FUNCTIONALITY CANT BE INCORPORATED YET
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
        NOT AVAILABLE RIGHT NOW AS ATM FUNCTIONALITY CANT BE INCORPORATED. PLEASE VISIT ANY OF OUR BRANCH
    `;
    document.getElementById('transaction-management-content').innerHTML = content;
}

function showWithdrawal() {
    const content = `
        <h4>Withdrawal</h4>
        NOT AVAILABLE RIGHT NOW AS ATM FUNCTIONALITY CANT BE INCORPORATED. PLEASE VISIT ANY OF OUR BRANCH
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
            <div class="form-group">
                <label for="beneficiaryAccount">Beneficiary Account:</label>
                <input type="text" class="form-control" id="beneficiaryAccount" name="beneficiaryAccount" required>
            </div>
            <!-- more fields as needed -->
            <button type="submit" class="btn btn-success">Transfer</button>
            <div id='transfer_msg'></div>
        </form>
    `;
    document.getElementById('transaction-management-content').innerHTML = content;
}

function showAccountStatement() {
    const content = `
        <h4>Account Statement</h4>
        <!-- form or table for account statement -->
        <form id = "account-statement-form">
            <!-- form fields for updating account information -->
            <button type="submit" class="btn btn-success">Get Account Statement</button>
            <div id='account_statement_msg'></div>
        </form>
    `;
    document.getElementById('reporting-management-content').innerHTML = content;
}

function showLoanRepaymentSchedule() {
    const content = `
        <h4>Loan Repayment Schedule</h4>
        <!-- form or table for loan repayment schedule -->
        <form id = "loan-repayment-form">
            <!-- form fields for updating account information -->
            <button type="submit" class="btn btn-success">Get Loan Repayment Schedule</button>
            <div id='loan_repayment_msg'></div>
        </form>
    `;
    document.getElementById('reporting-management-content').innerHTML = content;
}

