<template>
  <div class="container">
    <div
      class="row justify-content-center"
      v-if="gottenRequests.data.length && this.loaded"
    >
      <div class="col-12 card mt-3">
        <div class="card-body text-center">
          <h3 class="card-title">Gotten Requests</h3>
          <div class="table-responsive">
            <table class="table-striped w-100 d-block d-md-table">
              <thead>
                <tr>
                  <th style="width: 40%">Reason</th>
                  <th style="width: 20%">Requester</th>
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
                  <td style="width: 20%">
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
          <pagination v-model="page" :records="this.gottenRequests.total" :per-page="10" @paginate="fetchRequestsData"/>
        </div>
      </div>
    </div>
    <div v-else-if="this.loaded" class="row justify-content-center">
      <div class="col-12 card mt-3">
        <div class="card-body text-center">
          <h3 class="card-title">Gotten Requests</h3>
          <h5 class="card-text">
            You have no active requests from team members.
          </h5>
        </div>
      </div>
    </div>
    <div v-else class="row justify-content-center">
      <div class="loader"></div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import moment from "moment";
import Pagination from 'vue-pagination-2';

function Team({ id, name, description, created_at, updated_at, pivot, users }) {
  this.id = id;
  this.name = name;
  this.description = description;
  this.created_at = created_at;
  this.updated_at = updated_at;
  this.pivot = pivot;
  this.users = users;
}

function Request({
  id,
  date_from,
  date_to,
  description,
  type,
  is_confirmed,
  confirmed_at,
  requester_id,
  responser_id,
  created_at,
  updated_at,
}) {
  this.id = id;
  this.date_from = date_from;
  this.date_to = date_to;
  this.description = description;
  this.type = type;
  this.is_confirmed = is_confirmed;
  this.confirmed_at = confirmed_at;
  this.requester_id = requester_id;
  this.responser_id = responser_id;
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
      loaded: false,
      modal: false,
      edit: null,
      dynamicTitle: null,
      users: {},
      gottenRequests: {
        data:[]
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
    Pagination
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
            });
            this.loaded = true;
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },

    async fetchRequestsData(page) {
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

    async confirm(request) {
      let data = {
        is_confirmed: true,
        confirmed_at: moment(),
      }
      console.log(request.id, data);
       await axios
        .put(process.env.MIX_API_URL + "requests/" + request.id, data)
        .then((response) => {
          if (response.data != null) {
            let requestIndex = this.gottenRequests.data.findIndex(gottenRequest => {gottenRequest.id == request.id});
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
      }
      console.log(request.id, data);
       await axios
        .put(process.env.MIX_API_URL + "requests/" + request.id, data)
        .then((response) => {
          if (response.data != null) {
            let requestIndex = this.gottenRequests.data.findIndex(gottenRequest => {gottenRequest.id == request.id});
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

.full-width {
  width: 100%;
}

.input-sm {
  height: calc(2.15rem + 2px);
}

.modal-body {
  position: relative;
  flex: 1 1 auto;
  padding: 1rem;
}
</style>