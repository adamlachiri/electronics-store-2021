export default class Functionalty {
    constructor() {
        this.nav_dropdown();
        this.dropdown();
        this.counter();
        this.loading_page();
        this.links();
        this.fade_out();
        this.format_int();
        this.success();
        this.error();
        this.close();
    }


    nav_dropdown() {
        // check
        if (!document.querySelector(".js-nav-dropdown-btn") ||
            !document.querySelector(".js-nav-dropdown-box")
        ) {
            return;
        }

        // html
        const btn = document.querySelector(".js-nav-dropdown-btn");
        const box = document.querySelector(".js-nav-dropdown-box");
        const navbar = document.getElementById("navbar");

        // set dropdown height
        box.style.height = "calc(100vh - " + navbar.clientHeight + "px)";

        // toggle dropdown
        btn.addEventListener("click", function () {
            // open box
            if (box.classList.contains("d-none")) {
                box.classList.remove("d-none");
                setTimeout(() => {
                    box.classList.remove("hide-top");
                    box.classList.remove("opacity-0");
                    btn.classList.remove("fa-bars");
                    btn.classList.add("fa-times");
                }, 100);
            }

            // close box
            else {
                close();
            }
        })

        // close itself
        box.addEventListener("click", close);

        // remove dropdown when resizing
        window.addEventListener("resize", close);

        // functions

        function close() {
            btn.classList.add("fa-bars");
            box.classList.add("hide-top");
            box.classList.add("opacity-0");
            btn.classList.remove("fa-times");
            setTimeout(() => {
                box.classList.add("d-none");
            }, 500);
        }
    }

    dropdown() {
        // check
        if (!document.querySelector(".js-dropdown-btn") ||
            !document.querySelector(".js-dropdown-box")
        ) {
            return;
        }

        // html
        const btns = document.querySelectorAll(".js-dropdown-btn");

        // loop
        for (let i = 0; i < btns.length; i++) {
            const btn = btns[i];
            const box = btn.querySelector(".js-dropdown-box");
            const icon = btn.querySelector("i");

            // exe
            btn.addEventListener("click", function () {
                // open box
                if (box.classList.contains("d-none")) {
                    box.classList.remove("d-none");
                    setTimeout(() => {
                        box.classList.remove("opacity-0");
                        icon.classList.remove("fa-angle-down");
                        icon.classList.add("fa-angle-up");
                    }, 100);
                }

                // close box
                else {
                    box.classList.add("opacity-0");
                    icon.classList.add("fa-angle-down");
                    icon.classList.remove("fa-angle-up");
                    setTimeout(() => {
                        box.classList.add("d-none");
                    }, 500);
                }
            })

            window.addEventListener("resize", function () {
                box.classList.add("opacity-0");
                icon.classList.add("fa-angle-down");
                icon.classList.remove("fa-angle-up");
                setTimeout(() => {
                    box.classList.add("d-none");
                }, 500);
            })
        }
    }

    loading_page() {
        // check
        if (!document.querySelector(".js-loading-page")
        ) {
            return;
        }

        // html
        const loading = document.querySelector(".js-loading-page");
        const delay = 300;

        // exe
        window.addEventListener("load", function () {
            loading.style.animation = delay + "ms fade_out linear forwards"
            setTimeout(() => {
                loading.classList.add("d-none");
            }, delay);
        })
    }

    counter() {
        // check
        if (!document.querySelector(".js-counter")
        ) {
            return;
        }

        // vars
        const speed = 10;

        // html
        const counters = document.querySelectorAll(".js-counter");

        // loop
        for (let i = 0; i < counters.length; i++) {
            const counter = counters[i];
            const limit = counter.dataset.limit;
            counter.innerHTML = "0";

            // exe
            exe();

            // exe function
            function exe() {
                let count = parseInt(counter.innerHTML);
                if (count < limit) {
                    setTimeout(() => {
                        count++;
                        counter.innerHTML = count;
                        exe();
                    }, speed)
                } else {
                    return;
                }
            }
        }
    }

    links() {
        // check
        if (!document.getElementsByClassName("js-link")) {
            return;
        }

        // html
        const links = document.getElementsByClassName("js-link");

        // vars
        const class_active = "text-main";

        // exe
        for (let i = 0; i < links.length; i++) {
            // html
            const link = links[i];

            // vars
            const url = window.location.href;
            const link_href = link.href;

            // exe
            if (url.includes(link_href)) {
                link.classList.add(class_active);
            }
            else {
                link.classList.remove(class_active);
            }
        }

    }

    fade_out() {
        // check
        if (!document.querySelector(".js-fade-out")) {
            return;
        }

        // html
        const items = document.querySelectorAll(".js-fade-out");

        // vars
        const delay = 2000;

        // loop
        for (let i = 0; i < items.length; i++) {
            // html
            const item = items[i];

            // exe
            setTimeout(() => {
                item.classList.add("a-fade-out");
                setTimeout(() => {
                    item.classList.add("d-none");
                }, 500);
            }, delay);
        }

    }

    format_int() {
        // check
        if (!document.getElementsByClassName("js-format-int")[0]) {
            return;
        }

        // html 
        const ints = document.getElementsByClassName("js-format-int");

        // loop
        for (let i = 0; i < ints.length; i++) {
            // html
            const int = ints[i];

            // var
            const value = parseInt(int.innerHTML);
            let result;

            // format
            if (value >= 1000000) {
                result = Math.floor(value / 1000000) + "M";
            }
            else if (value >= 10000) {
                result = Math.floor(value / 1000) + "K";
            }
            else {
                result = value;
            }

            // exe
            int.innerHTML = result;
        }
    }

    success() {
        if (!document.getElementsByClassName("js-success")[0]) {
            return;
        }

        // html
        const element = document.getElementsByClassName("js-success")[0];

        // exe
        setTimeout(() => {
            element.classList.add("d-none");
        }, 5000);
    }

    error() {
        if (!document.getElementsByClassName("js-error")[0]) {
            return;
        }

        // html
        const element = document.getElementsByClassName("js-error")[0];

        // exe
        setTimeout(() => {
            element.classList.add("d-none");
        }, 5000);
    }

    close() {
        if (!document.getElementsByClassName("js-close")[0]) {
            return;
        }

        // vars
        const close = document.getElementsByClassName("js-close")[0];
        const id = close.dataset.id;
        const box = document.getElementById(id);

        // exe
        close.addEventListener("click", function () {
            box.classList.add("d-none");
        })
    }



}