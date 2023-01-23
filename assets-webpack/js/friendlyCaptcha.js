document.addEventListener('DOMContentLoaded', function (event) {
    if (document.querySelector('.frc-captcha')) {
        import('friendly-challenge/widget');
    }
})