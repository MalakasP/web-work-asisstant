<template>
  <div class="container">
    <h3 class="text-center p-3">Created Tasks</h3>
    <div class="row">
      <div class="col-3 float-md-right">
        <button type="button" class="btn btn-secondary" @click="startCreate()">
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
      </div>
    </div>
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
                      editTask = null;
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
                  <div class="form-group row">
                    <div class="form-group col-md-6">
                      <label>Enter Deadline</label>
                      <input
                        type="date"
                        class="form-control"
                        :class="{ 'is-invalid': errors.date_till_done }"
                        v-model="form.date_till_done"
                      />
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
                          v-for="user in this.projectsUsers"
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
                    <div class="form-group col-md-6">
                      <label>Choose Priority</label>
                      <select
                        class="form-control to-capital-first"
                        :class="{ 'is-invalid': errors.priority }"
                        v-model="form.priority"
                      >
                        <option
                          v-for="priority in this.priorities"
                          :value="priority.val"
                          :key="priority.val"
                        >
                          {{ priority.val }}
                        </option>
                      </select>
                      <div class="invalid-feedback" v-if="errors.priority">
                        {{ errors.priority }}
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Choose Project</label>
                    <select
                      class="form-control"
                      :class="{ 'is-invalid': errors.project_id }"
                      v-model="form.project_id"
                    >
                      <option
                        v-for="project in this.projects"
                        :value="project.id"
                        :key="project.id"
                      >
                        {{ project.title }}
                      </option>
                    </select>
                    <div class="invalid-feedback" v-if="errors.project_id">
                      {{ errors.project_id }}
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
        <div class="card p-3">
          <div v-for="project in projects" :key="project.id">
            <h5 class="text-left p-1">{{ project.title }}</h5>
            <div class="card p-3">
              <table class="table-striped table-responsive">
                <thead>
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
                    <td style="width: 20%">{{ task.status }}</td>
                    <td class="to-capital-first" style="width: 20%">
                      {{ task.priority }}
                    </td>
                    <td style="width: 10%">
                      {{ projectsUsers[task.assignee_id].name }}
                    </td>
                    <td style="width: 5%">
                      <button
                        type="button"
                        class="btn btn-primary"
                        @click="startEdit(task)"
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
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import moment from "moment";

function Task({
  id,
  title,
  description,
  date_till_done,
  status,
  priority,
  project_id,
  reporter_id,
  assignee_id,
  created_at,
  updated_at,
}) {
  this.id = id;
  this.title = title;
  this.description = description;
  this.date_till_done = date_till_done;
  this.status = status;
  this.priority = priority;
  this.project_id = project_id;
  this.reporter_id = reporter_id;
  this.assignee_id = assignee_id;
  this.created_at = created_at;
  this.updated_at = updated_at;
}

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

export default {
  data: function () {
    return {
      noTasks: false,
      dynamicTitle: null,
      modal: false,
      statuses: {
        1: { val: "To Do" },
        2: { val: "In Progress" },
        3: { val: "Done" },
      },
      priorities: {
        1: { val: "lowest" },
        2: { val: "low" },
        3: { val: "medium" },
        4: { val: "high" },
        5: { val: "critical" },
      },
      editTask: null,
      taskProject: null,
      projects: [],
      projectsUsers: {},
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
      return value.substring(5);
    },
  },
  methods: {
    ...mapActions("worktime", []),

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
        .get(process.env.MIX_API_URL + "createdTasks")
        .then((response) => {
          if (response.data != null) {
            this.projects = [];
            response.data.createdTasks.forEach((project) => {
              if (project.hasOwnProperty("id")) {
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
            });
          }
        })
        .catch((error) => {
          console.log(error);
          if (error.response.status == 404) {
            this.noTasks = true;
          }
        });
    },

    async update() {
      if (this.form.project_id == 0) {
        this.form.project_id = null;
      }

      await window.axios
        .put(process.env.MIX_API_URL + "tasks/" + this.editTask.id, this.form)
        .then((response) => {
          if (response.data != null) {
            this.modal = false;
            if (this.editTask.project_id != null) {
              this.projects.forEach((project) => {
                if (project.id == this.editTask.project_id) {
                  var taskIndex = project.tasks.findIndex(
                    (task) => task.id == this.editTask.id
                  );
                  project.tasks.splice(taskIndex, 1, response.data.task);
                }
              });
            } else {
              var taskIndex = this.projects[0].tasks.find(
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
              this.$alert(error.response.data.status, "Warning", "error");
            } else {
              if (this.form.project_id == null) {
                this.form.project_id = 0;
              }
              this.$store.commit("setErrors", error.response.data.errors);
            }
          }
        });
    },

    async create() {
      if (this.form.project_id == 0) {
        this.form.project_id = null;
      }

      await window.axios
        .post(process.env.MIX_API_URL + "tasks", this.form)
        .then((response) => {
          if (response.data != null) {
            this.modal = false;
            this.projects.forEach((project) => {
              if (project.id == this.form.project_id) {
                project.tasks.push(response.data.task);
              }
            });
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
            if (error.response.status != 422) {
              this.modal = false;
              this.$alert(error.response.data.status, "Warning", "error");
            } else {
              this.$store.commit("setErrors", error.response.data.errors);
            }
          }
        });
    },

    async delete(task) {
      await window.axios
        .delete(process.env.MIX_API_URL + "tasks/" + task.id)
        .then((response) => {
          if (response.data.task.id != task.id) {
            this.$alert("Something went wrong.", "Warning", "error");
          } else {
            if (this.task.project_id != null) {
              this.projects.forEach((project) => {
                if (project.id == task.project_id) {
                  var taskIndex = project.tasks.findIndex(
                    (task) => task.id == this.task.id
                  );
                  project.tasks.splice(taskIndex, 1);
                }
              });
            } else {
              var taskIndex = this.projects[0].tasks.find(
                (task) => task.id == task.id
              );
              this.projects[0].tasks.splice(taskIndex, 1);
            }
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

    startCreate() {
      this.modal = true;
      this.dynamicTitle = "Create Task";
      this.form.title = null;
      this.form.description = null;
      this.form.date_till_done = moment().format("YYYY-MM-DD");
      this.form.status = this.statuses[1].val;
      this.form.priority = this.priorities[1].val;
      this.form.project_id = this.projects[0].id;
      this.form.reporter_id = this.user.id;
      this.form.assignee_id = this.projectsUsers[1].id;
    },

    startEdit(task) {
      this.modal = true;
      this.dynamicTitle = "Edit Task";
      this.editTask = task;
      this.form.title = task.title;
      this.form.description = task.description;
      this.form.date_till_done = task.date_till_done;
      this.form.status = task.status;
      this.form.priority = task.priority;
      if (task.project_id != null) {
        this.form.project_id = task.project_id;
      } else {
        this.form.project_id = this.projects[0].id;
      }

      this.form.reporter_id = task.reporter_id;
      this.form.assignee_id = task.assignee_id;
    },

    startDelete(task) {
      this.$confirm("Are You sure?", "Confirm Delete", "error").then(() => {
        this.delete(task);
      });
    },
  },
};
</script>

<style scoped>
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
  height: 65vh;
  overflow-y: auto;
}
</style>