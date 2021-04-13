<template>
  <div class="container">
    <h3 class="p-3 text-center">Teams</h3>
    <div class="container">
      <div class="card p-3 m-b-3">
        <div v-for="team in teams" :key="team.id">
          <h5 class="p-1 text-left">{{ team.title }}</h5>
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
function Team({
  id,

 

  created_at,
  updated_at,
}) {
  this.id = id;

  this.created_at = created_at;
  this.updated_at = updated_at;
}

function User({
  id,

  created_at,
  updated_at,
  teams
}) {
  this.id = id;

  this.created_at = created_at;
  this.updated_at = updated_at;
  this.teams = teams;
}

export default {
  data: function () {
    return {

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
    ...mapActions("worktime"),

    async read() {
 
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