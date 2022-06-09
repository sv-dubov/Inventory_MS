<template>
    <!--Edit employee Content -->
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
                                        <h1 class="h4 text-gray-900 mb-4">Edit employee</h1>
                                    </div>
                                    <form class="user" @submit.prevent="editEmployee" enctype="multipart/form-data">
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
                                                    <input type="file" class="custom-file-input" id="customFile" @change="onFileSelected">
                                                    <small class="text-danger" v-if="errors.photo"> {{ errors.photo[0] }}</small>
                                                    <label class="custom-file-label" for="customFile">Choose photo</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <img :src="form.photo" style="height: 50px; width: 50px;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">Update</button>
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
                    name: '',
                    email: '',
                    address: '',
                    phone: '',
                    salary: '',
                    n_id: '',
                    join_at: '',
                    photo: '',
                    new_photo: ''
                },
                errors:{}
            }
        },
        created() {
            let id = this.$route.params.id;
            axios.get('/api/employees/' + id)
                .then(({data}) => (this.form = data))
                .catch(console.log('error'))
        },
        methods: {
            onFileSelected(event) {
                let file = event.target.files[0];
                if (file.size > 1048770) {
                    Notification.image_validation()
                } else {
                    let reader = new FileReader();
                    reader.onload = event => {
                        this.form.new_photo = event.target.result
                    };
                    reader.readAsDataURL(file);
                }
            },
            editEmployee() {
                let id = this.$route.params.id;
                axios.patch('/api/employees/' + id, this.form)
                    .then(() => {
                        this.$router.push({name: 'employees'});
                        Notification.success()
                    })
                    .catch(error => this.errors = error.response.data.errors)
            }
        }
    }
</script>

<style scoped>
