import {vueCheckbox} from "./components/checkbox.js";
import {vueInput} from "./components/input.js";
vueCheckbox();
vueInput();

const app = new Vue({
    el: '#root',
    data: {
        regularH1: "Subscribe to newsletter",
        successH1: "Thanks for subscribing!",
        regularP: "Subscribe to our newsletter and get 10% discount on pineapple glasses.",
        successP: "You have successfully subscribed to our email listing. Check your email for the discount code.",
        trophyImage: "../static/images/ic_success.svg",
        errors: {
            invalidEmail: "Please provide a valid e-mail address",
            acceptTerms: "You must accept the terms and conditions",
            noEmail: "Email address is required",
            noColombia: "We are not accepting subscriptions from Colombia emails"
        },

        emailInput: null,
        isEmailValid: false,
        isTermsChecked: false,
        isSubmissionSuccessful: 0,
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
