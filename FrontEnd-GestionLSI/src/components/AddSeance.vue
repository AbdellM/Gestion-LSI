<template>
  <div class="container mt-5">
    <form @submit.prevent="submitNewSeance">
      <div class="form-group">
        <select v-model="day_id">
          <option disabled value="">Selectionnez le jour</option>
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
          <option disabled value="">Selectionnez Temps</option>
          <option value="1">Matin</option>
          <option value="2">Après midi</option>
        </select>
      </div>
      <div class="form-group">
        <label>Num de la salle</label>
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
export default {
  name: "AddSeance",
  data() {
    return {
      day_id: "",
      time_id: "",
      salle: "",
      module_id: "",
      Modules: [],
    };
  },
  methods: {
    getAllModule() {
      this.$store.dispatch("getAllModule").then((response) => {
        this.Modules = response.data;
      });
    },
    submitNewSeance() {
      this.$store.dispatch("submitNewSeance", {
        day_id: this.day_id,
        time_id: this.time_id,
        salle: this.salle,
        module_id: this.module_id,
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
