<template>
  <v-row>
    <v-col
            class="mb-5"
            cols="12"

    >
      <v-card
              elevation="2"
              outlined
              tile
      >
        <v-card-subtitle class="pb-0 text-center">
          <span>Заказ 1234 </span><span>(новый)</span>
        </v-card-subtitle>
        <v-card-text>
          <v-list-item  class="pt-0 pb-0">
            <v-list-item-content>
              <v-list-item-title>Шуруповерт макита макси 455</v-list-item-title>
              <v-list-item-subtitle>5000р. <span class="pl-5">id: 12345</span> </v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
          <v-list-item class="pt-0 pb-0">
            <v-list-item-content>
              <v-list-item-title>Бензопила лютик дизельная</v-list-item-title>
              <v-list-item-subtitle>3508р. <span class="pl-5">id: 45</span> </v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
        </v-card-text>
        <v-card-actions>
          <span>1095р.</span>
          <v-spacer></v-spacer>
          <v-btn
                  color="primary"
                  text
          >
            оплатить
          </v-btn>

        </v-card-actions>
      </v-card>


    </v-col>
  </v-row>
</template>

<script>
  export default {
    name: 'Orders',

    data: () => ({
      ecosystem: [
        {
          text: 'vuetify-loader',
          href: 'https://github.com/vuetifyjs/vuetify-loader',
        },
        {
          text: 'github',
          href: 'https://github.com/vuetifyjs/vuetify',
        },
        {
          text: 'awesome-vuetify',
          href: 'https://github.com/vuetifyjs/awesome-vuetify',
        },
      ],
    }),
  }
</script>
