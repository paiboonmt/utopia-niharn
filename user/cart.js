var paymentMethodSelect = document.getElementById("paymentMethodSelect");
var paymentDetailsInput3 = document.getElementById("paymentDetails3");
var paymentDetailsInput7 = document.getElementById("paymentDetails7");

paymentMethodSelect.addEventListener("change", function() {

if (paymentMethodSelect.value === "Cash" || paymentMethodSelect.value === "QrCode" ) {
    paymentDetailsInput7.value = "7" ,paymentDetailsInput3.value = "0"; 
} else if (paymentMethodSelect.value === "CreditCard") {
    paymentDetailsInput3.value = "3" , paymentDetailsInput7.value = "0";
} else {
    paymentDetailsInput7.value = "0";
    paymentDetailsInput3.value = "0";
}

});