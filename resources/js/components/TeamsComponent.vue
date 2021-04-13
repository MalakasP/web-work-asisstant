<template>
  <div class="container">
    <h3 class="p-3 text-center">Teams</h3>
    <div class="row justify-content-center" v-if="this.teams.length > 0">
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
    <div v-else>
      <h4 class="p-3 text-center">You are not included in any team.</h4>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import moment from "moment";

function Team({ id, name, description, created_at, updated_at }) {
  this.id = id;
  this.name = name;
  this.description = description;
  this.created_at = created_at;
  this.updated_at = updated_at;
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
      teams: {},

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

    async read() {},
  },
};
</script>

<style scoped>
</style>