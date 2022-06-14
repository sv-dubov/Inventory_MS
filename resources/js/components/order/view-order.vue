<template>
    <!--View order Content -->
    <div>
        <div class="row">
            <router-link to="/orders" class="btn btn-primary">All orders</router-link>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Order details</h1>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 mb-4">
                                            <div class="card">
                                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                                    <h6 class="m-0 font-weight-bold text-primary">Customer details</h6>
                                                </div>
                                                <div class="table-responsive">
                                                    <ul class="list-group">
                                                        <li class="list-group-item">Name: {{ orders.name }}</li>
                                                        <li class="list-group-item">Phone: {{ orders.phone }}</li>
                                                        <li class="list-group-item">Address: {{ orders.address }}</li>
                                                        <li class="list-group-item">Date: {{ orders.order_date }}</li>
                                                        <li class="list-group-item">Pay by: {{ orders.pay_by }}</li>
                                                    </ul>
                                                </div>
                                                <div class="card-footer"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-4">
                                            <div class="card">
                                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                                    <h6 class="m-0 font-weight-bold text-primary">Order details</h6>
                                                </div>
                                                <div class="table-responsive">
                                                    <ul class="list-group">
                                                        <li class="list-group-item">Sub Total: {{ orders.sub_total }} $</li>
                                                        <li class="list-group-item">Vat: {{ orders.vat }} $</li>
                                                        <li class="list-group-item">Total: {{ orders.total }} $</li>
                                                        <li class="list-group-item">Pay Amount: {{ orders.pay }} $</li>
                                                        <li class="list-group-item">Due Amount: {{ orders.due }} $</li>
                                                    </ul>
                                                </div>
                                                <div class="card-footer"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 mb-4">
                                            <div class="card">
                                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                                    <h6 class="m-0 font-weight-bold text-primary">Product details</h6>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table align-items-center table-flush">
                                                        <thead class="thead-light">
                                                        <tr>
                                                            <th>Product Name</th>
                                                            <th>Image</th>
                                                            <th>Product Code</th>
                                                            <th>Quantity</th>
                                                            <th>Unit Price</th>
                                                            <th>Total</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr v-for="detail in details">
                                                            <td>{{ detail.product_name }}</td>
                                                            <td v-if="detail.image">
                                                                <img :src="'/' + detail.image" class="prod_image">
                                                            </td>
                                                            <td v-else>
                                                                <img src="/backend/img/no-photo.jpg" class="prod_image">
                                                            </td>
                                                            <td>{{ detail.product_code }}</td>
                                                            <td>{{ detail.product_quantity }}</td>
                                                            <td>{{ detail.product_price }} $</td>
                                                            <td>{{ detail.sub_total }} $</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="card-footer"></div>
                                            </div>
                                        </div>
                                    </div>
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
                errors: {},
                orders: {},
                details: {},
            }
        },
        created() {
            let id = this.$route.params.id;
            axios.get('/api/order/details/' + id)
                .then(({data}) => (this.orders = data))
                .catch(console.log('error'));
            axios.get('/api/order/details/all/' + id)
                .then(({data}) => (this.details = data))
                .catch(console.log('error'))
        },
        methods: {}
    }
</script>

<style scoped>
    .prod_image {
        height: 40px;
        width: 50px;
    }
</style>
