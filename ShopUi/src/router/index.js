import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '@/views/HomeView.vue'
import CartView from "@/views/cart/CartView.vue";
import LoginView from "@/views/users/LoginView.vue";
import RegisterView from "@/views/users/RegisterView.vue";
import ProductView from "@/views/products/ProductView.vue";
import createProductView from "@/views/products/CreateProductView.vue";
import editProductView from "@/views/products/EditProductView.vue";
import NotFound from "@/views/NotFound.vue";
import SearchView from "@/views/SearchView.vue";
import ProfileView from "@/views/users/ProfileView.vue";
import UserView from "@/views/users/UserView.vue";
import UsersView from "@/views/users/UsersView.vue";
import UserCartView from "@/views/users/UserCartView.vue";
import UserCartsView from "@/views/users/UserCartsView.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [{
      path: '/',
      children:[
          {path:'', redirect:'home', meta: {requiresAuth: false}},
          {path:'home', name:'home', component:HomeView, meta: {requiresAuth: false}},
          {path: '/user',
              children:[
                {path:'login', name:'login', component: LoginView, meta: {requiresAuth: false}},
                {path:'register', name:'register', component: RegisterView, meta: {requiresAuth: false}},
                {path:'profile', name:'profile', component: ProfileView, meta: {requiresAuth: true}},
                {path: ':id', name: 'user',component: UserView, meta: {requiresAuth: true}},
                {path: ':id/carts', name: 'userCarts', component: UserCartsView, meta: {requiresAuth: true}},
                {path: ':user/cart/:id', name: 'userCart', component: UserCartView, meta: {requiresAuth: true} }
              ]},
          {path:'/users', name:'users', component: UsersView, meta: {requiresAuth: true}},
          {path:'/cart', name:'cart', component: CartView, meta: {requiresAuth: true}},
          {path:'/product',
              children:[
                  {path:'create',name:'createProduct', component: createProductView, meta: {requiresAuth: true}},
                  {path: ':id/edit', name: 'editeProduct', component: editProductView, meta: {requiresAuth: true}},
                  {path:':id',name:'products', component: ProductView ,meta: {requiresAuth: false}}]},
          {path: "search", name:'search', component: SearchView, meta: {requiresAuth: false}},
          {path: "/:notFound", component: NotFound, meta: {requiresAuth: false}}
      ]
    }]
})
router.beforeEach(async (to, from, next) => {
    if (to.meta.requiresAuth) {
        const token = localStorage.getItem('token');
        if (token) {
            next();
        } else {
            next('/user/login');
        }
    } else {
        next();
    }
});

export default router
