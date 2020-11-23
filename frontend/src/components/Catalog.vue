<template>
  <v-container>
    <v-row class="text-left">

      <v-divider></v-divider>
      <v-col cols="12">
        <CatalogProduct v-for="product in products" :product="product" :key="product.id" @add-to-cart='addToCart'></CatalogProduct>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
  import CatalogProduct from "@/components/CatalogProduct";

  export default {
    name: 'Catalog',
    props: ['products'], // тут принимаем массив со списком продуктов для каталога
    components: {
        CatalogProduct
    },
    methods: {
        addToCart(product) {
            this.$emit('add-to-cart', product);
        }
    }
  }
</script>
