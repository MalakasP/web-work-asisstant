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
                  <button type="button" class="close" @click="closeModal()">
                    <span aria-hidden="true">&times; </span>
                  </button>
                </div>
                <div class="modal-body" v-if="!editProject">
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
                          v-for="user in project.team.users"
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
                      @click="updateTask"
                    />
                  </div>
                </div>
                <div class="modal-body" v-else>
                  <div class="form-group">
                    <label>Enter Title</label>
                    <input
                      type="text"
                      class="form-control"
                      :class="{ 'is-invalid': errors.title }"
                      v-model="editProjectForm.title"
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
                      v-model="editProjectForm.description"
                      rows="3"
                    ></textarea>
                    <div class="invalid-feedback" v-if="errors.description">
                      {{ errors.description }}
                    </div>
                  </div>
                  <div align="center">
                    <input
                      type="button"
                      class="btn btn-primary"
                      value="Submit"
                      @click="updateProject"
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
      v-if="Object.keys(this.project).length > 0 && this.loaded && !this.error"
    >
      <div class="container">
        <div class="card mt-5">
          <div class="card-header bg-white">
            <div class="row justify-content-between">
              <div class="col-4">
                <button type="button" class="btn btn-primary" @click="goBack()">
                  <span class="icon is-small">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="16"
                      height="16"
                      fill="currentColor"
                      class="bi bi-arrow-left"
                      viewBox="0 0 16 16"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"
                      />
                    </svg>
                  </span>
                </button>
              </div>
              <div class="col-4">
                <button
                  type="button"
                  class="btn btn-danger float-right"
                  style="margin: 1px"
                  @click="startDeleteProject()"
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
                <button
                  type="button"
                  class="btn btn-primary float-right"
                  style="margin: 1px"
                  @click="startEditProject()"
                >
                  <span class="icon is-small">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="16"
                      height="16"
                      fill="currentColor"
                      class="bi bi-pencil-square"
                      viewBox="0 0 16 16"
                    >
                      <path
                        d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"
                      />
                      <path
                        fill-rule="evenodd"
                        d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"
                      />
                    </svg>
                  </span>
                </button>
              </div>
            </div>
          </div>
          <div class="card-body">
            <h3 class="card-title text-center">{{ project.title }}</h3>
            <h5 class="card-text min-height p-3" v-if="project.description">
              {{ project.description }}
            </h5>
            <button
              v-if="project.tasks && Object.keys(project.tasks).length > 0"
              type="button"
              class="btn btn-success m-3"
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
                Create Task
              </span>
            </button>
            <div v-if="project.tasks && Object.keys(project.tasks).length > 0">
              <div
                class="row justify-content-center"
                v-for="status in statuses"
                :key="status.id"
              >
                <h5 class="p-3" v-if="project.tasks[status.name].length > 0">
                  {{ status.name }}
                </h5>
                <div class="col-12">
                  <div class="table-responsive">
                    <table
                      class="table-striped w-100 d-block d-md-table"
                      v-if="project.tasks[status.name].length > 0"
                    >
                      <thead>
                        <tr>
                          <th style="width: 40%">Title</th>
                          <th style="width: 20%">Deadline</th>
                          <th style="width: 20%">Priority</th>
                          <th style="width: 10%">Assignee</th>
                          <th style="width: 5%"></th>
                          <th style="width: 5%"></th>
                        </tr>
                      </thead>
                      <tbody v-if="project.tasks[status.name].length > 0">
                        <tr
                          v-for="task in project.tasks[status.name]"
                          :key="task.id"
                        >
                          <td style="width: 40%">{{ task.title }}</td>
                          <td style="width: 20%">
                            {{ task.date_till_done | monthDay }}
                          </td>
                          <td class="to-capital-first" style="width: 20%">
                            {{ priorities[task.priority_id].name }}
                          </td>
                          <td style="width: 10%">
                            {{ project.team.users[task.assignee_id].name }}
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
                              @click="startDeleteTask(task)"
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
            <div v-else class="text-center">
              <h5>No tasks in project.</h5>
              <button
                type="button"
                class="btn btn-success"
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
                  Create Task
                </span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-else-if="this.loaded && this.error">
      <not-found-component></not-found-component>
    </div>
    <div v-else class="row justify-content-center">
      <div class="loader mt-3"></div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import moment from "moment";
