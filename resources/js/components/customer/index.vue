<template>
    <!--All customers Content -->
    <div>
        <div class="row">
            <router-link to="/store-customer" class="btn btn-primary">Add customer</router-link>
        </div>
        <br>
        <input type="text" v-model="searchCust" class="form-control" style="width: 300px;" placeholder="Search Customer">
        <br>
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">All customers</h1>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table align-items-center table-flush">
                                            <thead class="thead-light">
                                            <tr>
                                                <th>Name</th>
                                                <th>Photo</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Address</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="customer in filterSearch" :key="customer.id">
                                                <td> {{ customer.name }}</td>
                                                <td v-if="customer.photo">
                                                    <img :src="customer.photo" class="cust_photo">
                                                </td>
                                                <td v-else>
                                                    <img src="/backend/img/no-photo.jpg" class="cust_photo">
                                                </td>
                                                <td>{{ customer.email }}</td>
                                                <td>{{ customer.phone }}</td>
                                                <td>{{ customer.address }}</td>
                                                <td>
                                                    <router-link :to="{name: 'edit-customer', params:{id:customer.id}}"
                                                                 class="btn btn-sm btn-primary">Edit
                                                    </router-link>
                                                    <a @click="deleteCustomer(customer.id)"
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
                customers: [],
                searchCust: ''
            }
        },
        computed: {
            filterSearch() {
                return this.customers.filter(customer => {
                    return customer.name.match(this.searchCust)
                })
            }
        },
        methods: {
            allCustomers() {
                axios.get('/api/customers')
                    .then(({data}) => (this.customers = data))
                    .catch()
            },
            deleteCustomer(id) {
                Swal.fire({
                    title: 'Do you really want to delete this customer?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, do it!'
                }).then((result) => {
                    if (result.value) {
                        axios.delete('/api/customers/' + id)
                            .then(() => {
                                this.customers = this.customers.filter(customer => {
                                    return customer.id != id
                                })
                            })
                            .catch(() => {
                                this.$router.push({name: 'customers'})
                            });
                        Swal.fire(
                            'Deleted!',
                            'The customer has been deleted.',
                            'success'
                        )
                    }
                })
            }
        },
        created() {
            this.allCustomers();
        }
    }
</script>

<style scoped>
    .cust_photo {
        height: 40px;
        width: 50px;
    }
</style>
