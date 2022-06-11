let login = require('./components/auth/login.vue').default;
let register = require('./components/auth/register.vue').default;
let forget = require('./components/auth/forget.vue').default;
let logout = require('./components/auth/logout.vue').default;
let home = require('./components/home.vue').default;
//Employee
let employees = require('./components/employee/index.vue').default;
let store_employee = require('./components/employee/create.vue').default;
let edit_employee = require('./components/employee/edit.vue').default;
//Supplier
let suppliers = require('./components/supplier/index.vue').default;
let store_supplier = require('./components/supplier/create.vue').default;
let edit_supplier = require('./components/supplier/edit.vue').default;
//Category
let categories = require('./components/category/index.vue').default;
let store_category = require('./components/category/create.vue').default;
let edit_category = require('./components/category/edit.vue').default;
//Product
let products = require('./components/product/index.vue').default;
let store_product = require('./components/product/create.vue').default;
let edit_product = require('./components/product/edit.vue').default;
//Expense
let expenses = require('./components/expense/expense.vue').default;
let store_expense = require('./components/expense/create.vue').default;
let edit_expense = require('./components/expense/edit.vue').default;

export const routes = [
    {path: '/', component: login, name: '/'},
    {path: '/register', component: register, name: 'register'},
    {path: '/forget', component: forget, name: 'forget'},
    {path: '/logout', component: logout, name: 'logout'},
    {path: '/home', component: home, name: 'home'},
    //Employee routes
    {path: '/employees', component: employees, name: 'employees'},
    {path: '/store-employee', component: store_employee, name: 'store-employee'},
    {path: '/edit-employee/:id', component: edit_employee, name: 'edit-employee'},
    //Supplier routes
    {path: '/suppliers', component: suppliers, name: 'suppliers'},
    {path: '/store-supplier', component: store_supplier, name: 'store-supplier'},
    {path: '/edit-supplier/:id', component: edit_supplier, name: 'edit-supplier'},
    //Category routes
    {path: '/categories', component: categories, name: 'categories'},
    {path: '/store-category', component: store_category, name: 'store-category'},
    {path: '/edit-category/:id', component: edit_category, name: 'edit-category'},
    //Product routes
    {path: '/products', component: products, name: 'products'},
    {path: '/store-product', component: store_product, name: 'store-product'},
    {path: '/edit-product/:id', component: edit_product, name: 'edit-product'},
    //Expense routes
    {path: '/expenses', component: expenses, name: 'expenses'},
    {path: '/store-expense', component: store_expense, name: 'store-expense'},
    {path: '/edit-expense/:id', component: edit_expense, name: 'edit-expense'},
];