import NotFoundComponent from "../home/NotFoundComponent";

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
  components: { NotFoundComponent },
  data: function () {
    return {
      isAdmin: false,
      loaded: false,
      project: {
        tasks: {},
      },
      statuses: {},
      priorities: {},
      error: false,
      createForm: false,
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
      modal: false,
      dynamicTitle: null,
      editTask: null,
      editProject: false,
      editProjectForm: {
        name: null,
        description: null,
      },
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
    this.fetchProjectTasksByStatus();
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
    /**
     * Get context data for project component
     */
    async read() {
      /**
       * Get project data
       */
      await axios({
        url:
          process.env.MIX_API_URL + "projects/" + this.$route.params.projectId,
        baseURL: "/",
      })
        .then((response) => {
          if (response.data != null) {
            this.project = {};
            this.project = response.data.project;
            console.log(this.project);
          }
        })
        .catch((error) => {
          if (error.response.status == 404) {
            this.error = true;
          }
        });

      /**
       * Get team data
       */
      await axios({
        url: process.env.MIX_API_URL + "teams/" + this.project.team_id,
        baseURL: "/",
      })
        .then((response) => {
          if (response.data != null) {
            let users = {};
            response.data.team.users.forEach((user) => {
              users[user.id] = user;
            });
            this.project.team = new Team({
              id: response.data.team.id,
              name: response.data.team.name,
              description: response.data.team.description,
              created_at: moment(),
              updated_at: moment(),
              pivot: response.data.team.pivot,
              users: users,
            });
          }
        })
        .catch((error) => {
          if (error.response.status == 404) {
            this.project.team = {};
            this.project.team = new Team({
              id: 0,
              name: "No Team",
              description: "",
              created_at: moment(),
              updated_at: moment(),
              pivot: {
                is_admin: true,
              },
              users: {},
            });
            this.project.team.users[this.user.id] = this.user;
          }
        });

      /**
       * Get task priorities
       */
      await axios({
        url: process.env.MIX_API_URL + "taskPriorities",
        baseURL: "/",
      })
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
       * Get task statuses
       */
      await axios({
        url: process.env.MIX_API_URL + "taskStatuses",
        baseURL: "/",
      })
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
    },

    /**
     * Get project tasks grouped by status
     */
    async fetchProjectTasksByStatus() {
      await axios({
        url:
          process.env.MIX_API_URL +
          "project/" +
          this.$route.params.projectId +
          "/tasks",
        baseURL: "/",
      })
        .then((response) => {
          if (response.data != null) {
            console.log(response.data);
            this.project.tasks = {};
            this.project.tasks = response.data.tasks;
            this.$forceUpdate();
            this.loaded = true;
          }
        })
        .catch((error) => {
          if (error.response.status == 404) {
            this.project.tasks = {};
            console.log(this.project.tasks);
            this.loaded = true;
          }
        });
    },

    /**
     * Create task for the project
     */
    async create() {
      await axios({
        method: "post",
        url: process.env.MIX_API_URL + "tasks",
        baseURL: "/",
        data: this.form,
      })
        .then((response) => {
          if (response.data != null) {
            this.modal = false;
            Object.values(this.statuses).forEach((status) => {
              if (status.id == this.form.status_id) {
                if (this.project.tasks[status.name].length < 1) {
                  this.project.tasks[status.name] = [];
                }
                this.project.tasks[status.name].push(response.data.task);
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
     * Delete selected task of the project
     */
    async deleteTask(task) {
      await axios({
        method: "delete",
        url: process.env.MIX_API_URL + "tasks/" + task.id,
        baseURL: "/",
      })
        .then((response) => {
          if (response.data != null) {
            Object.values(this.statuses).forEach((status) => {
              if (status.id == task.status_id) {
                this.project.tasks[status.name].splice(
                  this.project.tasks[status.name].indexOf(task),
                  1
                );
                this.$forceUpdate();
              }
            });

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
     * Update selected task of the project
     */
    async updateTask() {
      await axios({
        method: "put",
        url: process.env.MIX_API_URL + "tasks/" + this.editTask.id,
        baseURL: "/",
        data: this.form,
      })
        .then((response) => {
          if (response.data != null) {
            Object.values(this.statuses).forEach((status) => {
              if (status.id == this.editTask.status_id) {
                this.project.tasks[status.name].splice(
                  this.project.tasks[status.name].indexOf(this.editTask),
                  1
                );
              }

              if (status.id == this.form.status_id) {
                if (this.project.tasks[status.name].length < 1) {
                  this.project.tasks[status.name] = [];
                }
                this.project.tasks[status.name].push(response.data.task);
              }
            });
            this.closeModal();
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
            if (error.response.status == 403) {
              this.closeModal();
              this.$alert(error.response.data.error, "Forbidden", "error");
            } else if (error.response.status == 422) {
              this.$store.commit("setErrors", error.response.data.errors);
            } else {
              this.closeModal();
              this.$alert("Something went wrong", "Warning", "error");
            }
          }
        });
    },

    /**
     * Delete the project
     */
    async deleteProject() {
      await axios({
        method: "delete",
        url: process.env.MIX_API_URL + "projects/" + this.project.id,
        baseURL: "/",
        data: this.form,
      })
        .then((response) => {
          if (response.data != null) {
            this.goBack();
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
     * Update project information
     */
    async updateProject() {
      await axios({
        method: "put",
        url: process.env.MIX_API_URL + "projects/" + this.project.id,
        baseURL: "/",
        data: this.editProjectForm,
      })
        .then((response) => {
          if (response.data != null) {
            this.closeModal();
            this.project.title = this.editProjectForm.title;
            this.project.description = this.editProjectForm.description;
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
            if (error.response.status == 403) {
              this.closeModal();
              this.$alert(error.response.data.error, "Forbidden", "error");
            } else if (error.response.status == 422) {
              this.$store.commit("setErrors", error.response.data.errors);
            } else {
              this.closeModal();
              this.$alert(error.response.data.status, "Warning", "error");
            }
          }
        });
    },

    /**
     * Start creation of the task
     */
    startCreate() {
      this.$store.commit("setErrors", {});
      this.modal = true;
      this.dynamicTitle = "Create Task";
      this.form.title = null;
      this.form.description = null;
      this.form.date_till_done = moment().format("YYYY-MM-DD");
      this.form.status_id = this.statuses[1].id;
      this.form.priority_id = this.priorities[1].id;
      this.form.project_id = this.project.id;
      this.form.reporter_id = this.user.id;
      if (this.project.team_id != null) {
        this.form.assignee_id = this.project.team.users[this.user.id].id;
      } else {
        this.form.assignee_id = this.user.id;
      }
    },

    /**
     * Start editing of the task
     */
    startEdit(task) {
      this.$store.commit("setErrors", {});
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
        this.form.project_id = this.project.id;
      }
      this.form.reporter_id = task.reporter_id;
      this.form.assignee_id = task.assignee_id;
    },

    /**
     * Start deletion of the task
     */
    startDeleteTask(task) {
      this.$confirm("Are You sure?", "Confirm Delete", "error")
        .then(() => {
          this.deleteTask(task);
        })
        .catch((error) => {
          console.log(error);
        });
    },

    /**
     * Start deletion of the project
     */
    startDeleteProject() {
      this.$confirm("Are You sure?", "Confirm Delete", "error")
        .then(() => {
          this.deleteProject();
        })
        .catch((error) => {
          console.log(error);
        });
    },

    /**
     * Start edition of the project information
     */
    startEditProject() {
      this.$store.commit("setErrors", {});
      this.dynamicTitle = "Edit Project";
      this.modal = true;
      this.editProject = true;
      this.editProjectForm.title = this.project.title;
      this.editProjectForm.description = this.project.description;
    },

    /**
     * Go back one page
     */
    goBack() {
      this.$router.go(-1);
    },

    /**
     * Close modal window
     */
    closeModal() {
      this.modal = false;
      this.editTask = null;
      this.editProject = false;
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

.min-height {
  min-height: 50px;
}

.to-capital-first {
  text-transform: capitalize;
}

thead tr,
tbody tr {
  line-height: 40px;
}

.card-header {
  border: none;
  padding-top: 0.75rem;
  padding-left: 1.25rem;
  padding-right: 1.25rem;
  padding-bottom: 0;
}
</style>