<template>
  <NavBar />
  <div class="container mt-5">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button
          class="nav-link active"
          id="add-tab"
          data-bs-toggle="tab"
          data-bs-target="#add"
          type="button"
          role="tab"
          aria-controls="add"
          aria-selected="true"
        >
          Ajouter un seance
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button
          class="nav-link"
          id="show-tab"
          data-bs-toggle="tab"
          data-bs-target="#show"
          type="button"
          role="tab"
          aria-controls="show"
          aria-selected="false"
        >
          Afficher les Seances
        </button>
      </li>
    </ul>
    <div class="tab-content" id="myTabContent">
      <div
        id="add"
        class="tab-pane fade show active"
        role="tabpanel"
        aria-labelledby="home-tab"
      >
        <AddSeance />
      </div>
      <div
        id="show"
        class="tab-pane fade"
        role="tabpanel"
        aria-labelledby="show"
      >
        <ShowTable
          :tableHeader="tableHeader"
          :objects="Seances"
          type="seance"
        />
      </div>
    </div>
  </div>
</template>

<script>
// @ is an alias to /src
import NavBar from "@/components/NavBar.vue";
import AddSeance from "@/components/AddSeance.vue";
import ShowTable from "@/components/ShowTable.vue";

export default {
  name: "GestionEmploi",
  components: {
    NavBar,
    AddSeance,
    ShowTable,
  },
  data() {
    return {
      tableHeader: ["Jour", "Temps", "Module", "Salle"],
      Seances: [],
    };
  },
  methods: {
    getAllSeances() {
      this.$store.dispatch("getAllSeances").then((response) => {
        this.Seances = response.data;
      });
    },
  },
  beforeMount() {
    this.getAllSeances();
  },
};
</script>


