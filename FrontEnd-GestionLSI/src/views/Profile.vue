<template>
  <div>
    <NavBar />
    <table>
      <tbody>
        <tr v-for="(value, name) in object" :key="(name, value)">
          <th scope="col">
            {{ name }}
          </th>
          <td>
            {{ value }}
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import NavBar from "@/components/NavBar.vue";

export default {
  name: "Profile",
  components: {
    NavBar,
  },
  data() {
    return {
      object: {},
    };
  },
  methods: {
    getProfile() {
      this.$store.dispatch("retrieveProfile").then((response) => {
        // console.log( response.data[0]);
        this.object = response.data[0];
        // return response.data[0];
      });
    },
  },
  beforeMount() {
    this.getProfile();
  },
};
</script>

<style>
table {
  margin: 5%;
}
</style>