<template>
    <!--All salary Content -->
    <div>
        <div class="row">
            <router-link to="/given-salary" class="btn btn-primary">Pay salary</router-link>
        </div>
        <br>
        <input type="text" v-model="searchMonth" class="form-control" style="width: 300px;" placeholder="Search Salary">
        <br>
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">All salary details</h1>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table align-items-center table-flush">
                                            <thead class="thead-light">
                                            <tr>
                                                <th>Month</th>
                                                <th>Details</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="salary in filterSearch" :key="salary.id">
                                                <td> {{ salary.salary_month }} </td>
                                                <td>
                                                    <router-link :to="{name: 'view-salary', params:{id:salary.salary_month}}" class="btn btn-sm btn-primary">View salary</router-link>
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
                searchMonth: ''
            }
        },
        computed: {
            filterSearch() {
                return this.salaries.filter(salary => {
                    return salary.salary_month.match(this.searchMonth)
                })
            }
        },
        methods: {
            allSalary() {
                axios.get('/api/salary/')
                    .then(({data}) => (this.salaries = data))
                    .catch()
            },
        },
        created() {
            this.allSalary();
        }
    }
</script>

<style scoped>

</style>
