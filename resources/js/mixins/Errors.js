export default {
    methods: {
        checkForError: function(key) {
            return (-1 !== this.errors.indexOf(key));
        },
        removeError: function(error) {
            let errorIndex = this.errors.indexOf(error);
            if (errorIndex !== -1) {
                this.errors.splice(errorIndex, 1);
            }
        }
    }
}
