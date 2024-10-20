<script >

import axios from "axios";
import Card from "@/components/Card.vue";
import Layout from "@/layout/Layout.vue";

import {ChevronLeftIcon, ChevronRightIcon } from "@heroicons/vue/20/solid/index.js";

export default {
  name:'Products',
  components: {ChevronLeftIcon, Layout, ChevronRightIcon, Card},
  created() {
    this.getProducts()
  },
  data(){
    return{
      products:[],
      errorMsg:'',
      currentPage: 1,
      totalPages: 0,
      user:[localStorage.getItem('userId'),localStorage.getItem('userName'), localStorage.getItem('userEmail')],
      rqPage:'',
    }
  },
  watch:{
    currentPage(){
      this.getProducts();
    },
    totalPages(){
      this.getProducts()
    }
  },
  methods:{
    async getProducts(page = this.currentPage){
      await axios.get(`http://127.0.0.1:8000/api/product?page=${page}`).
      then((response) =>{
        this.products = response.data.data
        this.totalPages = response.data.total/response.data.per_page>0? Math.round(response.data.total/response.data.per_page) : 1 ;
        this.currentPage = page;
      })
          .catch(() =>{
            this.errorMsg = 'Error retrieving data'
          })
    },
     previous() {
      if (this.currentPage > 1) {
        this.currentPage = this.currentPage - 1;
      }
    },
    next () {
      if (this.currentPage >= 1 && this.currentPage < this.totalPages) {
        this.currentPage = this.currentPage + 1;
      }
    },
  }
}
</script>

<template>
  <Layout>
    <template #createBtn v-if="user[0]!= null">
      <router-link  to="product/create">
        <button class="justify-center h-4">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
          </svg>
        </button>
      </router-link>
    </template>
    <div class="mt-16 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-4"  >
      <Card v-for="product in products" :key="product.id" :product-id="product.id" :productName="product.name" :productPrice="product.price"/>
    </div>
    <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
      <div v-show=" (totalPages>1)">
        <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
          <button @click="previous" class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
            <span class="sr-only">Previous</span>
            <ChevronLeftIcon class="h-5 w-5" aria-hidden="true" />
          </button>
          <button v-for="page in totalPages" :key="page" @click="currentPage = page" :class="(page !== currentPage)?'relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0' : 'relative z-10 inline-flex items-center bg-indigo-600 px-4 py-2 text-sm font-semibold text-white focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600' ">{{ page }}</button>
          <button @click="next" class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
            <span class="sr-only">Next</span>
            <ChevronRightIcon class="h-5 w-5" aria-hidden="true" />
          </button>
        </nav>
      </div>

    </div>
  </Layout>
</template>
