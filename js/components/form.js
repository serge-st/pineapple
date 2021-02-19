import {vueCheckbox} from "./checkbox.js";
import {vueInput} from "./input.js";
import {vueError} from "./error.js";
vueCheckbox();
vueInput();
vueError();

export const vueForm = () => {
    Vue.component('vue-form', {
        methods: {
            updateTerms(checkboxValue) {
                this.isTermsChecked = checkboxValue;
            },
            passEmailInput(inputValue){
                this.emailInput = inputValue;
            },
            validateForm() {
                if (!this.emailInput) return console.log(this.errors.noEmail);
                if (!this.emailRegEx.test(this.emailInput)) return console.log(this.errors.invalidEmail);
                if (this.emailRegEx.test(this.emailInput)) {
                    if (this.emailInput.split(".").pop() === "co") return console.log(this.errors.noColombia);
                }
                if (!this.isTermsChecked) return console.log(this.errors.acceptTerms);
                // FETCH RECORDS FROM DB TO CHECK IF THE EMAIL IS ALREADY SUBSCRIBED
                console.log('all goooOOOD');
            }
        },
        data() {
            return {
                emailInput: null,
                isEmailValid: false,
                isColombia: false,
                isTermsChecked: false,
                alreadyExists: false,
                isSubmissionSuccessful: 0,
                emailRegEx: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
                errors: {
                    noEmail: "Email address is required",
                    invalidEmail: "Please provide a valid e-mail address",
                    noColombia: "We are not accepting subscriptions from Colombia emails",
                    acceptTerms: "You must accept the terms and conditions",
                    emailExists: "The provided email is already subscribed"
                }
            };
        },
        template: `
        <form 
            @submit.prevent="validateForm"
            v-show="!isSubmissionSuccessful"
            action="" method="POST">
    
            <label class="input-arrow">
                <vue-input @email-input-value="passEmailInput"></vue-input>
                <button type="submit" class="submit-btn"></button>
            </label>

            <vue-error message=""></vue-error>

            <div class="service-terms">
                <vue-checkbox @checkbox-value="updateTerms"></vue-checkbox>
                <p>I agree to <a href="#" class="underline"> terms of service</a></p>
            </div>
        </form>
        `
    });
}; 