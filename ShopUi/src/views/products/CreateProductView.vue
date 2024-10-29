<script >
import FormLayout from "@/layout/FormLayout.vue";
import Layout from "@/layout/Layout.vue";
import axios from "axios";

export default {
  name:"createProduct",
  components: {FormLayout, Layout},
  data(){
    return {
      formData: {
        'name': '',
        'description': '',
        'price':''
      },
      errors:{
        'name':null,
        'description':null,
        'price':null
      },
      redirect: '/home'
    }
  },
  methods: {
    create() {
      const config = {
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('token')}`,
          'Content-Type': 'application/json',
        },
      };
      console.log(config)
      axios.post("/product/create",
          this.formData,
          config
      )
          .then((response) => {
            console.log(response)
            alert("product added")
            window.location.href = '/home';
          }).catch(errs => {
            if(errs.status === 422) {
              const errors = errs.response.data.errors;
              if (errors.name !== undefined) {
                this.errors.name = errors.name[0];
              }
              if (errors.description !== undefined) {
                this.errors.description = errors.description[0];
              }
              if (errors.price !== undefined) {
                this.errors.price = errors.price[0];
              }
            }
            else {
              console.log(errs)
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
  <Layout>
  <FormLayout name="login">
    <template #formBody>
      <form class="space-y-6">
        <div>
          <label for="productName" class="block text-sm font-medium leading-6 text-gray-900">Product name</label>
          <div class="mt-2">
            <input id="productName" name="productName" type="text" required="" v-model="formData.name"
                   class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert" v-if="errors.name">
              <span class="block sm:inline">{{errors.name}}</span>
            </div>
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
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert" v-if="errors.description">
              <span class="block sm:inline">{{errors.description}}</span>
            </div>
          </div>
        </div>
        <div>
          <label for="productPrice" class="block text-sm font-medium leading-6 text-gray-900">Product price</label>
          <h6 class="block text-sm font-light leading-6 text-gray-600">In cents</h6>
          <div class="mt-2">
            <input id="productPrice" name="productPrice" type="number" required="" v-model="formData.price"
                   class="block w-1/3 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert" v-if="errors.price">
              <span class="block sm:inline">{{errors.price}}</span>
            </div>
          </div>
        </div>

        <div class="flex md:space-x-32">
          <button type="submit" @click.prevent="create()" class="flex w-1/3 justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-gray-300 shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Create</button>
          <button type="submit" @click.prevent="cancel()" class="flex w-1/3 justify-center rounded-md bg-gray-300 px-3 py-1.5 text-sm font-semibold leading-6 text-indigo-600 shadow-sm hover:bg-gray-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Cancel</button>
        </div>
      </form>
    </template>
  </FormLayout>
  </Layout>
</template>

<style scoped>

</style>