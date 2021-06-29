<template>
  <NavBar />
  <div class="container mt-5">
    <form @submit.prevent="submitUpdateProf">
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
        <input v-model="pdw" type="passwoord" class="form-control" />
      </div>
      <div class="form-group">
        <label>Modifier le Module à renseigner</label>
        <select v-model="module" multiple>
          <option :value="Module.nom" v-for="(Module, i) in Modules" :key="i">
            {{ Module.nom }} -------------- S{{ Module.semestre_id }}
          </option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</template>

<script>
// @ is an alias to /src
import NavBar from "@/components/NavBar.vue";

export default {
  name: "EditProf",
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
      module: "",
      Modules: [],
    };
  },
  methods: {
    submitUpdateProf() {
      this.$store
        .dispatch("submitUpdateProf", {
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
      if (this.module) {
        for (let index = 0; index < this.module.length; index++) {
          formData.append(`module[${index}]`, this.module[index]);
        }
      }
      return formData;
    },
    getAllModule() {
      this.$store.dispatch("getAllModule").then((response) => {
        this.Modules = response.data;
      });
    },
  },
  beforeMount() {
    this.$store
      .dispatch("getProfyId", { id: (this.id = this.$route.params.id) })
      .then((response) => {
        this.nom = response.data[0].nom;
        this.prenom = response.data[0].prenom;
        this.email = response.data[0].email;
      });
    this.getAllModule();
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
