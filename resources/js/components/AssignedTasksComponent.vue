<template>
  <div class="container">
    <h3 class="p-3 text-center">Assigned Tasks</h3>
    <div class="container">
      <div class="card p-3 m-b-3">
        <div v-if="!this.noTasks">
          <div v-for="project in projects" :key="project.id">
            <h5 class="p-1 mt-3 text-left">{{ project.title }}</h5>
            <div class="card p-3">
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
      loaded: false,
      noTasks: false,
      projects: [],
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
    async read() {
      await window.axios
        .get(process.env.MIX_API_URL + "assignedTasks")
        .then((response) => {
          if (response.data != null) {
            this.assignedTasks = [];
            response.data.assignedTasks.forEach((project) => {
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
  },
};
</script>

<style scoped>
</style>