<template>
  <v-row>
    <v-col
            class="mb-5"
            cols="12"

    >
      <OneOrder v-for="order in orders" :key="order.id" :order="order" @update-site-data="emitGetSiteData"></OneOrder>

      <p class="pt-10 grey--text pr-10 pl-10 text-center" v-if="this.orders && !this.orders.length">вы еще не делали заказы</p>

    </v-col>
  </v-row>
</template>

<script>
  import OneOrder from "@/components/OneOrder";

  export default {
    name: 'Orders',
    props: ['orders'],
    components: {
        OneOrder
    },
    methods: {
        emitGetSiteData() {
            // рассылаем событие обновления данных сайта
            this.$emit('update-site-data', true);
        }
    }
  }
</script>
