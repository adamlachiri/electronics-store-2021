export default class Forms {
    constructor() {
        this.submit_onclick();
        this.submit_onchange();
    }


    submit_onclick() {
        // check
        if (!document.getElementsByClassName("js-submit-onclick")[0]) {
            return;
        }

        // html
        const inputs = document.getElementsByClassName("js-submit-onclick");

        // loop
        for (let i = 0; i < inputs.length; i++) {
            // vars
            const input = inputs[i];
            const id = input.dataset.id;
            const form = document.getElementById(id);
            // event
            input.addEventListener("click", function () {
                console.log("i have been clicked");
                form.submit();
            })

        }
    }

    submit_onchange() {
        // check
        if (!document.getElementsByClassName("js-submit-onchange")[0]) {
            return;
        }

        // html
        const inputs = document.getElementsByClassName("js-submit-onchange");

        // loop
        for (let i = 0; i < inputs.length; i++) {
            // vars
            const input = inputs[i];
            const id = input.dataset.id;
            const form = document.getElementById(id);


            // event
            input.addEventListener("change", function () {
                form.submit();
            })

        }
    }

}