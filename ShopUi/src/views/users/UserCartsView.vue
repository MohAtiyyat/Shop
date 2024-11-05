<script>
  import Layout from "@/layout/Layout.vue";
  import axios from "axios";
  export default {
    name: "UserCartsView",
      components:{Layout},
    created() {
    this.getCarts()
  },
    data(){
    return{
    carts:[]
  }
  },
    methods:{
    async getCarts(){
    const pathArray = window.location.pathname.split('/');
    const id = pathArray[2];
    console.log(id)
    const config = {
    headers: {
    'Authorization': `Bearer ${localStorage.getItem('token')}`,
    'Content-Type': 'application/json',
  },
  };
    await axios.get(`/user/${id}/carts`,
    config).
    then((response) =>{
    this.carts = response.data
    console.log(response)
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
    back(){
    window.history.back();
  }
  }
}
</script>

<template>
  <Layout>
    <ul role="list" class="divide-y divide-gray-100">
      <li v-for="cart in carts" :key="cart.id" class="flex justify-between gap-x-6 py-5">
        <div class="flex min-w-0 gap-x-4">
          <div class="min-w-0 flex-auto">
            <router-link :to="{path: 'cart/' + cart.id}" class="font-semibold text-xl leading-8 text-black max-[550px]:text-center">{{cart.id}}
            </router-link>
          </div>
        </div>
        <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
          <p class="text-sm/6 text-gray-900">created at: {{cart.created_at}}</p>
          <p class="text-xs/5 text-gray-500">{{cart.ordered_at !== null? "ordered at : " + cart.ordered_at : "not ordered yet" }}</p>
        </div>
      </li>
    </ul>
    <div>
      <button type="submit" @click.prevent="back()" class="flex w-1/3 justify-center rounded-md bg-gray-200 px-3 py-1.5 text-sm font-semibold leading-6 text-indigo-600 shadow-sm hover:bg-gray-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Back</button>

    </div>
  </Layout>
</template>

<style scoped>

</style>