<template>
  <div class="container">
    <h3 class="p-3 text-center">Assigned Tasks</h3>
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
                    <label>Select Deadline</label> <br/>
                    <v-date-picker v-model="form.date_till_done" mode="date" :min-date='new Date()' >
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
                  <div class="form-group">
                    <label>Choose Status</label>
                    <select
                      class="form-control"
                      :class="{ 'is-invalid': errors.status }"
                      v-model="form.status"
                    >
                      <option
                        v-for="status in this.statuses"
                        :value="status.val"
                        :key="status.val"
                      >
                        {{ status.val }}
                      </option>
                    </select>
                    <div class="invalid-feedback" v-if="errors.status">
                      {{ errors.status }}
                    </div>
                  </div>
                  <div align="center">
                    <input
                      type="button"
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
    <div class="container">
      <div class="card p-3 m-b-3">
        <div v-if="!this.noTasks">
          <div v-for="project in projects" :key="project.id">
            <div class="card p-3 mt-3">
              <div class="card-header bg-white justify-content-start">
                <div class="row">
                  <div class="col-2">
                    <h5>{{ project.title }}</h5>
                  </div>
                  <div class="col-2">
                    <h6>{{ teams[project.team_id].name }}</h6>
                  </div>
                </div>
              </div>
              <table class="table-striped w-100 d-block d-md-table">
                <thead>
                  <tr>
                    <th style="width: 20%">Title</th>
                    <th style="width: 20%">Deadline</th>
                    <th style="width: 20%">Status</th>
                    <th style="width: 20%">Priority</th>
                    <th style="width: 10%"></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="task in project.tasks" :key="task.id">
                    <td style="width: 20%">{{ task.title }}</td>
                    <td style="width: 20%">
                      {{ task.date_till_done | monthDay }}
                    </td>
                    <td style="width: 20%">{{ task.status }}</td>
                    <td style="width: 20%">{{ task.priority }}</td>
                    <td style="width: 10%">
                      <button
                        type="button"
                        style="margin: 1px"
                        class="btn btn-primary"
                        @click="startEdit(task)"
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
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div v-else-if="this.loaded">
          <h4 class="p-3 text-center">You have no assigned tasks.</h4>
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
      teams: {},
      projects: [],
      edit: null,
      modal: false,
       statuses: {
        1: { val: "To Do" },
        2: { val: "In Progress" },
        3: { val: "Done" },
      },
      form: {
        title: null,
        description: null,
        date_till_done: null,
        status: null,
        priority: null,
        project_id: null,
        reporter_id: null,
        assignee_id: null,
        created_at: null,
        updated_at: null,
      },
      dynamicTitle: null,
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
    monthDay: function (value) {
      if (!value) return "";
      value = value.toString();
      return value.substring(5, 10);
    },
  },
  methods: {
    async read() {
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
        .get(process.env.MIX_API_URL + "assignedTasks")
        .then((response) => {
          if (response.data != null) {
            this.assignedTasks = [];
            response.data.assignedTasks.forEach((project) => {
              if (project.hasOwnProperty("id")) {
                if(project.team_id == null) {
                  project.team_id = 0;
                }
                this.projects.push(new Project(project));
              } else if (project[0].project_id === null) {
                this.projects.push(
                  new Project({
                    id: 0,
                    title: "No Project",
                    description: "Tasks without project",
                    author_id: this.user.id,
                    team_id: 0,
                    created_at: moment().format(),
                    updated_at: moment().format(),
                    tasks: project,
                  })
                );
              }
              this.loaded = true;
            });
          }
        })
        .catch((error) => {
          if (error.response.status == 404) {
            this.noTasks = true;
            this.loaded = true;
            console.log(this.noTasks, this.loaded);
          }
        });
    },

    async update() {
      await axios
        .put(process.env.MIX_API_URL + "tasks/" + this.edit.id, this.form)
        .then((response) => {
          if (response.data != null) {
            this.modal = false;
            if (this.edit.project_id != null) {
              let taskIndex = this.projects[
                this.edit.project_id
              ].tasks.findIndex((task) => task.id == this.edit.id);
              this.projects[this.edit.project_id].tasks.splice(
                taskIndex,
                1,
                response.data.task
              );
            } else {
              let taskIndex = this.projects[0].tasks.findIndex(
                (task) => task.id == this.edit.id
              );
              this.projects[0].tasks.splice(taskIndex, 1, response.data.task);
            }
            this.edit = null;
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
              this.$store.commit("setErrors", error.response.data.errors);
            }
          }
        });
    },

    startEdit(task) {
      this.$store.commit("setErrors", {});
      this.dynamicTitle = "Edit task";
      this.edit = task;
      this.modal = true;
       this.form.title = task.title;
      this.form.description = task.description;
      this.form.date_till_done = task.date_till_done;
      this.form.status = task.status;
      this.form.priority = task.priority;
      this.form.project_id = task.project_id;
      this.form.reporter_id = task.reporter_id;
      this.form.assignee_id = task.assignee_id;
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
</style>