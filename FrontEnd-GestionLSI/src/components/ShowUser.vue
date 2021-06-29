<template>
  <div class="container mt-5">
    <form>
      <div class="form-group">
        <select v-model="role" @click="getAllUsers">
          <option disabled value="">Ajouter un ...</option>
          <option value="student">Etudiant</option>
          <option value="prof">Professeur</option>
          <option value="admin">Admin</option>
        </select>
      </div>
    </form>
    <ShowTable
      v-if="role == 'student'"
      :tableHeader="tableHeaderStudent"
      :objects="Students"
      type="student"
    />
    <ShowTable
      v-if="role == 'prof'"
      :tableHeader="tableHeaderProf"
      :objects="Profs"
      type="prof"
    />
    <ShowTable
      v-if="role == 'admin'"
      :tableHeader="tableHeaderAdmin"
      :objects="Admins"
      type="admin"
    />
  </div>
</template>

<script>
import ShowTable from "@/components/ShowTable.vue";

export default {
  name: "ShowUser",
  components: {
    ShowTable,
  },
  data() {
    return {
      role: "",
      Students: [],
      Profs: [],
      Admins: [],
      tableHeaderStudent: [
        "Nom",
        "Prenom",
        "Email",
        "Date de naissance",
        "CNE",
        "Semestre",
      ],
      tableHeaderProf: ["Nom", "Prenom", "Email", "Modules"],
      tableHeaderAdmin: ["Nom", "Prenom", "Email"],
    };
  },
  methods: {
    getAllUsers() {
      switch (this.role) {
        case "student":
          this.$store.dispatch("getAllStudents").then((response) => {
            this.Students = response.data;
          });
          break;
        case "prof":
          this.$store.dispatch("getAllProfs").then((response) => {
            this.Profs = response.data;
          });
          break;
        case "admin":
          this.$store.dispatch("getAllAdmins").then((response) => {
            this.Admins = response.data;
          });
          break;
      }
    },
  },
};
</script>

<style>
</style>