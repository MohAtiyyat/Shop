<script >
import AuthLayout from "@/layout/AuthLayout.vue";
import axios from "axios";

export default {
  name:"createProduct",
  components: {AuthLayout},
  data(){
    return {
      formData: {
        'name': '',
        'description': '',
        'price':''
      },
      errorMsg: '',
      redirect: '/home'
    }
  },
  methods: {
    create() {
      const config = {
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('token').slice(1,-1)}`,
          'Content-Type': 'application/json',
        },
      };
      console.log(config)
      axios.post("http://127.0.0.1:8000/api/product/create",
          this.formData,
          config
      )
          .then((response) => {
            console.log(response)
            alert("product added")
            window.location.href = '/home';
          }).catch(errors => {
        errors = errors.response.data.errors;
        for (const error in errors) {
          console.log(errors[error])
        }
      });
    },
    cancel(){
      window.history.back();
    }

  }
}

</script>

<template>
  <AuthLayout name="login">
    <template #formBody>
      <form class="space-y-6">
        <div>
          <label for="productName" class="block text-sm font-medium leading-6 text-gray-900">Product name</label>
          <div class="mt-2">
            <input id="productName" name="productName" type="text" required="" v-model="formData.name"
                   class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
          </div>
        </div>

        <div>
          <div class="flex items-center justify-between">
            <label for="productDescription" class="block text-sm font-medium leading-6 text-gray-900">Product
              description</label>
          </div>
          <div class="mt-2">
            <textarea id="productDescription" name="productDescription" v-model="formData.description"
                      class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
          </div>
        </div>
        <div>
          <label for="productPrice" class="block text-sm font-medium leading-6 text-gray-900">Product price</label>
          <h6 class="block text-sm font-light leading-6 text-gray-600">without dot</h6>
          <div class="mt-2">
            <input id="productPrice" name="productPrice" type="number" required="" v-model="formData.price"
                   class="block w-1/3 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
          </div>
        </div>

        <div class="flex md:space-x-32">
          <button type="submit" @click.prevent="create()" class="flex w-1/3 justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-gray-300 shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Create</button>
          <button type="submit" @click.prevent="cancel()" class="flex w-1/3 justify-center rounded-md bg-gray-300 px-3 py-1.5 text-sm font-semibold leading-6 text-indigo-600 shadow-sm hover:bg-gray-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Cancel</button>
        </div>
      </form>
    </template>
  </AuthLayout>

</template>

<style scoped>

</style>