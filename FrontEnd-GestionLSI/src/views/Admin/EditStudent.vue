<template>
  <NavBar />
  <div class="container mt-5">
    <form @submit.prevent="submitUpdateStudent">
      <div class="form-group">
        <label>Nouveau Nom</label>
        <input v-model="nom" type="text" class="form-control" />
      </div>
      <div class="form-group">
        <label>Nouveau Prénom</label>
        <input v-model="prenom" type="text" class="form-control" />
      </div>
      <div class="form-group">
        <label>Nouveau Email</label>
        <input v-model="email" type="text" class="form-control" />
      </div>
      <div class="form-group">
        <label>Nouveau Mot de passe</label>
        <input v-model="pdw" type="password" class="form-control" />
      </div>
      <div class="form-group">
        <label>Nouvelle Date de naissance</label>
        <input
          v-model="datedenaissance"
          placeholder="aaaa-mm-dd"
          type="text"
          class="form-control"
        />
      </div>
      <div>
        <div class="form-group">
          <label>Nouveau CNE</label>
          <input v-model="cne" type="text" class="form-control" />
        </div>
        <div class="form-group">
          <label>Modifier Semestre</label>
          <select v-model="semestre">
            <option :value="i + 1" v-for="(Semestre, i) in Semestres" :key="i">
              {{ Semestre }}
            </option>
          </select>
        </div>
      </div>

      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</template>

<script>
// @ is an alias to /src
import NavBar from "@/components/NavBar.vue";

export default {
  name: "EditStudent",
  components: {
    NavBar,
  },
  data() {
    return {
      nom: "",
      prenom: "",
      email: "",
      datedenaissance: "",
      pdw: "",
      cne: "",
      semestre: "",
      Semestres: ["S1", "S2", "S3", "S4", "S5"],
    };
  },
  methods: {
    submitUpdateStudent() {
      this.$store
        .dispatch("submitUpdateStudent", {
          id: this.id,
          data: this.getData(),
        })
        .then(() => {
          this.$router.push({ name: "GestionUser" });
        });
    },
    getData() {
      let formData = new URLSearchParams();
      if (this.nom) {
        formData.append("nom", this.nom);
      }
      if (this.prenom) {
        formData.append("prenom", this.prenom);
      }
      if (this.email) {
        formData.append("email", this.email);
      }
      if (this.pdw) {
        formData.append("password", this.pdw);
      }
      if (this.cne) {
        formData.append("cne", this.cne);
      }
      if (this.datedenaissance) {
        formData.append("dateN", this.datedenaissance);
      }
      if (this.semestre) {
        formData.append("semestre_id", this.semestre);
      }
      return formData;
    },
  },
  beforeMount() {
    this.$store
      .dispatch("getStudentById", { id: (this.id = this.$route.params.id) })
      .then((response) => {
        this.nom = response.data[0].nom;
        this.prenom = response.data[0].prenom;
        this.email = response.data[0].email;
        this.cne = response.data[0].cne;
        this.datedenaissance = response.data[0].dateN;
        this.semestre = response.data[0].semestre;
      });
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
