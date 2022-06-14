<template>
    <div>
        <div class="container-fluid" id="container-wrapper">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">POS Dashboard</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="./">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">POS</li>
                </ol>
            </div>
            <div class="row mb-3">
                <!-- Area Chart -->
                <div class="col-xl-5 col-lg-5">
                    <div class="card mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Expense Insert</h6>
                            <router-link to="/store-customer" class="btn btn-primary">Add customer</router-link>
                        </div>
                        <div class="table-responsive" style="font-size: 12px;">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Unit</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="cart in carts" :key="cart.id">
                                    <td>{{ cart.prod_name }}</td>
                                    <td>
                                        <input type="text" readonly="" style="width: 15px;" :value="cart.prod_quantity">
                                        <button @click.prevent="increment(cart.id)" class="btn btn-sm btn-success">+</button>
                                        <button @click.prevent="decrement(cart.id)" class="btn btn-sm btn-danger" v-if="cart.prod_quantity > 1">-</button>
                                        <button class="btn btn-sm btn-danger" v-else="" disabled="">-</button>
                                    </td>
                                    <td>{{ cart.prod_price }}</td>
                                    <td>{{ cart.sub_total }}</td>
                                    <td>
                                        <a @click="removeItem(cart.id)" class="btn btn-sm btn-primary"><font color="#ffffff">X</font></a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">Total Quantity:
                                    <strong>{{ qty }}</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">Sub Total:
                                    <strong>{{ subtotal }} $</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">VAT:
                                    <strong>{{ vats.vat }} %</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">Total:
                                    <strong>{{ subtotal * vats.vat / 100 + subtotal}} $</strong>
                                </li>
                            </ul>
                            <br>
                            <form @submit.prevent="orderDone">
                                <label>Customer Name</label>
                                <select class="form-control" v-model="customer_id">
                                    <option :value="customer.id" v-for="customer in customers">{{ customer.name }}</option>
                                </select>
                                <label>Pay</label>
                                <input type="text" class="form-control" required="" v-model="pay">
                                <label>Due</label>
                                <input type="text" class="form-control" required="" v-model="due">
                                <label>Pay by</label>
                                <select class="form-control" v-model="pay_by">
                                    <option value="HandCash">Hand Cash</option>
                                    <option value="Check">Check</option>
                                    <option value="GiftCard">Gift Card</option>
                                </select>
                                <br>
                                <button type="submit" class="btn btn-success">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Pie Chart -->
                <div class="col-xl-7 col-lg-7">
                    <div class="card mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Products Sold</h6>
                        </div>
                        <!--  Category Wise Product -->
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">All products</a>
                            </li>
                            <li class="nav-item" v-for="category in categories" :key="category.id">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false" @click="subProduct(category.id)" >{{ category.name }}</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="card-body">
                                    <input type="text" v-model="searchTerm" class="form-control" style="width: 560px;" placeholder="Search Product">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-6" v-for="product in filterSearch" :key="product.id">
                                            <button class="btn btn-sm" @click.prevent="addToCart(product.id)">
                                                <div class="card" style="width: 8.5rem; margin-bottom: 5px;">
                                                    <img v-if="product.image" :src="product.image" class="card-img-top prod_image">
                                                    <img v-else src="/backend/img/no-photo.jpg" class="card-img-top prod_image">
                                                    <div class="card-body">
                                                        <h6 class="card-title">{{ product.product_name }}</h6>
                                                        <span class="badge badge-success" v-if="product.product_quantity > 0">Available {{ product.product_quantity }}</span>
                                                        <span class="badge badge-danger" v-else=" ">Stock Out</span>
                                                    </div>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <input type="text" v-model="getSearchTerm" class="form-control" style="width: 560px;" placeholder="Search Product">
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-6 col-6" v-for="getProduct in getFilterSearch" :key="getProduct.id">
                                        <button class="btn btn-sm" @click.prevent="addToCart(getProduct.id)">
                                            <div class="card" style="width: 8.5rem; margin-bottom: 5px;">
                                                <img v-if="getProduct.image" :src="getProduct.image" class="card-img-top prod_image">
                                                <img v-else src="/backend/img/no-photo.jpg" class="card-img-top prod_image">
                                                <div class="card-body">
                                                    <h6 class="card-title">{{ getProduct.product_name }}</h6>
                                                    <span class="badge badge-success" v-if="getProduct.product_quantity > 0">Available {{ getProduct.product_quantity }}</span>
                                                    <span class="badge badge-danger" v-else=" ">Stock Out</span>
                                                </div>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Category Wise Product -->
                    </div>
                </div>
            </div>
        </div>
        <!--Row-->
    </div>
