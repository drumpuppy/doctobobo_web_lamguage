$(document).ready(function() {
    document.querySelector('form').addEventListener('submit', function(event) {
        event.preventDefault();

        const email = document.getElementById('email').value;
        const password = document.getElementById('pwd').value;
        const userType = document.querySelector('input[name="titre"]:checked').value;

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'phpDatabase/login.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    console.log('Response:', xhr.responseText);
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        localStorage.setItem('user_type', userType);
                        window.location.href = 'my_space.html';
                    } else {
                        document.getElementById('error-message').style.display = 'block';
                    }
                }
            }
        };

        const data = 'email=' + encodeURIComponent(email) + '&pwd=' + encodeURIComponent(password) + '&titre=' + encodeURIComponent(userType);
        console.log('Data:', data);
        xhr.send(data);
    });
});
