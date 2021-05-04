<template>
  <div class="container">
    <h3 class="text-center p-3">Created Tasks</h3>
    <div v-if="modal">
      <transition name="model">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">{{ dynamicTitle }}</h4>
                  <button type="button" class="close" @click="closeModal()">
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
                  <div class="form-group row">
                    <div class="form-group col-md-6">
                      <label>Select Deadline</label> <br />
                      <v-date-picker
                        v-model="form.date_till_done"
                        mode="date"
                        :masks="masks"
                      >
                        <template v-slot="{ inputValue, inputEvents }">
                          <input
                            class="px-2 py-1 border rounded focus:outline-none focus:border-blue-300"
                            :value="inputValue"
                            v-on="inputEvents"
                          />
                        </template>
                      </v-date-picker>
                      <div
                        class="invalid-feedback"
                        v-if="errors.date_till_done"
                      >
                        {{ errors.date_till_done }}
                      </div>
                    </div>
                    <div class="form-group col-md-6">
                      <label>Choose Assignee</label>
                      <select
                        class="form-control"
                        :class="{ 'is-invalid': errors.assignee_id }"
                        v-model="form.assignee_id"
                      >
                        <option
                          v-for="user in teams[selectedProjectTeam].users"
                          :value="user.id"
                          :key="user.id"
                        >
                          {{ user.name }}
                        </option>
                      </select>
                      <div class="invalid-feedback" v-if="errors.assignee_id">
                        {{ errors.assignee_id }}
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="form-group col-md-6">
                      <label>Choose Status</label>
                      <select
                        class="form-control"
                        :class="{ 'is-invalid': errors.status }"
                        v-model="form.status_id"
                      >
                        <option
                          v-for="status in this.statuses"
                          :value="status.id"
                          :key="status.id"
                        >
                          {{ status.name }}
                        </option>
                      </select>
                      <div class="invalid-feedback" v-if="errors.status">
                        {{ errors.status }}
                      </div>
                    </div>
                    <div class="form-group col-md-6">
                      <label>Choose Priority</label>
                      <select
                        class="form-control to-capital-first"
                        :class="{ 'is-invalid': errors.priority }"
                        v-model="form.priority_id"
                      >
                        <option
                          v-for="priority in this.priorities"
                          :value="priority.id"
                          :key="priority.id"
                        >
                          {{ priority.name }}
                        </option>
                      </select>
                      <div class="invalid-feedback" v-if="errors.priority">
                        {{ errors.priority }}
                      </div>
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
                  <div align="center">
                    <input
                      type="button"
                      v-if="editTask == null"
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
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="card p-3" v-if="this.loaded">
          <div v-for="project in projects" :key="project.id">
            <div class="card p-3 mt-3">
              <div class="card-header bg-white justify-content-start">
                <div class="row">
                  <div class="col-2">
                    <h5
                      v-if="project.id > 0"
                      class="link"
                      @click="
                        $router.push({
                          name: 'Project',
                          params: { projectId: project.id },
                        })
                      "
                    >
                      {{ project.title }}
                    </h5>
                    <h5 v-else>{{ project.title }}</h5>
                  </div>
                  <div class="col-2">
                    <h6
                      v-if="teams[project.team_id].id > 0"
                      class="link"
                      @click="
                        $router.push({
                          name: 'Team',
                          params: { teamId: teams[project.team_id].id },
                        })
                      "
                    >
                      {{ teams[project.team_id].name }}
                    </h6>
                    <h6 v-else>{{ teams[project.team_id].name }}</h6>
                  </div>
                </div>
              </div>
              <div class="table-responsive">
                <table class="table-striped w-100 d-block d-md-table">
                  <thead v-if="project.tasks && project.tasks.length > 0">
                    <tr>
                      <th style="width: 20%">Title</th>
                      <th style="width: 20%">Deadline</th>
                      <th style="width: 20%">Status</th>
                      <th style="width: 20%">Priority</th>
                      <th style="width: 10%">Assignee</th>
                      <th style="width: 5%"></th>
                      <th style="width: 5%"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="task in project.tasks" :key="task.id">
                      <td style="width: 20%">{{ task.title }}</td>
                      <td style="width: 20%">
                        {{ task.date_till_done | monthDay }}
                      </td>
                      <td style="width: 20%">
                        {{ statuses[task.status_id].name }}
                      </td>
                      <td class="to-capital-first" style="width: 20%">
                        {{ priorities[task.priority_id].name }}
                      </td>
                      <td style="width: 10%">
                        {{ projectsUsers[task.assignee_id].name }}
                      </td>
                      <td style="width: 5%">
                        <button
                          type="button"
                          style="margin: 1px"
                          class="btn btn-primary"
                          @click="startEdit(task, project.team_id)"
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
                          style="margin: 1px"
                          @click="startDelete(task)"
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
                    <tr class="bg-white">
                      <td v-if="project.tasks && project.tasks.length > 0"></td>
                      <td v-if="project.tasks && project.tasks.length > 0"></td>
                      <td>
                        <button
                          type="button"
                          class="btn btn-secondary"
                          style="margin: 3px"
                          @click="startCreate(project)"
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
                            Add Task
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
        <div v-else class="row justify-content-center">
          <div class="loader mt-3"></div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import moment from "moment";

