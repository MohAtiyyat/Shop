<script >
import FormLayout from "@/layout/FormLayout.vue";
import axios from "axios";

export default {
  name:'createProduct',
  components: {FormLayout},
  data(){
    return{
      formData: {
        'productName': '',
        'productDescription': ''
      },
      errorMsg:'',
      redirect:'/home'
    }
  },
  methods:{
  }
}

</script>

<template>
  <FormLayout name="login">
    <template #formBody>
      <form class="space-y-6"    >
        <div>
          <label for="productName" class="block text-sm font-medium leading-6 text-gray-900">Product name</label>
          <div class="mt-2">
            <input id="productName" name="productName" type="text" required="" v-model="formData.productName" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
          </div>
        </div>

        <div>
          <div class="flex items-center justify-between">
            <label for="productDescription" class="block text-sm font-medium leading-6 text-gray-900">Product description</label>
          </div>
          <div class="mt-2">
            <textarea id="productDescription" name="productDescription" v-model="formData.productDescription" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
          </div>
        </div>
        <div>
          <label for="productPrice" class="block text-sm font-medium leading-6 text-gray-900">Product price</label>
          <h6 class="block text-sm font-light leading-6 text-gray-600">without dot</h6>
          <div class="mt-2">
            <input id="productPrice" name="productPrice" type="number" required="" v-model="formData.productPrice" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
          </div>
        </div>

        <div>
          <slot name="buttons"></slot>
        </div>
      </form>
    </template>
  </FormLayout>

</template>

<style scoped>

</style>