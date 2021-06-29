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
          Ajouter un utilisateur
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
          Afficher les Utilisateurs
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
        <AddUser />
      </div>
      <div
        id="show"
        class="tab-pane fade"
        role="tabpanel"
        aria-labelledby="show"
      >
        <ShowUser />
      </div>
    </div>
  </div>
</template>

<script>
// @ is an alias to /src
import NavBar from "@/components/NavBar.vue";
import AddUser from "@/components/AddUser.vue";
import ShowUser from "@/components/ShowUser.vue";

export default {
  name: "GestionUser",
  data() {
    return {};
  },
  components: {
    NavBar,
    AddUser,
    ShowUser,
  },
};
</script>
