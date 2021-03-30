<template>
  <div class="login mt-5">
    <div class="card">
      <div class="card-header">Login</div>
      <div class="card-body">
        <form>
          <div class="form-group">
            <label for="email">Email address</label>
            <input
              type="email"
              class="form-control"
              :class="{ 'is-invalid': errors.email }"
              id="email"
              v-model="details.email"
              placeholder="Enter email"
            />
            <div class="invalid-feedback" v-if="errors.email">
              {{ errors.email[0] }}
            </div>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input
              type="password"
              class="form-control"
              :class="{ 'is-invalid': errors.email }"
              id="password"
              v-model="details.password"
              placeholder="Password"
            />
            <div class="invalid-feedback" v-if="errors.email">
              {{ errors.email[0] }}
            </div>
          </div>
          <button type="button" @click="login" class="btn btn-primary">
            Login
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import moment from "moment";

export default {
  name: "Home",
  data: function () {
    return {
      details: {
        email: null,
        password: null,
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
  methods: {
    ...mapActions("auth", ["sendLoginRequest"]),
    ...mapActions("worktime", [
      "getWorktimesByDate",
      "setDuration",
      "createWorktime",
    ]),

    /**
     * Attempt to log in user to the application.
     */
    login: function () {
      this.sendLoginRequest(this.details)
        .then(() => {
          this.createWorktime(this.user);
          this.getTodaysWorktimesDuration();
          // this.$router.go("/home");
          this.$router.push("/");
        })
        .catch((error) => {
          if (error.response) {
            this.$store.commit("setErrors", error.response.data.errors);
          }
        });
    },

    /**
     * Get the duration of today worked hours.
     */
    getTodaysWorktimesDuration() {
      var format_to = "YYYY-MM-DD HH:mm:ss";
      var date = moment().format(format_to);
      axios
        .get(process.env.MIX_API_URL + "worktimes?date=" + date)
        .then((response) => {
          this.setDuration(
            response.data.worktimes.reduce(
              (total, worktime) => total + this.$parent._durationToSeconds(worktime.duration),
              0
            )
          );
          this.$parent.initiateTimerAfterLogin();
        })
        .catch((error) => {
          if (error.response.status === 404) {
            this.setDuration(0);
            this.$parent.initiateTimerAfterLogin();
          }
        });
    },
  },
};
</script>