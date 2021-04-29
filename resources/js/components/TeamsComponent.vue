<template>
  <div class="container">
    <h3 class="p-3 text-center">Teams</h3>
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
                    @click="(modal = false)"
                  >
                    <span aria-hidden="true">&times; </span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <label>Enter Name</label>
                    <input
                      type="text"
                      class="form-control"
                      :class="{ 'is-invalid': errors.name }"
                      v-model="form.name"
                    />
                    <div class="invalid-feedback" v-if="errors.name">
                      {{ errors.name }}
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
                  <div align="center">
                    <input
                      type="button"
                      class="btn btn-primary"
                      value="Submit"
                      @click="create()"
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
      v-if="this.teamsLength > 0 && this.loaded"
    >
      <div class="container">
        <div class="row">
          <div class="col-4 p-1" v-for="team in teams" :key="team.id">
            <div class="card ripple" @click="goRouter(team)">
              <div class="card-body">
                <h5 class="card-title">{{ team.name }}</h5>
                <p class="card-text" v-if="team.description">
                  {{ team.description }}
                </p>
                <p class="card-text" v-else>No description. Maybe add one?</p>
              </div>
            </div>
          </div>
          <div class="col-4 p-1">
            <div class="card ripple" @click="startCreate()">
              <div class="card-body">
                <h5 class="card-title">Create new team</h5>
                <p class="card-text">Want to start a new team? Click here.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-else-if="this.loaded">
      <h4 class="p-3 text-center">You are not included in any team.</h4>
      <div class="row justify-content-center">
        <div class="container">
          <div class="row">
            <div class="col-4 p-1">
              <div class="card ripple" @click="startCreate()">
                <div class="card-body">
                  <h5 class="card-title">Create new team</h5>
                  <p class="card-text">Want to start a new team? Click here.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-else class="row justify-content-center">
      <div class="loader mt-3"></div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

function Team({ id, name, description, created_at, updated_at }) {
  this.id = id;
  this.name = name;
  this.description = description;
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
      teams: {},
      teamsLength: 0,
      users: {},
      form: {
        name: null,
        description: null,
      },
      modal: false,
      dynamicTitle: null,
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

  methods: {
    async read() {
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
            this.teamsLength = Object.keys(this.teams).length;
            this.loaded = true;
          }
        })
        .catch((error) => {
          console.log(error);
          this.loaded = true;
        });

        //get projects and show in team card (atleast a few)
    },

    async create() {
      await axios({
        method: "post",
        url: process.env.MIX_API_URL + "teams/",
        baseURL: "/",
        data: this.form,
      })
        .then((response) => {
          if (response.data != null) {
            this.$store.commit("setErrors", {});
            this.modal = false;
            if (response.data.team != null) {
              this.teams[response.data.team.id] = new Team(response.data.team);
            }
            this.$notify({
              group: "app",
              title: "Success!",
              type: "success",
              text: response.data.message,
            });
            this.goRouter(this.teams[response.data.team.id]);
          }
        })
        .catch((error) => {
          if (error.response.status == 422) {
            this.$store.commit("setErrors", error.response.data.errors);
          } else if (error.response.status == 409) {
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

    goRouter(team) {
      this.$router.push({ name: "Team", params: { teamId: team.id } });
    },

    startCreate() {
      this.dynamicTitle = "Create Team";
      this.modal = true;
      this.form.name = null;
      this.form.description = null;
      this.$store.commit("setErrors", {});
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

.card:hover {
  color: white;
  -webkit-box-shadow: 0 10px 20px 0 rgb(0 0 0 / 50%);
  box-shadow: 0 10px 20px 0 rgb(0 0 0 / 50%);
}

.ripple {
  background-position: center;
  transition: background 0.8s;
}

.ripple:hover {
  background: #007bff radial-gradient(circle, transparent 1%, #007bff 1%)
    center/15000%;
}

.ripple:active {
  background-color: #6eb9f7;
  background-size: 100%;
  transition: background 0s;
}
</style>