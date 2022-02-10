export default class Carousels {
    constructor() {
        this.carousel_lg();
        this.carousel_fade();
        this.carousel_fade_auto();
        this.carousel();
        this.carousel_vertical();
    }

    carousel_lg() {
        // check
        if (!document.getElementsByClassName("js-carousel-lg")[0]) {
            return;
        }

        // html
        const carousels = document.getElementsByClassName("js-carousel-lg");
        const btn_class = "bg-main";

        // loop
        for (let i = 0; i < carousels.length; i++) {
            //html
            const carousel = carousels[i];
            const slider = carousel.getElementsByClassName("js-slider")[0];
            const items = slider.getElementsByClassName("js-item");
            const paginations = carousel.getElementsByClassName("js-pagination-btn")[0];
            const next = carousel.getElementsByClassName("js-next")[0];
            const prev = carousel.getElementsByClassName("js-prev")[0];

            // vars
            let index = 1;
            const limit = items.length - 1;
            const lag_delay = 100;


            // functions
            function exe() {
                // calculate dimensions
                const carousel_width = carousel.clientWidth;
                for (let i = 0; i < items.length; i++) {
                    const item = items[i];
                    item.style.width = carousel_width + "px";
                }

                // checking position
                if (index == -1) {
                    index = limit - 1;
                    slider.classList.remove("ease-out-fast");
                    slider.style.transform =
                        "translateX(-" + index * carousel_width + "px)";
                    index--;
                }
                else if (index == limit + 1) {
                    index = 1;
                    slider.classList.remove("ease-out-fast");
                    slider.style.transform =
                        "translateX(-" + index * carousel_width + "px)";
                    index++;
                }

                //scrolling & pagination
                setTimeout(() => {
                    slider.classList.add("ease-out-fast");
                    slider.style.transform =
                        "translateX(-" + index * carousel_width + "px)";
                    check_pagination();
                }, lag_delay);
            }

            function check_pagination() {
                for (let i = 0; i < paginations.length; i++) {
                    const pagination = paginations[i];
                    if (index == 0) {
                        if (i == paginations.length - 1) {
                            pagination.classList.add(btn_class);
                        }
                        else {
                            pagination.classList.remove(btn_class);
                        }
                    }
                    else if (index == limit) {
                        if (i == 0) {
                            pagination.classList.add(btn_class);
                        }
                        else {
                            pagination.classList.remove(btn_class);
                        }
                    }
                    else {
                        if (index == i + 1) {
                            pagination.classList.add(btn_class);

                        } else {
                            pagination.classList.remove(btn_class);
                        }
                    }
                }
            }

            // exe
            for (let i = 0; i < paginations.length; i++) {
                const pagination = paginations[i];
                pagination.addEventListener("click", function () {
                    index = i + 1;
                    exe()
                });
            }

            prev.addEventListener("click", function () {
                index--;
                exe()
            })

            next.addEventListener("click", function () {
                index++;
                exe()
            })

            window.addEventListener("resize", function () {
                exe()
            });

            // starter
            exe();
        }
    }

    carousel_fade() {
        // check
        if (!document.getElementsByClassName("js-carousel-fade")[0]) {
            return;
        }

        // html
        const carousels = document.getElementsByClassName("js-carousel-fade");
        const btn_class = "bg-light";

        // loop
        for (let i = 0; i < carousels.length; i++) {
            //html
            const carousel = carousels[i];
            const items = carousel.getElementsByClassName("js-item");
            const paginations = carousel.getElementsByClassName("js-pagination-btn");
            const next = carousel.getElementsByClassName("js-next")[0];
            const prev = carousel.getElementsByClassName("js-prev")[0];

            // vars
            let index = 0;
            const limit = items.length - 1;
            const animation_delay = 500;

            // functions

            function fade_in() {
                // fix index
                index = index == -1 ? limit : (index == limit + 1 ? 0 : index);

                // fade in
                for (let i = 0; i < items.length; i++) {
                    const item = items[i];
                    if (index == i) {
                        item.classList.remove("d-none");
                        item.classList.add("fade-in");
                    }
                    else {
                        item.classList.remove("fade-in", "fade-out");
                        item.classList.add("d-none");
                    }
                }

                // check pagination
                check_pagination();
            }

            function calculate_dimensions() {
                const carousel_width = carousel.clientWidth;
                for (let i = 0; i < items.length; i++) {
                    const item = items[i];
                    item.style.width = carousel_width + "px";
                }
            }

            function check_pagination() {
                for (let i = 0; i < paginations.length; i++) {
                    const pagination = paginations[i];
                    if (index == i) {
                        pagination.classList.add(btn_class);

                    } else {
                        pagination.classList.remove(btn_class);
                    }
                }
            }

            // events
            for (let i = 0; i < paginations.length; i++) {
                const pagination = paginations[i];
                pagination.addEventListener("click", function () {
                    // html
                    let item = items[index];
                    // fade out
                    item.classList.add("fade-out");
                    index = i;

                    setTimeout(() => {
                        fade_in();
                    }, animation_delay);
                });
            }

            prev.addEventListener("click", function () {
                // html
                let item = items[index];
                // fade out
                item.classList.add("fade-out");
                index--;

                setTimeout(() => {
                    fade_in();
                }, animation_delay);
            })

            next.addEventListener("click", function () {
                // html
                let item = items[index];
                // fade out
                item.classList.add("fade-out");
                index++;

                setTimeout(() => {
                    fade_in();
                }, animation_delay);
            })

            window.addEventListener("resize", function () {
                calculate_dimensions();
            });

            // starter
            calculate_dimensions();
        }
    }

    carousel_fade_auto() {
        // check
        if (!document.getElementsByClassName("js-carousel-fade-auto")) {
            return;
        }

        // html
        const carousels = document.getElementsByClassName("js-carousel-fade-auto");
        const btn_class = "bg-main";

        // loop
        for (let i = 0; i < carousels.length; i++) {
            //html
            const carousel = carousels[i];
            const items = carousel.getElementsByClassName("js-item");

            // vars
            let index = 0;
            const limit = items.length - 1;
            const animation_delay = 500;
            const auto_delay = 3000;

            // functions

            function fade_in() {
                // fix index
                index = index == -1 ? limit : (index == limit + 1 ? 0 : index);

                // fade in
                for (let i = 0; i < items.length; i++) {
                    const item = items[i];
                    if (index == i) {
                        item.classList.remove("d-none");
                        item.classList.add("fade-in");
                    }
                    else {
                        item.classList.remove("fade-in", "fade-out");
                        item.classList.add("d-none");
                    }
                }
            }

            function calculate_dimensions() {
                const carousel_width = carousel.clientWidth;
                const carousel_height = carousel.clientHeight;
                for (let i = 0; i < items.length; i++) {
                    const item = items[i];
                    item.style.width = carousel_width + "px";
                    item.style.height = carousel_height + "px";
                }
            }

            window.addEventListener("resize", function () {
                calculate_dimensions();
            });

            // starter
            calculate_dimensions();
            setInterval(() => {
                // html
                let item = items[index];
                // fade out
                item.classList.add("fade-out");
                index++;

                setTimeout(() => {
                    fade_in();
                }, animation_delay);
            }, auto_delay);
        }
    }

    carousel() {
        if (!document.getElementsByClassName("js-carousel")[0]) {
            return;
        }

        const carousels = document.getElementsByClassName("js-carousel");
        //loop through carousels
        for (let i = 0; i < carousels.length; i++) {
            //html
            const carousel = carousels[i];
            const slider_container = carousel.getElementsByClassName("js-slider-container")[0];
            const slider = carousel.getElementsByClassName("js-slider")[0];
            const scrollbar = carousel.getElementsByClassName("js-scrollbar")[0];
            const next = carousel.getElementsByClassName("js-next")[0];
            const prev = carousel.getElementsByClassName("js-prev")[0];

            //general parameters
            const animation_class = "ease-out-fast";
            const scrollbar_class = "bg-dark";
            let slider_position = 0;
            let step;
            let link;

            //slider parameters
            let slider_container_width;
            let slider_width;
            let slider_limit;

            //scroll bar parameters
            let scrollbar_limit;
            let scrollbar_width;
            let scrollbar_position = 0;
            let old_scrollbar_position = 0;
            let is_down;
            let start;

            //calculate sizes function
            function calculate_sizes() {
                slider_container_width = slider_container.clientWidth;
                slider_width = slider.clientWidth;
                scrollbar_width =
                    (slider_container_width * slider_container_width) / slider_width;
                scrollbar.style.width = scrollbar_width + "px";
                slider_limit = slider_width - slider_container_width;
                scrollbar_limit = slider_container_width - scrollbar_width;
                link = scrollbar_limit / slider_limit;
                step = slider_container_width * 0.8;
            }

            //scroll function
            function scroll() {
                slider.style.transform = "translateX(-" + slider_position + "px)";
                scrollbar.style.left = slider_position * link + "px";
                if (slider_position == 0) {
                    prev.classList.add("d-none");
                    next.classList.remove("d-none");
                } else if (slider_position == slider_limit) {
                    next.classList.add("d-none");
                    prev.classList.remove("d-none");
                } else {
                    next.classList.remove("d-none");
                    prev.classList.remove("d-none");
                }
            }

            // check slider 
            function check_slider_width() {
                if (slider_width <= slider_container_width) {
                    next.classList.add("d-none");
                    prev.classList.add("d-none");
                    scrollbar.classList.add("d-none");
                    slider_container.classList.add("d-center");
                }
            }


            //mouse event listeners
            scrollbar.addEventListener("mousedown", function (e) {
                is_down = true;
                start = e.clientX;
                // css
                carousel.classList.remove(animation_class);
                scrollbar.classList.add(scrollbar_class);
            });
            window.addEventListener("mouseup", function (e) {
                is_down = false;
                old_scrollbar_position = scrollbar_position;
                // css
                carousel.classList.add(animation_class);
                scrollbar.classList.remove(scrollbar_class);
            });
            window.addEventListener("mousemove", function (e) {
                if (is_down) {
                    calculate_sizes();
                    scrollbar_position = old_scrollbar_position + e.clientX - start;
                    scrollbar_position =
                        scrollbar_position > 0
                            ? scrollbar_position < scrollbar_limit
                                ? scrollbar_position
                                : scrollbar_limit
                            : 0;
                    slider_position = scrollbar_position / link;
                    scroll();
                }
            });

            //buttons events listeners
            next.addEventListener("click", function () {
                calculate_sizes();
                slider_position =
                    slider_position + step > slider_limit
                        ? slider_limit
                        : slider_position + step;
                old_scrollbar_position = slider_position * link;
                scroll();
            });
            prev.addEventListener("click", function () {
                calculate_sizes();
                slider_position =
                    slider_position - step < 0 ? 0 : slider_position - step;
                old_scrollbar_position = slider_position * link;
                scroll();
            });

            //starter check
            calculate_sizes();
            check_slider_width();
            scroll();


            window.addEventListener("resize", function () {
                calculate_sizes();
                check_slider_width();
                scroll();
            });
        }

    }

    carousel_vertical() {
        if (!document.getElementsByClassName("js-carousel-vertical")[0]) {
            return;
        }

        //html
        const carousel = document.getElementsByClassName("js-carousel-vertical")[0];
        const slider = carousel.getElementsByClassName("js-slider")[0];
        const next = carousel.getElementsByClassName("js-next")[0];
        const prev = carousel.getElementsByClassName("js-prev")[0];
        const slider_height = slider.clientHeight;
        const carousel_height = carousel.clientHeight;

        //vars
        const limit = slider_height - carousel_height;
        const step = carousel_height * 0.8;
        let position = 0;

        //check carousel size
        if (slider_height <= carousel_height) {
            next.classList.add("d-none");
            prev.classList.add("d-none");
            return;
        }

        //check buttons
        function scroll() {
            slider.style.transform = "translateY(-" + position + "px)";
            if (position == 0) {
                prev.classList.add("d-none");
                next.classList.remove("d-none");
            } else if (position == limit) {
                next.classList.add("d-none");
                prev.classList.remove("d-none");
            } else {
                next.classList.remove("d-none");
                prev.classList.remove("d-none");
            }
        }

        //page load
        scroll();

        next.addEventListener("click", function () {
            position = position + step > limit ? limit : position + step;
            scroll();
        });
        prev.addEventListener("click", function () {
            position = position - step < 0 ? 0 : position - step;
            scroll();
        });

    }

}