import {vueForm} from "./components/form.js";
vueForm();

const app = new Vue({
    el: '#root',
    data: {
        regularH1: "Subscribe to newsletter",
        successH1: "Thanks for subscribing!",
        regularP: "Subscribe to our newsletter and get 10% discount on pineapple glasses.",
        successP: "You have successfully subscribed to our email listing. Check your email for the discount code.",
        trophyImage: "../static/images/ic_success.svg",
        emails: [],
        providers: [],
        isSubmissionSuccessful: false
    },
    methods: {
        addEmail(newEmail) {
            fetch("/api/insertEmail.php", {
                method: 'POST',
                body: JSON.stringify({email: newEmail, provider: newEmail.split("@").pop().split(".").shift().replace(/\b(\w)/, l => l.toUpperCase())})
            }).then( response => response.text())
            .then(this.isSubmissionSuccessful = true)
            .catch(err => console.error(err));
        }
    },
    computed: {
        heading() {
            return this.isSubmissionSuccessful ?  this.successH1 : this.regularH1;
        },
        paragraph() {
            return this.isSubmissionSuccessful ? this.successP : this.regularP;
        }
    }
});
