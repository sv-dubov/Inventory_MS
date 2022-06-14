<template>
    <div>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </div>
        <div class="row mb-3">
            <!-- Today's Sell -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">Today's sell amount</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">$ {{ todaysell }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fab fa-cc-mastercard fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Today's Income -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">Today's income</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">$ {{ income }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-money-check-alt fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Today's Due -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">Today's due</div>
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">$ {{ due }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-credit-card fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Today's Expenses -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">Today's expenses</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">$ {{ expense }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-money-check fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 mb-4">
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Out of stock products</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Code</th>
                                <th>Buying price</th>
                                <th>Status</th>
                                <th>Quantity</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="product in products" :key="product.id">
                                <td> {{ product.product_name }}</td>
                                <td v-if="product.image">
                                    <img :src="product.image" class="prod_image">
                                </td>
                                <td v-else>
                                    <img src="/backend/img/no-photo.jpg" class="prod_image">
                                </td>
                                <td> {{ product.product_code }}</td>
                                <td>{{ product.buying_price }}</td>
                                <td v-if="product.product_quantity  >= 1 ">
                                    <span class="badge badge-success">Available</span>
                                </td>
                                <td v-else=" "><span class="badge badge-danger">Stock Out</span></td>
                                <td>{{ product.product_quantity }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer"></div>
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
                todaysell: '',
                income: '',
                due: '',
                expense: '',
                products: ''
            }
        },
        mounted() {
            this.TodaySell();
            this.TodayIncome();
            this.TodayDue();
            this.TodayExpense();
            this.StockOut();
        },
        methods: {
            TodaySell() {
                axios.get('/api/today/sell')
                    .then(({data}) => (this.todaysell = data))
                    .catch()
            },
            TodayIncome() {
                axios.get('/api/today/income')
                    .then(({data}) => (this.income = data))
                    .catch()
            },
            TodayDue() {
                axios.get('/api/today/due')
                    .then(({data}) => (this.due = data))
                    .catch()
            },
            TodayExpense() {
                axios.get('/api/today/expense')
                    .then(({data}) => (this.expense = data))
                    .catch()
            },
            StockOut() {
                axios.get('/api/today/stockout')
                    .then(({data}) => (this.products = data))
                    .catch()
            }
        }
    }
</script>

<style scoped>
    .prod_image {
        height: 40px;
        width: 50px;
    }
</style>
