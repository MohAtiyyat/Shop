<script >
import FormLayout from "@/layout/FormLayout.vue";
import axios from "axios";
import Layout from "@/layout/Layout.vue";

export default {
  name:'createProduct',
  components: {Layout, FormLayout},
  created() {
    this.getProduct();
  },
  data(){
    return {
      token:'',
      msg:'',
      product:[],
      errorMsg: [],
      pstErrMsg:[],
      user:{
        id:localStorage.getItem('userId'),
        name:localStorage.getItem('userName'),
        email:localStorage.getItem('userEmail'),
        role:localStorage.getItem('role')},
    }
  },
  methods: {
    async getProduct() {
      const pathArray = window.location.pathname.split('/');
      const id = pathArray[2];
      const config = {
        headers: {
          'Content-Type': 'application/json',
        },
      };
      await axios.get(`/product/${id}`,
          config
      )
          .then((response) => {
            this.product = response.data;
            this.product.quantity = 1;
          }).catch(errors => {
        this.errorMsg = errors.response.data.errors;
        for (const error in errors) {
          console.log(errors[error])
        }
      });
    },
    async addToCart(){
      const config = {
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('token')}`,
          'Content-Type': 'application/json',
        },
      };
      await axios.put('/cart/update',
          {'product_id': `${this.product.id}`,
          'quantity':`${this.product.quantity}` },
          config
      ).then((response) => {
        this.msg = response.data;
        alert('Product added')
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
    async deleteProduct(){
      const config = {
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('token')}`,
          'Content-Type': 'application/json',
        },
      };
      await axios.delete(`/product/${this.product.id}/delete`,
          config
      ).then((res) => {
        alert(res.data.message)
        console.log(res.data)
        window.history.back();
      }).catch(errors => {
        errors = errors.response.data.errors;
        for (const error in errors) {
          console.log(errors[error])
        }
      });
    },
    quantityDec(quantity){
      try {
        this.product.quantity = parseInt(quantity - 1)
      }catch (e) {
        console.log(e)
      }
    },
    quantityInc(quantity){
      try {
        this.product.quantity = parseInt(quantity + 1)
      }catch (e) {
        console.log(e)
      }
    },
  }
}

</script>

<template>
  <Layout>
  <FormLayout name="login">
    <template #formBody>
      <form class="space-y-6">
        <div>
          <div class="mt-2">
            <h1 class="block font-bold text-3xl text-center  leading-6 text-gray-900">{{product.name}}</h1>
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
              ${{product.price/100}}
            </p>
          </div>
        <div>
          <div class="flex items-center w-1/4 h-1/4 mx-auto justify-center">
            <button @click.prevent="quantityDec(product.quantity)"
                    class="group rounded-l-full px-6 py-[18px] border border-gray-200 flex items-center justify-center shadow-sm shadow-transparent transition-all duration-500 hover:shadow-gray-200 hover:border-gray-300 hover:bg-gray-50">
              <svg class="stroke-gray-900 transition-all duration-500 group-hover:stroke-black"
                   xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22"
                   fill="none">
                <path d="M16.5 11H5.5" stroke="" stroke-width="1.6" stroke-linecap="round" />
                <path d="M16.5 11H5.5" stroke="" stroke-opacity="0.2" stroke-width="1.6"
                      stroke-linecap="round" />
                <path d="M16.5 11H5.5" stroke="" stroke-opacity="0.2" stroke-width="1.6"
                      stroke-linecap="round" />
              </svg>
            </button>
            <input type="text" readonly
                   class="border-y border-gray-200 outline-none text-gray-900 font-semibold text-lg w-full max-w-[118px] min-w-[80px] placeholder:text-gray-900 py-[15px] text-center bg-transparent"
                   :placeholder='product.quantity'>
            <button @click.prevent="quantityInc( product.quantity)"
                    class="group rounded-r-full px-6 py-[18px] border border-gray-200 flex items-center justify-center shadow-sm shadow-transparent transition-all duration-500 hover:shadow-gray-200 hover:border-gray-300 hover:bg-gray-50">
              <svg class="stroke-gray-900 transition-all duration-500 group-hover:stroke-black"
                   xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22"
                   fill="none">
                <path d="M11 5.5V16.5M16.5 11H5.5" stroke="" stroke-width="1.6"
                      stroke-linecap="round" />
                <path d="M11 5.5V16.5M16.5 11H5.5" stroke="" stroke-opacity="0.2" stroke-width="1.6"
                      stroke-linecap="round" />
                <path d="M11 5.5V16.5M16.5 11H5.5" stroke="" stroke-opacity="0.2" stroke-width="1.6"
                      stroke-linecap="round" />
              </svg>
            </button>
          </div>
        </div>

        <div class="flex md:space-x-32">
          <button type="submit" @click.prevent="addToCart()" v-show="user.id != null" class="flex w-1/3 justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-gray-200 shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Add to cart</button>
          <button type="submit" @click.prevent="back()" class="flex w-1/3 justify-center rounded-md bg-gray-200 px-3 py-1.5 text-sm font-semibold leading-6 text-indigo-600 shadow-sm hover:bg-gray-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Back</button>
        </div>
        <div class="flex md:space-x-52">
          <router-link :to="{ path: product.id + '/edit' }" v-show="user.role ==='admin'" tag="button" class="lex  justify-center rounded-md bg-green-500 text-gray-200 px-3 py-1.5">Edit </router-link>
          <button @click.prevent="deleteProduct()" v-show="user.role ==='admin'" class="flex  justify-center rounded-md bg-red-700 text-gray-200 px-3 py-1.5">Delete</button>

        </div>
      </form>
    </template>
  </FormLayout>
  </Layout>
</template>

<style scoped>

</style>