<template>
  <div
    class="navbar navbar-expand-lg navbar-dark bg-dark"
    style="padding: 1rem 1rem; height: 0; min-height: 7vh"
  >
    <div class="container-fluid">
      <a class="navbar-brand" href="/login">Cycle LSI</a>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div
        class="collapse navbar-collapse justify-content-between"
        id="navbarSupportedContent"
      >
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <router-link class="nav-link" to="Profile">Profile</router-link>
          </li>

          <!-- STUDENT  -->
          <li class="nav-item" v-if="role == 'student'">
            <router-link class="nav-link" to="note">Note</router-link>
          </li>
          <li class="nav-item" v-if="role == 'student'">
            <router-link class="nav-link" to="EmploiStudent"
              >Emploi</router-link
            >
          </li>
          <li class="nav-item" v-if="role == 'student'">
            <router-link class="nav-link" to="Pfe">PFE</router-link>
          </li>

          <!-- PROF -->
          <li class="nav-item" v-if="role == 'prof'">
            <router-link class="nav-link" to="addnote">Note</router-link>
          </li>
          <li class="nav-item" v-if="role == 'prof'">
            <router-link class="nav-link" to="EmploiProf">Emploi</router-link>
          </li>
          <li class="nav-item" v-if="role == 'prof'">
            <router-link class="nav-link" to="PfeProf">PFE</router-link>
          </li>

          <!-- ADMIN -->
          <li class="nav-item" v-if="role == 'admin'">
            <router-link class="nav-link" to="GestionUser"
              >Gestion Utilisateur</router-link
            >
          </li>
          <li class="nav-item" v-if="role == 'admin'">
            <router-link class="nav-link" to="GestionPfe"
              >Gestion PFE</router-link
            >
          </li>
          <li class="nav-item" v-if="role == 'admin'">
            <router-link class="nav-link" to="GestionEmploi"
              >Gestion Emploi</router-link
            >
          </li>
        </ul>
        <div class="navbar-nav ms-auto d-flex" style="cursor: pointer">
          <a class="nav-link" @click="logout" to="Login">Se Déconnecter</a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
// import axios from "axios";

export default {
  name: "NavBar",
  data() {
    return {
      role: "",
    };
  },
  mounted() {
    this.role = localStorage.getItem("role");
  },
  methods: {
    logout() {
      this.$store.dispatch("destroyToken").then(() => {
        this.$router.push({ name: "Login" });
      });
    },
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
