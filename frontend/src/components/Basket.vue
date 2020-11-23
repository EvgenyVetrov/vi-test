<template>
  <v-container>
    <v-row class="text-left">
      <v-col cols="12">
      <BasketProduct v-for="product in products" :product="product" :key="product.id" @remove-product="removeProduct" ></BasketProduct>
      </v-col>
    </v-row>
    <v-divider></v-divider>
    <v-row class="text-right">
      <v-col>
        <p>Итого: {{summ}} р.</p><v-btn>Заказать</v-btn>
      </v-col>


    </v-row>

  </v-container>
</template>

<script>
    import BasketProduct from "@/components/BasketProduct";

  export default {
    name: 'Basket',
    props: ['products'],
    components: {
      BasketProduct
    },
    watch: {
      products() {
        var initialValue = 0;
        this.summ = this.products.reduce(
          (accumulator, currentValue) => accumulator + currentValue.price,
          initialValue
        );
      }
    },
    methods: {
      removeProduct(id) {
        this.$emit('remove-product', id);
      }
    },

    data: () => ({
      summ: 0
    }),
  }
</script>
