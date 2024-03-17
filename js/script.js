const emailInput = document.getElementById("email");

emailInput.addEventListener("focus", () => {
    emailInput.style.border = "2px solid #007bff";
});

emailInput.addEventListener("blur", () => {
    emailInput.style.border = "1px solid #ccc";
});