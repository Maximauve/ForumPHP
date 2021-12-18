const check = function() {
    const confpassword = document.getElementById('confirmpassword')
    const message = document.getElementById('message')
    const password = document.getElementById('password')
    const confirmbtn = document.getElementById('confirmbtn')
    if (password.value ==
        confpassword.value) {
        message.style.color = 'green';
        message.innerHTML = 'Les mots de passe correspondent !';
        confirmbtn.disabled = false;
        confirmbtn.innerHTML = "Connexion"
    } else {
        message.style.color = 'red';
        message.innerHTML = 'Les mots de passe ne correspondent pas !';
        confirmbtn.disabled = true;
        confirmbtn.innerHTML = "❌"
    }
}