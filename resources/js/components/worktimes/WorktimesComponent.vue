<template>
  <div class="container">
    <div class="row justify-content-center" v-if="true && this.loaded">
      <div class="col-12 card mt-3">
        <h3 class="p-3 text-center">Worktimes</h3>
        <div class="card-header bg-white">
          <div class="row justify-content-end">
            <div class="col-4"></div>
          </div>
        </div>
        <div class="card-body">
          <div class="row justify-content-between">
            <v-date-picker
              v-model="range"
              @input="getDays"
              is-range
              :max-date="new Date()"
            >
              <template v-slot="{ inputValue, inputEvents }">
                <div class="form-group row">
                  <div class="col-6">
                    <input
                      :value="inputValue.start"
                      v-on="inputEvents.start"
                      class="form-control"
                    />
                  </div>
                  <div class="col-6">
                    <input
                      :value="inputValue.end"
                      v-on="inputEvents.end"
                      class="form-control"
                    />
                  </div>
                </div>
              </template>
            </v-date-picker>
            <div
              class="form-group col-2"
              v-if="Object.keys(teamsAdmin).length > 0"
            >
              <div class="form-group row">
                <select
                  class="form-control"
                  v-model="selectedTeamId"
                  @change="getDays"
                >
                  <option
                    v-for="team in this.teams"
                    :value="team.id"
                    :key="team.id"
                  >
                    {{ team.name }}
                  </option>
                </select>
              </div>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table w-100 d-block d-md-table">
              <thead
                v-if="teams[selectedTeamId].users[0].selectedDays.length > 0"
              >
                <tr>
                  <th style="width: 20%">Users</th>
                  <th
                    v-for="day in teams[selectedTeamId].users[0].selectedDays"
                    :key="day.id"
                  >
                    {{ day.month_day }}
                  </th>
                </tr>
              </thead>
              <tbody v-if="loadedWorktimes">
                <tr v-for="user in teams[selectedTeamId].users" :key="user.id">
                  <td class="font-weight-bold">{{ user.name }}</td>
                  <td v-for="day in user.selectedDays" :key="day.id">
                    {{ day.worktime | zeroTime }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div v-else-if="this.loaded">
      <h4 class="p-3 text-center">You have no worktimes.</h4>
    </div>
    <div v-else class="row justify-content-center">
      <div class="loader mt-3"></div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import moment from "moment";

function Day({ weekday_name, month_day, full_date, worktime }) {
  this.weekday_name = weekday_name;
  this.month_day = month_day;
  this.full_date = full_date;
  this.worktime = worktime;
}

function Team({ id, name, description, created_at, updated_at, pivot, users }) {
  this.id = id;
  this.name = name;
  this.description = description;
  this.created_at = created_at;
  this.updated_at = updated_at;
  this.pivot = pivot;
  this.users = users;
}

export default {
  data: function () {
    return {
      loaded: false,
      modal: false,
      range: {
        start: new Date(moment().subtract(7, "d")),
        end: new Date(moment()),
      },
      teams: {},
      selectedTeamId: 0,
      worktimes: [],
      loadedWorktimes: false,
    };
  },
  computed: {
    ...mapGetters(["errors"]),
    ...mapGetters("auth", ["user"]),

    teamsAdmin: function () {
      const teamsAdmin = Object.entries(this.teams).filter(function ([
        key,
        team,
      ]) {
        if (team.pivot.is_admin) {
          return team.pivot.is_admin;
        } else {
          return false;
        }
      });
      return Object.fromEntries(teamsAdmin);
    },
  },
  mounted() {
    this.$store.commit("setErrors", {});
  },
  created() {
    this.fetchContextData();
  },
  filters: {
    zeroTime(value) {
      if (value != 0 && value != null && value !== undefined) {
        return value;
      } else {
        return "00:00";
      }
    },
  },
  components: {},
  methods: {
    async fetchContextData() {
      await axios
        .get(process.env.MIX_API_URL + "teams")
        .then((response) => {
          if (response.data != null) {
            this.teams = {};
            response.data.teams.forEach((team) => {
              if (team != null) {
                this.teams[team.id] = new Team(team);
              }
            });
            this.teams[0] = new Team({
              id: 0,
              name: "No Team",
              description: "",
              created_at: moment(),
              updated_at: moment(),
              pivot: {
                is_admin: true,
              },
              users: [this.user],
            });
            this.getDays();
          }
        })
        .catch((error) => {
          console.log(error);
          if (error.response.status == 404) {
            this.teams[0] = new Team({
              id: 0,
              name: "No Team",
              description: "",
              created_at: moment(),
              updated_at: moment(),
              pivot: {
                is_admin: true,
              },
              users: [this.user],
            });
            this.getDays();
          }
        });
    },

    async fetchUserWorktimesData() {
      let format_to = "YYYY-MM-DD HH:mm:ss";
      let from = moment(this.range.start).format(format_to);
      let to = moment(this.range.end).add(1, "day").format(format_to);
      if (this.selectedTeamId > 0) {
        await axios
          .get(
            process.env.MIX_API_URL +
              "teams/" +
              this.selectedTeamId +
              "/worktimes?from=" +
              from +
              "&to=" +
              to
          )
          .then((response) => {
            if (response.data != null) {
              this.usersWorktimes = response.data.usersWorktimes;
              Object.entries(this.usersWorktimes).forEach(([userId, days]) => {
                Object.entries(days).forEach(([day, worktimes]) => {
                  this.calculateDurationOfWorktimes(userId, day, worktimes);
                });
              });
              this.$forceUpdate();
              this.loaded = true;
              this.loadedWorktimes = true;
            }
          })
          .catch((error) => {
            this.loaded = true;
            this.loadedWorktimes = true;
            console.log(error);
          });
      } else if (this.selectedTeamId == 0) {
        await axios
          .get(process.env.MIX_API_URL + "worktimes?from=" + from + "&to=" + to)
          .then((response) => {
            if (response.data != null) {
              this.worktimes = response.data.worktimes;
              Object.entries(this.worktimes).forEach(([day, worktimes]) => {
                this.calculateDurationOfWorktimes(this.user.id, day, worktimes);
              });
              this.loaded = true;
              this.loadedWorktimes = true;
            }
          })
          .catch((error) => {
            this.loaded = true;
            this.loadedWorktimes = true;
            console.log(error);
          });
      }
    },

    calculateDurationOfWorktimes(userId, day, worktimes) {
      let result = 0;

      let user = this.teams[this.selectedTeamId].users.find((user) => {
        if (user.id == userId) {
          return true;
        }
      });

      user.selectedDays.forEach((calendarDay) => {
        if (moment(calendarDay.full_date).isSame(day, "day")) {
          result = worktimes.reduce(
            (total, worktime) =>
              total + this.durationToSeconds(worktime.duration),
            0
          );
          calendarDay.worktime = this.readableTimeFromSeconds(result);
          return;
        } 

      });

    },

    getDays() {
      this.loadedWorktimes = false;
      this.teams[this.selectedTeamId].users.forEach((user) => {
        user.selectedDays = [];
        let days = [];
        let start = this.range.start;
        while (start <= this.range.end) {
          days.push(
            new Day({
              weekday_name: moment(start).format("ddd"),
              month_day: moment(start).format("MM-DD"),
              full_date: moment(start).format("YYYY-MM-DD"),
              worktime: "00:00",
            })
          );
          let nextDay = start.setDate(start.getDate() + 1);
          start = new Date(nextDay);
        }
        user.selectedDays = [];
        user.selectedDays = days;
        this.range.start = new Date(moment(days[0].full_date));
      });

      this.fetchUserWorktimesData();
    },

    /**
     * Conditionally pads a number with "0"
     */
    padNumber(number) {
      return number > 9 ? number : "0" + number;
    },

    /**
     * Splits seconds into hours, minutes, and seconds.
     */
    readableTimeFromSeconds(seconds) {
      const hours = 3600 > seconds ? 0 : parseInt(seconds / 3600, 10);
      return (
        this.padNumber(hours) +
        ":" +
        this.padNumber(parseInt(seconds / 60, 10) % 60).toString()
      );
    },

    /**
     * Converts readable time to seconds.
     */
    durationToSeconds(duration) {
      var timeMeasures = duration.split(":");
      var seconds =
        +timeMeasures[0] * 3600 + +timeMeasures[1] * 60 + +timeMeasures[2];
      return seconds;
    },
  },
};
</script>

<style scoped>
.card {
  min-height: 200px;
  border: 0;
  -webkit-box-shadow: 0 10px 20px 0 rgb(0 0 0 / 20%);
  box-shadow: 0 10px 20px 0 rgb(0 0 0 / 20%);
}

table {
  display: block;
  overflow-x: auto;
  white-space: nowrap;
}

th {
  border: 1px solid #dee2e6;
  min-width: 20%;
}

th + th {
  border: 1px solid #dee2e6;
  width: auto;
}

td {
  border: 1px solid #dee2e6;
}
</style>