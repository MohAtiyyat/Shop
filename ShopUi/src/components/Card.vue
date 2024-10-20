<template>
  <div class="select-none mb-6 w-full">
    <div class="px-4 -mt-16 relative">
      <div class="bg-white rounded-lg shadow-lg border">
        <div class="p-5">

          <a class="text-gray-800 block mt-2 truncate hover:underline font-medium text-lg" href="#">
            {{productName}}
          </a>
        </div>

        <div class="flex justify-between items-center pb-3 px-4">
          <div>
            <div class="text-gray-800 text-lg">
              <span class="font-medium">${{productPrice/100}}</span>
            </div>
          </div>
          <div>
            <slot name="button"></slot>
          </div>
          <div>
            <router-link :to="{ path: '/product/' + productId }">View Product &rarr;</router-link>

          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default{
  name: "Card",
  props:[
    'productName','productPrice','productId'
  ]
}
</script>

<style lang="scss" scoped>

</style>