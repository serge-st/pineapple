import {vueCheckbox} from "./checkbox.js";
import {vueInput} from "./input.js";
vueCheckbox();
vueInput();

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
            }
        },
        data() {
            return {
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
            };
        },
        template: `
        <form v-show="!isSubmissionSuccessful"
            action="" method="POST">
    
            <label class="input-arrow">
                <vue-input @email-input-value="passEmailInput"></vue-input>
                <button type="submit" class="submit-btn"></button>
            </label>

            <div class="error-message">We are not accepting subscriptions from Colombia emails</div>

            <div class="service-terms">
                <vue-checkbox @checkbox-value="updateTerms"></vue-checkbox>
                <p>I agree to <a href="#" class="underline"> terms of service</a></p>
            </div>
        </form>
        `
    });
}; 