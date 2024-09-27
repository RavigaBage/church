document.addEventListener('DOMContentLoaded', async () => {
    try {
        const response = await fetch('http://localhost:3000/api/csrf-token', {
            method: 'GET',
            credentials: 'include',
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();
        document.getElementById('csrfTokenInput').value = data.csrfToken;
    } catch (error) {
        console.error('Error fetching CSRF token:', error);
    }
});
document.getElementById('loginForm').addEventListener('submit', async function (e) {
    e.preventDefault();

    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const csrfToken = document.getElementById('csrfTokenInput').value;

    if (!validateEmail(email)) {
        console.error('Invalid email format');
        return;
    }

    const dataToSend = {
        email: email,
        password: password,
    };

    try {
        const request = await fetch("http://localhost:3000/api/login", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-XSRF-TOKEN": csrfToken
            },
            credentials: 'include', // Ensure cookies are sent
            body: JSON.stringify(dataToSend),
        });

        if (request.status === 200) {
            const data = await request.json();
            console.log(data);
            if (data === 'success') {
                console.log('Entry was a success');
            }
        } else {
            console.log('Login request failed:', request.status);
        }
    } catch (error) {
        console.error('Error during login request:', error);
    }
});

function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}
