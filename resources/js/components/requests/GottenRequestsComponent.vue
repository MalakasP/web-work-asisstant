<template>
  <div class="container">
    <div
      class="row justify-content-center"
      v-if="gottenRequests.data.length > 0 && this.loaded && !noTeam"
    >
      <div class="col-12 card mt-3">
        <div class="card-header bg-white">
          <div class="row justify-content-end">
            <div class="col-4" v-if="this.adminOfTeam">
              <button
                type="button"
                class="btn btn-primary float-right"
                @click="history()"
              >
                <span class="icon is-small">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    fill="currentColor"
                    class="bi bi-clock-history"
                    viewBox="0 0 16 16"
                  >
                    <path
                      d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022l-.074.997zm2.004.45a7.003 7.003 0 0 0-.985-.299l.219-.976c.383.086.76.2 1.126.342l-.36.933zm1.37.71a7.01 7.01 0 0 0-.439-.27l.493-.87a8.025 8.025 0 0 1 .979.654l-.615.789a6.996 6.996 0 0 0-.418-.302zm1.834 1.79a6.99 6.99 0 0 0-.653-.796l.724-.69c.27.285.52.59.747.91l-.818.576zm.744 1.352a7.08 7.08 0 0 0-.214-.468l.893-.45a7.976 7.976 0 0 1 .45 1.088l-.95.313a7.023 7.023 0 0 0-.179-.483zm.53 2.507a6.991 6.991 0 0 0-.1-1.025l.985-.17c.067.386.106.778.116 1.17l-1 .025zm-.131 1.538c.033-.17.06-.339.081-.51l.993.123a7.957 7.957 0 0 1-.23 1.155l-.964-.267c.046-.165.086-.332.12-.501zm-.952 2.379c.184-.29.346-.594.486-.908l.914.405c-.16.36-.345.706-.555 1.038l-.845-.535zm-.964 1.205c.122-.122.239-.248.35-.378l.758.653a8.073 8.073 0 0 1-.401.432l-.707-.707z"
                    />
                    <path
                      d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0v1z"
                    />
                    <path
                      d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5z"
                    />
                  </svg>
                </span>
                History
              </button>
            </div>
          </div>
        </div>
        <div class="card-body text-center">
          <h3 class="card-title">Gotten Requests</h3>
          <div class="table-responsive">
            <table class="table-striped w-100 d-block d-md-table">
              <thead>
                <tr>
                  <th style="width: 40%">Reason</th>
                  <th style="width: 10%">Team</th>
                  <th style="width: 10%">Requester</th>
                  <th style="width: 15%">Date From</th>
                  <th style="width: 15%">Date To</th>
                  <th style="width: 5%"></th>
                  <th style="width: 5%"></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="request in gottenRequests.data" :key="request.id">
                  <td
                    style="width: 40%"
                    v-tooltip:left="'Description: ' + request.description"
                  >
                    {{ request.type }}
                  </td>
                  <td style="width: 10%">
                    {{ teams[request.team_id].name }}
                  </td>
                  <td style="width: 10%">
                    {{ users[request.requester_id].name }}
                  </td>
                  <td style="width: 15%">
                    {{ request.date_from | monthDay }}
                  </td>
                  <td style="width: 15%">
                    {{ request.date_to | monthDay }}
                  </td>
                  <td style="width: 5%">
                    <button
                      type="button"
                      class="btn btn-success"
                      style="margin: 1px"
                      @click="confirm(request)"
                    >
                      <span class="icon is-small">
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          width="16"
                          height="16"
                          fill="currentColor"
                          class="bi bi-check-square"
                          viewBox="0 0 16 16"
                        >
                          <path
                            d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"
                          />
                          <path
                            d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.235.235 0 0 1 .02-.022z"
                          />
                        </svg>
                      </span>
                    </button>
                  </td>
                  <td style="width: 5%">
                    <button
                      type="button"
                      class="btn btn-danger"
                      @click="reject(request)"
                    >
                      <span class="icon is-small">
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          width="16"
                          height="16"
                          fill="currentColor"
                          class="bi bi-x-square"
                          viewBox="0 0 16 16"
                        >
                          <path
                            d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"
                          />
                          <path
                            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"
                          />
                        </svg>
                      </span>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer text-center">
          <pagination
            v-model="page"
            :records="this.gottenRequests.total"
            :per-page="10"
            @paginate="fetchRequestsData"
          />
        </div>
      </div>
    </div>
    <div v-else-if="this.loaded && !noTeam" class="row justify-content-center">
      <div class="col-12 card mt-3">
        <div class="card-header bg-white">
          <div class="row justify-content-end">
            <div class="col-4" v-if="this.adminOfTeam">
              <button
                type="button"
                class="btn btn-primary float-right"
                style="margin: 1px"
                @click="history()"
              >
                <span class="icon is-small">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    fill="currentColor"
                    class="bi bi-clock-history"
                    viewBox="0 0 16 16"
                  >
                    <path
                      d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022l-.074.997zm2.004.45a7.003 7.003 0 0 0-.985-.299l.219-.976c.383.086.76.2 1.126.342l-.36.933zm1.37.71a7.01 7.01 0 0 0-.439-.27l.493-.87a8.025 8.025 0 0 1 .979.654l-.615.789a6.996 6.996 0 0 0-.418-.302zm1.834 1.79a6.99 6.99 0 0 0-.653-.796l.724-.69c.27.285.52.59.747.91l-.818.576zm.744 1.352a7.08 7.08 0 0 0-.214-.468l.893-.45a7.976 7.976 0 0 1 .45 1.088l-.95.313a7.023 7.023 0 0 0-.179-.483zm.53 2.507a6.991 6.991 0 0 0-.1-1.025l.985-.17c.067.386.106.778.116 1.17l-1 .025zm-.131 1.538c.033-.17.06-.339.081-.51l.993.123a7.957 7.957 0 0 1-.23 1.155l-.964-.267c.046-.165.086-.332.12-.501zm-.952 2.379c.184-.29.346-.594.486-.908l.914.405c-.16.36-.345.706-.555 1.038l-.845-.535zm-.964 1.205c.122-.122.239-.248.35-.378l.758.653a8.073 8.073 0 0 1-.401.432l-.707-.707z"
                    />
                    <path
                      d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0v1z"
                    />
                    <path
                      d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5z"
                    />
                  </svg>
                </span>
                History
              </button>
            </div>
          </div>
        </div>
        <div class="card-body text-center">
          <h3 class="card-title">Gotten Requests</h3>
          <h5 class="card-text">
            You have no active requests from team members.
          </h5>
        </div>
      </div>
    </div>
    <div v-else-if="loaded && noTeam" class="col-12 card mt-3">
      <div class="card-body text-center">
        <h3 class="card-title">Gotten Requests</h3>
        <h5 class="card-text">You do not have a team. Start one.</h5>
      </div>
    </div>
    <div v-else class="row justify-content-center">
      <div class="loader mt-3"></div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import moment from "moment";
