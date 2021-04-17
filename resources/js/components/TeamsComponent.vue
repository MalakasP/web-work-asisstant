<template>
  <div class="container">
    <h3 class="p-3 text-center">Teams</h3>

    <div
      class="row justify-content-center"
      v-if="this.teamsLength > 0 && this.loaded"
    >
      <div class="container">
        <div class="row">
          <div class="col-4 p-1" v-for="team in teams" :key="team.id">
            <div class="card ripple" @click="loadRouterLink(team)">
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
            <div class="card ripple">
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
    </div>
    <div v-else class="row justify-content-center">
      <div class="loader"></div>
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
            console.log(response.data.teams);
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
    },

    loadRouterLink(team) {
      this.$router.push({ name: "Team", params: { teamId: team.id } });
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