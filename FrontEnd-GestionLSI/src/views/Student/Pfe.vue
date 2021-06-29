<template>
  <div>
    <NavBar />
    <table>
      <tbody>
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
      </tbody>
    </table>
  </div>
</template>

<script>
import NavBar from "@/components/NavBar.vue";

export default {
  name: "Pfe",
  components: {
    NavBar,
  },
  data() {
    return {
      object: {},
    };
  },
  methods: {
    getPfe() {
      this.$store.dispatch("retrievePfe").then((response) => {
        // console.log( response.data[0]);
        this.object = response.data[0];
        // return response.data[0];
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