export default {
    methods: {
        copy: function(object) {
            return JSON.parse(JSON.stringify(object))
        }
    }
}
