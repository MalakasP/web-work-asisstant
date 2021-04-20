<template>
  <div class="d-flex flex-column min-vh-100">
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
            <li class="nav-item dropdown">
              <div
                class="nav-link dropdown-toggle"
                id="navbarDropdown"
                role="button"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
                v-show="isAuthenticated"
              >
                <a>Tasks</a>
              </div>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item"
                  ><router-link to="/assignedTasks"
                    >Assigned Tasks</router-link
                  ></a
                >
                <a class="dropdown-item"
                  ><router-link to="/createdTasks"
                    >Created Tasks</router-link
                  ></a
                >
              </div>
            </li>
            <li class="nav-item" v-show="isAuthenticated">
              <router-link class="nav-link" to="/projects"
                >Projects</router-link
              >
            </li>
            <li class="nav-item" v-show="isAuthenticated">
              <router-link class="nav-link" to="/teams">Teams</router-link>
            </li>
            <li class="nav-item" v-show="isAuthenticated">
              <router-link class="nav-link" to="/worktimes">Worktimes</router-link>
            </li>
            <li class="nav-item dropdown">
              <div
                class="nav-link dropdown-toggle"
                id="navbarDropdownRequests"
                role="button"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
                v-show="isAuthenticated"
              >
                <a>Requests</a>
              </div>
              <div class="dropdown-menu" aria-labelledby="navbarDropdownRequests">
                <a class="dropdown-item"
                  ><router-link to="/gottenRequests"
                    >Gotten Requests</router-link
                  ></a
                >
                <a class="dropdown-item"
                  ><router-link to="/createdRequests"
                    >Created Requests</router-link
                  ></a
                >
              </div>
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
              class="btn btn-light width-20"
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

    <notifications group="app" position="bottom right" />
    <main role="main" class="container">
      <router-view />
    </main>

    <footer class="mt-auto">
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
    ...mapGetters("auth", ["isAuthenticated", "user", "token"]),
    ...mapGetters("worktime", [
      "duration",
      "isTimerStopped",
      "worktime",
      "timer",
    ]),
  },

  created() {
    if (this.isAuthenticated) {
      //check if there is today's timer started for this user and assign it if it's not over 8 hours
      // this.counter.timer = timer;

      if (!this.isTimerStopped) {
        let todaysDate = moment().startOf("day");
        let savedDate = moment(this.worktime.created_at).startOf("day");

        if (
          this.timer &&
          Math.abs(moment.duration(savedDate.diff(todaysDate))._data.days) <= 1
        ) {
          this.counter.seconds = this.timer;
        } else if (this.duration >= 0) {
          this.counter.seconds = this.duration;
        }

        this.counter.ticker = setInterval(() => {
          const time = this._readableTimeFromSeconds(++this.counter.seconds);
          // console.log(this.counter.seconds);
          // check if 8 hours is reached
          this.activeTimerString = `${time.hours}:${time.minutes}`;
          if (this.counter.seconds % 60 == 0) {
            this.setTimer(this.counter.seconds);
          }

          this.loadingStatus = true;
        }, 1000);
      }
    }
  },

  mounted() {},

  methods: {
    ...mapActions("auth", ["sendLogoutRequest", "getUserData"]),
    ...mapActions("worktime", [
      "createWorktime",
      "setTimerStopped",
      "setDuration",
      "setWorktime",
      "setTimer",
    ]),
    /**
     * Logout user.
     */
    logout() {
      this.sendLogoutRequest();
      this.setTimerStopped(false);
      this.setDuration(null);
      this.setTimer(0);
      this.setWorktime(null);
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
      this.initiateTimerAfterLogin();
    },

    /**
     * End current worktime by updating its duration
     */
    updateWorktime() {
      var data = {
        user_id: this.user.id,
        end_time: moment().format(),
      };

      axios({
        method: "put",
        url: process.env.MIX_API_URL + "worktimes/" + this.worktime.id,
        baseURL: "/",
        data: data,
      })
        .then((response) => {
          console.log(response);
          this.setDuration(this.duration + this._durationToSeconds(response.data.worktime.duration));
          this.setTimerStopped(true);
          clearInterval(this.counter.ticker);
        })
        .catch((error) => {
          if (error.response) {
            if (error.response.status === 406) {
              this.$alert(error.response.data.message);
            }
          }
        });
    },

    initiateTimerAfterLogin() {
      console.log(!this.isTimerStopped);
      if (this.isAuthenticated && !this.isTimerStopped) {
        this.loadingStatus = true;
        if (this.duration >= 0) {
          this.counter.seconds = this.duration;
        }

        this.counter.ticker = setInterval(() => {
          const time = this._readableTimeFromSeconds(++this.counter.seconds);
          // console.log(this.counter.seconds);
          // check if 8 hours is reached
          this.activeTimerString = `${time.hours}:${time.minutes}`;
          if (this.counter.seconds % 60 == 0) {
            this.setTimer(this.counter.seconds);
            // this.duration(this.counter.seconds);
          }
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
  vertical-align: -0.125em;
}

th,
td {
  text-align: center;
}

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

.modal-dialog {
  overflow-y: initial !important;
}

textarea {
  resize: none;
}
</style>

<style scoped>
.timer {
  padding-right: 0.5rem;
  font-size: 25px;
  color: white;
}

@media (max-width: 768px) {
  button.width-20 {
    width: 20%;
  }
}

.min-vh-100 {
  min-height: 100vh;
}
</style>