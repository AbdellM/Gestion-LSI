<template>
  <NavBar />
  <div class="container mt-5">
    <form @submit.prevent="submitUpdateSeance">
      <div class="form-group">
        <select v-model="day_id">
          <option disabled value="">Selectionnez le nouveau jour</option>
          <option value="1">Lundi</option>
          <option value="2">Mardi</option>
          <option value="3">Mercredi</option>
          <option value="4">Jeudi</option>
          <option value="5">Vendredi</option>
          <option value="6">Samedi</option>
        </select>
      </div>
      <div class="form-group">
        <select v-model="time_id">
          <option disabled value="">Selectionnez un nouveau créneau</option>
          <option value="1">Matin</option>
          <option value="2">Après midi</option>
        </select>
      </div>
      <div class="form-group">
        <label>Num de la nouvelle salle</label>
        <input v-model="salle" type="text" class="form-control" />
      </div>

      <div class="form-group">
        <select v-model="module_id" class="form-select">
          <option disabled value="">Selectionez un Module</option>
          <option v-for="Module in Modules" :key="Module" :value="Module.id">
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
  name: "EditSeance",
  components: {
    NavBar,
  },
  data() {
    return {
      day_id: "",
      time_id: "",
      salle: "",
      module_id: "",
      Modules: [],
      id: "",
    };
  },
  methods: {
    submitUpdateSeance() {
      this.$store
        .dispatch("submitUpdateSeance", {
          id: this.id,
          data: this.getData(),
        })
        .then(() => {
          this.$router.push({ name: "GestionEmploi" });
        });
    },
    getAllModule() {
      this.$store.dispatch("getAllModule").then((response) => {
        this.Modules = response.data;
      });
    },
    getData() {
      let formData = new URLSearchParams();
      if (this.day_id) {
        formData.append("day_id", this.day_id);
      }
      if (this.time_id) {
        formData.append("time_id", this.time_id);
      }
      if (this.salle) {
        formData.append("salle", this.salle);
      }
      if (this.module_id) {
        formData.append("module_id", this.module_id);
      }
      return formData;
    },
  },
  beforeMount() {
    this.$store
      .dispatch("getSeanceById", { id: (this.id = this.$route.params.id) })
      .then((response) => {
        this.day_id = response.data.day_id;
        this.time_id = response.data.time_id;
        this.salle = response.data.salle;
        this.module_id = response.data.module_id;
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