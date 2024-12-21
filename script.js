$(document).ready(function () {
    // Generate and display Captcha
    const generateCaptcha = () => {
        const captcha = Math.random().toString(36).substr(2, 5).toUpperCase();
        $('#captcha-image').text(captcha);
        return captcha;
    };

    let currentCaptcha = generateCaptcha();

    // Form submission handler
    $('#registrationForm').on('submit', function (e) {
        e.preventDefault();

        const userCaptcha = $('#captcha').val().toUpperCase();
        if (userCaptcha !== currentCaptcha) {
            alert("Invalid Captcha. Please try again.");
            currentCaptcha = generateCaptcha();
            return;
        }

        $.ajax({
            url: 'submit.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                $('#result').text(response);
                $('#registrationForm')[0].reset();
                currentCaptcha = generateCaptcha();
            },
        });
    });
});
