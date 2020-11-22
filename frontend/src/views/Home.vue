<template>
  <v-container style="max-width: 1024px">

    <v-row class="text-center">
      <v-col>
        <v-img
                :src="require('../assets/logo.svg')"
                class="my-3"
                contain
                height="200"
        />
      </v-col>

      <v-col class="mb-4">
        <h1 class="display-2 font-weight-bold mb-3">
          Vi-test
        </h1>

        <p class="subheading font-weight-regular">
          Микроприложение для генерации, заказа и оплаты товаров.
        </p>

        <v-btn tile
               color="success">
          сгенерировать товары

        </v-btn>
      </v-col>
    </v-row>

    <v-row>
      <v-col cols="12" md="4" sm="6" style="background-color: rgba(207,71,78,0.3)"><h3>каталог</h3>
        <Catalog/>
      </v-col>
      <v-col cols="12" md="4" sm="6" style="background-color: rgba(162,92,118,0.31)"><h3>корзина</h3>
        <Basket/>
      </v-col>
      <v-col cols="12" md="4" sm="6" style="background-color: rgba(118,128,182,0.31)"><h3>заказы</h3>
        <Orders/>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
// @ is an alias to /src
//import HelloWorld from '@/components/HelloWorld.vue'
import Catalog from "@/components/Catalog";
import Basket  from "@/components/Basket";
import Orders  from "@/components/Orders";

export default {
  name: 'Home',
  /*data() => {
    'fullResp'
  },*/
  components: {
    Catalog,
    Basket,
    Orders,
  },
  mounted() {
      this.$axios
          .get('/default/site-data')
          .then(response => (this.info = response.data.bpi));
  }
}
</script>
