<template>
  <div class="container mt-5">
    <form @submit.prevent="submitNewPfe">
      <div class="form-group">
        <label>Etudiant</label>
        <select v-model="Etudiant" class="form-select">
          <option disabled value="">Sélectionnez un Etudiant</option>
          <option
            v-for="Etudiant in Etudiants"
            :key="Etudiant"
            :value="Etudiant.id"
          >
            {{ Etudiant.nom }} {{ Etudiant.prenom }}
          </option>
        </select>
      </div>
      <div class="form-group">
        <label>Professeur</label>
        <select v-model="Prof" class="form-select">
          <option disabled value="">Sélectionnez un Prof</option>
          <option v-for="Prof in Profs" :key="Prof" :value="Prof.id">
            {{ Prof.nom }} {{ Prof.prenom }}
          </option>
        </select>
      </div>
      <div class="form-group">
        <label>Sujet</label>
        <input v-model="sujet" type="text" class="form-control" />
      </div>
      <div class="form-group">
        <label>Date soutenance PFE</label>
        <input
          placeholder="aaaa-mm-jj"
          v-model="DateSoutenance"
          type="text"
          class="form-control"
        />
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</template>
<script>
export default {
  name: "AddPfe",
  data() {
    return {
      Etudiants: [],
      Profs: [],
      Etudiant: "",
      Prof: "",
      sujet: "",
      DateSoutenance: "",
    };
  },
  methods: {
    submitNewPfe() {
      this.$store.dispatch("submitNewPfe", {
        student_id: this.Etudiant,
        prof_id: this.Prof,
        sujet: this.sujet,
        dateP: this.DateSoutenance,
      });
    },
    getStudentsS5() {
      this.$store.dispatch("getStudentsS5").then((response) => {
        this.Etudiants = response.data;
      });
    },
    getAllProfs() {
      this.$store.dispatch("getAllProfs").then((response) => {
        this.Profs = response.data;
      });
    },
  },
  beforeMount() {
    this.getStudentsS5();
    this.getAllProfs();
  },
};
</script>
<style scoped>
label {
  display: flex;
  margin-top: 20px;
}
select {
  display: flex;
  margin-top: 20px;
}
button {
  display: flex;
  margin-top: 20px;
}
</style>