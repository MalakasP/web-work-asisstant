<template>
  <div class="container">
    <div
      class="row justify-content-center"
      v-if="answeredRequests.data.length > 0 && this.loaded"
    >
      <div class="col-12 card mt-3">
        <div class="card-header bg-white">
          <div class="row justify-content-between">
            <div class="col-4">
              <button type="button" class="btn btn-primary" @click="goBack()">
                <span class="icon is-small">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    fill="currentColor"
                    class="bi bi-arrow-left"
                    viewBox="0 0 16 16"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"
                    />
                  </svg>
                </span>
              </button>
            </div>
          </div>
        </div>
        <div class="card-body text-center">
          <h3 class="card-title">Answered Requests</h3>
          <div class="table-responsive">
            <table class="table-striped w-100 d-block d-md-table">
              <thead>
                <tr>
                  <th style="width: 30%">Reason</th>
                  <th style="width: 20%">Requester</th>
                  <th style="width: 15%">Status</th>
                  <th style="width: 15%">Date From</th>
                  <th style="width: 15%">Date To</th>
                  <th style="width: 5%"></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="request in answeredRequests.data" :key="request.id">
                  <td style="width: 30%">
                    {{ request.type }}
                  </td>
                  <td style="width: 20%">
                    {{ users[request.requester_id].name }}
                  </td>
                  <td style="width: 15%">
                    {{ request.status | statusReadable }}
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
                      class="btn btn-primary"
                      style="margin: 1px"
                      @click="rollback(request)"
                    >
                      <span class="icon is-small">
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          width="16"
                          height="16"
                          fill="currentColor"
                          class="bi bi-arrow-counterclockwise"
                          viewBox="0 0 16 16"
                        >
                          <path
                            fill-rule="evenodd"
                            d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"
                          />
                          <path
                            d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"
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
            :records="this.answeredRequests.total"
            :per-page="10"
            @paginate="fetchAnsweredRequestsData"
          />
        </div>
      </div>
    </div>
    <div v-else-if="this.loaded" class="row justify-content-center">
      <div class="col-12 card mt-3">
        <div class="card-header bg-white">
          <div class="row justify-content-between">
            <div class="col-4">
              <button type="button" class="btn btn-primary" @click="goBack()">
                <span class="icon is-small">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    fill="currentColor"
                    class="bi bi-arrow-left"
                    viewBox="0 0 16 16"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"
                    />
                  </svg>
                </span>
              </button>
            </div>
          </div>
        </div>
        <div class="card-body text-center">
          <h3 class="card-title">Answered Requests</h3>
          <h5 class="card-text">
            You have no answered requests from team members.
          </h5>
        </div>
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
      loaded: false,
      users: {},
      teams: {},
      answeredRequests: {
        data: [],
      },
      page: 1,
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
    this.fetchAnsweredRequestsData();
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
    statusReadable: function (value) {
      if (!value) return "Rejected";
      return "Confirmed";
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

    async roleback(request) {},

    goBack() {
      this.$router.push({ name: "GottenRequests" });
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
  padding-top: .75rem;
  padding-left: 1.25rem;
  padding-right: 1.25rem;
  padding-bottom:0;
}
</style>