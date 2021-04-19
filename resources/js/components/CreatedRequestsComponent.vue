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
                      <template
                        v-slot="{ inputValue, inputEvents}"
                      >
                        <div
                          class="form-group row"
                        >
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
                            <div
                                class="invalid-feedback"
                                v-if="errors.date_to"
                              >
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
                  <div
                    class="form-group"
                    v-if="Object.keys(this.teamsNotAdmin).lenght > 1"
                  >
                    <label>Choose Team</label>
                    <select class="form-control" v-model="selectedTeam">
                      <option
                        v-for="team in this.teamsNotAdmin"
                        :value="team.id"
                        :key="team.id"
                      >
                        {{ team.name }}
                      </option>
                    </select>
                  </div>
                  <div class="form-group" v-if="selectedTeam">
                    <label>Choose Responser</label>
                    <select class="form-control" v-model="selectedTeam">
                      <option
                        v-for="team in this.teamsNotAdmin"
                        :value="team.id"
                        :key="team.id"
                      >
                        {{ team.name }}
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
    <div class="row justify-content-center" v-if="this.createdRequests.length > 0 && this.loaded">
      <div class="col-12 card mt-3">
        <div class="card-body text-center">
          <h3 class="card-title">Created Requests</h3>
          <div class="table-responsive">
            <table class="table-striped w-100 d-block d-md-table">
              <thead>
                <tr>
                  <th style="width: 40%">Type</th>
                  <th style="width: 35%">Responser</th>
                  <th style="width: 5%">Status</th>
                  <th style="width: 10%">Date From</th>
                  <th style="width: 10%">Date To</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="request in createdRequests" :key="request.id">
                  <td style="width: 40%">{{ request.type }}</td>
                  <td style="width: 35%">Responser from Team??</td>
                  <td style="width: 5%">{{request.is_confirmed | makeBooleanReadable}}</td>
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
      </div>
    </div>
    <div v-else-if="this.loaded" class="row justify-content-center">
      <div class="col-12 card mt-3">
        <div class="card-body text-center">
          <h3 class="card-title">Created Requests</h3>
          <button
            type="button"
            class="btn btn-secondary w-25 mt-3"
            @click="startCreate()"
          >
            <span class="icon full-size">
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
              Create Request
            </span>
          </button>
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
      gottenRequests: [],
      createdRequests: [],
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

    teamsAdmin: function () {
      const adminTeams = Object.entries(this.teams).filter(function ([
        key,
        team,
      ]) {
        if (team.pivot.is_admin) {
          return team.pivot.is_admin;
        } else {
          return false;
        }
      });
      return Object.fromEntries(adminTeams);
    },

    teamsNotAdmin: function () {
      const adminNotTeams = Object.entries(this.teams).filter(function ([
        key,
        team,
      ]) {
        if (team.pivot.is_admin) {
          return false;
        } else {
          return true;
        }
      });
      return Object.fromEntries(adminNotTeams);
    },

    adminOfTeams: function () {
      const adminNotTeams = this.teamsNotAdmin();
      const result = Object.entries(this.adminNotTeams).forEach(
        ([key, team]) => {
          return team.users.find((user) => {
            user.pivot.is_admin == 1;
          });
        }
      );
      console.log(result);
      return adminNotTeams;
    },
  },
  mounted() {
    this.$store.commit("setErrors", {});
  },
  created() {
    this.read();
  },
  filters: {
    monthDay: function (value) {
      if (!value) return "";
      value = value.toString();
      return value.substring(16, 5);
    },
    makeBooleanReadable: function (value) {
      if (!value) return "No";
      return "Yes";
    },
  },
  methods: {
    async read() {
      //   await axios
      //     .get(process.env.MIX_API_URL + "users")
      //     .then((response) => {
      //       if (response.data != null) {
      //         this.projectsUsers = {};
      //         response.data.users.forEach((user) => {
      //           if (user != null) {
      //             this.projectsUsers[user.id] = new User(user);
      //           }
      //         });
      //       }
      //     })
      //     .catch((error) => {
      //       console.log(error);
      //     });

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
          }
        })
        .catch((error) => {
          console.log(error);
        });

      await axios
        .get(process.env.MIX_API_URL + "requests")
        .then((response) => {
          if (response.data != null) {
            this.gottenRequests = [];
            this.createdRequests = [];
            if (response.data.gottenRequests != null) {
              console.log(response.data.gottenRequests);
              response.data.gottenRequests.forEach((gottenRequest) => {
                if (gottenRequest != null) {
                  this.gottenRequests.push(new Request(gottenRequest));
                }
              });
            }
            if (response.data.createdRequests != null) {
              console.log(response.data.createdRequests);
              response.data.createdRequests.forEach((createdRequest) => {
                if (createdRequest != null) {
                  this.createdRequests.push(new Request(createdRequest));
                }
              });
            }
            this.loaded = true;
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },

    update() {},

    create() {},

    startCreate(request) {
      let start = moment();
      let remainder = 15 - (start.minute() % 15);
      let now = moment(start).add(remainder, "minutes");
      this.range.start = new Date(now);
      this.range.end = new Date(now.add(1, "days"));
      this.modal = true;
      this.edit = request;
      console.log(request.id);
    },

    startEdit(request) {
      let start = moment();
      let remainder = 15 - (start.minute() % 15);
      let now = moment(start).add(remainder, "minutes");
      this.range.start = new Date(now);
      this.range.end = new Date(now.add(1, "days"));
      this.modal = true;
      this.edit = request;
      console.log(request.id);
    },

    startDelete(request) {
      console.log(request.id);
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