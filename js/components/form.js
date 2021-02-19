import {vueCheckbox} from "./checkbox.js";
import {vueInput} from "./input.js";
vueCheckbox();
vueInput();

export const vueForm = () => {
    Vue.component('vue-form', {
        template: `
            <form
            action="" method="POST" v-show="!isSubmissionSuccessful">
        
                <label class="input-arrow">
                    <vue-input @email-input-value="passEmailInput"></vue-input>

                    <button type="submit" class="submit-btn"></button>

                </label>

            
                <div class="error-message">Error Message</div>

                <div class="service-terms">
                    <vue-checkbox @checkbox-value="updateTerms"></vue-checkbox>

                    <p>I agree to <a href="#" class="underline"> terms of service</a></p>
                    
                </div>
            </form>
        `,
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
        methods: {
            updateTerms(checkboxValue) {
                console.log(checkboxValue);
                this.isTermsChecked = checkboxValue;
            },
            passEmailInput(inputValue){
                console.log(inputValue);
                this.emailInput = inputValue;
            }
        }
    
    });
}; 