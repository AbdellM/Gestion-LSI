<template>
  <table class="table">
    <thead>
      <tr>
        <th scope="row">#</th>
        <th scope="col" v-for="value in tableHeader" :key="value">
          {{ value }}
        </th>
        <th scope="col"></th>
        <th scope="col"></th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="object in objects" :key="object">
        <td v-for="element in object" :key="element">{{ element }}</td>
        <td>
          <input
            class="btn btn-danger"
            value="Supprimer"
            type="button"
            @click="deletee(object.id)"
          />
        </td>
        <td>
          <input
            class="btn btn-primary"
            value="Modifier"
            type="button"
            @click="update(object.id)"
          />
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script>
export default {
  name: "ShowTable",
  props: ["tableHeader", "objects", "type"],
  methods: {
    deletee(id) {
      switch (this.type) {
        case "pfe":
          this.$store.dispatch("deletepfe", { id: id });
          this.$router.push({ name: "GestionPfe" });
          break;
        case "seance":
          this.$store.dispatch("deleteseance", { id: id });
          this.$router.push({ name: "GestionEmploi" });
          break;
        case "student":
          this.$store.dispatch("deletestudent", { id: id });
          this.$router.push({ name: "GestionUser" });
          break;
        case "prof":
          this.$store.dispatch("deleteprof", { id: id });
          this.$router.push({ name: "GestionUser" });
          break;
        case "admin":
          this.$store.dispatch("deleteadmin", { id: id });
          this.$router.push({ name: "GestionUser" });
          break;
      }
    },
    update(id) {
      switch (this.type) {
        case "pfe":
          this.$router.push({ name: "EditPFE", params: { id: id } });
          break;
        case "seance":
          this.$router.push({ name: "EditSeance", params: { id: id } });
          break;
        case "student":
          this.$router.push({ name: "EditStudent", params: { id: id } });
          break;
        case "prof":
          this.$router.push({ name: "EditProf", params: { id: id } });
          break;
        case "admin":
          this.$router.push({ name: "EditAdmin", params: { id: id } });
          break;
      }
    },
  },
};
</script>