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
          <div class="table-responsive">
            <table class="table-striped w-100 d-block d-md-table">
              <thead>
                <tr>
                  <th style="width: 25%">Title</th>
                  <th style="width: 40%">Description</th>
                  <th style="width: 25%">Team</th>
                  <th style="width: 5%"></th>
                  <th style="width: 5%"></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="project in createdProjects" :key="project.id">
                  <td style="width: 25%">{{ project.title }}</td>
                  <td style="width: 40%" v-if="project.description != null">
                    {{ project.description }}
                  </td>
                  <td style="width: 40%" v-else>-</td>
                  <td style="width: 25%" v-if="project.team_id != null">
                    {{ projectsTeams[project.team_id].name }}
                  </td>
                  <td style="width: 25%" v-else>No Team</td>
                  <td style="width: 5%">
                    <button
                      type="button"
                      class="btn btn-primary"
                      style="margin: 1px"
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
                      @click="startDelete(project)"
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
                <tr class="bg-white" v-if="!createForm">
                  <td></td>
                  <td>
                    <button
                      type="button"
                      class="btn btn-secondary"
                      style="margin: 3px;"
                      @click="startCreate()"
                    >
                      <span class="icon full-size">
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          width="16"
                          height="16"
                          fill="currentColor"
                          class="bi bi-plus-square"
                          viewBox="0 0 16 16"
                        >
                          <path
                            d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"
                          />
                          <path
                            d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"
                          />
                        </svg>
                        Create Project
                      </span>
                    </button>
                  </td>
                </tr>
                <tr class="bg-white" v-else>
                  <td>
                    <input
                      type="text"
                      class="form-control input-sm"
                      :class="{ 'is-invalid': errors.title }"
                      v-model="form.title"
                      placeholder="Enter title"
                    />
                    <div
                      class="tooltip bs-tooltip-top show invalid-feedback"
                      v-if="errors.title"
                    >
                      {{ errors.title }}
                    </div>
                  </td>
                  <td>
                    <input
                      type="text"
                      class="form-control input-sm"
                      :class="{ 'is-invalid': errors.description }"
                      v-model="form.description"
                      rows="1"
                      placeholder="Enter description"
                    />
                    <div
                      class="tooltip bs-tooltip-top show invalid-feedback"
                      v-if="errors.description"
                    >
                      {{ errors.description }}
                    </div>
                  </td>
                  <td>
                    <select
                      class="form-control input-sm"
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
                    <div
                      class="tooltip bs-tooltip-top show invalid-feedback"
                      v-if="errors.team_id"
                    >
                      {{ errors.team_id }}
                    </div>
                  </td>
                  <td>
                    <button
                      type="button"
                      class="btn btn-success"
                      style="margin: 1px"
                      @click="create()"
                    >
                      <span class="icon is-small">
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          width="16"
                          height="16"
                          fill="currentColor"
                          class="bi bi-check-circle"
                          viewBox="0 0 16 16"
                        >
                          <path
                            d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"
                          />
                          <path
                            d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"
                          />
                        </svg>
                      </span>
                    </button>
                  </td>
                  <td>
                    <button
                      type="button"
                      class="btn btn-danger"
                      style="margin: 1px"
                      @click="endCreate()"
                    >
                      <span class="icon is-small">
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          width="16"
                          height="16"
                          fill="currentColor"
                          class="bi bi-x-circle"
                          viewBox="0 0 16 16"
                        >
                          <path
                            d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"
                          />
                          <path
                            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"
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
    </div>
    <div v-else-if="this.loaded">
      <button type="button" class="btn btn-secondary" @click="startProject()">
        <span class="icon full-size">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="16"
            height="16"
            fill="currentColor"
            class="bi bi-plus-square"
            viewBox="0 0 16 16"
          >
            <path
              d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"
            />
            <path
              d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"
            />
          </svg>
          Start Project
        </span>
      </button>
    </div>
    <div class="row justify-content-center" v-if="this.teamProjects.length > 0">
      <div class="col-12">
        <h3 class="p-3">Team Projects</h3>
        <table class="table-striped full-width">
          <thead>
            <tr>
              <th style="width: 30%">Title</th>
              <th style="width: 30%">Author</th>
              <th style="width: 30%">Team</th>
              <th style="width: 5%"></th>
              <th style="width: 5%"></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="project in teamProjects" :key="project.id">
              <td style="width: 30%">{{ project.title }}</td>
              <td style="width: 30%">
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

