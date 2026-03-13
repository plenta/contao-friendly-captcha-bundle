document.addEventListener('DOMContentLoaded', async () => {
    const widget = document.querySelector('.frc-captcha');

    if (!widget) {
        return;
    }

    const version = widget.dataset.fcVersion;

    if (version === 'v2') {
        const { FriendlyCaptchaSDK } = await import('@friendlycaptcha/sdk');
        const sdk = new FriendlyCaptchaSDK();
        sdk.attach();
    } else {
        import('friendly-challenge/widget');
    }
});
