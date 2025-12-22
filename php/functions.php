<?php
function formatAsNaira($amount) {
    // Format the amount with 2 decimal places and comma as thousand separator
    $formattedAmount = number_format($amount, 2, '.', ',');

    // Prepend the Naira symbol
    return '₦' . $formattedAmount;
}

// Example usage
//$amount = 1234567.89;
//echo formatAsNaira($amount);  // Output: ₦1,234,567.89

?>
