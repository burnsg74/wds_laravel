<template>
  <v-container fluid
               fill-height>
    <v-layout align-center
              justify-center
              row
              wrap>
      <v-flex xs12>
        <v-card class="elevation-12"
                v-show="isLoggedFormShown">
          <v-toolbar dark
                     color="primary">
            <v-toolbar-title>Login form</v-toolbar-title>
          </v-toolbar>
          <v-card-text>
            <v-form>
              <v-text-field prepend-icon="person"
                            v-model="email"
                            name="email"
                            label="Email"
                            type="text"></v-text-field>
              <v-text-field prepend-icon="lock"
                            v-model="password"
                            name="password"
                            label="Password"
                            id="password"
                            type="password"></v-text-field>
            </v-form>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="primary"
                   @click="submit">Login
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-flex>
      <v-flex v-if="isLoggedin" xs12 pa-2 mb-2>
        <markdown-editor v-if="isLoggedin"
                         v-on:repullNotes="repullNotes()"
                         id=0
                         origMarkdownText=""></markdown-editor>
      </v-flex>
      <v-flex xs12 pa-2 mb-2
              v-for="note in notes" v-bind:key="note.id">
        <markdown-editor :id=note.id
                         :origMarkdownText=note.markdown></markdown-editor>
      </v-flex>
    </v-layout>
  </v-container>
</template>
<script>
import { mapState } from 'vuex'

export default {
  name: 'Home',
  computed: mapState(['isLoggedFormShown', 'isLoggedin']),
  data () {
    return {
      csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      password: '',
      email: '',
      notes: null
    }
  },
  mounted () {
    axios.get('/api/getNotes').then(response => (this.notes = response.data))
  },
  methods: {
    submit () {
      let vue = this
      axios.post('/api/login', {csrf: this.csrf, password: this.password, email: this.email}).then(function (response) {
        if (response.data.success === true) {
          vue.$store.commit('isLoggedin')
          vue.showLogin = false
          vue.$store.commit('setLoggedFormShown', false)
        }
      }).catch(function (error) {
        console.log(error)
      })
    },
    showLoginForm () {
      this.showLogin = true
    },
    repullNotes: function () {
      console.log('Repull')
      axios.get('/api/getNotes').then(response => (this.notes = response.data))
    }
  }
}
</script>
