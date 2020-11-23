<template>
  <v-container>

    <v-btn
            :disabled="dialog"
            :loading="dialog"
            class="white--text"
            color="success"
            @click="startGenerate"
    >
      сгенерировать товары
    </v-btn>
    <v-dialog
            v-model="dialog"
            hide-overlay
            persistent
            width="300"
    >
      <v-card
              color="primary"
              dark
      >
        <v-card-text>
          <br>
          <v-progress-linear
                  indeterminate
                  color="white"
                  class="mb-0"
          ></v-progress-linear>
        </v-card-text>
      </v-card>
    </v-dialog>
    </v-container>
</template>

<script>
  export default {
    name: 'GenerateBtn',
    data () {
        return {
            dialog: false,
            generatorResult: null,
            productsCounter: null,
            resultMessage: null,
            generateNumber:  5, // сколько генерить за раз
        }
    },
    methods: {
      startGenerate: function () {
        this.generatorResult = null;
        this.dialog = true;

          this.$axios
              .get('/default/generate-products?number='+this.generateNumber)
              .then(response => {
                  this.generatorResult = response.data;
                  this.productsCounter = response.data.counter;
                  this.dialog = false;
                  this.resultMessage = 'Сгенерировано товаров: ' + this.productsCounter;

                  this.$root.$children[0].notify({
                      serverResponce: this.generatorResult,
                      resultMessage: this.resultMessage,
                      openDialog: true,
                  });
                  // рассылаем событие обновления данных сайта
                  this.$emit('update-site-data', true);
              })
              .catch(error => {
                  this.generatorResult = error;
                  this.productsCounter = null;
                  this.dialog = false
              });
      }
    }
  }
</script>
