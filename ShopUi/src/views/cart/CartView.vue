<script >

import axios from "axios";
import Card from "@/components/Card.vue";
import Layout from "@/layout/Layout.vue";
export default {
  name:'Products',
  components: {Layout, Card},
  created() {
    this.getProducts()
  },
  data(){
    return{
      products:[],
      totalQuantity:'',
      totalPrice:'',
      errorMsg:''
    }
  },

  methods:{
    async getProducts(){
      try {
        const config = {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
            'Content-Type': 'application/json',
          },
        };
        await axios.get('/cart',
            config).then((response) => {
          this.products = response.data.products
          this.totalQuantity = response.data.totalQuantity
          this.totalPrice = response.data.totalPrice
        }).catch(errors => {
              errors = errors.response;
              if(errors.status === 401){
                localStorage.clear()
                window.location.href = '/user/login';
              }
              for (let error in errors){
                console.log(error.status + "  " + error.data.message)
              }
            })
      }catch (e) {
        console.log(e)
      }
    },
    async quantityDec(id, quantity){
      try {
        const config = {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
            'Content-Type': 'application/json',
          },
        };
        await axios.put('/cart/update',
            {
              'product_id': parseInt(id),
              'quantity': -1
            },
            config
        ).then((response) => {
          this.msg = response.data;
          this.getProducts();
        }).catch(errors => {
          this.pstErrMsg = errors.response.data.errors;
          for (const error in errors) {
            console.log(errors[error])
          }
        });
      }catch (e) {
        console.log(e)
      }
    },
    async quantityInc(id, quantity){
      try {
        const config = {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
            'Content-Type': 'application/json',
          },
        };
         await axios.put('/cart/update',
            {
              'product_id': id,
              'quantity': 1
            },
            config
        ).then((response) => {
          this.msg = response.data;
          this.getProducts();
        }).catch(errors => {
          this.pstErrMsg = errors.response.data.errors;
          for (const error in errors) {
            console.log(errors[error])
          }
        });
      }catch (e) {
        console.log(e)
      }
    },
    async buy(){
      try {
        const config = {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
            'Content-Type': 'application/json',
          },
        };
        await axios.put('/cart/buy', {},
            config
        ).then((response) => {
          this.msg = response.data;
          this.getProducts();
        }).catch(errors => {
          this.pstErrMsg = errors.response.data.errors;
          for (const error in errors) {
            console.log(error)
          }
        });
      }catch (e) {
        console.log(e)
      }

    }

  }
}
</script>

<template>
  <Layout>
    <section class="py-24 relative">
      <div class="w-full max-w-7xl px-4 md:px-5 lg-6 mx-auto">

        <h2 class="title font-manrope font-bold text-4xl leading-10 mb-8 text-center text-black">Shopping Cart
        </h2>
        <div class="hidden lg:grid grid-cols-2 py-6">
          <div class="font-normal text-xl leading-8 text-gray-500">Product</div>
          <p class="font-normal text-xl leading-8 text-gray-500 flex items-center justify-between">
            <span class="w-full max-w-[260px] text-center">Quantity</span>
            <span class="w-full max-w-[200px] text-center">Total</span>
          </p>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 min-[550px]:gap-6 border-t border-gray-200 py-6" v-for="product in products">
          <div
              class="flex items-center flex-col min-[550px]:flex-row gap-3 min-[550px]:gap-6 w-full max-xl:justify-center max-xl:max-w-xl max-xl:mx-auto">
            <div class="pro-data w-full max-w-sm ">
              <router-link :to="{path: '/product/' + product.id}" class="font-semibold text-xl leading-8 text-black max-[550px]:text-center">{{product.name}}
              </router-link>
              <br>
              <h6 class="font-medium text-lg leading-8 text-indigo-600  max-[550px]:text-center">${{product.price/100}}</h6>
            </div>
          </div>
          <div
              class="flex items-center flex-col min-[550px]:flex-row w-full max-xl:max-w-xl max-xl:mx-auto gap-2">
            <div class="flex items-center w-1/4 h-1/4 mx-auto justify-center">
              <button @click.prevent="quantityDec(product.id, product.pivot.quantity)"
                  class="group rounded-l-full px-6 py-[18px] border border-gray-200 flex items-center justify-center shadow-sm shadow-transparent transition-all duration-500 hover:shadow-gray-200 hover:border-gray-300 hover:bg-gray-50">
                <svg class="stroke-gray-900 transition-all duration-500 group-hover:stroke-black"
                     xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22"
                     fill="none">
                  <path d="M16.5 11H5.5" stroke="" stroke-width="1.6" stroke-linecap="round" />
                  <path d="M16.5 11H5.5" stroke="" stroke-opacity="0.2" stroke-width="1.6"
                        stroke-linecap="round" />
                  <path d="M16.5 11H5.5" stroke="" stroke-opacity="0.2" stroke-width="1.6"
                        stroke-linecap="round" />
                </svg>
              </button>
              <input type="text" readonly
                     class="border-y border-gray-200 outline-none text-gray-900 font-semibold text-lg w-full max-w-[118px] min-w-[80px] placeholder:text-gray-900 py-[15px] text-center bg-transparent"
                     :placeholder='product.pivot.quantity'>
              <button @click.prevent="quantityInc(product.id, product.pivot.quantity)"
                  class="group rounded-r-full px-6 py-[18px] border border-gray-200 flex items-center justify-center shadow-sm shadow-transparent transition-all duration-500 hover:shadow-gray-200 hover:border-gray-300 hover:bg-gray-50">
                <svg class="stroke-gray-900 transition-all duration-500 group-hover:stroke-black"
                     xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22"
                     fill="none">
                  <path d="M11 5.5V16.5M16.5 11H5.5" stroke="" stroke-width="1.6"
                        stroke-linecap="round" />
                  <path d="M11 5.5V16.5M16.5 11H5.5" stroke="" stroke-opacity="0.2" stroke-width="1.6"
                        stroke-linecap="round" />
                  <path d="M11 5.5V16.5M16.5 11H5.5" stroke="" stroke-opacity="0.2" stroke-width="1.6"
                        stroke-linecap="round" />
                </svg>
              </button>
            </div>
            <h6
                class="text-indigo-600 font-manrope font-bold text-2xl leading-9 w-full max-w-[176px] text-center">
              ${{product.pivot.quantity * product.price /100}}</h6>
          </div>
        </div>
        <div class="bg-gray-50 rounded-xl p-6 w-full mb-8 max-lg:max-w-xl max-lg:mx-auto">
          <div class="flex items-center justify-between w-full py-6">
            <p class="font-manrope font-medium text-2xl leading-9 text-gray-900">Items</p>
            <h6 class="font-manrope font-medium text-2xl leading-9 text-indigo-500">{{totalQuantity}} </h6>
          </div>
          <div class="flex items-center justify-between w-full py-6">
            <p class="font-manrope font-medium text-2xl leading-9 text-gray-900">Total</p>
            <h6 class="font-manrope font-medium text-2xl leading-9 text-indigo-500">${{totalPrice/100}}</h6>
          </div>
        </div>
        <div class="flex items-center flex-col sm:flex-row justify-center gap-3 mt-8">
          <button @click.prevent="buy"
              class="rounded-full w-full max-w-[280px] py-4 text-center justify-center items-center bg-indigo-600 font-semibold text-lg text-white flex transition-all duration-500 hover:bg-indigo-700">Buy

          </button>
        </div>
      </div>
    </section>

  </Layout>
</template>
