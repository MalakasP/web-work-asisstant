<template>
  <div>
    <header>
      <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-primary">
        <router-link class="navbar-brand" to="/">Work Assistant</router-link>
        <button
          class="navbar-toggler"
          type="button"
          data-toggle="collapse"
          data-target="#navbarCollapse"
          aria-controls="navbarCollapse"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item" v-show="isAuthenticated">
              <router-link class="nav-link" to="/tasks">Tasks</router-link>
            </li>
            <li class="nav-item" v-show="isAuthenticated">
              <router-link class="nav-link" to="/">Projects</router-link>
            </li>
            <li class="nav-item" v-show="isAuthenticated">
              <router-link class="nav-link" to="/">Teams</router-link>
            </li>
            <li class="nav-item" v-show="isAuthenticated">
              <router-link class="nav-link" to="/">Worktimes</router-link>
            </li>
          </ul>
          <ul class="navbar-nav">
            <li class="nav-item" v-show="!isAuthenticated">
              <router-link class="nav-link" to="/login">Login</router-link>
            </li>
            <li class="nav-item" v-show="!isAuthenticated">
              <router-link class="nav-link" to="/register"
                >Register</router-link
              >
            </li>
            <li
              class="nav-item timer"
              v-show="isAuthenticated"
              v-if="loadingStatus"
            >
              <strong>{{ activeTimerString }}</strong>
            </li>
            <li class="nav-item timer" v-show="isAuthenticated" v-else>
              <div class="loader"></div>
            </li>
            <button
              type="button"
              class="btn btn-light"
              @click="stopTimer"
              v-show="isAuthenticated && !isTimerStopped"
            >
              Stop
            </button>
            <button
              type="button"
              class="btn btn-light"
              @click="startTimer"
              v-show="isAuthenticated && isTimerStopped"
            >
              Start
            </button>
            <li class="nav-item" v-show="isAuthenticated && isTimerStopped">
              <a class="nav-link" href="#" @click="logout">Logout</a>
            </li>
          </ul>
        </div>
      </nav>
    </header>

    <main role="main" class="container">
      <router-view />
    </main>

    <footer class="footer">
      <div class="container text-center">
        <span class="text-muted">
          © 2021 Copyright:
          <a>PM</a>
        </span>
      </div>
    </footer>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import moment from "moment";

export default {
  data() {
    return {
      loadingStatus: false,
      activeTimerString: "00:00",
      counter: { seconds: 0, timer: null },
    };
  },

  computed: {
    ...mapGetters("auth", ["isAuthenticated", "user"]),
    ...mapGetters("worktime", ["duration", "isTimerStopped", "worktime"]),
  },

  created() {
    if (localStorage.getItem("authToken")) {
      //check if there is today's timer started for this user and assign it if it's not over 8 hours
      // this.counter.timer = timer;
      if (!this.isTimerStopped) {
        if (localStorage.getItem("counter")) {
          this.counter.seconds = localStorage.getItem("counter");
        } else if (this.duration >= 0) {
          this.counter.seconds = this.duration;
        }

        this.counter.ticker = setInterval(() => {
          const time = this._readableTimeFromSeconds(++this.counter.seconds);
          // console.log(this.counter.seconds);
          // check if 8 hours is reached
          this.activeTimerString = `${time.hours}:${time.minutes}`;
          localStorage.setItem("counter", this.counter.seconds);
          this.loadingStatus = true;
        }, 1000);
      }
    }
  },

  mounted() {},

  methods: {
    ...mapActions("auth", ["sendLogoutRequest", "getUserData"]),
    ...mapActions("worktime", ["createWorktime", "setTimerStopped", "setDuration"]),
    /**
     * Logout user.
     */
    logout() {
      this.sendLogoutRequest();
      this.setTimerStopped(false);
      this.setDuration(null);
      // this.$router.push("/home");
    },

    /**
     *
     */
    onRefresh() {
      if (this.isAuthenticated) {
        // this.setCounter(this.counter);
      }
    },

    /**
     * Stops timer
     */
    stopTimer() {
      console.log("Timer stop");
      this.updateWorktime();
    },

    /**
     * Starts timer after it was stopped
     */
    startTimer() {
      this.setTimerStopped(false);
      this.createWorktime(this.user);
    },

    /**
     * End current worktime by updating its duration
     */
    updateWorktime() {
      var data = {
        user_id: this.user.id,
        end_time: moment().format(),
      };

      axios
        .put(process.env.MIX_API_URL + "worktimes/" + this.worktime.id, data)
        .then((response) => {
          console.log(response.data);
          this.setTimerStopped(true);
          clearInterval(this.counter.ticker);
        })
        .catch((error) => {
          if (error.response) {
            if (error.response.status === 406) {
              this.$alert(error.response.data.error);
            }
          }
        });
    },

    initiateTimerAfterLogin() {
      console.log(!this.isTimerStopped);
      if (localStorage.getItem("authToken") && !this.isTimerStopped) {
        this.loadingStatus = true;
        if (this.duration >= 0) {

          this.counter.seconds = this.duration;
        }

        this.counter.ticker = setInterval(() => {
          const time = this._readableTimeFromSeconds(++this.counter.seconds);
          // console.log(this.counter.seconds);
          // check if 8 hours is reached
          this.activeTimerString = `${time.hours}:${time.minutes}`;
          localStorage.setItem("counter", this.counter.seconds);
          
        }, 1000);
      }
    },

    /**
     * Conditionally pads a number with "0"
     */
    _padNumber(number) {
      return number > 9 ? number : "0" + number;
    },

    /**
     * Splits seconds into hours, minutes, and seconds.
     */
    _readableTimeFromSeconds(seconds) {
      const hours = 3600 > seconds ? 0 : parseInt(seconds / 3600, 10);
      return {
        hours: this._padNumber(hours),
        seconds: this._padNumber(seconds % 60),
        minutes: this._padNumber(parseInt(seconds / 60, 10) % 60),
      };
    },

    _durationToSeconds(duration) {
      var timeMeasures = duration.split(":");
      var seconds =
        +timeMeasures[0] * 3600 + +timeMeasures[1] * 60 + +timeMeasures[2];
      return seconds;
    },

    /**
     * Calculate the amount of time spent when logged in.
     */
    calculateTimeSpent(timer) {
      const started = moment(timer.started_at);
      const stopped = moment(timer.stopped_at);
      const time = this._readableTimeFromSeconds(
        parseInt(moment.duration(stopped.diff(started)).asSeconds())
      );
      return `${time.hours}:${time.minutes}`;
    },
  },
};
</script>

<style>
body > div > div > .container {
  padding: 60px 15px 0;
}

.loader {
  border: 8px solid white;
  border-top: 8px solid #007bff;
  border-radius: 50%;
  width: 40px;
  height: 40px;
  animation: spin 2s linear infinite;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

.bi {
  display: inline-block;
  vertical-align: -.125em;
}

th {
  text-align: center;
}
</style>

<style scoped>
.timer {
  padding-right: 0.5rem;
  padding-left: 0.5rem;
  font-size: 25px;
  color: white;
}
</style>