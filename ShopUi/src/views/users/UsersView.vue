<script>
import Layout from "@/layout/Layout.vue";
import SearchBar from "@/components/SearchBar.vue";
import {ChevronLeftIcon, ChevronRightIcon} from "@heroicons/vue/20/solid/index.js";
import axios from "axios";
export default {
  name: "UsersView",
  components: {SearchBar, ChevronLeftIcon, Layout, ChevronRightIcon},
  created() {
    this.getProducts()
  },
  data(){
    return {
      users: [],
      currentPage: 1,
      totalPages: 0,
      rqPage: '',
      search: '',
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
      const config = {
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('token')}`,
          'Content-Type': 'application/json',
        },
      };
      await axios.get(`/users?page=${page}`, config).
      then((response) =>{
        this.users = response.data.data
        this.totalPages = response.data.total/response.data.per_page>0? Math.round(response.data.total/response.data.per_page) : 1 ;
        this.currentPage = page;
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
    }
  }
}
</script>

<template>
<Layout>
  <ul role="list" class="divide-y divide-black">
    <li v-for="user in users" :key="user.id" class="flex justify-between gap-x-6 py-5">
      <div class="flex min-w-0 gap-x-4">
        <div class="min-w-0 flex-auto">
          <router-link :to="{ path: '/user/' + user.id }" class="text-lg font-semibold text-gray-900 ">{{user.name}}</router-link>
          <p class="mt-1 truncate text-xs/5 text-gray-500">{{ user.email }}</p>
        </div>
      </div>
      <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
        <router-link :to="{path: '/user/'+ user.id +'/carts'}">Cart</router-link>
        <p v-if="user.banned ===1" class="mt-1 text-xs/5 text-gray-500">Banned</p>
      </div>

    </li>
  </ul>




</Layout>
</template>

<style scoped>

</style>