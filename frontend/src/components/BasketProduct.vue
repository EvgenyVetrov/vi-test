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
      <v-btn @click="removeProduct"
              color="red lighten-2"
              text
      >
        убрать
      </v-btn>

    </v-card-actions>
  </v-card>
</template>

<script>
  export default {
    name: 'CatalogProduct',
    props: ['product'],
    methods: {
      removeProduct() {
          this.$emit('remove-product', this.product.id);
      }
    }
  }
</script>
