<template>
    <!--All category Content -->
    <div>
        <div class="row">
            <router-link to="/store-category" class="btn btn-primary">Add category</router-link>
        </div>
        <br>
        <input type="text" v-model="searchCat" class="form-control" style="width: 300px;" placeholder="Search Category">
        <br>
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">All categories</h1>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table align-items-center table-flush">
                                            <thead class="thead-light">
                                            <tr>
                                                <th>Name</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="category in filterSearch" :key="category.id">
                                                <td> {{ category.name }}</td>
                                                <td>
                                                    <router-link :to="{name: 'edit-category', params:{id:category.id}}"
                                                                 class="btn btn-sm btn-primary">Edit
                                                    </router-link>
                                                    <a @click="deleteCategory(category.id)"
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
                categories: [],
                searchSupp: ''
            }
        },
        computed: {
            filterSearch() {
                return this.categories.filter(category => {
                    return category.name.match(this.searchCat)
                })
            }
        },
        methods: {
            allCategories() {
                axios.get('/api/categories')
                    .then(({data}) => (this.categories = data))
                    .catch()
            },
            deleteCategory(id) {
                Swal.fire({
                    title: 'Do you really want to delete this category?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, do it!'
                }).then((result) => {
                    if (result.value) {
                        axios.delete('/api/categories/' + id)
                            .then(() => {
                                this.categories = this.categories.filter(category => {
                                    return category.id != id
                                })
                            })
                            .catch(() => {
                                this.$router.push({name: 'categories'})
                            });
                        Swal.fire(
                            'Deleted!',
                            'The category has been deleted.',
                            'success'
                        )
                    }
                })
            }
        },
        created() {
            this.allCategories();
        }
    }
</script>

<style scoped>

</style>
