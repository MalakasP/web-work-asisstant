<template>
  <div class="container">
    <div
      class="row justify-content-center"
      v-if="Object.keys(this.team).length > 0 && this.loaded"
    >
      <div class="container">
        <div class="card mt-5">
          <div class="card-body">
            <h3 class="card-title text-center">{{ team.name }}</h3>
            <h5 class="card-text min-height p-3">{{ team.description }}</h5>
            <div
              class="row justify-content-center"
              v-if="this.team.users.length > 0"
            >
              <div class="col-12">
                <table class="table-striped full-width">
                  <thead>
                    <tr>
                      <th style="width: 30%">Name</th>
                      <th style="width: 30%">Name In Team</th>
                      <th style="width: 30%">Team Admin</th>
                      <th style="width: 5%"></th>
                      <th style="width: 5%"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="user in this.team.users" :key="user.id">
                      <td style="width: 30%">{{ user.name }}</td>
                      <td style="width: 30%">
                        {{ user.pivot.name_in_team }}
                      </td>
                      <td style="width: 30%">
                        {{ user.pivot.is_admin | isAdmin }}
                      </td>
                      <td style="width: 5%" v-if="isAdmin">
                        <button
                          type="button"
                          class="btn btn-primary"
                          style="margin: 1px"
                          @click="startEdit(user)"
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
                      <td style="width: 5%" v-else></td>
                      <td style="width: 5%" v-if="isAdmin">
                        <button
                          type="button"
                          class="btn btn-danger"
                          @click="startRemove(user)"
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
                      <td style="width: 5%" v-else></td>
                    </tr>
                    <tr class="bg-white" v-if="!createForm && isAdmin">
                      <td></td>
                      <td>
                        <button
                          type="button"
                          class="btn btn-secondary"
                          style="margin: 3px"
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
                            Add User
                          </span>
                        </button>
                      </td>
                    </tr>
                    <tr class="bg-white" v-else>
                      <td>
                        <input
                          type="text"
                          class="form-control input-sm"
                          :class="{ 'is-invalid': errors.email }"
                          v-model="form.email"
                          placeholder="Enter user email"
                        />
                        <div
                          class="tooltip bs-tooltip-top show invalid-feedback"
                          v-if="errors.email"
                        >
                          {{ errors.email }}
                        </div>
                      </td>
                      <td>
                        <input
                          type="text"
                          class="form-control input-sm"
                          :class="{ 'is-invalid': errors.name_in_team }"
                          v-model="form.name_in_team"
                          placeholder="Enter user name in team"
                        />
                        <div
                          class="tooltip bs-tooltip-top show invalid-feedback"
                          v-if="errors.name_in_team"
                        >
                          {{ errors.name_in_team }}
                        </div>
                      </td>
                      <td>
                        <select
                          class="form-control input-sm"
                          :class="{ 'is-invalid': errors.is_admin }"
                          v-model="form.is_admin"
                        >
                          <option :value="true">Yes</option>
                          <option :value="false">No</option>
                        </select>
                        <div
                          class="tooltip bs-tooltip-top show invalid-feedback"
                          v-if="errors.team_id"
                        >
                          {{ errors.team_id }}
                        </div>
                      </td>
                      <td>
                        <button
                          type="button"
                          class="btn btn-success"
                          style="margin: 1px"
                          @click="create()"
                        >
                          <span class="icon is-small">
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              width="16"
                              height="16"
                              fill="currentColor"
                              class="bi bi-check-circle"
                              viewBox="0 0 16 16"
                            >
                              <path
                                d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"
                              />
                              <path
                                d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"
                              />
                            </svg>
                          </span>
                        </button>
                      </td>
                      <td>
                        <button
                          type="button"
                          class="btn btn-danger"
                          style="margin: 1px"
                          @click="endCreate()"
                        >
                          <span class="icon is-small">
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              width="16"
                              height="16"
                              fill="currentColor"
                              class="bi bi-x-circle"
                              viewBox="0 0 16 16"
                            >
                              <path
                                d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"
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
          </div>
        </div>
      </div>
    </div>
    <div v-else-if="this.loaded && this.error">
      <not-found-component></not-found-component>
    </div>
    <div v-else class="row justify-content-center">
      <div class="loader"></div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import NotFoundComponent from "./NotFoundComponent.vue";

export default {
  components: { NotFoundComponent },
  data: function () {
    return {
      isAdmin: false,
      loaded: false,
      team: {},
      error: false,
      createForm: false,
      form: {
        email: null,
        name_in_team: null,
        is_admin: null,
      },
      editForm: {},
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
    this.read();
  },
  filters: {
    isAdmin: function (value) {
      if (!value) return "No";
      return "Yes";
    },
  },
  methods: {
    async read() {
      await window
        .axios({
          url: process.env.MIX_API_URL + "teams/" + this.$route.params.teamId,
          baseURL: "/",
        })
        .then((response) => {
          if (response.data != null) {
            this.team = {};
            this.team = response.data.team;

            this.loaded = true;
          }
        })
        .catch((error) => {
          if (error.response.status == 404) {
            this.error = true;
            this.loaded = true;
          }
        });

      this.isUserAdmin();
    },

    async create() {
      await window
        .axios({
          method: "post",
          url: process.env.MIX_API_URL + "teams/" + this.team.id + "/addUser",
          baseURL: "/",
          data: this.form,
        })
        .then((response) => {
          if (response.data != null) {
            this.createForm = false;

            response.data.user.pivot = [];
            response.data.user.pivot.is_admin = this.form.is_admin,
            response.data.user.pivot.name_in_team = this.form.name_in_team,
            this.team.users.push(response.data.user);
            this.$notify({
              group: "app",
              title: "Success!",
              type: "success",
              text: response.data.message,
            });
            this.$store.commit("setErrors", {});
          }
        })
        .catch((error) => {
          if (error.response.status == 409) {
            this.$notify({
              group: "app",
              title: "Warning",
              type: "error",
              text: response.data.message,
            });
          } else if (error.response.status == 403) {
            this.$alert(error.response.data.error, "Forbidden", "error");
          } else {
            this.$alert(error.response.data.status, "Warning", "error");
          }
        });
    },

    async remove(userId) {
      await window
        .axios({
          method: "delete",
          url:
            process.env.MIX_API_URL +
            "teams/" +
            this.team.id +
            "/users/" +
            userId,
          baseURL: "/",
        })
        .then((response) => {
          if (response.data != null) {
            var userIndex = this.team.users.findIndex(
              (user) => user.id == userId
            );
            this.team.users.splice(userIndex, 1);
            this.$notify({
              group: "app",
              title: "Success!",
              type: "success",
              text: response.data.message,
            });
          }
        })
        .catch((error) => {
          if (error.response.status == 403) {
            this.$alert(error.response.data.error, "Forbidden", "error");
          } else {
            this.$alert(error.response.data.status, "Warning", "error");
          }
        });
    },

    startCreate() {
      this.createForm = true;
      this.form.email = null;
      this.form.name_in_team = null;
      this.form.is_admin = false;
    },

    endCreate() {
      this.createForm = false;
      this.$store.commit("setErrors", {});
    },

    startEdit(user) {},

    startRemove(user) {
      this.$confirm("Are You sure?", "Confirm Remove", "error").then(() => {
        this.remove(user.id);
      });
    },

    isUserAdmin() {
      if (
        this.team.users.find((user) => user.id == this.user.id).pivot.is_admin
      ) {
        this.isAdmin = true;
      }
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

.min-height {
  min-height: 50px;
}

.to-capital-first {
  text-transform: capitalize;
}
</style>