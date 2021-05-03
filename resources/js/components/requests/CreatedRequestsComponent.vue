<template>
  <div class="container">
    <div v-if="modal">
      <transition name="model">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">{{ dynamicTitle }}</h4>
                  <button
                    type="button"
                    class="close"
                    @click="
                      edit = null;
                      modal = false;
                    "
                  >
                    <span aria-hidden="true">&times; </span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <label>Choose Date</label>
                    <v-date-picker
                      v-model="range"
                      mode="dateTime"
                      :masks="masks"
                      is-range
                      is24hr
                      :minute-increment="15"
                    >
                      <template v-slot="{ inputValue, inputEvents }">
                        <div class="form-group row">
                          <div class="form-group col-md-6">
                            <input
                              class="form-control"
                              :class="{ 'is-invalid': errors.date_from }"
                              :value="inputValue.start"
                              v-on="inputEvents.start"
                            />
                            <div
                              class="invalid-feedback"
                              v-if="errors.date_from"
                            >
                              {{ errors.date_from }}
                            </div>
                          </div>

                          <div class="form-group col-md-6">
                            <input
                              class="form-control"
                              :class="{ 'is-invalid': errors.date_to }"
                              :value="inputValue.end"
                              v-on="inputEvents.end"
                            />
                            <div class="invalid-feedback" v-if="errors.date_to">
                              {{ errors.date_to }}
                            </div>
                          </div>
                        </div>
                      </template>
                    </v-date-picker>
                    <div class="invalid-feedback" v-if="errors.date_from">
                      {{ errors.date_from }}
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Enter Description</label>
                    <textarea
                      class="form-control"
                      :class="{ 'is-invalid': errors.description }"
                      v-model="form.description"
                      rows="3"
                    ></textarea>
                    <div class="invalid-feedback" v-if="errors.description">
                      {{ errors.description }}
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Enter Type</label>
                    <input
                      type="text"
                      class="form-control"
                      :class="{ 'is-invalid': errors.type }"
                      v-model="form.type"
                    />
                    <div class="invalid-feedback" v-if="errors.type">
                      {{ errors.type }}
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Choose Team</label>
                    <select
                      class="form-control"
                      v-model="form.team_id"
                      @change="loadAdmins"
                    >
                      <option
                        v-for="team in this.teamsAdmin"
                        :value="team.id"
                        :key="team.id"
                      >
                        {{ team.name }}
                      </option>
                    </select>
                  </div>
                  <div class="form-group" v-if="form.team_id">
                    <label>Choose Responser</label>
                    <select class="form-control" v-model="form.responser_id">
                      <option
                        v-for="user in this.adminOfTeams[form.team_id]"
                        :value="user.id"
                        :key="user.id"
                      >
                        {{ user.name }}
                      </option>
                    </select>
                  </div>
                  <div align="center">
                    <input
                      type="button"
                      v-if="edit == null"
                      class="btn btn-primary"
                      value="Submit"
                      @click="create"
                    />
                    <input
                      type="button"
                      v-else
                      class="btn btn-primary"
                      value="Submit"
                      @click="update"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </transition>
    </div>
    <div
      class="row justify-content-center"
      v-if="this.createdRequests.data.length > 0 && this.loaded && !noTeam"
    >
      <div class="col-12 card mt-3">
        <div class="card-header bg-white">
          <div class="row justify-content-end">
            <div class="col-4">
              <button
                type="button"
                class="btn btn-success float-right"
                @click="startCreate()"
              >
                <span class="icon is-small">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    fill="currentColor"
                    class="bi bi-plus-square"
                    viewBox="0 0 16 16"
                  >
                    <path
                      d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"
                    />
                    <path
                      d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"
                    />
                  </svg>
                </span>
                Make Request
              </button>
            </div>
          </div>
        </div>
        <div class="card-body text-center">
          <h3 class="card-title">Created Requests</h3>
          <div class="table-responsive">
            <table class="table-striped w-100 d-block d-md-table">
              <thead>
                <tr>
                  <th style="width: 30%">Type</th>
                  <th style="width: 15%">Responser</th>
                  <th style="width: 15%">Team</th>
                  <th style="width: 10%">Status</th>
                  <th style="width: 10%">Date From</th>
                  <th style="width: 10%">Date To</th>
                  <th style="width: 5%"></th>
                  <th style="width: 5%"></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="request in createdRequests.data" :key="request.id">
                  <td style="width: 30%">{{ request.type }}</td>
                  <td style="width: 15%">
                    {{ responser(request.responser_id, request.team_id) }}
                  </td>
                  <td style="width: 15%">{{ teams[request.team_id].name }}</td>
                  <td style="width: 10%" v-if="request.confirmed_at">
                    {{ request.is_confirmed | statusReadable }}
                  </td>
                  <td style="width: 15%" v-else>Not answered</td>
                  <td style="width: 10%">
                    {{ request.date_from | monthDay }}
                  </td>
                  <td style="width: 10%">
                    {{ request.date_to | monthDay }}
                  </td>
                  <td style="width: 5%">
                    <button
                      type="button"
                      class="btn btn-primary"
                      style="margin: 1px"
                      @click="startEdit(request)"
                    >
                      <span class="icon is-small">
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          width="16"
                          height="16"
                          fill="currentColor"
                          class="bi bi-three-dots"
                          viewBox="0 0 16 16"
                        >
                          <path
                            d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"
                          />
                        </svg>
                      </span>
                    </button>
                  </td>
                  <td style="width: 5%">
                    <button
                      type="button"
                      class="btn btn-danger"
                      @click="startDelete(request)"
                    >
                      <span class="icon is-small">
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          width="16"
                          height="16"
                          fill="currentColor"
                          class="bi bi-trash"
                          viewBox="0 0 16 16"
                        >
                          <path
                            d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"
                          />
                          <path
                            fill-rule="evenodd"
                            d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"
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
            :records="this.createdRequests.total"
            :per-page="10"
            @paginate="fetchRequestsData"
          />
        </div>
      </div>
    </div>
    <div v-else-if="loaded && !noTeam" class="row justify-content-center">
      <div class="col-12 card mt-3">
        <div class="card-body text-center">
          <h3 class="card-title">Created Requests</h3>
          <button type="button" class="btn btn-success" @click="startCreate()">
            <span class="icon is-small">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="16"
                height="16"
                fill="currentColor"
                class="bi bi-plus-square"
                viewBox="0 0 16 16"
              >
                <path
                  d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"
                />
                <path
                  d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"
                />
              </svg>
            </span>
            Make Request
          </button>
        </div>
      </div>
    </div>
    <div v-else-if="loaded && noTeam" class="col-12 card mt-3">
      <div class="card-body text-center">
        <h3 class="card-title">Created Requests</h3>
        <h5 class="card-text">You do not have a team. Start or join one.</h5>
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

