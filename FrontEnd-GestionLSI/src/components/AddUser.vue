<template>
  <div class="container mt-5">
    <form @submit.prevent="submitNewUser">
      <div class="form-group">
        <select v-model="role">
          <option disabled value="">Ajouter un ...</option>
          <option value="student">Etudiant</option>
          <option value="prof">Professeur</option>
          <option value="admin">Admin</option>
        </select>
      </div>

      <div class="form-group">
        <label>Nom</label>
        <input v-model="nom" type="text" class="form-control" />
      </div>
      <div class="form-group">
        <label>Prénom</label>
        <input v-model="prenom" type="text" class="form-control" />
      </div>
      <div class="form-group">
        <label>Email</label>
        <input v-model="email" type="email" class="form-control" />
      </div>
      <div class="form-group">
        <label>Mot de passe</label>
        <input v-model="pdw" type="password" class="form-control" pa />
      </div>
      <div class="form-group">
        <label>Date de naissance</label>
        <input
          v-model="datedenaissance"
          placeholder="aaaa-mm-dd"
          type="text"
          class="form-control"
        />
      </div>

      <div v-if="role == 'student'">
        <div class="form-group">
          <label>CNE</label>
          <input v-model="cne" type="text" class="form-control" />
        </div>
        <div class="form-group">
          <label>Semestre</label>
          <select v-model="semestre">
            <option
              :value="Semestre"
              v-for="(Semestre, i) in Semestres"
              :key="i"
            >
              {{ Semestre }}
            </option>
          </select>
        </div>
      </div>
      <div v-if="role == 'prof'">
        <div class="form-group">
          <label>Module à renseigner</label>
          <select class="selectpicker" v-model="module" multiple>
            <option :value="Module.nom" v-for="(Module, i) in Modules" :key="i">
              {{ Module.nom }} -------------- S{{ Module.semestre_id }}
            </option>
          </select>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</template>
<script>
export default {
  name: "AddUser",
  data() {
    return {
      role: "",
      nom: "",
      prenom: "",
      email: "",
      datedenaissance: "",
      pdw: "",
      cne: "",
      semestre: "",
      module: [],
      Modules: [],
      Semestres: ["S1", "S2", "S3", "S4", "S5"],
    };
  },
  methods: {
    submitNewUser() {
      switch (this.role) {
        case "student":
          this.addNewStudent();
          break;
        case "prof":
          this.addNewProf();
          break;
        case "admin":
          this.addNewAdmin();
          break;
      }
    },
    addNewStudent() {
      this.$store.dispatch("addNewStudent", {
        data: this.getData(),
      });
    },
    addNewProf() {
      this.$store.dispatch("addNewProf", {
        data: this.getData(),
      });
    },
    addNewAdmin() {
      this.$store.dispatch("addNewAdmin", {
        data: this.getData(),
      });
    },
    getData() {
      let formData = new FormData();

      formData.append("nom", this.nom);
      formData.append("prenom", this.prenom);
      formData.append("email", this.email);
      formData.append("password", this.pdw);
      formData.append("dateN", this.datedenaissance);
      formData.append("role", this.role);

      switch (this.role) {
        case "student":
          formData.append("cne", this.cne);
          formData.append("semestre", this.semestre);
          break;
        case "prof":
          for (let index = 0; index < this.module.length; index++) {
            formData.append(`module[${index}]`, this.module[index]);
          }
          break;
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