<template>
  <NavBar />
  <div class="container mt-5">
    <table class="table">
      <thead>
        <tr>
          <th scope="col"></th>
          <th scope="col">Matin</th>
          <th scope="col">Après-midi</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th scope="row">Lundi</th>
          <td :class="matrix[0][0].class">
            {{ matrix[0][0].module }}<br />
            {{ matrix[0][0].salle }}
          </td>
          <td :class="matrix[0][1].class">
            {{ matrix[0][1].module }}<br />
            {{ matrix[0][1].salle }}
          </td>
        </tr>
        <tr>
          <th scope="row">Mardi</th>
          <td :class="matrix[1][0].class">
            {{ matrix[1][0].module }}<br />
            {{ matrix[1][0].salle }}
          </td>
          <td id="22" :class="matrix[1][1].class">
            {{ matrix[1][1].module }}<br />
            {{ matrix[1][1].salle }}
          </td>
        </tr>
        <tr>
          <th scope="row">Mercredi</th>
          <td :class="matrix[2][0].class">
            {{ matrix[2][0].module }}<br />
            {{ matrix[2][0].salle }}
          </td>
          <td :class="matrix[2][1].class">
            {{ matrix[2][1].module }}<br />
            {{ matrix[2][1].salle }}
          </td>
        </tr>
        <tr>
          <th scope="row">Jeudi</th>
          <td :class="matrix[3][0].class">
            {{ matrix[3][0].module }}<br />
            {{ matrix[3][0].salle }}
          </td>
          <td id="42" :class="matrix[3][1].class">
            {{ matrix[3][1].module }}<br />
            {{ matrix[3][1].salle }}
          </td>
        </tr>
        <tr>
          <th scope="row">vendredi</th>
          <td :class="matrix[4][0].class">
            {{ matrix[4][0].module }}<br />
            {{ matrix[4][0].salle }}
          </td>
          <td id="52" :class="matrix[4][1].class">
            {{ matrix[4][1].module }}<br />
            {{ matrix[4][1].salle }}
          </td>
        </tr>
        <tr>
          <th scope="row">Samedi</th>
          <td :class="matrix[5][0].class">
            {{ matrix[5][0].module }}<br />
            {{ matrix[5][0].salle }}
          </td>
          <td :class="matrix[5][1].class">
            {{ matrix[5][1].module }}<br />
            {{ matrix[5][1].salle }}
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
// import $ from "jquery";
import NavBar from "@/components/NavBar.vue";
export default {
  name: "EmploiProf",
  components: {
    NavBar,
  },
  data() {
    return {
      Seances: [],
      matrix: [],
      Modules: [],
      module: "",
    };
  },
  methods: {
    getSeanceProf() {
      this.$store.dispatch("getSeanceProf").then((response) => {
        this.Seances = response.data;
        this.changecolor();
      });
      this.changecolor();
    },
    setSeanceColor(Seance, matrix) {
      for (let i = 0; i < 6; i++) {
        for (let j = 0; j < 2; j++) {
          if (Seance.day_id - 1 == i && Seance.time_id - 1 == j) {
            matrix[i][j] = {
              class: "colorchanger",
              module: Seance.module,
              salle: Seance.salle,
            };
          }
        }
      }
      return matrix;
    },
    changecolor() {
      let matrix = new Array(6).fill(0).map(() => new Array(2).fill(0));
      this.Seances.forEach((element) => {
        matrix = this.setSeanceColor(element, matrix);
      });
      this.matrix = matrix;
    },
  },
  beforeMount() {
    this.getSeanceProf();
  },
};
</script>

<style>
tr {
  border: solid black 2px;
}
td {
  border: solid black 2px;
}

.colorchanger {
  background: linear-gradient(135deg, #eec08e, #dcee8e);
}
</style>