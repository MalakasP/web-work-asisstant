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
                    >
                      <template
                        v-slot="{ inputValue, inputEvents, isDragging }"
                      >
                        <div
                          class="flex flex-col sm:flex-row justify-start items-center"
                        >
                          <div class="relative flex-grow">
                            <svg
                              class="text-gray-600 w-4 h-full mx-2 absolute pointer-events-none"
                              fill="none"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              viewBox="0 0 24 24"
                              stroke="currentColor"
                            >
                              <path
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                              ></path>
                            </svg>
                            <input
                              class="flex-grow pl-8 pr-2 py-1 bg-gray-100 border rounded w-full"
                              :class="
                                isDragging ? 'text-gray-600' : 'text-gray-900'
                              "
                              :value="inputValue.start"
                              v-on="inputEvents.start"
                            />
                          </div>
                          <span class="flex-shrink-0 m-2">
                            <svg
                              class="w-4 h-4 stroke-current text-gray-600"
                              viewBox="0 0 24 24"
                            >
                              <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3"
                              />
                            </svg>
                          </span>
                          <div class="relative flex-grow">
                            <svg
                              class="text-gray-600 w-4 h-full mx-2 absolute pointer-events-none"
                              fill="none"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              viewBox="0 0 24 24"
                              stroke="currentColor"
                            >
                              <path
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                              ></path>
                            </svg>
                            <input
                              class="flex-grow pl-8 pr-2 py-1 bg-gray-100 border rounded w-full"
                              :class="
                                isDragging ? 'text-gray-600' : 'text-gray-900'
                              "
                              :value="inputValue.end"
                              v-on="inputEvents.end"
                            />
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
    <div class="row justify-content-center" v-if="true">
      <div class="col-12 card mt-3">
        <div class="card-body text-center">
          <h3 class="card-title">Requests</h3>
          <div class="table-responsive">
            <table class="table-striped w-100 d-block d-md-table"></table>
          </div>
        </div>
      </div>
    </div>
    <div v-else-if="this.loaded" class="row justify-content-center">
      <div class="col-12 card mt-3">
        <div class="card-body text-center">
          <h3 class="card-title">Created Projects</h3>
          <button
            type="button"
            class="btn btn-secondary w-25 mt-3"
            @click="startProject()"
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
              Start Project
            </span>
          </button>
        </div>
      </div>
    </div>
    <div v-else class="row justify-content-center">
      <div class="loader"></div>
    </div>
    <div class="row justify-content-center" v-if="true">
      <div class="col-12 card mt-3">
        <div class="card-body text-center">
          <h3 class="card-title">Gotten Requests</h3>
          <table class="table-striped full-width">
            <thead>
              <tr>
                <th style="width: 35%">Title</th>
                <th style="width: 30%">Author</th>
                <th style="width: 35%">Team</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="request in gottenRequests" :key="request.id">
                <td style="width: 35%">{{ request.description }}</td>
                <td style="width: 30%">
                  {{ request.date_from }}
                </td>
                <td style="width: 35%">
                  {{ request.responser_id }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
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

function Request({ id, date_from, date_to, description, type, is_confirmed, requester_id, responser_id, created_at, updated_at }) {
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
        start: new Date(moment()),
        end: new Date(moment().add(2, "days")),
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
      return Object.fromEntries(adminTeams);
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
          }
        })
        .catch((error) => {
          console.log(error);
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
  height: 40vh;
  overflow-y: auto;
}

thead tr,
tbody tr {
  line-height: 40px;
}
</style>