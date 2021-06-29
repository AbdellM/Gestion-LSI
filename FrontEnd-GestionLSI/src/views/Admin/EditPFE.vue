<template>
  <NavBar />
  <div class="container mt-5">
    <form @submit.prevent="submitUpdatePfe">
      <div class="form-group">
        <label>Nouveau Etudiant</label>
        <select v-model="Etudiant" class="form-select" disabled>
          <option selected value="">
            {{ Selected.stdNom }} {{ Selected.stdPrenom }}
          </option>
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
        <label>Nouveau Professeur</label>
        <select v-model="Prof" class="form-select" required>
          <option selected value="">
            {{ Selected.prfNom }} {{ Selected.prfPrenom }}
          </option>
          <option v-for="Prof in Profs" :key="Prof" :value="Prof.id">
            {{ Prof.nom }} {{ Prof.prenom }}
          </option>
        </select>
      </div>
      <div class="form-group">
        <label>Nouveau Sujet</label>
        <input
          v-model="sujet"
          type="text"
          class="form-control"
          :palaceholder="Selected.sujet"
        />
      </div>
      <div class="form-group">
        <label>Nouvelle Date soutenance PFE</label>
        <input
          v-model="DateSoutenance"
          type="text"
          class="form-control"
          :palaceholder="Selected.dateP"
        />
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</template>

<script>
// @ is an alias to /src
import NavBar from "@/components/NavBar.vue";

export default {
  name: "EditPfe",
  components: {
    NavBar,
  },
  data() {
    return {
      Etudiants: [],
      Profs: [],
      Etudiant: "",
      Prof: "",
      Selected: {},
      sujet: "",
      DateSoutenance: "",
      id: "",
    };
  },
  methods: {
    submitUpdatePfe() {
      this.$store
        .dispatch("submitUpdatePfe", {
          id: this.id,
          data: this.getData(),
        })
        .then(() => {
          this.$router.push({ name: "GestionPfe" });
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
    getData() {
      let formData = new URLSearchParams();
      if (this.Etudiant) {
        formData.append("student_id", this.Etudiant);
      }
      if (this.Prof) {
        formData.append("prof_id", this.Prof);
      }
      if (this.sujet) {
        formData.append("sujet", this.sujet);
      }
      if (this.DateSoutenance) {
        formData.append("dateP", this.DateSoutenance);
      }
      return formData;
    },
  },
  beforeMount() {
    this.$store
      .dispatch("getPfeById", { id: (this.id = this.$route.params.id) })
      .then((response) => {
        this.Selected = response.data[0];
        this.sujet = response.data[0].sujet;
        this.DateSoutenance = response.data[0].dateP;
      });
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
