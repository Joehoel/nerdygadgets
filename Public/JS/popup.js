function popup(text, isError) {
    window.addEventListener("load", () => {
        const pop_up = document.getElementById("pop-up");
        pop_up.innerHTML = text;
        if (isError) {
            pop_up.classList = "pop-up pop-up-show error";
        } else {
            pop_up.classList = "pop-up pop-up-show";
        }
        setTimeout(() => {
            if (isError) {
                pop_up.classList = "pop-up pop-up-hidden error";
            } else {
                pop_up.classList = "pop-up pop-up-hidden";
            }
            setTimeout(() => {
                pop_up.classList = "pop-up";
            }, 200);
        }, 4000);
    })
}
