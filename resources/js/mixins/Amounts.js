export default {
    methods: {
        incrementAmount(amount) {
            if (amount === 0) {
                return 0.1;
            } else if (amount === 0.1) {
                return 0.25;
            }
            return amount + 0.25;
        },
        decrementAmount(amount) {
            if (amount === 0) {
                return 0;
            }

            if (amount === 0.1) {
                return 0;
            } else if (amount === 0.25) {
                return 0.1;
            }
            return amount - 0.25;
        }
    }
}