function Project({
  id,
  title,
  description,
  author_id,
  team_id,
  created_at,
  updated_at,
  tasks,
}) {
  this.id = id;
  this.title = title;
  this.description = description;
  this.author_id = author_id;
  this.team_id = team_id;
  this.created_at = created_at;
  this.updated_at = updated_at;
  this.tasks = tasks;
}

function Team({ id, name, description, created_at, updated_at, pivot, users }) {
  this.id = id;
  this.name = name;
  this.description = description;
  this.created_at = created_at;
  this.updated_at = updated_at;
  this.pivot = pivot;
  this.users = users;
}

export default {
  data: function () {
    return {
      loaded: false,
      noTasks: false,
      dynamicTitle: null,
      modal: false,
      statuses: {},
      priorities: {},
      editTask: null,
      taskProject: null,
      projects: {},
      projectsUsers: {},
      teams: {},
      form: {
        title: null,
        description: null,
        date_till_done: null,
        status_id: null,
        priority_id: null,
        project_id: null,
        reporter_id: null,
        assignee_id: null,
        created_at: null,
        updated_at: null,
      },
      selectedProjectTeam: null,
      masks: {
        input: "YYYY-MM-DD",
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
  filters: {
    /**
     * Filter date to show only month and day
     */
    monthDay: function (value) {
      if (!value) return "";
      value = value.toString();
      return value.substring(5, 10);
    },
  },
  methods: {
    ...mapActions("worktime", []),

    async read() {
      /**
       * Get users that the user is in the teams with
       */
      await axios
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
          this.projectsUsers = {};
          this.projectsUsers[this.user.id] = this.user;
        });

      /**
       * Get task statuses
       */
      await axios
        .get(process.env.MIX_API_URL + "taskStatuses")
        .then((response) => {
          if (response.data != null) {
            this.statuses = {};
            response.data.taskStatuses.forEach((status) => {
              this.statuses[status.id] = status;
            });
          }
        })
        .catch((error) => {
          console.log(error);
        });

      /**
       * Get task priorities
       */
      await axios
        .get(process.env.MIX_API_URL + "taskPriorities")
        .then((response) => {
          if (response.data != null) {
            this.priorities = {};
            response.data.taskPriorities.forEach((priority) => {
              this.priorities[priority.id] = priority;
            });
          }
        })
        .catch((error) => {
          console.log(error);
        });

      /**
       * Get teams that the user is in
       */
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
              users: [this.user],
            });
            console.log(this.teams);
          }
        })
        .catch((error) => {
          console.log(error);
          if (error.response.status == 404) {
            this.teams[0] = new Team({
              id: 0,
              name: "No Team",
              description: "",
              created_at: moment(),
              updated_at: moment(),
              pivot: {
                is_admin: true,
              },
              users: [this.user],
            });
          }
        });

      /**
       * Get created projects
       */
      await axios
        .get(
          process.env.MIX_API_URL + "users/" + this.user.id + "/teamProjects"
        )
        .then((response) => {
          if (response.data != null) {
            if (response.data.createdProjects != null) {
              this.projects = {};
              response.data.createdProjects.forEach((project) => {
                if (project.team_id == null) {
                  project.team_id = 0;
                }
                this.projects[project.id] = new Project(project);
                this.projects[project.id].tasks = [];
              });
            }
          }
        })
        .catch((error) => {
          console.log(error);
        });

      /**
       * Get created tasks data
       */
      await axios
        .get(process.env.MIX_API_URL + "createdTasks")
        .then((response) => {
          if (response.data != null) {
            response.data.createdTasks.forEach((project) => {
              if (project.hasOwnProperty("id")) {
                this.projects[project.id].tasks = project.tasks;
              } else if (Array.isArray(project)) {
                this.projects[0] = new Project({
                  id: 0,
                  title: "No Project",
                  description: "Tasks without project",
                  author_id: this.user.id,
                  team_id: 0,
                  created_at: moment().format(),
                  updated_at: moment().format(),
                  tasks: project,
                });
              }
            });
            this.loaded = true;
          }
        })
        .catch((error) => {;
          if (error.response.status == 404) {
            this.projects[0] = new Project({
              id: 0,
              title: "No Project",
              description: "Tasks without project",
              author_id: this.user.id,
              team_id: 0,
              created_at: moment().format(),
              updated_at: moment().format(),
              tasks: [],
            });
          }
          this.loaded = true;
        });
    },

    /**
     * Update the selected task
     */
    async update() {
      if (this.form.project_id == 0) {
        this.form.project_id = null;
      }

      await axios
        .put(process.env.MIX_API_URL + "tasks/" + this.editTask.id, this.form)
        .then((response) => {
          if (response.data != null) {
            this.modal = false;
            if (this.editTask.project_id != null) {
              let taskIndex = this.projects[
                this.editTask.project_id
              ].tasks.findIndex((task) => task.id == this.editTask.id);
              this.projects[this.editTask.project_id].tasks.splice(
                taskIndex,
                1,
                response.data.task
              );
            } else {
              let taskIndex = this.projects[0].tasks.findIndex(
                (task) => task.id == this.editTask.id
              );
              this.projects[0].tasks.splice(taskIndex, 1, response.data.task);
            }
            this.editTask = null;
            this.$notify({
              group: "app",
              title: "Success!",
              type: "success",
              text: "Task was updated!",
            });
          }
        })
        .catch((error) => {
          console.log(error);
          if (error.response) {
            if (error.response.status != 422) {
              this.modal = false;
              this.editTask = null;
              this.$alert("Something went wrong", "Warning", "error");
            } else {
              if (this.form.project_id == null) {
                this.form.project_id = 0;
              }
              this.$store.commit("setErrors", error.response.data.errors);
            }
          }
        });
    },

    /**
     * Create new task
     */
    async create() {
      if (this.form.project_id == 0) {
        this.form.project_id = null;
      }

      await axios
        .post(process.env.MIX_API_URL + "tasks", this.form)
        .then((response) => {
          if (response.data != null) {
            this.modal = false;
            if (this.form.project_id != null) {
              this.projects[this.form.project_id].tasks.push(
                response.data.task
              );
            } else {
              this.projects[0].tasks.push(response.data.task);
            }

            this.$notify({
              group: "app",
              title: "Success!",
              type: "success",
              text: "Task was added!",
            });
          }
        })
        .catch((error) => {
          console.log(error);
          if (error.response) {
            console.log(error);
            if (error.response.status != 422) {
              this.modal = false;
              this.$alert(error.response.data.status, "Warning", "error");
            } else {
              console.log(error);
              this.$store.commit("setErrors", error.response.data.errors);
            }
          }
        });
    },

    /**
     * Delete the selected task
     */
    async delete(task) {
      await axios
        .delete(process.env.MIX_API_URL + "tasks/" + task.id)
        .then((response) => {
          if (response.data.task.id != task.id) {
            this.$alert("Something went wrong.", "Warning", "error");
          } else {
            if (task.project_id != null) {
              this.projects[task.project_id].tasks.splice(
                this.projects[task.project_id].tasks.indexOf(task),
                1
              );
              this.$forceUpdate();
            } else {
              this.projects[0].tasks.splice(
                this.projects[0].tasks.indexOf(task),
                1
              );
              this.$forceUpdate();
            }
            console.log(this.projects);
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
          if (error.response.status == 403) {
            this.$alert(error.response.data.error, "Forbidden", "error");
          } else if (error.response.status == 404) {
            this.$alert(
              error.response.data.message,
              "Task Not Found!",
              "error"
            );
          } else {
            this.$alert("Something went wrong", "Warning", "error");
          }
        });
    },

    /**
     * Start creation of a new task
     */
    startCreate(project) {
      this.$store.commit("setErrors", {});
      this.modal = true;
      this.dynamicTitle = "Create Task";
      this.form.title = null;
      this.form.description = null;
      this.form.date_till_done = moment().format("YYYY-MM-DD");
      this.form.status_id = this.statuses[1].id;
      this.form.priority_id = this.priorities[1].id;
      if (project.team_id != null) {
        this.selectedProjectTeam = project.team_id;
      } else {
        this.selectedProjectTeam = 0;
      }
      this.form.project_id = this.projects[project.id].id;
      this.form.reporter_id = this.user.id;
      this.form.assignee_id = this.teams[this.selectedProjectTeam].users[0].id;
    },

    /**
     * Start editing of the selected task
     */
    startEdit(task, projectTeamId) {
      this.$store.commit("setErrors", {});
      this.modal = true;
      this.dynamicTitle = "Edit Task";
      this.editTask = task;
      this.form.title = task.title;
      this.form.description = task.description;
      this.form.date_till_done = moment(task.date_till_done).format(
        "YYYY-MM-DD"
      );
      this.form.status_id = task.status_id;
      this.form.priority_id = task.priority_id;
      if (task.project_id != null) {
        this.form.project_id = task.project_id;
      } else {
        this.form.project_id = this.projects[0].id;
      }
      if (projectTeamId != null) {
        this.selectedProjectTeam = projectTeamId;
      } else {
        this.selectedProjectTeam = 0;
      }
      this.form.reporter_id = task.reporter_id;
      this.form.assignee_id = task.assignee_id;
    },

    /**
     * Start deletion of the selected task
     */
    startDelete(task) {
      this.$store.commit("setErrors", {});
      this.$confirm("Are You sure?", "Confirm Delete", "error")
        .then(() => {
          this.delete(task);
        })
        .catch();
    },

    /**
     * Close modal window
     */
    closeModal() {
      this.modal = false;
      this.editTask = null;
    },

    /**
     * Load selected project component
     */
    goToProject(name, id) {
      if (id > 0) {
        this.$router.push({ name: name, params: { projectId: id } });
      }
    },

    /**
     * Load selected team component
     */
    goToTeam(name, id) {
      if (id > 0) {
        this.$router.push({ name: name, params: { teamId: id } });
      }
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

.to-capital-first {
  text-transform: capitalize;
}

.modal-body {
  height: 60vh;
  overflow-y: auto;
}

.link:hover {
  color: #007bff;
}
</style>