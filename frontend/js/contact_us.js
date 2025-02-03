
   
const form = document.getElementById("validation-form");
const nameInput = document.getElementById("name");
const emailInput = document.getElementById("email");

const nameError = document.getElementById("name-error");
const emailError = document.getElementById("email-error");


form.addEventListener("submit", function (event) {
    let isValid = true;

    if (nameInput.value.trim() === "") {
        nameInput.classList.add("invalid");
        nameError.classList.add("visible");
        isValid = false;
    } else {
        nameInput.classList.remove("invalid");
        nameError.classList.remove("visible");
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(emailInput.value)) {
        emailInput.classList.add("invalid");
        emailError.classList.add("visible");
        isValid = false;
    } else {
        emailInput.classList.remove("invalid");
        emailError.classList.remove("visible");
    }


    if (!isValid) {
        event.preventDefault();
    }
});

// Clear validation classes when inputs are focused
const inputs = [nameInput, emailInput, passwordInput, confirmPasswordInput];
inputs.forEach(input => {
    input.addEventListener("focus", function () {
        this.classList.remove("invalid");
    });
});