function App() {
    /* Logic */

    if(document.getElementById("js-navbar-menu")) {
        Menu();
    }
}

function Menu() {
    const open_menu = document.getElementById("js-open-menu");
    const close_menu = document.getElementById("js-close-menu");
    const sidebar_menu = document.querySelector(".nav-menu");

    open_menu.addEventListener("click", () => {
        sidebar_menu.classList.toggle("active");
    });

    close_menu.addEventListener("click", () => {
        sidebar_menu.classList.remove("active");
    });
}

App();

