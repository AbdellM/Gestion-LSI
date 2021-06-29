<template>
  <NavBar />
  <div class="container">
    <form @submit.prevent="submitStudentNote">
      <div class="form-group">
        <select v-model="module" class="form-select">
          <option disabled value="">Selectionez un Module</option>
          <option v-for="Module in Modules" :key="Module" :value="Module.id">
            {{ Module.module }}
          </option>
        </select>
        {{ getStd }}
      </div>

      <table class="table">
        <thead>
          <tr>
            <th scope="col">Nom</th>
            <th scope="col">Prenom</th>
            <th scope="col">CNE</th>
            <th scope="col">Note</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(Student, index) in Students" :key="Student">
            <td>{{ Student.nom }}</td>
            <td>{{ Student.prenom }}</td>
            <td>{{ Student.cne }}</td>
            <td>
              <input
                v-model="note[index]"
                type="number"
                :placeholder="Student.note"
              />
            </td>
          </tr>
        </tbody>
      </table>

      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</template>

<script>
import NavBar from "@/components/NavBar.vue";

export default {
  name: "Addnote",
  components: {
    NavBar,
  },
  data() {
    return {
      Modules: [],
      Students: [],
      module: "",
      note: [],
    };
  },
  methods: {
    getModuleProf() {
      this.$store.dispatch("getModuleProf").then((response) => {
        this.Modules = response.data;
      });
    },
    getStudentNote() {
      if (this.module != "") {
        this.$store
          .dispatch("getStudentNote", {
            module: this.module,
          })
          .then((response) => {
            this.Students = response.data;
          });
      }
    },
    submitStudentNote() {
      this.$store.dispatch("submitStudentNote", {
        data: this.getData,
        module: this.module,
      });
    },
  },
  computed: {
    getStd() {
      return this.getStudentNote();
    },
    getData() {
      let formData = new URLSearchParams();
      let i = 0;
      this.Students.forEach((std) => {
        formData.append("student_id[" + i + "]", std.id);
        formData.append("note[" + i + "]", this.note[i]);
        i++;
      });
      return formData;
    },
  },
  beforeMount() {
    this.getModuleProf();
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
  position: relative;
  display: inline-block;
}
</style>
