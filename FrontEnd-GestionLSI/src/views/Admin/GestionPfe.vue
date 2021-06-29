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
          Ajouter un PFE
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
          Afficher les PFEs
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
        <AddPfe />
      </div>
      <div
        id="show"
        class="tab-pane fade"
        role="tabpanel"
        aria-labelledby="show"
      >
        <ShowTable
          @click="updateparent"
          :tableHeader="tableHeader"
          :objects="Pfes"
          type="pfe"
        />
      </div>
    </div>
  </div>
</template>

<script>
// @ is an alias to /src
import NavBar from "@/components/NavBar.vue";
import AddPfe from "@/components/AddPfe.vue";
import ShowTable from "@/components/ShowTable.vue";

export default {
  name: "GestionPfe",
  components: {
    NavBar,
    AddPfe,
    ShowTable,
  },
  data() {
    return {
      tableHeader: [
        "Etudiant Nom",
        "Etudiant Prenom",
        "CNE",
        "Professeur Nom",
        "Professeur Prenom",
        "Sujet",
        "Date Presentation",
      ],
      Pfes: [],
      componentKey: 0,
    };
  },
  methods: {
    updateparent(variable) {
      this.parentvariable = variable;
    },
    getAllPfes() {
      this.$store.dispatch("getAllPfes").then((response) => {
        this.Pfes = response.data;
      });
    },
    setPfes(Data) {
      Data.forEach((element) => {
        element.stdNom;
      });
    },
  },
  beforeMount() {
    this.getAllPfes();
  },
};
</script>
