<template>
    <!--Edit product stock Content -->
    <div>
        <div class="row">
            <router-link to="/stock" class="btn btn-primary">Stock</router-link>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Edit product stock</h1>
                                    </div>
                                    <form class="user" @submit.prevent="editProductStock">
                                        <div class="form-group">
                                            <label for="InputProductName">Product Name</label>
                                            <input type="text" class="form-control" id="InputProductName" v-model="form.product_name" readonly>
                                            <small class="text-danger" v-if="errors.product_name">{{ errors.product_name[0] }}</small>
                                        </div>
                                        <div class="form-group">
                                            <label for="FormControlProductQuantity">Quantity</label>
                                            <input type="number" class="form-control" id="FormControlProductQuantity" v-model="form.product_quantity">
                                            <small class="text-danger" v-if="errors.product_quantity">{{ errors.product_quantity[0] }}</small>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        created() {
            if (!User.loggedIn()) {
                this.$router.push({name: '/'})
            }
        },
        data() {
            return {
                form: {
                    product_name: '',
                    product_quantity: ''
                },
                errors: {},
            }
        },
        created() {
            let id = this.$route.params.id;
            axios.get('/api/products/' + id)
                .then(({data}) => (this.form = data))
                .catch(console.log('error'))
        },
        methods: {
            editProductStock() {
                let id = this.$route.params.id;
                axios.post('/api/stock/update/' + id, this.form)
                    .then(() => {
                        this.$router.push({name: 'stock'})
                        Notification.success()
                    })
                    .catch(error => this.errors = error.response.data.errors)
            },
        }
    }
</script>

<style scoped>

</style>
