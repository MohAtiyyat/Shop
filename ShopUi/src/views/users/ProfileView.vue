<script>
import FormLayout from '@/layout/FormLayout.vue';
import axios from "axios";
import Layout from "@/layout/Layout.vue";
export default {
  name: "UserView",
  components:{Layout, FormLayout},
  data() {
    return{
      user: []
    }
  },
  created() {
    this.getUser();
  },
  methods:{
      async getUser() {

          const config = {
            headers: {
              'Authorization': `Bearer ${localStorage.getItem('token')}`,
              'Content-Type': 'application/json',

            },
          };
          await axios.get(`/user/profile`,
              config
          )
              .then((response) => {
                this.user.name = response.data.name;
                this.user.email = response.data.email;
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
      }
}
}
</script>

<template>
  <Layout>
    <FormLayout>
      <template #formBody>
        <form class="space-y-6">
          <div>
            <div class="flex items-center justify-between">
              <label for="userName" class="block text-2xl font-medium leading-6 text-gray-900">Name</label>
            </div>
            <div class="mt-2">
              <h1 id="userName" class="block w-full rounded-md py-1.5 text-gray-900 font-medium focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-xl sm:leading-6">
                {{user.name}}
              </h1>
            </div>
          </div>
          <div>
            <div class="flex items-center justify-between">
              <label for="userEmail" class="block text-2xl font-medium leading-6 text-gray-900">Email</label>
            </div>
            <div class="mt-2">
              <h1 id="userEmail" class="block w-full rounded-md py-1.5 text-gray-900 font-medium focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                {{user.email}}
              </h1>
            </div>
          </div>


          <div>
            <slot name="buttons"></slot>
          </div>
        </form>
      </template>
    </FormLayout>
  </Layout>
</template>

<style scoped>

</style>