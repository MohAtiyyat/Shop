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
          products:[],
          errorMsg:''
        }
      },

      methods:{
        getProducts(){
          const search =this.$route.query.search;
          const config = {
            headers: {
              'Authorization': `Bearer ${localStorage.getItem('token').slice(1,-1)}`,
              'Content-Type': 'application/json',
            },
          };
          axios.get(`http://127.0.0.1:8000/api/product/search?search=${search}`)
              .then((response) =>{
            this.products = response.data
          })
              .catch(errors => {
                errors = errors.response.data.errors;
                for (const error in errors) {
                  console.log(errors[error])
                }
              })
        },
      }
    }
  </script>

  <template>
    <Layout>
      <div class="mt-16 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-4"  >
        <Card v-for="product in products" :key="product.id" :product-id="product.id" :product-name="product.name" :product-price="product.price" >
        </Card>
      </div>
    </Layout>
  </template>

<style scoped>

</style>