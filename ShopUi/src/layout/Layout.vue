<template>
  <div class="min-h-full">
    <Disclosure as="nav" class="bg-gray-800" v-slot="{ open }">
      <div class="mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <img class="h-8 w-8" src="https://tailwindui.com/plus/img/logos/mark.svg?color=indigo&shade=500" alt="Your Company" />
            </div>
            <div class="hidden md:block">
              <div class="ml-10 flex items-baseline space-x-4">
                <RouterLink v-for="item in navigation" :key="item.name" :to="item.href" v-show="item.show" @click.prevent="currentPage" :class="[item.name.toUpperCase() === currentP.toUpperCase() ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'rounded-md px-3 py-2 text-sm font-medium']" :aria-current="item.name.toUpperCase() === currentP.toUpperCase() ? 'page' : undefined" >
                  {{item.name }}</RouterLink>
              </div>
            </div>
          </div>
          <div class="hidden md:block">
            <div class="ml-4 flex items-center md:ml-6">
              <div v-if="user[0] === null">
              <RouterLink v-for="item in authNavigation" :key="item.name" :to="item.href" @click.prevent="currentPage" :class="[item.name.toUpperCase() === currentP.toUpperCase() ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'rounded-md px-3 py-2 text-sm font-medium']" :aria-current="item.name.toUpperCase() === currentP.toUpperCase() ? 'page' : undefined">
                {{item.name }}</RouterLink>
              </div>
              <div v-if="user[0] !=null" >
                Welcome, <RouterLink to="/user/profile" class="hover:underline hover:text-white rounded-md">{{user[0]}}</RouterLink> | <button @click="logout()" class="hover:bg-gray-700 hover:text-white rounded-md text-center p-1">Logout</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </Disclosure>

    <header class="bg-white ">
      <div class="mx-auto  px-4 py-6 sm:px-6 lg:px-8">
        <slot name="extra"></slot>
        <h1 class="text-3xl font-bold tracking-tight text-gray-900"></h1>
      </div>
    </header>
    <main>
      <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <slot></slot>
      </div>
    </main>
  </div>
</template>

<script setup>
import { Disclosure } from '@headlessui/vue'
import SearchBar from "@/components/SearchBar.vue";
const user = [localStorage.getItem('userName'),
localStorage.getItem('userId'),
localStorage.getItem('userEmail')]
const navigation = [
  { name: 'Home', href: '/home', show: true, currentPage: true},
  { name: 'Cart', href: '/cart', show: user[0] != null, currentPage: false},

]
const userNavigation = [
  { name: 'Sign out' },
]
const authNavigation = [
  { name: 'login', href: '/user/login', currentPage: false },
  { name: 'register', href: '/user/register', currentPage: false }
]

</script>
<script>
import axios from "axios";

export default {
  created() {
    this.currentPage();
  },
  data(){
    return{
      currentP:''
    }
  },
  methods:{
    logout(){
      localStorage.clear();
      axios.post("/user/logout");
      window.location.href = '/home';
    },
    currentPage(){
      const pathArray = window.location.pathname.split('/');
      this.currentP = pathArray[1];
      if(this.currentP==='user') {
        this.currentP = pathArray[2];
      }

    }
  }
}
</script>