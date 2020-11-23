<template>
  <v-app>
    <v-app-bar
      app
      color="primary"
      dark
    >
      <div class="d-flex align-center">
        <v-img
          alt="Vuetify Logo"
          class="shrink mr-2"
          contain
          src="https://cdn.vuetifyjs.com/images/logos/vuetify-logo-dark.png"
          transition="scale-transition"
          width="40"
        />

      </div>

      <v-spacer></v-spacer>

    </v-app-bar>

    <v-main>
      <router-view/>
    </v-main>
    <RequestResult :key="1" :serverResponce="this.notifyData.serverResponce" :message="this.notifyData.resultMessage" :openDialog="this.notifyData.openDialog"></RequestResult>
  </v-app>
</template>

<script>
//import HelloWorld from './components/HelloWorld';
import RequestResult  from "@/components/RequestResult";


export default {
  name: 'App',
  data () {
      return {
          notifyData: {
              serverResponce: null,
              resultMessage: null,
              openDialog: false,
          }
      }
  },
  components: {
    RequestResult,
  },
  methods: {
      notify(data) {
          this.notifyData = data;
      }
  }
};
</script>