import Pagination from "vue-pagination-2";

function Team({ id, name, description, created_at, updated_at, pivot, users }) {
  this.id = id;
  this.name = name;
  this.description = description;
  this.created_at = created_at;
  this.updated_at = updated_at;
  this.pivot = pivot;
  this.users = users;
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
      noTeam: false,
      adminOfTeam: false,
      loaded: false,
      modal: false,
      edit: null,
      dynamicTitle: null,
      users: {},
      gottenRequests: {
        data: [],
      },
      page: 1,
      teams: {},
      range: {
        start: null,
        end: null,
      },
      masks: {
        input: "YYYY-MM-DD h:mm A",
      },
      form: {
        date_from: null,
        date_to: null,
        description: null,
        is_confirmed: false,
        type: null,
        requester_id: null,
        responser_id: null,
      },
      selectedTeam: null,
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
    this.fetchRequestsData();
    this.fetchContextData();
  },
  components: {
    Pagination,
  },
  filters: {
    monthDay: function (value) {
      if (!value) return "";
      value = value.toString();
      return value.substring(16, 5);
    },
  },
  methods: {
    async fetchContextData() {
      await axios
        .get(process.env.MIX_API_URL + "users")
        .then((response) => {
          if (response.data != null) {
            this.users = {};
            response.data.users.forEach((user) => {
              if (user != null) {
                this.users[user.id] = new User(user);
              }
            });
          }
        })
        .catch((error) => {
          console.log(error);
        });

      await axios
        .get(process.env.MIX_API_URL + "teams")
        .then((response) => {
          if (response.data != null) {
            this.teams = {};
            response.data.teams.forEach((team) => {
              if (team != null) {
                if (team.pivot.is_admin > 0) {
                  this.adminOfTeam = true;
                }
                this.teams[team.id] = new Team(team);
              }
              console.log(this.adminOfTeam);
            });
            this.noTeam = false;
            this.loaded = true;
          }
        })
        .catch((error) => {
          console.log(error);
          if (error.response.status == 404) {
            this.noTeam = true;
            this.loaded = true;
          }
        });
    },

    async fetchRequestsData(page = 1) {
      await axios
        .get(process.env.MIX_API_URL + "getNotAnsweredRequests?page=" + page)
        .then((response) => {
          if (response.data != null) {
            this.gottenRequests = {};
            this.gottenRequests = response.data.gottenRequests;
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },

    async fetchAnsweredRequestsData(page = 1) {
      await axios
        .get(process.env.MIX_API_URL + "getAnsweredRequests?page=" + page)
        .then((response) => {
          if (response.data != null) {
            this.answeredRequests = {};
            this.answeredRequests = response.data.answeredRequests;
          }
        })
        .catch((error) => {
          if (error.response.status == 404) {
            this.$notify({
              group: "app",
              title: "Error!",
              type: "error",
              text: "You do not have answered requests!",
            });
          }
        });
    },

    async confirm(request) {
      let data = {
        is_confirmed: true,
        confirmed_at: moment(),
      };

      await axios
        .put(process.env.MIX_API_URL + "requests/" + request.id, data)
        .then((response) => {
          if (response.data != null) {
            let requestIndex = this.gottenRequests.data.findIndex(
              (gottenRequest) => {
                gottenRequest.id == request.id;
              }
            );
            this.gottenRequests.data.splice(requestIndex, 1);
            this.$notify({
              group: "app",
              title: "Success!",
              type: "success",
              text: "Request was confirmed!",
            });
          }
        })
        .catch((error) => {
          if (error.response) {
            if (error.response.status == 403) {
              this.$alert(error.response.message, "Warning", "error");
            } else {
              this.$alert("Something went wrong", "Warning", "error");
            }
          }
        });
    },

    async reject(request) {
      let data = {
        is_confirmed: false,
        confirmed_at: moment(),
      };
      console.log(request.id, data);
      await axios
        .put(process.env.MIX_API_URL + "requests/" + request.id, data)
        .then((response) => {
          if (response.data != null) {
            let requestIndex = this.gottenRequests.data.findIndex(
              (gottenRequest) => {
                gottenRequest.id == request.id;
              }
            );
            this.gottenRequests.data.splice(requestIndex, 1);
            this.$notify({
              group: "app",
              title: "Success!",
              type: "success",
              text: "Request was rejected!",
            });
          }
        })
        .catch((error) => {
          if (error.response) {
            if (error.response.status == 403) {
              this.$alert(error.response.message, "Warning", "error");
            } else {
              this.$alert("Something went wrong", "Warning", "error");
            }
          }
        });
    },

    async history() {
      this.$router.push({ name: "AnsweredRequests" });
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

.card-header {
  border: none;
  padding-top: 0.75rem;
  padding-left: 1.25rem;
  padding-right: 1.25rem;
  padding-bottom: 0;
}
</style>