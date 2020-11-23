<template>
  <v-row justify="center">
    <v-dialog
            v-model="dialog"
            persistent
            max-width="290"
    >
      <v-card>
        <v-card-title class="headline">
          {{this.title}}
        </v-card-title>
        <v-card-text>{{this.showedMessage}}</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>

          <v-btn
                  color="green darken-1"
                  text
                  @click="dialog = false"
          >
            OK, принял
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
  export default {
    name: 'RequestResult',
    props: ['serverResponce', 'message', 'type', 'openDialog'],
    data () {
        return {
            dialog: false,
            timerId: null,
            title: 'Произошла ошибка',
            showedMessage: 'Что-то пошло не так'
        }
    },

    watch: {
        dialog (val) {
            if (!val) {
                this.timerId = null;
                return;
            }

            this.timerId = setTimeout(() => (this.dialog = false), 8000)
        },
        serverResponce() {
            this.dialog = this.openDialog ? true : false;
            this.showedMessage = this.message ? this.message : this.serverResponce.message;

            if (!this.type && this.serverResponce && !this.serverResponce.status) { this.title = 'Внимание!'; }
            if (this.type == "success" || this.serverResponce && this.serverResponce.status == "success") { this.title = 'Успешно завершено!'; }
            if (this.type == "warning" || this.serverResponce && this.serverResponce.status == "warning") { this.title = 'Есть нюансы'; }
            if (this.type == "error" || this.serverResponce && this.serverResponce.status == "error") { this.title = 'Ошибка'; }
        }
    },
  }
</script>
