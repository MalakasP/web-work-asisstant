<template>
  <div class="container">
    <h3 class="p-3 text-center">Assigned Tasks</h3>
    <div class="container">
      <div v-for="project in projects" :key="project.id">
        <div class="card p-3 m-b-3">
          <div class="card">
            <h5 class="p-1 text-left">{{ project.title }}</h5>
          </div>
          <div class="card p-3">
            <table class="table-striped">
              <thead>
                <tr>
                  <th>Title</th>
                  <th>Deadline</th>
                  <th>Status</th>
                  <th>Priority</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="task in project.tasks" :key="task.id">
                  <td>{{ task.title }}</td>
                  <td>{{ task.date_till_done }}</td>
                  <td>{{ task.status }}</td>
                  <td>{{ task.priority }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import moment from "moment";
// <div>
//   <h2 class="p-3 text-center">You have no tasks assigned!</h2>
// </div>
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
      modal: false,
      projects: [],
      projectsWithUserTasks: [],
      pagination: {},
      editForm: {
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
  methods: {
    ...mapActions("worktime", ["makePagination"]),

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
                console.log(project);
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

    startEdit(id) {
      this.modal = true;
      this.form.title = null;
      this.form.description = null;
      this.form.date_till_done = null;
      this.form.status = null;
      this.form.priority = null;
      this.form.project_id = null;
      this.form.reporter_id = null;
      this.form.assignee_id = null;
      this.form.created_at = null;
      this.form.updated_at = null;
    },
  },
};
</script>

<style scoped>
</style>