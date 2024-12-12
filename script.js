// Check login status
function isLoggedIn() {
    return sessionStorage.getItem('loggedIn') === 'true';
}

// Redirect to login page if not logged in
function protectPage() {
    if (!isLoggedIn()) {
        alert('You must log in to access this page.');
        window.location.href = 'login.html';
    }
}

// Set login status
function loginUser() {
    sessionStorage.setItem('loggedIn', 'true');
}

// Log out
function logoutUser() {
    sessionStorage.removeItem('loggedIn');
}
