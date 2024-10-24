<template>
<AuthLayout>
  <template #formBody>
    <form class="space-y-6" @submit.prevent="userRegister" method="POST">
      <div>
        <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Name</label>
        <div class="mt-2">
          <input id="name" name="name" v-model="formData.name" type="text" autocomplete="name" required="" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
        </div>

      </div>
  <div>
    <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
    <div class="mt-2">
      <input id="email" name="email" v-model="formData.email" type="email" autocomplete="email" required="" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
    </div>
  </div>

  <div>
    <div class="flex items-center justify-between">
      <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
    </div>
    <div class="mt-2">
      <input id="password" v-model="formData.password" name="password" type="password" required="" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
    </div>
    <div class="flex items-center justify-between">
      <label for="password_confirmation" class="block text-sm font-medium leading-6 text-gray-900">Password confirmation</label>
    </div>
    <div class="mt-2">
      <input id="password_confirmation" v-model="formData.password_confirmation" name="password_confirmation" type="password" required="" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
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
</template>

<script >
import AuthLayout from "@/layout/FormLayout.vue";
import { required, email, minLength, sameAs } from '@vuelidate/validators';
import { useVuelidate } from '@vuelidate/core';
import axios from "axios";

export default {
  name:'userRegister',
  components: {AuthLayout},
  setup () { return { v$: useVuelidate() } },
  data(){
    return{
      formData: {
        name:'',
        email: '',
        password: '',
        password_confirmation:''
      },
      errorMsg:'',
      redirect:'/home'
    }
  },
  methods: {
    register() {
      axios.post("http://127.0.0.1:8000/api/user/register",
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
          }).catch(errors => {
        errors = errors.response.data.errors;
        for (const error in errors) {
          console.log(errors[error])
        }
      });
    }
  }
}

</script>

<style scoped>

</style>