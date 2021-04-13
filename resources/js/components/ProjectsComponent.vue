<template>
  <div class="container">
    <div v-if="modal">
      <transition name="model">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">{{ dynamicTitle }}</h4>
                  <button
                    type="button"
                    class="close"
                    @click="
                      edit = null;
                      modal = false;
                    "
                  >
                    <span aria-hidden="true">&times; </span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <label>Enter Title</label>
                    <input
                      type="text"
                      class="form-control"
                      :class="{ 'is-invalid': errors.title }"
                      v-model="form.title"
                    />
                    <div class="invalid-feedback" v-if="errors.title">
                      {{ errors.title }}
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Enter Description</label>
                    <textarea
                      class="form-control"
                      :class="{ 'is-invalid': errors.description }"
                      v-model="form.description"
                      rows="2"
                    ></textarea>
                    <div class="invalid-feedback" v-if="errors.description">
                      {{ errors.description }}
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Choose Team</label>
                    <select
                      class="form-control"
                      :class="{ 'is-invalid': errors.team_id }"
                      v-model="form.team_id"
                    >
                      <option
                        v-for="team in this.projectsTeams"
                        :value="team.id"
                        :key="team.id"
                      >
                        {{ team.name }}
                      </option>
                    </select>
                    <div class="invalid-feedback" v-if="errors.team_id">
                      {{ errors.team_id }}
                    </div>
                  </div>
                  <div align="center">
                    <input
                      type="button"
                      v-if="edit == null"
                      class="btn btn-primary"
                      value="Submit"
                      @click="create"
                    />
                    <input
                      type="button"
                      v-else
                      class="btn btn-primary"
                      value="Submit"
                      @click="update"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </transition>
    </div>

    <div
      class="row justify-content-center"
      v-if="this.createdProjects.length > 0"
    >
      <div class="col-12">
        <h3 class="p-3">Created Projects</h3>
        <div class="card p-3">
          <table class="table-striped table-responsive full-width">
            <thead>
              <tr>
                <th style="width: 40%">Title</th>
                <th style="width: 20%">Author</th>
                <th style="width: 30%">Team</th>
                <th style="width: 5%"></th>
                <th style="width: 5%"></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="project in createdProjects" :key="project.id">
                <td style="width: 40%">{{ project.title }}</td>
                <td style="width: 20%">
                  {{ projectsUsers[project.author_id].name }}
                </td>
                <td style="width: 30%" v-if="project.team_id != null">
                  {{ projectsTeams[project.team_id].name }}
                </td>
                <td style="width: 30%" v-else>No Team</td>
                <td style="width: 5%">
                  <button
                    type="button"
                    class="btn btn-primary"
                    @click="startEdit(project)"
                  >
                    <span class="icon is-small">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        fill="currentColor"
                        class="bi bi-gear"
                        viewBox="0 0 16 16"
                      >
                        <path
                          d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z"
                        />
                        <path
                          d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115l.094-.319z"
                        />
                      </svg>
                    </span>
                  </button>
                </td>
                <td style="width: 5%">
                  <button
                    type="button"
                    class="btn btn-danger"
                    @click="del(project)"
                  >
                    <span class="icon is-small">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        fill="currentColor"
                        class="bi bi-trash"
                        viewBox="0 0 16 16"
                      >
                        <path
                          d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"
                        />
                        <path
                          fill-rule="evenodd"
                          d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"
                        />
                      </svg>
                    </span>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="row justify-content-center" v-if="this.teamProjects.length > 0">
      <div class="col-12">
        <h3 class="p-3">Team Projects</h3>
        <table class="table-striped full-width">
          <thead>
            <tr>
              <th style="width: 40%">Title</th>
              <th style="width: 20%">Author</th>
              <th style="width: 30%">Team</th>
              <th style="width: 5%"></th>
              <th style="width: 5%"></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="project in teamProjects" :key="project.id">
              <td style="width: 40%">{{ project.title }}</td>
              <td style="width: 20%">
                {{ projectsUsers[project.author_id].name }}
              </td>
              <td style="width: 30%" v-if="project.team_id != null">
                {{ projectsTeams[project.team_id].name }}
              </td>
              <td style="width: 30%" v-else>No Team</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import moment from "moment";

function Team({ id, name, description, created_at, updated_at }) {
  this.id = id;
  this.name = name;
  this.description = description;
  this.created_at = created_at;
  this.updated_at = updated_at;
}

function User({
  id,

  created_at,
  updated_at,
  teams,
}) {
  this.id = id;

  this.created_at = created_at;
  this.updated_at = updated_at;
  this.teams = teams;
}

export default {
  data: function () {
    return {
      modal: false,
      dynamicTitle: null,
      createdProjects: [],
      teamProjects: [],
      projectsUsers: {},
      projectsTeams: {},
      form: {
        title: null,
        description: null,
        author_id: null,
        team_id: null,
      },
    };
  },
  computed: {
    ...mapGetters(["errors"]),
    ...mapGetters("auth", ["user"]),
  },
  mounted() {
    this.$store.commit("setErrors", {});
  },
  created() {
    this.read();
  },
  methods: {
    async read() {
      await window.axios
        .get(process.env.MIX_API_URL + "users")
        .then((response) => {
          if (response.data != null) {
            this.projectsUsers = {};
            response.data.users.forEach((user) => {
              if (user != null) {
                this.projectsUsers[user.id] = user;
              }
            });
          }
        })
        .catch((error) => {
          console.log(error);
        });

      await window.axios
        .get(process.env.MIX_API_URL + "teams")
        .then((response) => {
          if (response.data != null) {
            this.projectsTeams = {};
            response.data.teams.forEach((team) => {
              if (team != null) {
                this.projectsTeams[team.id] = new Team(team);
              }
            });
            this.projectsTeams[0] = new Team({
              id: 0,
              name: "No Team",
              description: "",
              created_at: moment(),
              updated_at: moment(),
            });
          }
        })
        .catch((error) => {
          console.log(error);
        });

      await window.axios
        .get(
          process.env.MIX_API_URL + "users/" + this.user.id + "/teamProjects"
        )
        .then((response) => {
          if (response.data != null) {
            this.createdProjects = [];
            this.teamProjects = [];
            if (response.data.createdProjects != null) {
              response.data.createdProjects.forEach((project) => {
                this.createdProjects.push(project);
              });
            }

            if (response.data.teamProjects != null) {
              response.data.teamProjects.forEach((project) => {
                this.teamProjects.push(project);
              });
            }
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },

    openProjectModal(project) {
      console.log(project.id + " open");
    },

    startEdit(project) {
      console.log(this.projectsTeams[0].id);
      this.modal = true;
      this.edit = project.id;
      this.dynamicTitle = "Edit Project";
      if (project.team_id == null) {
        this.form.team_id = 0;
      } else {
        this.form.team_id = project.team_id;
      }
      this.form.title = project.title;
      this.form.description = project.description;
      this.form.author = project.author_id;
    },

    update() {},
  },
};
</script>

<style scoped>
.full-width {
  width: 100%;
}

.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: table;
  transition: opacity 0.3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}

.to-capital-first {
  text-transform: capitalize;
}

.modal-dialog {
  overflow-y: initial !important;
}
.modal-body {
  height: 40vh;
  overflow-y: auto;
}
</style>