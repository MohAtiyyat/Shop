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
                <RouterLink v-for="item in navigation" :key="item.name" :to="item.name" :class="[item.current ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'rounded-md px-3 py-2 text-sm font-medium']" :aria-current="item.current ? 'page' : undefined">
                  {{item.name }}</RouterLink>
              </div>
            </div>
          </div>
          <div class="hidden md:block">
            <div class="ml-4 flex items-center md:ml-6">
              <div v-if="user[0] === null">
              <RouterLink v-for="item in authNavigation" :key="item.name" :to="item.href" :class="[item.current ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'rounded-md px-3 py-2 text-sm font-medium']" :aria-current="item.current ? 'page' : undefined">
                {{item.name }}</RouterLink>
              </div>
              <div v-if="user[0] !=null" >
              Welcome, {{user[0]}} | <button @click="logout()">Logout</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <DisclosurePanel class="md:hidden">
        <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
          <DisclosureButton v-for="item in navigation" :key="item.name" as="a" :href="item.href" >{{ item.name }}</DisclosureButton>
        </div>
        <div class="border-t border-gray-700 pb-3 pt-4">
          <div class="flex items-center px-5">
            <div class="flex-shrink-0">
              {{user[0]}}
            </div>
            <div class="ml-3">
              <div class="text-base font-medium leading-none text-white">{{ user[0] }}</div>
              <div class="text-sm font-medium leading-none text-gray-400">{{ user[2] }}</div>
            </div>
            <button type="button" class="relative ml-auto flex-shrink-0 rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
              <span class="absolute -inset-1.5" />
              <span class="sr-only">View notifications</span>
              <BellIcon class="h-6 w-6" aria-hidden="true" />
            </button>
          </div>
          <DisclosureButton v-for="item in userNavigation" :key="item.name" as="a" :href="item.href" class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">{{ item.name }}</DisclosureButton>
          <div class="mt-3 space-y-1 px-2">
            <DisclosureButton v-for="item in userNavigation" :key="item.name" as="a" :href="item.href" class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">{{ item.name }}</DisclosureButton>
          </div>
        </div>
      </DisclosurePanel>
    </Disclosure>

    <header class="bg-white shadow">
      <div class="mx-auto  px-4 py-6 sm:px-6 lg:px-8">
<!--        add create btn -->
        <slot name="createBtn"></slot>
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
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue'
import { BellIcon, } from '@heroicons/vue/24/outline'
const user = [localStorage.getItem('userName'),
localStorage.getItem('userId'),
localStorage.getItem('userEmail')]
console.log(user);
const pathArray = window.location.pathname.split('/');
const currentPage = pathArray[1]
const navigation = [
  { name: 'Home', current: currentPage === name },
  { name: 'Cart', href: 'cart' ,current: currentPage === name },

]
const userNavigation = [
  { name: 'Sign out' },
]
const authNavigation = [
  { name: 'login', href: 'user/login' },
  { name: 'register', href: 'user/register' }
]

</script>
<script>
import axios from "axios";

export default {
  methods:{
    logout(){
      localStorage.clear();
      axios.post("http://127.0.0.1:8000/api/user/logout");
      window.location.href = '/home';
    }
  }
}
</script>