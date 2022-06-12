<template>
    <!--All employee salary Content -->
    <div>
        <div class="row">
            <router-link to="/salary" class="btn btn-primary">Back</router-link>
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
                                        <h1 class="h4 text-gray-900 mb-4">Employee salary details</h1>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table align-items-center table-flush">
                                            <thead class="thead-light">
                                            <tr>
                                                <th>Name</th>
                                                <th>Month</th>
                                                <th>Amount</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="salary in filterSearch" :key="salary.id">
                                                <td>{{ salary.name }}</td>
                                                <td>{{ salary.salary_month }}</td>
                                                <td>{{ salary.amount }}</td>
                                                <td>{{ salary.salary_date }}</td>
                                                <td>
                                                    <router-link :to="{name: 'edit-salary', params:{id:salary.id}}" class="btn btn-sm btn-primary">Edit Salary</router-link>
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
                salaries: [],
                searchEmp: ''
            }
        },
        computed: {
            filterSearch() {
                return this.salaries.filter(salary => {
                    return salary.name.match(this.searchEmp)
                })
            }
        },
        methods: {
            viewSalary() {
                let id = this.$route.params.id;
                axios.get('/api/salary/view/' + id)
                    .then(({data}) => (this.salaries = data))
                    .catch(error => this.errors = error.response.data.errors)
            },

        },
        created() {
            this.viewSalary();
        }
    }
</script>

<style scoped>
    .emp_photo {
        height: 40px;
        width: 50px;
    }
</style>
