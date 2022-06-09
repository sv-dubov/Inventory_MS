<template>
    <!--All employees Content -->
    <div>
        <div class="row">
            <router-link to="/store-employee" class="btn btn-primary">Add employee</router-link>
        </div>
        <br>
        <input type="text" v-model="searchEmp" class="form-control" style="width: 300px;" placeholder="Search Employee">
        <br>
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">All employees</h1>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table align-items-center table-flush">
                                            <thead class="thead-light">
                                            <tr>
                                                <th>Name</th>
                                                <th>Photo</th>
                                                <th>Phone</th>
                                                <th>Salary</th>
                                                <th>Joining Date</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="employee in filterSearch" :key="employee.id">
                                                <td> {{ employee.name }}</td>
                                                <td><img :src="employee.photo" id="emp_photo"></td>
                                                <td>{{ employee.phone }}</td>
                                                <td>{{ employee.salary }}</td>
                                                <td>{{ employee.join_at }}</td>
                                                <td>
                                                    <router-link :to="{name: 'edit-employee', params:{id:employee.id}}"
                                                                 class="btn btn-sm btn-primary">Edit
                                                    </router-link>
                                                    <a @click="deleteEmployee(employee.id)"
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
                employees: [],
                searchEmp: ''
            }
        },
        computed: {
            filterSearch() {
                return this.employees.filter(employee => {
                    return employee.name.match(this.searchEmp)
                })
            }
        },
        methods: {
            allEmployees() {
                axios.get('/api/employees')
                    .then(({data}) => (this.employees = data))
                    .catch()
            },
            deleteEmployee(id) {
                Swal.fire({
                    title: 'Do you really want to delete this employee?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, do it!'
                }).then((result) => {
                    if (result.value) {
                        axios.delete('/api/employees/' + id)
                            .then(() => {
                                this.employees = this.employees.filter(employee => {
                                    return employee.id != id
                                })
                            })
                            .catch(() => {
                                this.$router.push({name: 'employees'})
                            });
                        Swal.fire(
                            'Deleted!',
                            'The employee has been deleted.',
                            'success'
                        )
                    }
                })
            }
        },
        created() {
            this.allEmployees();
        }
    }
</script>

<style scoped>
    #emp_photo {
        height: 40px;
        width: 50px;
    }
</style>
