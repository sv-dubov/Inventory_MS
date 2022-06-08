<template>
    <!--Add employee Content -->
    <div>
        <div class="row">
            <router-link to="/employees" class="btn btn-primary">All Employee</router-link>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Add employee</h1>
                                    </div>
                                    <form class="user" @submit.prevent="createEmployee" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label>Full Name</label>
                                            <input type="text" class="form-control" id="exampleInputFullName" placeholder="Enter Full Name" v-model="form.name">
                                            <small class="text-danger" v-if="errors.name">{{ errors.name[0] }}</small>
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp"
                                                   placeholder="Enter Email Address" v-model="form.email">
                                            <small class="text-danger" v-if="errors.email">{{ errors.email[0] }}</small>
                                        </div>
                                        <div class="form-group">
                                            <label>Address</label>
                                            <input type="text" class="form-control" id="exampleInputAddress" placeholder="Enter Address" v-model="form.address">
                                            <small class="text-danger" v-if="errors.address">{{ errors.address[0] }}</small>
                                        </div>
                                        <div class="form-group">
                                            <label>Phone</label>
                                            <input type="text" class="form-control" id="exampleInputPhone" placeholder="Enter Phone" v-model="form.phone">
                                            <small class="text-danger" v-if="errors.phone">{{ errors.phone[0] }}</small>
                                        </div>
                                        <div class="form-group">
                                            <label>Salary</label>
                                            <input type="text" class="form-control" id="exampleInputSalary" placeholder="Enter Salary" v-model="form.salary">
                                            <small class="text-danger" v-if="errors.salary">{{ errors.salary[0] }}</small>
                                        </div>
                                        <div class="form-group">
                                            <label>Nid</label>
                                            <input type="text" class="form-control" id="exampleInputNid" placeholder="Enter Nid" v-model="form.n_id">
                                            <small class="text-danger" v-if="errors.n_id">{{ errors.n_id[0] }}</small>
                                        </div>
                                        <div class="form-group">
                                            <label>Join date</label>
                                            <input type="date" class="form-control" id="exampleInputJoinAt" v-model="form.join_at">
                                            <small class="text-danger" v-if="errors.join_at">{{ errors.join_at[0] }}</small>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <input type="file" class="custom-file-input" id="customFile">
                                                    <small class="text-danger" v-if="errors.photo"> {{ errors.photo[0] }}</small>
                                                    <label class="custom-file-label" for="customFile">Choose photo</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <img :src="form.photo" style="height: 50px; width: 50px;">
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
                    name: null,
                    email: null,
                    address: null,
                    phone: null,
                    salary: null,
                    n_id: null,
                    join_at: null,
                    photo: null
                },
                errors:{}
            }
        },
        methods: {
            createEmployee() {
                axios.post('/api/employee', this.form)
                    .then(() => {
                        this.$router.push({name: 'employee'});
                        Notification.success()
                    })
                    .catch(error => this.errors = error.response.data.errors)
            }
        }
    }
</script>

<style scoped>

</style>
