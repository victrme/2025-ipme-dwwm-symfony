
window.addEventListener('load', () => {
    const divAlert: HTMLDivElement = document.querySelector('[role="alert"]');
    if (divAlert) {
       setTimeout(() => {
           divAlert.remove();
       }, 5000);
    }
});
