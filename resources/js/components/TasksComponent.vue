<template>
  <div class="container">
    <h3 class="p-3 text-center">Tasks</h3>
    <table class="table table-striped table-bordered">
      <thead>
        <tr class="table-primary">
          <th>Title</th>
          <th>Deadline</th>
          <th>Status</th>
          <th>Priority</th>
          <th>Reporter</th>
          <th>Assignee</th>
          <th>Created At</th>
          <th>Updated At</th>
          <th>Edit</th>
          <th>Delete</th>
          <th>
            <button
              type="button"
              class="btn btn-primary"
              @click="openEditModal"
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
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="task in tasks" :key="task.id">
          <td>{{ task.title }}</td>
          <td>{{ task.description }}</td>
          <td>{{ task.date_till_done }}</td>
          <td>{{ task.status }}</td>
          <td>{{ task.priority }}</td>
          <td>{{ task.reporter }}</td>
          <td>{{ task.assignee }}</td>
          <td>{{ task.created_at }}</td>
          <td>{{ task.updated_at }}</td>
          <td>
            <button
              type="button"
              class="btn btn-primary"
              @click="openEditModal"
            >
              <span class="icon is-small">
                <i class="bi bi-gear"></i>
              </span>
            </button>
          </td>
          <td>
            <button type="button" class="button is-text" @click="openEditModal">
              <span class="icon is-small">
                <i class="mdi mdi-delete"></i>
              </span>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
  data: function () {
    return {
      assignedTasks: [],
      form: {
        title: null,
        description: null,
        date_till_done: null,
        status: null,
        priority: null,
        reporter: null,
        assignee: null,
        created_at: null,
        updated_at: null,
      },
    };
  },
  computed: {
    ...mapGetters(["errors"]),
  },
  mounted() {
    this.$store.commit("setErrors", {});
  },
  created() {
    this.read("/tasks");
  },
  methods: {
    ...mapActions("auth", ["sendRegisterRequest"]),

    async read(page_url) {
      let vm = this;
      page_url = page_url || "/tasks";

      await window.axios
        .get(process.env.MIX_API_URL + "tasks/" + this.worktime.id, data)
        .then((response) => {
          if (response.data != null) {
            this.tasks = [];
            response.data.assignedTasks.forEach((task) =>
              this.assignedTasks.push(task)
            );
            vm.makePagination();
          }
        })
        .catch((error) => {
          if (error.response.status == 404) {
            this.noTasks = true;
          }
        });
    },
  },
};
</script>

<style scoped>
</style>