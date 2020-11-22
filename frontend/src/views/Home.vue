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
      <v-col cols="12" md="4" sm="6"><h3>каталог</h3></v-col>
      <v-col cols="12" md="4" sm="6"><h3>корзина</h3></v-col>
      <v-col cols="12" md="4" sm="6"><h3>заказы</h3></v-col>
    </v-row>
  </v-container>
</template>

<script>
// @ is an alias to /src
//import HelloWorld from '@/components/HelloWorld.vue'
//import StoreCarcass from "../components/StoreCarcass";

export default {
  name: 'Home',
  /*data() => {
    'fullResp'
  },*/
  components: {
    //  StoreCarcass,
    //HelloWorld
  },
  mounted() {
      //alert(process.env.VUE_APP_APIDOMAIN);
      //alert(process.env.VUE_APP_TEST);

      //var api_domain = "http://api.vi-test.loc/v1";
      this.$axios
          .get('/default/site-data')
          .then(response => (this.info = response.data.bpi));
  }
}
</script>
