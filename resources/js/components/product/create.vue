<template>
    <!--Add product Content -->
    <div>
        <div class="row">
            <router-link to="/products" class="btn btn-primary">All Products</router-link>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Add product</h1>
                                    </div>
                                    <form class="user" @submit.prevent="createProduct" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label>Product Name</label>
                                            <input type="text" class="form-control" id="InputProductName" v-model="form.product_name">
                                            <small class="text-danger" v-if="errors.product_name">{{ errors.product_name[0] }}</small>
                                        </div>
                                        <div class="form-group">
                                            <label>Code</label>
                                            <input type="text" class="form-control" id="InputProductCode" v-model="form.product_code">
                                            <small class="text-danger" v-if="errors.product_code">{{ errors.product_code[0] }}</small>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <label for="InputProductCategory">Category</label>
                                                    <select class="form-control" id="InputProductCategory" v-model="form.category_id">
                                                        <option :value="category.id" v-for="category in categories">{{ category.name }}</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="InputProductSupplier">Supplier</label>
                                                    <select class="form-control" id="InputProductSupplier" v-model="form.supplier_id">
                                                        <option :value="supplier.id" v-for="supplier in suppliers">{{ supplier.name }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-4">
                                                    <label for="FormControlProductRoot">Product Root</label>
                                                    <input type="text" class="form-control" id="FormControlProductRoot" v-model="form.root">
                                                    <small class="text-danger" v-if="errors.root">{{ errors.root[0] }}</small>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="FormControlBuyingPrice">Buying Price</label>
                                                    <input type="number" class="form-control"
                                                           id="FormControlBuyingPrice" v-model="form.buying_price">
                                                    <small class="text-danger" v-if="errors.buying_price">{{ errors.buying_price[0] }}</small>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="FormControlSellingPrice">Selling Price</label>
                                                    <input type="number" class="form-control"
                                                           id="FormControlSellingPrice" v-model="form.selling_price">
                                                    <small class="text-danger" v-if="errors.selling_price">{{ errors.selling_price[0] }}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <label for="FormControlBuyingDate">Buying Date</label>
                                                    <input type="date" class="form-control" id="FormControlBuyingDate" v-model="form.buying_date">
                                                    <small class="text-danger" v-if="errors.buying_date">{{ errors.buying_date[0] }}</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="FormControlProductQuantity">Quantity</label>
                                                    <input type="number" class="form-control"
                                                           id="FormControlProductQuantity"
                                                           v-model="form.product_quantity">
                                                    <small class="text-danger" v-if="errors.product_quantity">{{ errors.product_quantity[0] }}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <input type="file" class="custom-file-input" id="customFile" @change="onFileSelected">
                                                    <small class="text-danger" v-if="errors.image">{{ errors.image[0] }}</small>
                                                    <label class="custom-file-label" for="customFile">Choose image</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <img :src="form.image" style="height: 50px; width: 50px;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">Add</button>
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

<script type="text/javascript">
    export default {
        created() {
            if (!User.loggedIn()) {
                this.$router.push({name: '/'})
            }
        },
        data() {
            return {
                form: {
                    product_name: null,
                    product_code: null,
                    category_id: null,
                    supplier_id: null,
                    root: null,
                    buying_price: null,
                    selling_price: null,
                    buying_date: null,
                    product_quantity: null,
                    image: null
                },
                errors:{},
                categories:{},
                suppliers:{}
            }
        },
        methods: {
            onFileSelected(event) {
                let file = event.target.files[0];
                if (file.size > 1048770) {
                    Notification.image_validation()
                } else {
                    let reader = new FileReader();
                    reader.onload = event => {
                        this.form.image = event.target.result;
                        console.log(event.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            },
            createProduct() {
                axios.post('/api/products', this.form)
                    .then(() => {
                        this.$router.push({name: 'products'});
                        Notification.success()
                    })
                    .catch(error => this.errors = error.response.data.errors)
            }
        },
        created() {
            //Category collected
            axios.get('/api/categories')
                .then(({data}) => (this.categories = data))
            //Supplier collected
            axios.get('/api/suppliers')
                .then(({data}) => (this.suppliers = data))
        }
    }
</script>

<style scoped>

</style>
