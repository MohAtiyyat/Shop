<script >
import FormLayout from "@/layout/FormLayout.vue";
import axios from "axios";
import Layout from "@/layout/Layout.vue";
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { ExclamationTriangleIcon } from '@heroicons/vue/24/outline'

export default {
  name:'createProduct',
  components: { Layout, FormLayout, Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot, ExclamationTriangleIcon},
  created() {
    this.getProduct();
  },
  data(){
    return {
      open: false,
      pop: {
        head:'',
        msg:'',
        btn1:'',
        btn2:'',
        link:''
      },
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
        this.open = true;
        this.pop.head = "Product added to cart";
        this.pop.btn1 = "Go to Cart";
        this.pop.btn2 = "Ok";
        this.pop.link = "/cart";
      }).catch(errors => {
        this.pstErrMsg = errors.response;
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
    goToCart(){
      window.location.href = '/cart';
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
          <button type="submit" @click.prevent="back()" class="flex w-1/3 justify-center rounded-md bg-gray-300 px-3 py-1.5 text-sm font-semibold leading-6 text-indigo-600 shadow-sm hover:bg-gray-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Back</button>
        </div>
        <div class="flex md:space-x-52">
          <router-link :to="{ path: product.id + '/edit' }" v-show="user.role ==='admin'" tag="button" class="lex  justify-center rounded-md bg-green-500 text-gray-200 hover:bg-green-400 px-3 py-1.5">Edit </router-link>
          <button @click.prevent="deleteProduct()" v-show="user.role ==='admin'" class="flex  justify-center rounded-md bg-red-700 text-gray-200  hover:bg-red-600 px-3 py-1.5">Delete</button>
        </div>
      </form>

<!--      pop up-->
      <TransitionRoot as="template" :show="open">
        <Dialog class="relative z-10" @close="open = false">
          <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
          </TransitionChild>

          <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
              <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                <DialogPanel class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                  <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                      <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                        <DialogTitle as="h3" class="text-base font-semibold text-gray-900">{{pop.head}}</DialogTitle>
                        <div class="mt-2">
                          <p class="text-sm text-gray-500">{{pop.msg}}</p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="button" class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-gray-200 shadow-sm hover:bg-indigo-500 sm:ml-3 sm:w-auto" @click="this.goToCart">{{pop.btn1}}</button>
                    <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-gray-300 px-3 py-2 text-sm font-semibold text-indigo-600 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-200 sm:mt-0 sm:w-auto" @click="open = false" ref="cancelButtonRef">
                      {{ pop.btn2 }}</button>
                  </div>
                </DialogPanel>
              </TransitionChild>
            </div>
          </div>
        </Dialog>
      </TransitionRoot>
    </template>
  </FormLayout>
  </Layout>
</template>

<style scoped>

</style>