Vue.component('email-checkbox', {
    template: `<input v-on:click='click' v-model="isChecked" class="user-checkbox" type="checkbox" name="id" :value="id">`,
    props: ['id'],
    created() {
        this.$root.getAvailableCount(this.$attrs['available-count']);
    },
    data() {
        return {
            isChecked: false,
        };
    },
    methods: {
        click() {
            this.isChecked = !this.isChecked;
            this.$emit('pass-id', this.id);
        },
    }
});

const app = new Vue({
    el: '#root',
    data: {
        allCheckboxesSelected: false,
        availableForExport: [],
        selectedCheckboxes: [],
    },
    methods: {
        getAvailableCount(num) {
            this.availableForExport.push(Number(num));
        },
        processSelected(id){
            if (this.selectedCheckboxes.includes(id)){
                this.selectedCheckboxes = this.selectedCheckboxes.filter(el => el !== id);
            } else {
                this.selectedCheckboxes.push(id);
            }
        },
        submitExport(newExport){
            console.log(newExport);

        },
        selectAll() {
            if (this.selectedCheckboxes.length !== this.availableForExport.length) {
                this.selectedCheckboxes = this.availableForExport;
                for (let key in this.$refs){
                    this.$refs[key].isChecked = true;
                }
            } else {
                this.selectNone();
            }
        },
        selectNone(){
            this.selectedCheckboxes = [];
            this.allCheckboxesSelected = false;
            for (let key in this.$refs){
                this.$refs[key].isChecked = false;
            } 
        }
    },
});