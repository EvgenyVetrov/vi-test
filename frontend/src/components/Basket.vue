<template>
  <v-container>
    <v-row class="text-left">

      <v-col
              class="mb-5"
              cols="12"

      >
        <v-card
                elevation="2"
                outlined
                tile
        >
          <v-card-subtitle>
            <span>Шуруповерт Огонь аппарат 2000</span> <v-spacer></v-spacer> id: 1234
          </v-card-subtitle>
          <v-card-actions>
            <span>1095р.</span>
            <v-spacer></v-spacer>
            <v-btn
                    color="red lighten-2"
                    text
            >
              убрать
            </v-btn>

          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
    <v-divider></v-divider>
    <v-row class="text-right">
      <v-col>
        <p>Итого: 1095 р.</p><v-btn>Заказать</v-btn>
      </v-col>


    </v-row>

  </v-container>
</template>

<script>
  export default {
    name: 'Basket',

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
