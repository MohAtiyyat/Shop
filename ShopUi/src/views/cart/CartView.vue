<script >

import axios from "axios";
import Card from "@/components/Card.vue";
import Layout from "@/layout/Layout.vue";
export default {
  name:'Products',
  components: {Layout, Card},
  created() {
    this.getProducts()
  },
  data(){
    return{
      products:[],
      errorMsg:''
    }
  },

  methods:{
    getProducts(){
      const config = {
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('token').slice(1,-1)}`,
          'Content-Type': 'application/json',
        },
      };
      axios.get('http://127.0.0.1:8000/api/cart',
      config).
      then((response) =>{
        this.products = response.data
      })
          .catch(errors => {
            errors = errors.response.data.errors;
            for (const error in errors) {
              console.log(errors[error])
            }
          })
    },
    removeFromCart(){const config = {
      headers: {
        'Authorization': `Bearer ${localStorage.getItem('token').slice(1,-1)}`,
        'Content-Type': 'application/json',
      },
    };
      const productId = document.getElementById("removeBtn").value
      axios.put('http://127.0.0.1:8000/api/cart/update',
          {'product_id': `${productId}`,
            'quantity': 0},
          config
      ).then((response) => {
        this.msg = response.data;
        location.reload();
      }).catch(errors => {
        this.pstErrMsg = errors.response.data.errors;
        for (const error in errors) {
          console.log(errors[error])
        }
      });
    },
  }
}
</script>

<template>
  <Layout>
    <div class="mt-16 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-4"  >
      <Card v-for="product in products" :key="product.id" :product-id="product.id" :product-name="product.name" :product-price="product.price" >
        <template #button>
          <button @click="removeFromCart" id="removeBtn" type="submit" :value="product.id" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-gray-300 shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"> remove</button>
        </template>
      </Card>
    </div>
  </Layout>
</template>
