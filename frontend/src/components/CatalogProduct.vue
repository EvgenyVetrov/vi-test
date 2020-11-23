<template>

  <v-card
          elevation="2"
          class="mb-3"
          outlined
          tile
  >
    <v-card-subtitle class="pb-0">
      <span>{{product.name}}</span> <v-spacer></v-spacer> id: {{product.id}}
    </v-card-subtitle>
    <v-card-actions>
      <span class="pl-2">{{product.price}}р.</span>
      <v-spacer></v-spacer>
      <v-btn
              color="green lighten-2"
              text
              @click="addToCart"
      >
        в корзину
      </v-btn>

    </v-card-actions>
  </v-card>
</template>

<script>
  export default {
    name: 'CatalogProduct',
    props: ['product'],
    methods: {
      addToCart() {
        this.$emit('add-to-cart', this.product);
      }
    }
  }
</script>
