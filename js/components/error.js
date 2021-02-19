export const vueError = () => {
    Vue.component('vue-error', {
        template: `
                <div v-show="message" class="error-message">{{ message }}</div>
                `,
        props: {
            message: {
                type: String,
                default: ""
            }
        }
    });
}; 
