<script >
import axios from "axios";
import FormLayout from "@/layout/FormLayout.vue"
import Layout from "@/layout/Layout.vue";

export default {
  name:"UserView",
  components: {FormLayout, Layout},
  data(){
    return {
      CUR: localStorage.getItem('role'),
      product:[],
      formData: {
        'name': '',
        'Email': '',
        'banned':''
      },
      errors:{
        'name':null,
        'Email':null,
      },
      redirect: '/home'
    }
  },
  created() {
    this.getUser();
  },
  methods: {
    async getUser(){
      const pathArray = window.location.pathname.split('/');
      const id = pathArray[2]
      const config = {
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('token')}`,
          'Content-Type': 'application/json',
        },
      };
      await axios.get(`/user/${id}`,
          config
      ).then((response) => {
        this.formData = response.data.user;
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
    },
    async save() {
      const pathArray = window.location.pathname.split('/');
      const id = pathArray[2]
      console.log(this.formData)
      const config = {
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('token')}`,
          'Content-Type': 'application/json',
        },
      };
      const user = {name:this.formData.name, email: this.formData.email,banned : this.formData.banned};
      await axios.put(`http://127.0.0.1:8000/api/user/${id}/update`,
          user,
          config
      )
          .then(() => {
            window.location.href = '/home';
            alert("user edited")
          }).catch(errs => {
            const errors = errs.response.data.errors;
            if(errs.status === 422) {
              if (errors.name !== undefined) {
                this.errors.name = errors.name[0];
              }
              if (errors.email !== undefined) {
                this.errors.eamil = errors.email[0];
              }
            }else if(errors.status === 401){
              localStorage.clear()
              window.location.href = '/user/login';
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
            <label for="UserName" class="block text-sm font-medium leading-6 text-gray-900">Name</label>
            <div class="mt-2">
              <input id="UserName" name="productName" type="text" required="" v-model="formData.name"
                     class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
              <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert" v-if="errors.name">
                <span class="block sm:inline">{{errors.name}}</span>
              </div>
            </div>
          </div>

          <div>
            <div class="flex items-center justify-between">
              <label for="UserEmail" class="block text-sm font-medium leading-6 text-gray-900">Email</label>
            </div>
            <div class="mt-2">
            <textarea id="UserEmail" name="productEmail" v-model="formData.email"
                      class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert" v-if="errors.email">
              <span class="block sm:inline">{{errors.email}}</span>
            </div>
          </div>
          <div v-show="CUR !== 'admin'">
            <label for="productPrice" class="block text-sm font-medium leading-6 text-gray-900">ban</label>

            <div class="flex items-center mb-4">
              <input :checked="formData.banned === 1" v-model="formData.banned" id="default-radio-1" type="radio" value="1" name="default-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2  dark:border-gray-600">
              <label for="default-radio-1" class="ms-2 text-sm font-medium text-gray-900 ">Yes</label>
            </div>
            <div class="flex items-center">
              <input  :checked="formData.banned === 0" v-model="formData.banned" id="default-radio-2" type="radio" value="0" name="default-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2  dark:border-gray-600">
              <label for="default-radio-2" class="ms-2 text-sm font-medium text-gray-900">No</label>
            </div>
          </div>

          <div class="flex md:space-x-32 ">
            <button type="submit" @click.prevent="save()" class="flex w-1/3 justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-gray-300 shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
            <button type="submit" @click.prevent="cancel()" class="flex w-1/3 justify-center rounded-md bg-gray-300 px-3 py-1.5 text-sm font-semibold leading-6 text-indigo-600 shadow-sm hover:bg-gray-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Cancel</button>
          </div>
        </form>
      </template>
    </FormLayout>
  </Layout>
</template>

<style scoped>

</style>