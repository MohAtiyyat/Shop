<script >
import AuthLayout from "@/layout/AuthLayout.vue";
import axios from "axios";

export default {
  name:'createProduct',
  components: {AuthLayout},
  created() {
    this.getProduct();
  },
  data(){
    return {
      msg:'',
      product:[],
      errorMsg: [],
      pstErrMsg:[]
    }
  },
  methods: {
    getProduct() {
      const pathArray = window.location.pathname.split('/');
      const id = pathArray[2]
      const config = {
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('token').slice(1,-1)}`,
          'Content-Type': 'application/json',
        },
      };
      console.log(config)
      axios.get(`http://127.0.0.1:8000/api/product/${id}`,
          config
      )
          .then((response) => {
            this.product = response.data;
          }).catch(errors => {
        this.errorMsg = errors.response.data.errors;
        for (const error in errors) {
          console.log(errors[error])
        }
      });
    },
    addToCart(){
      const config = {
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('token').slice(1,-1)}`,
          'Content-Type': 'application/json',
        },
      };
      axios.put('http://127.0.0.1:8000/api/cart/update',
          {'product_id': `${this.product.id}`,
          'quantity': 1},
          config
      ).then((response) => {
        this.msg = response.data;
        console.log(response)
      }).catch(errors => {
        this.pstErrMsg = errors.response.data.errors;
        for (const error in errors) {
          console.log(errors[error])
        }
      });
    },
    back(){
      window.history.back();
    },
    deleteProduct(){
      const pathArray = window.location.pathname.split('/');
      const id = pathArray[2]
      console.log(id);
      const config = {
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('token').slice(1,-1)}`,
          'Content-Type': 'application/json',
        },
      };
      console.log(config)
      axios.delete(`http://127.0.0.1:8000/api/product/${id}/delete`,
          config
      ).then((response) => {
        this.formData = response.data;
        window.history.back();
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
      <form class="space-y-6">
        <div>
          <div class="mt-2">
            <h1 class="block font-bold text-5xl leading-6 text-gray-900">{{product.name}}</h1>
          </div>
        </div>

        <div>
          <div class="flex items-center justify-between">
            <label for="productDescription" class="block text-2xl font-medium leading-6 text-gray-900">Description</label>
          </div>
          <div class="mt-2">
            <p id="productDescription" class="block w-full rounded-md py-1.5 text-gray-900 font-medium focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
            {{product.description}}
            </p>
          </div>
        </div>
          <div class="mt-2">
            <p id="productPrice" class="block w-full rounded-md py-1.5 text-gray-900 font-medium focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
              ${{product.price}}
            </p>
          </div>

        <div class="flex md:space-x-32">
          <button type="submit" @click.prevent="addToCart()" class="flex w-1/3 justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-gray-200 shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Add to cart</button>
          <button type="submit" @click.prevent="back()" class="flex w-1/3 justify-center rounded-md bg-gray-200 px-3 py-1.5 text-sm font-semibold leading-6 text-indigo-600 shadow-sm hover:bg-gray-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Back</button>
        </div>
        <div class="flex md:space-x-52">
          <router-link :to="{ path: product.id + '/edit' }" tag="button" class="lex  justify-center rounded-md bg-green-500 text-gray-200 px-3 py-1.5">Edit </router-link>
          <button @click.prevent="deleteProduct()" class="flex  justify-center rounded-md bg-red-700 text-gray-200 px-3 py-1.5">Delete</button>

        </div>
      </form>
    </template>
  </AuthLayout>

</template>

<style scoped>

</style>