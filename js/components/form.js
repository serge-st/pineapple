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
                console.log(checkboxValue);
                this.isTermsChecked = checkboxValue;
            },
            passEmailInput(inputValue){
                console.log(inputValue);
                this.emailInput = inputValue;
            },
        },
        data() {
            return {
                emailInput: null,
                isEmailValid: false,
                isColombia: false,
                isTermsChecked: false,
                alreadyExists: false,
                isSubmissionSuccessful: 0,
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
        <form v-show="!isSubmissionSuccessful"
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