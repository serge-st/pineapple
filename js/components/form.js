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
            showError(err){
                this.currentError = err;
            },
            submit() {
                this.$emit("form-submitted", this.emailInput);
                this.emailInput = null;
                this.$refs.inputRef.removeData();
            },
            validateForm() {
                if (!this.emailInput) return this.showError(this.errors.noEmail);
                if (!this.emailValidation.test(this.emailInput)) return this.showError(this.errors.invalidEmail);
                if (this.emailValidation.test(this.emailInput)) {
                    if (this.emailInput.split(".").pop().toLowerCase() === "co") return this.showError(this.errors.noColombia);
                }
                if (!this.isTermsChecked) return this.showError(this.errors.acceptTerms);
                // FETCH RECORDS FROM DB TO CHECK IF THE EMAIL IS ALREADY SUBSCRIBED
                
                // WHEN ALL IS GOOD SET ERROR TO NOTHING
                this.showError('');
                this.submit();
            }
        },
        data() {
            return {
                emailInput: null,
                emailValidation: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
                currentError: "",
                errors: {
                    noEmail: "Email address is required",
                    invalidEmail: "Please provide a valid e-mail address",
                    noColombia: "We are not accepting subscriptions from Colombia emails",
                    acceptTerms: "You must accept the terms and conditions",
                    emailExists: "The provided email is already subscribed"
                },
            };
        },
        template: `
        <form 
            @submit.prevent="validateForm"

            action="" method="POST">
    
            <label class="input-arrow">
                <vue-input @email-input-value="passEmailInput" ref="inputRef"></vue-input>
                <button type="submit" class="submit-btn"></button>
            </label>

            <vue-error :message="currentError"></vue-error>

            <div class="service-terms">
                <vue-checkbox @checkbox-value="updateTerms"></vue-checkbox>
                <p>I agree to <a href="#" class="underline"> terms of service</a></p>
            </div>
        </form>
        `
    });
}; 