function User({ id, name, email, created_at, updated_at }) {
  this.id = id;
  this.name = name;
  this.email = email;
  this.created_at = created_at;
  this.updated_at = updated_at;
}

export default {
  data: function () {
    return {
      loaded: false,
      modal: false,
      edit: null,
      createForm: false,
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
                this.projectsUsers[user.id] = new User(user);
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
            this.loaded = true;
          }
        })
        .catch((error) => {
          console.log(error);
        });
        
    },

    async update() {
      if (this.form.team_id == 0) {
        this.form.team_id = null;
      }

      await window.axios
        .put(process.env.MIX_API_URL + "projects/" + this.edit.id, this.form)
        .then((response) => {
          if (response.data != null) {
            this.modal = false;
            var projectIndex = this.createdProjects.findIndex(
              (project) => project.id == this.edit.id
            );
            this.createdProjects.splice(projectIndex, 1, response.data.project);
            this.edit = null;
            this.$notify({
              group: "app",
              title: "Success!",
              type: "success",
              text: response.data.message,
            });
            this.$store.commit("setErrors", {});
          }
        })
        .catch((error) => {
          console.log(error);
          if (error.response) {
            if (error.response.status != 422) {
              this.modal = false;
              this.edit = null;
              this.$alert(error.response.data.status, "Warning", "error");
            } else {
              this.$store.commit("setErrors", error.response.data.errors);
            }
          }
        });
    },

    async create() {
      this.form.author_id = this.user.id;
      if (this.form.team_id == 0) {
        this.form.team_id = null;
      }

      await window.axios
        .post(process.env.MIX_API_URL + "projects", this.form)
        .then((response) => {
          if (response.data != null) {
            this.createForm = false;
            this.createdProjects.push(response.data.project);
            this.$notify({
              group: "app",
              title: "Success!",
              type: "success",
              text: response.data.message,
            });
            this.$store.commit("setErrors", {});
          }
        })
        .catch((error) => {
          console.log(error);
          if (error.response) {
            if (error.response.status != 422) {
              this.createForm = false;
              this.$alert(error.response.data.status, "Warning", "error");
            } else {
              if (this.form.team_id == null) {
                this.form.team_id = 0;
              }
              this.$store.commit("setErrors", error.response.data.errors);
            }
          }
        });
    },

    async delete(id) {
      await window.axios
        .delete(process.env.MIX_API_URL + "projects/" + id)
        .then((response) => {
          if (response.data.project.id != id) {
            this.$alert("Something went wrong.", "Warning", "error");
          } else {
            var projectIndex = this.createdProjects.findIndex(
              (project) => project.id == id
            );
            this.createdProjects.splice(projectIndex, 1);
            this.$notify({
              group: "app",
              title: "Success!",
              type: "success",
              text: response.data.message,
            });
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },

    startDelete(project) {
      this.$confirm("Are You sure?", "Confirm Delete", "error").then(() => {
        this.delete(project.id);
      });
    },

    startEdit(project) {
      this.modal = true;
      this.edit = project;
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

    startCreate() {
      this.createForm = true;
      this.form.title = null;
      this.form.description = null;
      this.form.team_id = 0;
    },

    startProject() {
      this.modal = true;
      this.form.title = null;
      this.form.description = null;
      this.form.team_id = 0;
    },

    endCreate() {
      this.createForm = false;
      this.$store.commit("setErrors", {});
    },
  },
};
</script>

<style scoped>
.full-width {
  width: 100%;
}

.input-sm {
  height: calc(2.15rem + 2px);
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