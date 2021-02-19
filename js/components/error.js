export const vueError = () => {
    Vue.component('vue-error', {
        template: `
                <div 
                v-show="message" 
                name="fade"
                class="error-message">{{ message }}</div>
                `,
        props: {
            message: {
                type: String,
                default: ""
            }
        },
    });
}; 
