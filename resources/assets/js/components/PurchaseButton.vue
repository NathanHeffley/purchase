<template>
    <button class="btn" @click="openStripe">Purchase</button>
</template>

<script>
    export default {
        props: {
            id: Number,
            name: String,
            price: Number,
        },

        data() {
            return {
                stripeHandler: null,
            }
        },

        created() {
            const handler = StripeCheckout.configure({
                key: App.stripePublicKey,
            });

            window.addEventListener('popstate', () => {
                handler.close()
            });

            this.stripeHandler = handler;
        },

        methods: {
            openStripe() {
                this.stripeHandler.open({
                    name: this.name,
                    currency: 'usd',
                    allowRememberMe: false,
                    panelLabel: 'Pay',
                    amount: this.price,
                    token: this.purchase,
                })
            },

            purchase(token) {
                axios.post(`/products/${this.id}/orders`, {
                    email: token.email,
                    token: token.id,
                }).then(response => {
                    window.location = '/'
                })
            },
        },
    }
</script>
