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
                      rows="3"
                    ></textarea>
                    <div class="invalid-feedback" v-if="errors.description">
                      {{ errors.description }}
                    </div>
                  </div>
                  <div class="form-group" v-if="Object.keys(this.teamsAdmin).lenght > 1">
                    <label>Choose Team</label>
                    <select
                      class="form-control"
                      :class="{ 'is-invalid': errors.team_id }"
                      v-model="form.team_id"
                    >
                      <option
                        v-for="team in this.teamsAdmin"
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
      <div class="col-12 card mt-3">
        <div class="card-body text-center">
          <h3 class="card-title">Created Projects</h3>
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
                    {{ teams[project.team_id].name }}
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
                          class="bi bi-three-dots"
                          viewBox="0 0 16 16"
                        >
                          <path
                            d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"
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
                      style="margin: 3px"
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
                        v-for="team in this.teamsAdmin"
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
    <div v-else-if="this.loaded" class="row justify-content-center">
      <div class="col-12 card mt-3">
        <div class="card-body text-center">
          <h3 class="card-title">Created Projects</h3>
          <button
            type="button"
            class="btn btn-secondary w-25 mt-3"
            @click="startProject()"
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
              Start Project
            </span>
          </button>
        </div>
      </div>
    </div>
    <div v-else class="row justify-content-center">
      <div class="loader mt-3"></div>
    </div>
    <div class="row justify-content-center" v-if="this.teamProjects.length > 0">
      <div class="col-12 card mt-3">
        <div class="card-body text-center">
          <h3 class="card-title">Team Projects</h3>
          <table class="table-striped full-width">
            <thead>
              <tr>
                <th style="width: 35%">Title</th>
                <th style="width: 30%">Author</th>
                <th style="width: 35%">Team</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="project in teamProjects" :key="project.id">
                <td style="width: 35%">{{ project.title }}</td>
                <td style="width: 30%">
                  {{ projectsUsers[project.author_id].name }}
                </td>
                <td style="width: 35%" v-if="project.team_id != null">
                  {{ teams[project.team_id].name }}
                </td>
                <td style="width: 35%" v-else>No Team</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import moment from "moment";

function Team({ id, name, description, created_at, updated_at, pivot }) {
  this.id = id;
  this.name = name;
  this.description = description;
  this.created_at = created_at;
  this.updated_at = updated_at;
  this.pivot = pivot;
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
      teams: {},
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

    teamsAdmin: function () {
      const adminTeams = Object.entries(this.teams).filter(function ([
        key,
        team,
      ]) {
        if (team.pivot.is_admin) {
          return team.pivot.is_admin;
        } else {
          return false;
        }
      });
      return Object.fromEntries(adminTeams);
    },
  },
  mounted() {
    this.$store.commit("setErrors", {});
  },
  created() {
    this.read();
  },
  methods: {
    async read() {
      await axios
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

      await axios
        .get(process.env.MIX_API_URL + "teams")
        .then((response) => {
          if (response.data != null) {
            this.teams = {};
            response.data.teams.forEach((team) => {
              if (team != null) {
                this.teams[team.id] = new Team(team);
              }
            });
            this.teams[0] = new Team({
              id: 0,
              name: "No Team",
              description: "",
              created_at: moment(),
              updated_at: moment(),
              pivot: {
                is_admin: true,
              },
            });
          }
        })
        .catch((error) => {
          console.log(error);
        });

      await axios
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
          this.loaded = true;
          console.log(error);
        });
    },

    async update() {
      if (this.form.team_id == 0) {
        this.form.team_id = null;
      }

      await axios
        .put(process.env.MIX_API_URL + "projects/" + this.edit.id, this.form)
        .then((response) => {
          if (response.data != null) {
            this.modal = false;
            let projectIndex = this.createdProjects.findIndex(
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

      await axios
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
      await axios
        .delete(process.env.MIX_API_URL + "projects/" + id)
        .then((response) => {
          if (response.data.project.id != id) {
            this.$alert("Something went wrong.", "Warning", "error");
          } else {
            let projectIndex = this.createdProjects.findIndex(
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
      this.dynamicTitle = "New Project";
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
.card {
  min-height: 200px;
  border: 0;
  -webkit-box-shadow: 0 10px 20px 0 rgb(0 0 0 / 20%);
  box-shadow: 0 10px 20px 0 rgb(0 0 0 / 20%);
}

.full-width {
  width: 100%;
}

.input-sm {
  height: calc(2.15rem + 2px);
}

.modal-body {
  height: 40vh;
  overflow-y: auto;
}

thead tr,
tbody tr {
  line-height: 40px;
}
</style>