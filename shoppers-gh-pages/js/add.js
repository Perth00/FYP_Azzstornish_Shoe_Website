    document.addEventListener("DOMContentLoaded", function () {
        const showLoginButton = document.getElementById("show-login");
        const loginOverlay = document.getElementById("login-overlay");
        const closeLoginButton = document.getElementById("close-login");

        showLoginButton.addEventListener("click", function () {
            loginOverlay.style.display = "flex"; // Show the overlay
        });

        // Close the overlay when clicking the close button (X)
        closeLoginButton.addEventListener("click", function () {
            loginOverlay.style.display = "none"; // Hide the overlay
        });

        // Close the overlay when clicking outside of it
        loginOverlay.addEventListener("click", function (e) {
            if (e.target === loginOverlay) {
                loginOverlay.style.display = "none"; // Hide the overlay
            }
        });
    });
