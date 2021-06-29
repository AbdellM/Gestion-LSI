<template>
  <div>
    <NavBar />
    <table>
      <tbody v-for="object in array" :key="object">
        <tr>
          <th scope="col">Etudinat : Nom et Prenom :</th>
          <td>{{ object.stdNom }} {{ object.stdPrenom }}</td>
        </tr>
        <tr>
          <th scope="col">Professeur encadrant : Nom et Prenom :</th>
          <td>{{ object.prfNom }} {{ object.prfPrenom }}</td>
        </tr>
        <tr>
          <th scope="col">Sujet :</th>
          <td>{{ object.sujet }}</td>
        </tr>
        <tr>
          <th scope="col">Date de présentation :</th>
          <td>{{ object.dateP }}</td>
        </tr>
        <hr />
      </tbody>
    </table>
  </div>
</template>

<script>
import NavBar from "@/components/NavBar.vue";

export default {
  name: "PfeProf",
  components: {
    NavBar,
  },
  data() {
    return {
      array: [],
    };
  },
  methods: {
    getPfe() {
      this.$store.dispatch("retrievePfeProf").then((response) => {
        this.array = response.data;
      });
    },
  },
  beforeMount() {
    this.getPfe();
  },
};
</script>

<style>
table {
  margin: 5%;
}
</style>