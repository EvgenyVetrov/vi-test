<template>
  <v-row>
    <v-col
            class="mb-5"
            cols="12"

    >
      <OneOrder v-for="order in orders" :key="order.id" :order="order"></OneOrder>



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
