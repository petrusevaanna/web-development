const emailInput = document.getElementById('email');
const passwordInput = document.getElementById('password');
const loginButton = document.getElementById('loginButton');
const emailInfo = document.getElementById('email-info');
const passwordInfo = document.getElementById('password-info');

loginButton.addEventListener('click', (event) => {
    event.preventDefault();

    const email = emailInput.value.trim();
    const password = passwordInput.value.trim();

    let isValid = true;

    if (!isValidEmail(email)) {
        setFieldError(emailInput, emailInfo, 'Неверный формат email');
        isValid = false;
    } else {
        clearFieldError(emailInput, emailInfo);
    }

    if (password.length < 6) {
        setFieldError(passwordInput, passwordInfo, 'Пароль должен быть не менее 6 символов');
        isValid = false;
    } else {
        clearFieldError(passwordInput, passwordInfo);
    }

    if (isValid) {
        alert('Логин успешен!');
    }
});

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function setFieldError(inputElement, infoElement, message) {
    inputElement.classList.add('error');
    infoElement.classList.add('error');
    infoElement.textContent = message;
}

function clearFieldError(inputElement, infoElement) {
    inputElement.classList.remove('error');
    infoElement.classList.remove('error');
    infoElement.textContent = ''; 
}
