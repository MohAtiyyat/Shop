<script >
import AuthLayout from "@/layout/AuthLayout.vue";
import axios from "axios";

export default {
  name:'userLogin',
  components: {AuthLayout},
  data(){
    return{
      formData: {
        'email': '',
        'password': ''
      },
      errorMsg:'',
      redirect:'/home'
    }
  },
  methods:{
    login() {
        axios.post("http://127.0.0.1:8000/api/user/login",
            this.formData
        )
            .then((response) => {
              axios.defaults.headers.common['Authorization'] = 'Bearer ' + response.data.token;

              localStorage.setItem( 'token', JSON.stringify(response.data.token));
              localStorage.setItem('userName', JSON.stringify(response.data.userName));
              localStorage.setItem('userId', JSON.stringify(response.data.userId));
              localStorage.setItem('userEmail', JSON.stringify(response.data.userEmail));
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

<template>
  <AuthLayout name="login">
    <template #formBody>
      <form class="space-y-6"    >
      <div>
        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
        <div class="mt-2">
          <input id="email" name="email" type="email" autocomplete="email" required="" v-model="formData.email" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
        </div>
      </div>

      <div>
        <div class="flex items-center justify-between">
          <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
<!--          <div class="text-sm">-->
<!--            <a href="#" class="font-semibold text-indigo-600 hover:text-indigo-500">Forgot password?</a>-->
<!--          </div>-->
        </div>
        <div class="mt-2">
          <input id="password" name="password" type="password" autocomplete="current-password" required="" v-model="formData.password" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
        </div>
      </div>

      <div>
        <button type="submit" @click.prevent="login()" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sign in</button>
      </div>
      <p class="mt-10 text-center text-sm text-gray-500">
        Not a member?
        {{ ' ' }}
        <router-link to="register">Register Now</router-link>
      </p>
      </form>
    </template>
  </AuthLayout>

</template>

<style scoped>

</style>