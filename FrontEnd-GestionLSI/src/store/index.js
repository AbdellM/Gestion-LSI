import { createStore } from "vuex";
import axios from "axios";


axios.defaults.baseURL = 'http://127.0.0.1:8000/api/auth/'


export default createStore({
  state: {
    token: localStorage.getItem('access_token') || null,
    role: localStorage.getItem('role') || null,
  },
  getters: {
    getRole(state) {
      return state.role;
    },
    getToken(state) {
      return state.token;
    }
  },
  mutations: {
    retrieveToken(state, token) {
      state.token = token
    },
    retrieveRole(state, role) {
      state.role = role
    },
    destroyToken(state) {
      state.token = null
      state.role = null
    },
  },
  actions: {
    /*LOGOUT*/
    destroyToken(context) {
      axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token

      if (context.getters.getRole) {
        return new Promise((resolve, reject) => {
          axios.post('/logout')
            .then(response => {
              localStorage.removeItem('access_token')
              localStorage.removeItem('role')
              context.commit('destroyToken')
              resolve(response)
            })
            .catch(error => {
              localStorage.removeItem('access_token')
              context.commit('destroyToken')
              reject(error)
            })
        })
      }
    },
    /*LOGIN*/
    retrieveToken(context, credentials) {
      return new Promise((resolve, reject) => {
        axios.post('/login', {
          email: credentials.email,
          password: credentials.password,
        })
          .then(response => {
            const token = response.data.access_token
            const role = response.data.user.role

            localStorage.setItem('access_token', token)
            localStorage.setItem('role', role)
            context.commit('retrieveToken', token)
            context.commit('retrieveRole', role)
            // console.log(response);
            resolve(response)
          })
          .catch(error => {
            console.log(error)
            reject(error)
          })
      });
    },
    /*PROFILE*/
    retrieveProfile(context) {
      return new Promise((resolve, reject) => {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token

        axios.get('/user-profile')
          .then(response => {
            // console.log(response);
            resolve(response)
          })
          .catch(error => {
            console.log(error)
            reject(error)
          })
      });
    },
    /*STUDENT*/
    retrievePfe(context) {
      return new Promise((resolve, reject) => {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token

        axios.get('student/pfe')
          .then(response => {
            resolve(response)
          })
          .catch(error => {
            console.log(error)
            reject(error)
          })
      });
    },
    retrieveNote(context) {
      return new Promise((resolve, reject) => {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token
        axios.get('student/note')
          .then(response => {
            resolve(response)
          })
          .catch(error => {
            console.log(error)
            reject(error)
          })
      });
    },
    getSeanceStudent(context) {
      return new Promise((resolve, reject) => {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token
        axios.get('student/emploi')
          .then(response => {
            resolve(response)
          })
          .catch(error => {
            console.log(error)
            reject(error)
          })
      });
    },
    /*PROF*/
    retrievePfeProf(context) {
      return new Promise((resolve, reject) => {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token

        axios.get('prof/pfe')
          .then(response => {
            resolve(response)
          })
          .catch(error => {
            console.log(error)
            reject(error)
          })
      });
    },
    getModuleProf(context) {
      return new Promise((resolve, reject) => {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token

        axios.get('prof/module')
          .then(response => {
            resolve(response)
          })
          .catch(error => {
            console.log(error)
            reject(error)
          })
      });
    },
    getStudentNote(context, credentials) {
      return new Promise((resolve, reject) => {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token
        axios.get('prof/note/' +
          credentials.module
        )
          .then(response => {
            resolve(response)
          })
          .catch(error => {
            console.log(error)
            reject(error)
          })
      });
    },
    submitStudentNote(context, credentials) {
      return new Promise((resolve, reject) => {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token
        axios.defaults.headers.common['Content-Type'] = 'application/x-www-form-urlencoded'
        axios.put('prof/note/' + credentials.module, credentials.data
        )
          .then(response => {
            alert("Enregistrement avec succes");
            resolve(response)
          })
          .catch(error => {
            alert("échec d'enregistrement");
            console.log(error)
            reject(error)
          })
      });
    },
    getSeanceProf(context) {
      return new Promise((resolve, reject) => {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token
        axios.get('prof/emploi')
          .then(response => {
            resolve(response)
          })
          .catch(error => {
            console.log(error)
            reject(error)
          })
      });
    },
    /*ADMIN*/
    getAllModule(context) {
      return new Promise((resolve, reject) => {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token

        axios.get('admin/module')
          .then(response => {
            resolve(response)
          })
          .catch(error => {
            console.log(error)
            reject(error)
          })
      });
    },
    submitNewSeance(context, credentials) {
      return new Promise((resolve, reject) => {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token
        axios.post('admin/gestionSeance', {
          day_id: credentials.day_id,
          time_id: credentials.time_id,
          salle: credentials.salle,
          module_id: credentials.module_id,
        }
        )
          .then(response => {
            alert("Enregistrement avec succes");
            resolve(response)
          })
          .catch(error => {
            alert("échec d'enregistrement");
            console.log(error)
            reject(error)
          })
      });
    },
    addNewStudent(context, credentials) {
      return new Promise((resolve, reject) => {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token
        axios.post('admin/gestionstudent', credentials.data
        )
          .then(response => {
            alert("Enregistrement avec succes");
            resolve(response)
          })
          .catch(error => {
            alert("échec d'enregistrement");
            console.log(error)
            reject(error)
          })
      });
    },
    addNewProf(context, credentials) {
      return new Promise((resolve, reject) => {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token
        axios.post('admin/gestionProf', credentials.data
        )
          .then(response => {
            alert("Enregistrement avec succes");
            resolve(response)
          })
          .catch(error => {
            alert("échec d'enregistrement");
            console.log(error)
            reject(error)
          })
      });
    },
    addNewAdmin(context, credentials) {
      return new Promise((resolve, reject) => {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token
        axios.post('admin/gestionAdmin', credentials.data
        )
          .then(response => {
            alert("Enregistrement avec succes");
            resolve(response)
          })
          .catch(error => {
            alert("échec d'enregistrement");
            console.log(error)
            reject(error)
          })
      });
    },
    getStudentsS5(context) {
      return new Promise((resolve, reject) => {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token

        axios.get('admin/getStudents/s5')
          .then(response => {
            resolve(response)
          })
          .catch(error => {
            console.log(error)
            reject(error)
          })
      });
    },
    getAllProfs(context) {
      return new Promise((resolve, reject) => {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token

        axios.get('admin/gestionProf')
          .then(response => {
            resolve(response)
          })
          .catch(error => {
            console.log(error)
            reject(error)
          })
      });
    },
    submitNewPfe(context, credentials) {
      return new Promise((resolve, reject) => {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token
        axios.post('admin/gestionPfe', {
          student_id: credentials.student_id,
          prof_id: credentials.prof_id,
          sujet: credentials.sujet,
          dateP: credentials.dateP,
        }
        )
          .then(response => {
            alert("Enregistrement avec succes");
            resolve(response)
          })
          .catch(error => {
            alert("échec d'enregistrement");
            console.log(error)
            reject(error)
          })
      });
    },
    getAllSeances(context) {
      return new Promise((resolve, reject) => {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token

        axios.get('admin/gestionSeance')
          .then(response => {
            resolve(response)
          })
          .catch(error => {
            console.log(error)
            reject(error)
          })
      });
    },
    getAllPfes(context) {
      return new Promise((resolve, reject) => {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token

        axios.get('admin/gestionPfe')
          .then(response => {
            resolve(response)
          })
          .catch(error => {
            console.log(error)
            reject(error)
          })
      });
    },
    getAllAdmins(context) {
      return new Promise((resolve, reject) => {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token

        axios.get('admin/gestionAdmin')
          .then(response => {
            resolve(response)
          })
          .catch(error => {
            console.log(error)
            reject(error)
          })
      });
    },
    getAllStudents(context) {
      return new Promise((resolve, reject) => {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token

        axios.get('admin/gestionstudent')
          .then(response => {
            resolve(response)
          })
          .catch(error => {
            console.log(error)
            reject(error)
          })
      });
    },
    deletepfe(context, credentials) {
      return new Promise((resolve, reject) => {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token
        axios.delete('admin/gestionPfe/' + credentials.id)
          .then(response => {
            alert("Supprimer avec succes");
            resolve(response)
          })
          .catch(error => {
            alert("échec de suppression");
            console.log(error)
            reject(error)
          })
      });
    },
    deleteseance(context, credentials) {
      return new Promise((resolve, reject) => {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token
        axios.delete('admin/gestionSeance/' + credentials.id)
          .then(response => {
            alert("Supprimer avec succes");
            resolve(response)
          })
          .catch(error => {
            alert("échec de suppression");
            console.log(error)
            reject(error)
          })
      });
    },
    deletestudent(context, credentials) {
      return new Promise((resolve, reject) => {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token
        axios.delete('admin/gestionstudent/' + credentials.id)
          .then(response => {
            alert("Supprimer avec succes");
            resolve(response)
          })
          .catch(error => {
            alert("échec de suppression");
            console.log(error)
            reject(error)
          })
      });
    },
    deleteprof(context, credentials) {
      return new Promise((resolve, reject) => {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token
        axios.delete('admin/gestionProf/' + credentials.id)
          .then(response => {
            alert("Supprimer avec succes");
            resolve(response)
          })
          .catch(error => {
            alert("échec de suppression");
            console.log(error)
            reject(error)
          })
      });
    },
    deleteadmin(context, credentials) {
      return new Promise((resolve, reject) => {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token
        axios.delete('admin/gestionAdmin/' + credentials.id)
          .then(response => {
            alert("Supprimer avec succes");
            resolve(response)
          })
          .catch(error => {
            alert("échec de suppression");
            console.log(error)
            reject(error)
          })
      });
    },
    getPfeById(context, credentials) {
      return new Promise((resolve, reject) => {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token
        axios.get('admin/gestionPfe/' + credentials.id)
          .then(response => {
            resolve(response)
          })
          .catch(error => {
            console.log(error)
            reject(error)
          })
      });
    },
    submitUpdatePfe(context, credentials) {
      return new Promise((resolve, reject) => {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token
        axios.defaults.headers.common['Content-Type'] = 'application/x-www-form-urlencoded'

        axios.put('admin/gestionPfe/' + credentials.id, credentials.data)
          .then(response => {
            alert("Enregistrement avec succes");
            resolve(response)
          })
          .catch(error => {
            alert("échec d'enregistrement");
            console.log(error)
            reject(error)
          })
      });
    },
    getSeanceById(context, credentials) {
      return new Promise((resolve, reject) => {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token
        axios.get('admin/gestionSeance/' + credentials.id)
          .then(response => {
            console.log(response);
            resolve(response)
          })
          .catch(error => {
            console.log(error)
            reject(error)
          })
      });
    },
    submitUpdateSeance(context, credentials) {
      return new Promise((resolve, reject) => {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token
        axios.defaults.headers.common['Content-Type'] = 'application/x-www-form-urlencoded'

        axios.put('admin/gestionSeance/' + credentials.id, credentials.data)
          .then(response => {
            alert("Enregistrement avec succes");
            resolve(response)
          })
          .catch(error => {
            alert("échec d'enregistrement");
            console.log(error)
            reject(error)
          })
      });
    },
    getAdminById(context, credentials) {
      return new Promise((resolve, reject) => {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token
        axios.get('admin/gestionAdmin/' + credentials.id)
          .then(response => {
            resolve(response)
          })
          .catch(error => {
            console.log(error)
            reject(error)
          })
      });
    },
    submitUpdateAdmin(context, credentials) {
      return new Promise((resolve, reject) => {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token
        axios.defaults.headers.common['Content-Type'] = 'application/x-www-form-urlencoded'

        axios.put('admin/gestionAdmin/' + credentials.id, credentials.data)
          .then(response => {
            alert("Enregistrement avec succes");
            resolve(response)
          })
          .catch(error => {
            alert("échec d'enregistrement");
            console.log(error)
            reject(error)
          })
      });
    },
    getStudentById(context, credentials) {
      return new Promise((resolve, reject) => {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token
        axios.get('admin/gestionstudent/' + credentials.id)
          .then(response => {
            resolve(response)
          })
          .catch(error => {
            console.log(error)
            reject(error)
          })
      });
    },
    submitUpdateStudent(context, credentials) {
      return new Promise((resolve, reject) => {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token
        axios.defaults.headers.common['Content-Type'] = 'application/x-www-form-urlencoded'

        axios.put('admin/gestionstudent/' + credentials.id, credentials.data)
          .then(response => {
            alert("Enregistrement avec succes");
            resolve(response)
          })
          .catch(error => {
            alert("échec d'enregistrement");
            console.log(error)
            reject(error)
          })
      });
    },
    getProfyId(context, credentials) {
      return new Promise((resolve, reject) => {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token
        axios.get('admin/gestionProf/' + credentials.id)
          .then(response => {
            resolve(response)
          })
          .catch(error => {
            console.log(error)
            reject(error)
          })
      });
    },
    submitUpdateProf(context, credentials) {
      return new Promise((resolve, reject) => {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token
        axios.defaults.headers.common['Content-Type'] = 'application/x-www-form-urlencoded'

        axios.put('admin/gestionProf/' + credentials.id, credentials.data)
          .then(response => {
            alert("Enregistrement avec succes");
            resolve(response)
          })
          .catch(error => {
            alert("échec d'enregistrement");
            console.log(error)
            reject(error)
          })
      });
    },
  },
  modules: {},
});
