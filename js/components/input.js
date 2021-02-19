export const vueInput = () => {
    Vue.component('vue-input', {
        template: `
            <input v-model="emailInput"
                v-on:input="sendInput"
                :placeholder="placeholder"
                autocomplete="off" type="text" name="email" id="email">
                `,
        data() {
            return {
                placeholder: "Type your email address here…",
                emailInput: null
            };
        },
        methods: {
            sendInput() {
                this.$emit('email-input-value', this.emailInput);
            },
            removeData() {
                this.emailInput = null;
            }
        }
    
    });
}; 

