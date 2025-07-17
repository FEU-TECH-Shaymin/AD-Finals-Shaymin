document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("sign-up-form");

    form.addEventListener("submit", function (e) {
        let isValid = true;

        // Helper to mark a field invalid
        function invalidate(input, message) {
            input.classList.add("is-invalid");
            input.nextElementSibling.textContent = message;
            isValid = false;
        }

        // Clear previous invalid states
        const inputs = form.querySelectorAll("input");
        inputs.forEach(input => {
            input.classList.remove("is-invalid");
        });

        // Validate username
        const username = document.getElementById("username");
        if (username.value.trim().length < 3) {
            invalidate(username, "Username must be at least 3 characters.");
        }

        // Validate password
        const password = document.getElementById("password");
        if (password.value.length < 8) {
            invalidate(password, "Password must be at least 8 characters.");
        }

        // Validate names (only letters)
        const nameFields = ["first_name", "middle_name", "last_name"];
        nameFields.forEach(id => {
            const input = document.getElementById(id);

            // Validate only letters and spaces
            if (!/^[a-zA-Z\s]+$/.test(input.value.trim())) {
                invalidate(input, "Name must contain only letters.");
            } else {
                // Auto-capitalize first letter of each word
                input.value = value.replace(/\b\w/g, c => c.toUpperCase());
            }
        });

        // If form is invalid, prevent submission
        if (!isValid) {
            e.preventDefault();
        }
    });
});
