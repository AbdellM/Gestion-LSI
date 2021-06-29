import { createRouter, createWebHistory } from "vue-router";
import Login from "../views/Login.vue";
import Profile from "../views/Profile.vue";
import Pfe from "../views/Student/Pfe.vue";
import Note from "../views/Student/Note.vue";
import EmploiStudent from "../views/Student/EmploiStudent.vue";
import PfeProf from "../views/Prof/PfeProf.vue";
import Addnote from "../views/Prof/Addnote.vue";
import EmploiProf from "../views/Prof/EmploiProf.vue";
import GestionPfe from "../views/Admin/GestionPfe.vue";
import GestionUser from "../views/Admin/GestionUser.vue";
import GestionEmploi from "../views/Admin/GestionEmploi.vue";

import EditStudent from "../views/Admin/EditStudent.vue";
import EditPFE from "../views/Admin/EditPFE.vue";
import EditProf from "../views/Admin/EditProf.vue";
import EditAdmin from "../views/Admin/EditAdmin.vue";
import EditSeance from "../views/Admin/EditSeance.vue";



const routes = [
  {
    path: "/login",
    name: "Login",
    component: Login,
    meta: {
      requiresAuth: false,
    }
  },
  {
    path: "/profile",
    name: "Profile",
    component: Profile,
    meta: {
      requiresAuth: true,
    }
  },
  {/*STUDENT*/
    path: "/pfe",
    name: "Pfe",
    component: Pfe,
    meta: {
      requiresAuthStudent: true,
    }
  },
  {
    path: "/note",
    name: "note",
    component: Note,
    meta: {
      requiresAuthStudent: true,
    }
  },
  {
    path: "/EmploiStudent",
    name: "EmploiStudent",
    component: EmploiStudent,
    meta: {
      requiresAuthStudent: true,
    }
  },
  {/*PROF*/
    path: "/PfeProf",
    name: "PfeProf",
    component: PfeProf,
    meta: {
      requiresAuthProf: true,
    }
  },
  {
    path: "/addnote",
    name: "addnote",
    component: Addnote,
    meta: {
      requiresAuthProf: true,
    }
  },
  {
    path: "/EmploiProf",
    name: "EmploiEmploiProfStudent",
    component: EmploiProf,
    meta: {
      requiresAuthProf: true,
    }
  },
  /*Admin*/
  {
    path: "/gestionpfe",
    name: "GestionPfe",
    component: GestionPfe,
    meta: {
      requiresAuthAdmin: true,
    }
  },
  {
    path: "/GestionUser",
    name: "GestionUser",
    component: GestionUser,
    meta: {
      requiresAuthAdmin: true,
    }
  },
  {
    path: "/GestionEmploi",
    name: "GestionEmploi",
    component: GestionEmploi,
    meta: {
      requiresAuthAdmin: true,
    }
  },

  /*not yet*/
  {
    path: "/EditSeance",
    name: "EditSeance",
    component: EditSeance,
  },
  {
    path: "/editProf",
    name: "EditProf",
    component: EditProf,
  },
  {
    path: "/editadmin",
    name: "EditAdmin",
    component: EditAdmin,
  },
  {
    path: "/editpfe",
    name: "EditPFE",
    component: EditPFE,
    meta: {
      requiresAuthAdmin: true,
    }
  },
  {
    path: "/EditStudent",
    name: "EditStudent",
    component: EditStudent,
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
