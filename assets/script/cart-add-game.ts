function initAddGameButton(): void {
    const buttonAdd: HTMLButtonElement = document.querySelector('[data-add-to-cart]');
    if (buttonAdd) {
        buttonAdd.addEventListener('click', () => {
            const url: string = buttonAdd.getAttribute('data-add-to-cart');
            fetch(url)
                .then((response: Response)=> {
                    if (response.ok) return response.json();
                })
                .then((data) => {
                    console.log("All good muh frend");
                });
        });
        buttonAdd.removeAttribute('data-add-to-cart');
    }
}

window.addEventListener('load', () => {
    initAddGameButton();
});
