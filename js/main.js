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
        isSubmissionSuccessful: false

    },
    methods: {
        addEmail(newEmail) {
            this.emails.push(newEmail);
            console.log(this.emails);
            this.isSubmissionSuccessful = true;
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
