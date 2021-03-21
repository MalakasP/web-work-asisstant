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
              <router-link class="nav-link" to="/">Tasks</router-link>
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
              <router-link class="nav-link" to="/register">Register</router-link>
            </li>
            <li class="nav-item timer" v-show="isAuthenticated">
                <strong>{{ activeTimerString }}</strong>
            </li>
            <button type="button" class="btn btn-light" @click="stopTimer" v-show="isAuthenticated">Stop</button>
            <li class="nav-item" v-show="isAuthenticated">
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
            <span class="text-muted"> © 2021 Copyright:
              <a>PM</a>
            </span>
        </div>
    </footer>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import moment from 'moment';

export default {
  data() {
    return {
       activeTimerString: "00:00",
       counter: { seconds: 0, timer: null },
    }
  },

  computed: {
    ...mapGetters("auth", ["isAuthenticated"])
  },

  mounted() {
    if (localStorage.getItem("authToken")) {
      this.getUserData();
    }
  },

  methods: {
    ...mapActions("auth", ["sendLogoutRequest", "getUserData"]),
    logout() {
      this.sendLogoutRequest();
      this.$router.push("/");
    },

    /**
     * Stops timer
     */
    stopTimer() {
      console.log("Timer stop");
      // window.axios.post()
      //   .then(response => {
      //       // Loop through the projects and get the right project...
      //       this.projects.forEach(project => {
      //           if (project.id === parseInt(this.counter.timer.project.id)) {
      //               // Loop through the timers of the project and set the `stopped_at` time
      //               return project.timers.forEach(timer => {
      //                   if (timer.id === parseInt(this.counter.timer.id)) {
      //                       return timer.stopped_at = response.data.stopped_at
      //                   }
      //               })
      //           }
      //       });

           
      //   });
         // Stop the ticker
    clearInterval(this.counter.ticker);

    // Reset the counter and timer string
    this.counter = { seconds: 0, timer: null };
    this.activeTimerString = "00:00";
    },

    /**
     * Starts counting the timer
     */
    startTimer() {
      console.log("Timer start");

      const started = moment();
      console.log(started);
      //check if there is today's timer started for this user and assign it if it's not over 8 hours
      // this.counter.timer = timer;
      
      
      this.counter.seconds = parseInt(moment.duration(moment().diff(started)).asSeconds());
      this.counter.ticker = setInterval(() => {
          const time = this._readableTimeFromSeconds(++this.counter.seconds);
          this.activeTimerString = `${time.hours}:${time.minutes}`;
      }, 1000);
    },

    /**
     * Conditionally pads a number with "0"
     */
    _padNumber(number) {
      return (number > 9) ? number : "0" + number;
    },  
    
    /**
     * Splits seconds into hours, minutes, and seconds.
     */
    _readableTimeFromSeconds(seconds) {
        const hours = 3600 > seconds ? 0 : parseInt(seconds / 3600, 10)
        return {
            hours: this._padNumber(hours),
            seconds: this._padNumber(seconds % 60),
            minutes: this._padNumber(parseInt(seconds / 60, 10) % 60),
        }
    },

    /**
     * Calculate the amount of time spent on the project using the timer object.
     */
    calculateTimeSpent(timer) {
      if (timer.stopped_at) {
          const started = moment(timer.started_at)
          const stopped = moment(timer.stopped_at)
          const time = this._readableTimeFromSeconds(
              parseInt(moment.duration(stopped.diff(started)).asSeconds())
          )
          return `${time.hours} Hours | ${time.minutes} mins | ${time.seconds} seconds`
      }
      return ''
    },
  }
};
</script>

<style>
body > div > div > .container {
  padding: 60px 15px 0;
}
</style>

<style scoped>
.timer {
  padding-right: .5rem;
  padding-left: .5rem;
  font-size: 25px;
  color: white;
}
</style>