</template>

<script type="text/javascript">
    export default {
        created() {
            if (!User.loggedIn()) {
                this.$router.push({name: '/'})
            }
        },
        created() {
            this.allProducts();
            this.allCategories();
            this.allCustomers();
            this.cartProducts();
            this.vat();
            Reload.$on('AfterAdd', () => {
                this.cartProducts();
            })
        },
        data() {
            return {
                customer_id: '',
                pay: '',
                due: '',
                pay_by: '',
                products: [],
                categories: '',
                getProducts: [],
                searchTerm: '',
                getSearchTerm: '',
                customers: '',
                errors: '',
                carts: [],
                vats: ''
            }
        },
        computed: {
            filterSearch() {
                return this.products.filter(product => {
                    return product.product_name.match(this.searchTerm)
                })
            },
            getFilterSearch() {
                return this.getProducts.filter(getProduct => {
                    return getProduct.product_name.match(this.getSearchTerm)
                })
            },
            qty() {
                let sum = 0;
                for (let i = 0; i < this.carts.length; i++) {
                    sum += (parseFloat(this.carts[i].prod_quantity));
                }
                return sum;
            },
            subtotal() {
                let sum = 0;
                for (let i = 0; i < this.carts.length; i++) {
                    sum += (parseFloat(this.carts[i].prod_quantity) * parseFloat(this.carts[i].prod_price));
                }
                return sum;
            },
        },
        methods: {
            //Cart methods start
            addToCart(id) {
                axios.get('/api/cart/add/' + id)
                    .then(() => {
                        Reload.$emit('AfterAdd');
                        Notification.cart_success()
                    })
                    .catch()
            },
            cartProducts() {
                axios.get('/api/cart/products')
                    .then(({data}) => (this.carts = data))
                    .catch()
            },
            removeItem(id) {
                axios.get('/api/cart/remove/' + id)
                    .then(() => {
                        Reload.$emit('AfterAdd');
                        Notification.cart_delete()
                    })
                    .catch()
            },
            increment(id) {
                axios.get('/api/cart/increment/' + id)
                    .then(() => {
                        Reload.$emit('AfterAdd');
                        Notification.success()
                    })
                    .catch()
            },
            decrement(id) {
                axios.get('/api/cart/decrement/' + id)
                    .then(() => {
                        Reload.$emit('AfterAdd');
                        Notification.success()
                    })
                    .catch()
            },
            vat() {
                axios.get('/api/vats')
                    .then(({data}) => (this.vats = data))
                    .catch()
            },
            orderDone() {
                let total = this.subtotal * this.vats.vat / 100 + this.subtotal;
                var data = {
                    qty: this.qty,
                    subtotal: this.subtotal,
                    customer_id: this.customer_id,
                    pay_by: this.pay_by,
                    pay: this.pay,
                    due: this.due,
                    vat: this.vats.vat,
                    total: total
                };
                axios.post('/api/order/done', data)
                    .then(() => {
                        Notification.success()
                        this.$router.push({name: 'home'})
                    })
            },
            //Cart methods end
            allProducts() {
                axios.get('/api/products')
                    .then(({data}) => (this.products = data))
                    .catch()
            },
            allCategories() {
                axios.get('/api/categories')
                    .then(({data}) => (this.categories = data))
                    .catch()
            },
            allCustomers() {
                axios.get('/api/customers')
                    .then(({data}) => (this.customers = data))
                    .catch(console.log('error'))
            },
            subProduct(id) {
                axios.get('/api/products/get/' + id)
                    .then(({data}) => (this.getProducts = data))
                    .catch()
            }
        }
    }
</script>

<style type="text/css" scoped>
    .prod_image {
        height: 100px;
        width: 135px;
    }
</style>
