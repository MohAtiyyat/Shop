<script >

import axios from "axios";
import Card from "@/components/Card.vue";
import Layout from "@/layout/Layout.vue";

import {ChevronLeftIcon, ChevronRightIcon } from "@heroicons/vue/20/solid/index.js";
import SearchBar from "@/components/SearchBar.vue";

export default {
  name:'Products',
  components: {SearchBar, ChevronLeftIcon, Layout, ChevronRightIcon, Card},
  created() {
    this.getProducts()
  },
  data(){
    return{
      products:[],
      errorMsg:'',
      currentPage: 1,
      totalPages: 0,
      rqPage:'',
      search:'',
      user:{
        id:localStorage.getItem('userId'),
        name:localStorage.getItem('userName'),
        email:localStorage.getItem('userEmail'),
        role:localStorage.getItem('role')},
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
      await axios.get(`/product?page=${page}`).
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
    searchPar(){
      localStorage.setItem('search', this.search)
      window.location.replace(`/search?search=${this.search}`);
    }
  }
}
</script>

<template>
  <Layout>
    <template #extra>
      <router-link  to="product/create" v-if="user.role === 'admin'">
        <button class="justify-center h-4">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
          </svg>
        </button>
      </router-link>
      <!-- Search bar -->
      <form class="max-w-md mx-auto">
        <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
        <div class="relative">
          <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
            </svg>
          </div>
          <input type="search" name="search" v-model="search" id="search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search " required />
          <button type="submit" @click.prevent="searchPar()" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
        </div>
      </form>
    </template>
    <div class="mt-16 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-4"  >
      <Card v-for="product in products" :key="product.id" :productId="product.id" :productName="product.name" :productPrice="product.price"/>
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
