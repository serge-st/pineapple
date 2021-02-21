Vue.component('get-count', {
    template: `<input type="text" name="availableCount"`,
    created() {
        this.$root.getAvailableCount(this.$attrs['available-count']);
    }
});

Vue.component('email-checkbox', {
    template: `<input v-on:click='click' class="user-checkbox" type="checkbox" name="id" :value="id">`,
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
            console.log("id from checkbox", this.id);
            this.isChecked = !this.isChecked;
            this.$emit('pass-id', this.id);
        }
    }
});

const app = new Vue({
    el: '#root',
    data: {
        allCheckboxesSelected: false,
        availableForExport: [],
        selectedCheckboxes: [],
    },
    // mounted() {
    //     document.addEventListener('DOMContentLoaded', function() {
    //         console.log("loaded");
    //      }, false);
    // },
    computed: {
        // d() {
        //     if (this.selectedCheckboxes.length === this.availableForExport) {
        //         this.allCheckboxesSelected = true;
        //     } else {
        //         this.allCheckboxesSelected = false;
        //     }
        // }
    },
    methods: {
        compareAvailableCount(){
            console.log("watched");
            if (this.availableForExport.length === this.selectedCheckboxes.length){
                console.log("full");
                this.allCheckboxesSelected = true;
            } else {
                this.allCheckboxesSelected = false;
            }
        },
        getAvailableCount(num) {
            this.availableForExport.push(Number(num));
        },
        processSelected(id){
            if (this.selectedCheckboxes.includes(id)){
                this.selectedCheckboxes = this.selectedCheckboxes.filter(el => el !== id);
            } else {
                this.selectedCheckboxes.push(id);
            }
            console.log("id from root: " + id);
            this.compareAvailableCount();
        },
        selectAll() {
            console.log("selecting all chbxs");
        },
        toggleCheckboxSelection() {
            console.log("checkbox");
        }
    },

});