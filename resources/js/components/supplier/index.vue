<template>
    <!--All suppliers Content -->
    <div>
        <div class="row">
            <router-link to="/store-supplier" class="btn btn-primary">Add supplier</router-link>
        </div>
        <br>
        <input type="text" v-model="searchSupp" class="form-control" style="width: 300px;" placeholder="Search Supplier">
        <br>
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">All suppliers</h1>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table align-items-center table-flush">
                                            <thead class="thead-light">
                                            <tr>
                                                <th>Name</th>
                                                <th>Photo</th>
                                                <th>Phone</th>
                                                <th>Email</th>
                                                <th>Shop Name</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="supplier in filterSearch" :key="supplier.id">
                                                <td> {{ supplier.name }}</td>
                                                <td v-if="supplier.photo">
                                                    <img :src="supplier.photo" class="supp_photo">
                                                </td>
                                                <td v-else>
                                                    <img src="/backend/img/no-photo.jpg" class="supp_photo">
                                                </td>
                                                <td>{{ supplier.phone }}</td>
                                                <td>{{ supplier.email }}</td>
                                                <td>{{ supplier.shop_name }}</td>
                                                <td>
                                                    <router-link :to="{name: 'edit-supplier', params:{id:supplier.id}}"
                                                                 class="btn btn-sm btn-primary">Edit
                                                    </router-link>
                                                    <a @click="deleteSupplier(supplier.id)"
                                                       class="btn btn-sm btn-danger"><font color="#ffffff">Delete</font></a>
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
                suppliers: [],
                searchSupp: ''
            }
        },
        computed: {
            filterSearch() {
                return this.suppliers.filter(supplier => {
                    return supplier.name.match(this.searchSupp)
                })
            }
        },
        methods: {
            allSuppliers() {
                axios.get('/api/suppliers')
                    .then(({data}) => (this.suppliers = data))
                    .catch()
            },
            deleteSupplier(id) {
                Swal.fire({
                    title: 'Do you really want to delete this supplier?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, do it!'
                }).then((result) => {
                    if (result.value) {
                        axios.delete('/api/suppliers/' + id)
                            .then(() => {
                                this.suppliers = this.suppliers.filter(supplier => {
                                    return supplier.id != id
                                })
                            })
                            .catch(() => {
                                this.$router.push({name: 'suppliers'})
                            });
                        Swal.fire(
                            'Deleted!',
                            'The supplier has been deleted.',
                            'success'
                        )
                    }
                })
            }
        },
        created() {
            this.allSuppliers();
        }
    }
</script>

<style scoped>
    .supp_photo {
        height: 40px;
        width: 50px;
    }
</style>
