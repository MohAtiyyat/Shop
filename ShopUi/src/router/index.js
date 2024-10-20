import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '@/views/HomeView.vue'
import CartView from "@/views/cart/CartView.vue";
import LoginView from "@/views/users/LoginView.vue";
import RegisterView from "@/views/users/RegisterView.vue";
import ProductView from "@/views/products/ProductView.vue";
import createProductView from "@/views/products/CreateProductView.vue";
import editProductView from "@/views/products/EditProductView.vue";
import NotFound from "@/views/NotFound.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [{
      path: '/',
      children:[{
        path:'', name:'home', component:HomeView, alias:'home'
      },
      {
        path: '/user',
        name:'user',
        children:[
            {path:'login', name:'login', component: LoginView},
        {path:'register', name:'register', component: RegisterView}]
      },
          {
              path:'/cart',
              children:[
                  {path:'', name:'cart', component: CartView}
              ]
          },
          {
              path:'/product',
              children:[
                  {path:'create',name:'createProduct', component: createProductView},
                  {path: ':id/edit', name: 'editeProduct', component: editProductView},
                  {path:':id',name:'products', component: ProductView}
              ]
          },{
              path: "/:notFound",
              component: NotFound,
          },
      ]
    }]
})

export default router