function User({ id, name, email, created_at, updated_at, pivot }) {
  this.id = id;
  this.name = name;
  this.email = email;
  this.created_at = created_at;
  this.updated_at = updated_at;
  this.pivot = pivot;
}

export default {
  data: function () {
    return {
      loaded: false,
      modal: false,
      edit: null,
      dynamicTitle: null,
      createdRequests: {
        data: [],
      },
      users: [],
      teams: {},
      range: {
        start: null,
        end: null,
      },
      masks: {
        input: "YYYY-MM-DD h:mm A",
      },
      page: 1,
      form: {
        date_from: null,
        date_to: null,
        description: null,
        type: null,
        requester_id: null,
        responser_id: null,
        team_id: null,
      },
    };
  },
  computed: {
    ...mapGetters(["errors"]),
    ...mapGetters("auth", ["user"]),

    adminOfTeams: function () {
      let admins = {};
      Object.values(this.users).forEach((user) => {
        if (user.pivot.is_admin == 1 && user.id != this.user.id) {
          if (
            Object.keys(admins).findIndex((key) => {
              if (key == user.pivot.team_id) return true;
            }) > -1
          ) {
            admins[user.pivot.team_id].push(user);
          } else {
            admins[user.pivot.team_id] = [];
            admins[user.pivot.team_id].push(user);
          }
        }
      });
      return admins;
    },

    teamsAdmin: function () {
      let teamAdmins = Object.keys(this.adminOfTeams);

      let adminTeams = Object.values(this.teams).filter((team) => {
        return teamAdmins.indexOf(team.id.toString()) > -1;
      });

      return adminTeams;
    },
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
      value = value.toString().replace("T", " ");
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
            this.users = [];
            response.data.users.forEach((user) => {
              if (user != null) {
                this.users.push(new User(user));
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
          }
          this.noTeam = false;
          this.loaded = true;
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
        .get(process.env.MIX_API_URL + "createdRequests?page=" + page)
        .then((response) => {
          if (response.data != null) {
            this.createdRequests = [];
            this.createdRequests = response.data.createdRequests;
          }
        })
        .catch((error) => {
          if (error.response.status == 404) {
            this.$notify({
              group: "app",
              title: "Error!",
              type: "error",
              text: error.response.data.message,
            });
          } else {
            this.$alert("Something went wrong.", "Warning", "error");
          }
        });
    },

    async update() {
      this.form.requester_id = this.user.id;
      this.form.date_from = this.range.start;
      this.form.date_to = this.range.end;

      await axios
        .put(process.env.MIX_API_URL + "requests/" + this.edit.id, this.form)
        .then((response) => {
          if (response.data != null) {
            this.modal = false;
            let requestIndex = this.createdRequests.data.findIndex(
              (request) => request.id == this.edit.id
            );
            this.createdRequests.data[requestIndex] = response.data.request;
            this.$notify({
              group: "app",
              title: "Success!",
              type: "success",
              text: response.data.message,
            });
          }
        })
        .catch((error) => {
          if (error.response.status == 422) {
            this.$store.commit("setErrors", error.response.data.errors);
          } else if (error.response.status == 403) {
            this.modal = false;
            this.$alert(error.response.data.message, "Warning", "error");
          } else {
            this.modal = false;
            this.$alert("Something went wrong.", "Warning", "error");
          }
        });
    },

    async create() {
      this.form.requester_id = this.user.id;
      this.form.date_from = this.range.start;
      this.form.date_to = this.range.end;

      await axios
        .post(process.env.MIX_API_URL + "requests", this.form)
        .then((response) => {
          if (response.data != null) {
            this.modal = false;
            if (this.createdRequests.data.length < 1) {
              this.fetchRequestsData();
            } else {
              this.createdRequests.data.push(response.data.new_request);
            }
            this.$notify({
              group: "app",
              title: "Success!",
              type: "success",
              text: response.data.message,
            });
          }
        })
        .catch((error) => {
          if (error.response.status == 422) {
            this.$store.commit("setErrors", error.response.data.errors);
          } else if (error.response.status == 403) {
            this.modal = false;
            this.$alert(error.response.data.message, "Warning", "error");
          } else {
            this.modal = false;
            this.$alert("Something went wrong.", "Warning", "error");
          }
        });
    },

    async delete(requestId) {
      await axios
        .delete(process.env.MIX_API_URL + "requests/" + requestId)
        .then((response) => {
          if (response.data != null) {
            let requestIndex = this.createdRequests.data.findIndex(
              (request) => request.id == requestId
            );
            this.createdRequests.data.splice(requestIndex, 1);
            this.$forceUpdate();
            this.$notify({
              group: "app",
              title: "Success!",
              type: "success",
              text: response.data.message,
            });
          }
        })
        .catch((error) => {
          console.log(error);
          if (error.response.status == 403) {
            this.$alert(error.response.data.error, "Forbidden", "error");
          } else {
            this.$alert(error.response.data.status, "Warning", "error");
          }
        });
    },

    startCreate() {
      this.$store.commit("setErrors", {});
      this.dynamicTitle = "Create Request";
      let start = moment();
      let remainder = 15 - (start.minute() % 15);
      let now = moment(start).add(remainder, "minutes");
      this.range.start = new Date(now);
      this.range.end = new Date(now.add(1, "days"));
      this.modal = true;
      (this.form.type = null),
        (this.form.description = null),
        console.log(this.teamsAdmin);
      this.form.team_id = Object.values(this.teamsAdmin)[0].id;
      this.loadAdmins();
    },

    loadAdmins() {
      this.form.responser_id = this.adminOfTeams[this.form.team_id][0].id;
    },

    startEdit(request) {
      this.$store.commit("setErrors", {});
      this.dynamicTitle = "Edit Request";

      this.range.start = request.date_from;
      this.range.end = request.date_to;
      this.modal = true;
      this.edit = request;
      this.form.type = request.type;
      this.form.description = request.description;
      this.form.responser_id = request.responser_id;
      this.form.team_id = request.team_id;
    },

    startDelete(request) {
      this.$store.commit("setErrors", {});
      this.$confirm("Are You sure?", "Confirm Remove", "error")
        .then(() => {
          this.delete(request.id);
        })
        .catch((error) => {
          console.log(error);
        });
    },

    findUserFromTeams(userId) {
      let userArray = Object.values(this.users);
      return userArray.find(function (user) {
        if (user.id == userId) return true;
        return false;
      });
    },

    responser(userId, teamId) {
      let user = this.users.find((user) => {
        if (user.id == userId && user.pivot.team_id == teamId) {
          return true;
        }
      });
      if (user != null) return user.name;

      return "?";
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

.modal-body {
  position: relative;
  flex: 1 1 auto;
  padding: 1rem;
}

.card-header {
  border: none;
  padding-top: 0.75rem;
  padding-left: 1.25rem;
  padding-right: 1.25rem;
  padding-bottom: 0;
}
</style>