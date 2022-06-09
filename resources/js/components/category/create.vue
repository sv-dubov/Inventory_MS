<template>
    <!--Add category Content -->
    <div>
        <div class="row">
            <router-link to="/categories" class="btn btn-primary">All Categories</router-link>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Add category</h1>
                                    </div>
                                    <form class="user" @submit.prevent="createCategory">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" class="form-control" id="exampleInputName" placeholder="Enter Name" v-model="form.name">
                                            <small class="text-danger" v-if="errors.name">{{ errors.name[0] }}</small>
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
                    name: null
                },
                errors:{}
            }
        },
        methods: {
            createCategory() {
                axios.post('/api/categories', this.form)
                    .then(() => {
                        this.$router.push({name: 'categories'});
                        Notification.success()
                    })
                    .catch(error => this.errors = error.response.data.errors)
            }
        }
    }
</script>

<style scoped>

</style>
