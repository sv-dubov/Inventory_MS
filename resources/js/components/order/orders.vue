<template>
    <!--Orders Content -->
    <div>
        <input type="text" v-model="searchOrder" class="form-control" style="width: 300px;" placeholder="Search Order">
        <br>
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Today's orders</h1>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table align-items-center table-flush">
                                            <thead class="thead-light">
                                            <tr>
                                                <th>Name</th>
                                                <th>Total Amount</th>
                                                <th>Pay</th>
                                                <th>Due</th>
                                                <th>Pay by</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="order in filterSearch" :key="order.id">
                                                <td>{{ order.name }}</td>
                                                <td>{{ order.total }} $</td>
                                                <td>{{ order.pay }} $</td>
                                                <td>{{ order.due }} $</td>
                                                <td>{{ order.pay_by }}</td>
                                                <td>
                                                    <router-link :to="{name: 'view-order', params:{id:order.id}}"
                                                                 class="btn btn-sm btn-primary">View
                                                    </router-link>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
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

<script type="text/javascript">
    export default {
        created() {
            if (!User.loggedIn()) {
                this.$router.push({name: '/'})
            }
        },
        data() {
            return {
                orders: [],
                searchOrder: ''
            }
        },
        computed: {
            filterSearch() {
                return this.orders.filter(order => {
                    return order.name.match(this.searchOrder)
                })
            }
        },
        methods: {
            allOrders() {
                axios.get('/api/orders')
                    .then(({data}) => (this.orders = data))
                    .catch()
            },
        },
        created() {
            this.allOrders();
        }
    }
</script>

<style scoped>

</style>
