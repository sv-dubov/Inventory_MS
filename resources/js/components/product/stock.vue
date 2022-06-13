<template>
    <!--All products stock Content -->
    <div>
        <div class="row">
            <router-link to="/store-product" class="btn btn-primary">Add product</router-link>
        </div>
        <br>
        <input type="text" v-model="searchProd" class="form-control" style="width: 300px;" placeholder="Search Product">
        <br>
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Stock</h1>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table align-items-center table-flush">
                                            <thead class="thead-light">
                                            <tr>
                                                <th>Image</th>
                                                <th>Name</th>
                                                <th>Category</th>
                                                <th>Buying price</th>
                                                <th>Status</th>
                                                <th>Quantity</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="product in filterSearch" :key="product.id">
                                                <td v-if="product.image">
                                                    <img :src="product.image" class="prod_image">
                                                </td>
                                                <td v-else>
                                                    <img src="/backend/img/no-photo.jpg" class="prod_image">
                                                </td>
                                                <td>{{ product.product_name }}</td>
                                                <td>{{ product.category_name }}</td>
                                                <td>{{ product.buying_price }}</td>
                                                <td v-if="product.product_quantity > 0">
                                                    <span class="badge badge-success">Available</span>
                                                </td>
                                                <td v-else=" ">
                                                    <span class="badge badge-danger">Stock Out</span>
                                                </td>
                                                <td>{{ product.product_quantity }}</td>
                                                <td>
                                                    <router-link :to="{name: 'edit-stock', params:{id:product.id}}"
                                                                 class="btn btn-sm btn-primary">Edit
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
                products: [],
                searchProd: ''
            }
        },
        computed: {
            filterSearch() {
                return this.products.filter(product => {
                    return product.product_name.match(this.searchProd)
                })
            }
        },
        methods: {
            allProducts() {
                axios.get('/api/products')
                    .then(({data}) => (this.products = data))
                    .catch()
            },
        },
        created() {
            this.allProducts();
        }
    }
</script>

<style scoped>
    .prod_image {
        height: 40px;
        width: 50px;
    }
</style>
