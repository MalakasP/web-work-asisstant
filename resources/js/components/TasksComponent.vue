<template>
  <div class="container">
    <h3 class="p-3 text-center">Tasks</h3>
    <div v-for="project in userProjects" :key="project.id">
      <div class="card p-3">
        <div class="card">
          <h5 class="p-3 text-left">{{ project.title }}</h5>
        </div>
        <div class="card">
          <table class="table-striped">
            <thead>
              <tr>
                <th>Title</th>
                <th>Deadline</th>
                <th>Status</th>
                <th>Priority</th>
                <th>Edit</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="task in project.tasks" :key="task.id">
                <td>{{ task.title }}</td>
                <td>{{ task.date_till_done }}</td>
                <td>{{ task.status }}</td>
                <td>{{ task.priority }}</td>
                <td>
                  <button
                    type="button"
                    class="btn btn-primary"
                    @click="startEdit()"
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
                    Edit
                  </button>
                </td>
                <td>
                  <button type="button" class="button is-text" @click="del(id)">
                    <span class="icon is-small">
                      <i class="mdi mdi-delete"></i>
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
      userProjects: [],
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

    // projectsWithUserTasks: function () {
    //   return this.userProjects.filter((project) => {
    //     typeof project.tasks != "undefined" && project.tasks.lenght > 0;
    //   });
    // },
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
        .get(process.env.MIX_API_URL + "users/" + this.user.id + "/projects")
        .then((response) => {
          if (response.data != null) {
            this.userProjects = [];
            response.data.projects.forEach((project) =>
              this.userProjects.push(new Project(project))
            );
          }
        })
        .catch((error) => {
          console.log(error);
          if (error.response.status == 404) {
            this.projects = true;
          }
        });

      await window.axios
        .get(process.env.MIX_API_URL + "assignedTasks")
        .then((response) => {
          if (response.data != null) {
            this.assignedTasks = [];
            response.data.assignedTasks.forEach((project) => {
              if (
                this.userProjects.find(
                  (userProject) => userProject.id === project[0].project_id
                )
              ) {
                var userProject = this.userProjects.find(
                  (userProject) => userProject.id === project[0].project_id
                );

                userProject.tasks = project;
              } else if (project[0].project_id === null) {
                this.userProjects.push(
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

            this.userProjects = this.userProjects.filter(this.filterProject);
          }
        })
        .catch((error) => {
          console.log(error);
          if (error.response.status == 404) {
            this.noTasks = true;
          }
        });
    },

    filterProject(project) {
      if (typeof project.tasks != "undefined" && project.tasks.length > 0) {
        return project;
      }
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