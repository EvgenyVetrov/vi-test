<template>

  <v-card
          elevation="2"
          outlined
          tile
          class="mb-3"
  >
    <v-card-subtitle class="pb-0 text-center">
      <span>Заказ {{order.id}} </span><span>({{order.status_label}})</span>
    </v-card-subtitle>
    <v-card-text class="">
      <v-list-item v-for="product in order.products" :key="product.id" class="pt-0 pb-0">
        <v-list-item-content>
          <v-list-item-title>{{product.name}}</v-list-item-title>
          <v-list-item-subtitle>{{product.price}}р. <span class="pl-5">id: {{product.id}}</span> </v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>
      <p v-if="!this.order.products.length" class="red--text darken-4">
        Товаров в заказе нет. Вероятно они больше не существуют.
      </p>
      <!--<v-list-item class="pt-0 pb-0">
        <v-list-item-content>
          <v-list-item-title>Бензопила лютик дизельная</v-list-item-title>
          <v-list-item-subtitle>3508р. <span class="pl-5">id: 45</span> </v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>-->
    </v-card-text>
    <v-card-actions  class="pt-0" v-if="this.order.summ !== null">
      <span class="pl-2">Итого: {{order.summ}}р.</span>
      <v-spacer></v-spacer>
      <v-btn v-if="order.status == 0"
              color="primary"
              text
      >
        оплатить
      </v-btn>

    </v-card-actions>
  </v-card>
</template>

<script>
  export default {
    name: 'OneOrder',
    props: ['order'],
  }
</script>
