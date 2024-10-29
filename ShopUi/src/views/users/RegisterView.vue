<template>
  <Layout>
<AuthLayout>
  <template #formBody>
    <form class="space-y-6" @submit.prevent="userRegister" method="POST">
      <div>
        <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Name</label>
        <div class="mt-2">
          <input id="name" name="name" v-model="formData.name" type="text" autocomplete="name"  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
          <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert" v-if="errors.name">
            <span class="block sm:inline">{{errors.name}}</span>
          </div>
        </div>

      </div>
  <div>
    <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
    <div class="mt-2">
      <input id="email" name="email" v-model="formData.email" type="email" autocomplete="email" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert" v-if="errors.email">
        <span class="block sm:inline">{{errors.email}}</span>
      </div>
    </div>
  </div>

  <div>
    <div class="flex items-center justify-between">
      <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
    </div>
    <div class="mt-2">
      <input id="password" v-model="formData.password" name="password" type="password" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert" v-if="errors.password">
        <span class="block sm:inline">{{errors.password}}</span>
      </div>
    </div>
    <div class="flex items-center justify-between">
      <label for="password_confirmation" class="block text-sm font-medium leading-6 text-gray-900">Password confirmation</label>
    </div>
    <div class="mt-2">
      <input id="password_confirmation" v-model="formData.password_confirmation" name="password_confirmation" type="password" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
    </div>
  </div>

  <div>
    <button type="submit" @click="register()" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Register</button>
  </div>

    <p class="mt-10 text-center text-sm text-gray-500">
      A member?
      {{ ' ' }}
      <router-link to="login">Login</router-link>
    </p>
    </form>
  </template>

</AuthLayout>
  </Layout>
</template>

<script >
import AuthLayout from "@/layout/FormLayout.vue";
import { required, email, minLength, sameAs } from '@vuelidate/validators';
import { useVuelidate } from '@vuelidate/core';
import axios from "axios";
import Layout from "@/layout/Layout.vue";

export default {
  name:'userRegister',
  components: {Layout, AuthLayout},
  setup () { return { v$: useVuelidate() } },
  data(){
    return{
      formData: {
        name:'',
        email: '',
        password: '',
        password_confirmation:''
      },
      errors:{
        'name': null,
        'email': null,
        'password': null,
      },
      redirect:'/home'
    }
  },
  methods: {
    register() {
      axios.post("/user/register",
          this.formData
      )
          .then((response) => {
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + response.data.token;
            localStorage.setItem('token', response.data.token);
            localStorage.setItem('userName', response.data.userName);
            localStorage.setItem('userId', JSON.stringify(response.data.userId));
            localStorage.setItem('userEmail', response.data.userEmail);
            localStorage.setItem('role', response.data.role)
            window.location.href = '/home';
          }).catch(errs => {
            if(errs.status === 422) {
              const errors = errs.response.data.errors;
              if(errors.name !== undefined)
              {
                this.errors.name = errors.name[0];
              }
              if(errors.email !== undefined)
              {
                this.errors.email = errors.email[0];
              }
              if(errors.password !== undefined)
              {
                this.errors.password = errors.password[0];
              }
            }
            else {
              console.log(errs)
            }
      });
    }
  }
}

</script>

<style scoped>

</style>