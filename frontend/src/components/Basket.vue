<template>
  <v-container>
    <v-row class="text-left">
      <v-col cols="12">
      <BasketProduct v-for="product in products" :product="product" :key="product.id" @remove-product="removeProduct" ></BasketProduct>
      </v-col>
    </v-row>
    <p class="pt-7 grey--text pr-10 pl-10 text-center" v-if="!this.products.length">корзина пуста</p>
    <v-container v-if="this.products.length">
      <v-divider></v-divider>
      <v-row class="text-right">
        <v-col>
          <p>Итого: {{summ}} р.</p><v-btn @click="order">Заказать</v-btn>
        </v-col>


      </v-row>
    </v-container>

  </v-container>
</template>

<script>
    import BasketProduct from "@/components/BasketProduct";
    import qs from 'qs';

  export default {
    name: 'Basket',
    props: ['products'],
    components: {
      BasketProduct
    },
    data () {
        return {
            orderResult: null,
            summ: 0
        }
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
      },
      order() {
        if (!this.products) { return; } // без товарв в корзине даже не пытаемся оформить заказ
        // фрмируем списк ид-шников товаров, которые надо купить
        let orderedProductsIds = [];
        this.products.forEach(function(item) {
            orderedProductsIds.push(item.id);
        });

        this.$axios.post('/default/order', qs.stringify({ 'products': orderedProductsIds }))
          .then(response => {
              this.orderResult = response.data;
              this.$root.$children[0].notify({
                  serverResponce: this.orderResult,
                  openDialog: true,
              });

              // рассылаем событие обновления данных сайта
              this.$emit('update-site-data', true);
              this.$emit('clear-basket', true);
          })
          .catch(error => {
              this.orderResult = error;
              this.$root.$children[0].notify({
                  serverResponce: this.orderResult,
                  resultMessage: 'Не удалось выполнить запрос',
                  openDialog: true,
              })
          });
      }
    },
  }
</script>
