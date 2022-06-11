<template>
    <!--All expenses Content -->
    <div>
        <div class="row">
            <router-link to="/store-expense" class="btn btn-primary">Add expense</router-link>
        </div>
        <br>
        <input type="text" v-model="searchExp" class="form-control" style="width: 300px;" placeholder="Search Expense">
        <br>
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">All expenses</h1>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table align-items-center table-flush">
                                            <thead class="thead-light">
                                            <tr>
                                                <th>Details</th>
                                                <th>Amount </th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="expense in filterSearch" :key="expense.id">
                                                <td> {{ expense.details }} </td>
                                                <td> {{ expense.amount }} </td>
                                                <td> {{ expense.expense_date }} </td>
                                                <td>
                                                    <router-link :to="{name: 'edit-expense', params:{id:expense.id}}" class="btn btn-sm btn-primary">Edit</router-link>
                                                    <a @click="deleteExpense(expense.id)" class="btn btn-sm btn-danger"><font color="#ffffff">Delete</font></a>
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
                expenses: [],
                searchExp: ''
            }
        },
        computed: {
            filterSearch() {
                return this.expenses.filter(expense => {
                    return expense.expense_date.match(this.searchExp)
                })
            }
        },
        methods: {
            allExpenses() {
                axios.get('/api/expenses')
                    .then(({data}) => (this.expenses = data))
                    .catch()
            },
            deleteExpense(id) {
                Swal.fire({
                    title: 'Do you really want to delete this expense?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, do it!'
                }).then((result) => {
                    if (result.value) {
                        axios.delete('/api/expenses/' + id)
                            .then(() => {
                                this.expenses = this.expenses.filter(expense => {
                                    return expense.id != id
                                })
                            })
                            .catch(() => {
                                this.$router.push({name: 'expenses'})
                            });
                        Swal.fire(
                            'Deleted!',
                            'The expense has been deleted.',
                            'success'
                        )
                    }
                })
            }
        },
        created() {
            this.allExpenses();
        }
    }
</script>

<style scoped>

</style>
