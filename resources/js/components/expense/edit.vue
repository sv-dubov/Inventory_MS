<template>
    <!--Edit expense Content -->
    <div>
        <div class="row">
            <router-link to="/expenses" class="btn btn-primary">All Expenses</router-link>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Edit expense</h1>
                                    </div>
                                    <form class="user" @submit.prevent="editExpense">
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <label for="FormControlExpenseDetails">Expense Details</label>
                                                <textarea class="form-control" id="FormControlExpenseDetails" rows="3" v-model="form.details"></textarea>
                                                <small class="text-danger" v-if="errors.details"> {{ errors.details[0] }} </small>
                                            </div>
                                            <div class="col-md-12"><br>
                                                <label for="FormControlExpenseAmount">Expense Amount</label>
                                                <input type="text" class="form-control" id="FormControlExpenseAmount" v-model="form.amount">
                                                <small class="text-danger" v-if="errors.amount"> {{ errors.amount[0] }} </small>
                                            </div>
                                        </div>
                                        <br>
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
                    details: '',
                    amount: ''
                },
                errors:{}
            }
        },
        created() {
            let id = this.$route.params.id;
            axios.get('/api/expenses/' + id)
                .then(({data}) => (this.form = data))
                .catch(console.log('error'))
        },
        methods: {
            editExpense() {
                let id = this.$route.params.id;
                axios.patch('/api/expenses/' + id, this.form)
                    .then(() => {
                        this.$router.push({name: 'expenses'});
                        Notification.success()
                    })
                    .catch(error => this.errors = error.response.data.errors)
            }
        }
    }
</script>

<style scoped>

</style>
