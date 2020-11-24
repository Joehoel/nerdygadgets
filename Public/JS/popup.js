function popup(text) {
    window.addEventListener("load", () => {
        const pop_up = document.getElementById("pop-up");
        pop_up.innerText = text;
        pop_up.classList = "pop-up pop-up-show";
        setTimeout(() => {
            pop_up.classList = "pop-up pop-up-hidden";
            setTimeout(() => {
                pop_up.classList = "pop-up";
            }, 200);
        }, 3000);
    })

}
