<template>
  <v-layout row>
    <v-flex shrink
            pa-1>
      <h1>
        <router-link to="/"
                     style="text-decoration: none; color: darkslategrey;">Web Dev Source
        </router-link>
      </h1>
    </v-flex>
    <v-flex grow
            pa-1></v-flex>
    <span v-if="isLoggedin">
    <v-flex shrink
            pa-1>
      <v-icon color="green"
              @click.prevent="logout()">lock</v-icon>
    </v-flex>
    </span>
    <span v-else>
    <v-flex shrink
            pa-1>
      <v-icon @click="showLoginForm()">lock</v-icon>
    </v-flex>
    </span>
  </v-layout>
</template>
<script>
import { mapState } from 'vuex'

export default {
  name: 'TopNav',
  computed: mapState(['isLoggedin']),
  methods: {
    logout () {
      this.$store.commit('isLoggedout')
      axios.get('/api/logout')
      this.$router.push('/')
    },
    showLoginForm () {
      this.$store.commit('setLoggedFormShown', true)
    }
  }
}
</script>
