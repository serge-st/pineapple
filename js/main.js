Vue.component('checkbox', {
    template:   `<div v-on:click="click">
                    <div v-if="isChecked" class="checkbox-clicked">
                        <svg class="tick" width="14" height="11" viewBox="0 0 14 11" fill="none" xmlns="http://www.w3.org/2000/svg" >
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L4.70711 10.7071C4.31658 11.0976 3.68342 11.0976 3.29289 10.7071L0.292893 7.70711C-0.0976311 7.31658 -0.0976311 6.68342 0.292893 6.29289C0.683417 5.90237 1.31658 5.90237 1.70711 6.29289L4 8.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="white"/>
                        </svg>
                    </div>
                    <div v-else class="checkbox"></div>
                </div>`,
    data() {
        return {
            isChecked: false,
        };
    },
    methods: {
        click() {
            this.isChecked = !this.isChecked;
        }
    }
});

const app = new Vue({
    el: '#root',
    data: {
        heading: "Subscribe to newsletter",
        successHeading: "Thanks for subscribing!",
        paragraph: "Subscribe to our newsletter and get 10% discount on pineapple glasses.",
        successParagraph: "You have successfully subscribed to our email listing. Check your email for the discount code.",
        trophyImage: "../static/images/ic_success.svg",
        errors: {
            invalidEmail: "Please provide a valid e-mail address",
            acceptTerms: "You must accept the terms and conditions",
            noEmail: "Email address is required",
            noColombia: "We are not accepting subscriptions from Colombia emails"
        },

        emailInput: null,
        isEmailValid: false,
        isSubmissionSuccessful: 0,
    },

});
