<template>
  <v-container style="max-width: 1024px">

    <v-row class="text-center">
      <v-col>
        <v-img
                :src="require('../assets/logo.svg')"
                class="my-3"
                contain
                height="100"
        />
      </v-col>

      <v-col class="mb-4">
        <h1 class="display-2 font-weight-bold mb-3">
          Vi-test
        </h1>

        <p class="subheading font-weight-regular">
          Микроприложение для генерации, заказа и оплаты товаров.
        </p>

        <GenerateBtn @update-site-data="getSiteData"></GenerateBtn>
      </v-col>
    </v-row>

    <v-row>
      <v-col cols="12" md="4" sm="6" style="background-color: rgba(207,71,78,0.3)"><h3>каталог</h3>
        <Catalog :products="siteData.products_list" @add-to-cart="addToCart" />
      </v-col>
      <v-col cols="12" md="4" sm="6" style="background-color: rgba(162,92,118,0.31)"><h3>корзина</h3>
        <Basket :products="basketList" @remove-product="removeFromCart" @update-site-data="getSiteData"  @clear-basket="clearBasket" />
      </v-col>
      <v-col cols="12" md="4" sm="6" style="background-color: rgba(118,128,182,0.31)"><h3>заказы</h3>
        <Orders :orders="siteData.orders_list" />
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
// @ is an alias to /src
//import HelloWorld from '@/components/HelloWorld.vue'
import Catalog      from "@/components/Catalog";
import Basket       from "@/components/Basket";
import Orders       from "@/components/Orders";
import GenerateBtn  from "@/components/GenerateBtn";

export default {
  name: 'Home',
  data() {
    return {
      siteData: [{products_list: []}, {orders_list: []}],
      basketList: []
    }
  },
  components: {
    Catalog,
    Basket,
    Orders,
    GenerateBtn,
  },
  mounted() {
    this.getSiteData();
  },
  methods: {
    getSiteData() {
      this.$axios
          .get('/default/site-data')
          .then(response => (this.siteData = response.data));
    },
    addToCart(product) {
      // функция поиска по массиву объектов
      let getObjectByPropertyValue = function(array, propertyName, propertyValue) {
        return array.find((o) => { return o[propertyName] === propertyValue })
      }

      if (getObjectByPropertyValue(this.basketList, "id", product.id)) {
          alert('товар уже в корзине');
      } else {
          this.basketList.push(product);
      }
    },
    removeFromCart(id)
    {
        // удаляем объект с нужным ID из массива объектов
        let index = this.basketList.findIndex(n => n.id === id);
        if (index !== -1) {
            this.basketList.splice(index, 1);
        }
    },
    clearBasket() {
      this.basketList = [];
    }
  }
}
</script>
