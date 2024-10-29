  <script >
    import axios from "axios";
    import Card from "@/components/Card.vue";
    import Layout from "@/layout/Layout.vue";
    export default {
      name: "SearchView",
      components: {Layout, Card},
      created() {
        this.getProducts()
      },
      data(){
        return{
          search:'',
          products:[],
          errorMsg:'',
          resLen:''
        }
      },

      methods:{
        async getProducts(){
          const search =this.$route.query.search;
          await axios.get(`/product/search?search=${search}`)
              .then((response) =>{
                this.products = response.data;
                this.resLen = response.data.length;
          })
              .catch(errors => {
                errors = errors.response.data.errors;
                for (const error in errors) {
                  console.log(errors[error])
                }
              })
        },
        searchPar(){
          window.location.replace(`/search?search=${this.search}`);
        }
      }
    }
  </script>

  <template>
    <Layout>
      <template #extra>
        <form class="max-w-md mx-auto">
          <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
          <div class="relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
              <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
              </svg>
            </div>
            <input type="search" name="search" v-model="search" id="search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search " required />
            <button type="submit" @click.prevent="searchPar()" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
          </div>
        </form>
      </template>
      <div v-if="resLen === 0">
        <p class="text-4xl font-black text-black text-center">Product Not Found </p>
        <br>
        <p class="text-xl  text-black text-center">Try search something else</p>
      </div>
      <div class="mt-16 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-4"  >
        <Card v-for="product in products" :key="product.id" :product-id="product.id" :product-name="product.name" :product-price="product.price" >
        </Card>
      </div>
    </Layout>
  </template>

<style scoped>

</style>