<template>
  <v-card class="elevation-12">
    <v-card-text>
      <div v-if="isLoggedin" class="right">
        <v-icon @click.prevent="toggleEditor()">edit</v-icon>
      </div>
      <span v-show="isMarkdownShown"
            v-html="htmlFromMarkdown"></span>
      <v-textarea label="Markdown Editor"
                  v-model="markdownText"
                  v-show="isEditorShown"
                  auto-grow></v-textarea>
      <v-card-actions>
        <v-btn v-if="id>0"
               color="success"
               v-show="isEditorShown"
               @click="updateNote()">Update
        </v-btn>
        <v-btn v-if="id==0"
               color="success"
               v-show="isEditorShown"
               @click="saveNote()">Save
        </v-btn>
      </v-card-actions>
    </v-card-text>
  </v-card>
</template>
<script>
import MarkdownIt from 'markdown-it'
import { mapState } from 'vuex'
export default {
  props: ['id', 'origMarkdownText'],
  data () {
    return {
      isMarkdownShown: true,
      isEditorShown: false,
      markdownText: this.origMarkdownText,
    }
  },
  computed: {
    htmlFromMarkdown: function () {
      let md = new MarkdownIt()
      return md.render(this.markdownText)
    },
    ...mapState(['isLoggedin']),
  },
  methods: {
    toggleEditor () {
      this.isEditorShown = !this.isEditorShown
      this.isMarkdownShown = !this.isMarkdownShown
    },
    saveNote () {
      this.isEditorShown = !this.isEditorShown
      this.isMarkdownShown = !this.isMarkdownShown
      let vue = this
      axios.post('/api/saveNote', {csrf: this.csrf, id: this.id, markdownText: this.markdownText}).
        then(function (response) {
          if (response.data.success === true) {
            vue.$emit("repullNotes")
            vue.markdownText = '';
          }
        }).
        catch(function (error) {
          console.log(error)
        })
    },
    updateNote: function() {
      this.isEditorShown = !this.isEditorShown
      this.isMarkdownShown = !this.isMarkdownShown
      let vue = this
      axios.post('/api/updateNote', {csrf: this.csrf, id: this.id, markdownText: this.markdownText}).
        then(function (response) {
          if (response.data.success === true) {
          }
        }).
        catch(function (error) {
          console.log(error)
        })
    }
  }
}
</script>
