export const vueInput = () => {
    Vue.component('vue-input', {
        template: `<input v-model="emailInput" type="email" name="email" id="email" :placeholder="placeholder">`,
        data() {
            return {
                placeholder: "Type your email address here…",
                emailInput: null
            };
        },
    
    });
}; 

