<template>
  <NavBar />
  <div class="container">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Module</th>
          <th scope="col">note</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="Module in Modules" :key="Module">
          <td>{{ Module.module }}</td>
          <td>{{ Module.note }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import NavBar from "@/components/NavBar.vue";

export default {
  name: "Note",
  components: {
    NavBar,
  },
  data() {
    return {
      Modules: [],
    };
  },
  methods: {
    getNote() {
      this.$store.dispatch("retrieveNote").then((response) => {
        this.Modules = response.data;
      });
    },
  },
  beforeMount() {
    this.getNote();
  },
};
</script>
