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
];
