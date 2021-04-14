<template>
  <div class="container">
    <h3 class="p-3 text-center">Teams</h3>
    <div class="row justify-content-center" v-if="this.teamsLength > 0 && this.loaded">
      <div class="container">
        <div class="row">
          <div class="col-12-md" v-for="team in teams" :key="team.id">
            <div class="col-4 card p-3">
              <div>
                <h5>{{ team.name }}</h5>
              </div>
              <div>
                <h5>{{ team.description }}</h5>
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
import moment from "moment";

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
      cols:3
    };
  },
  computed: {
    ...mapGetters(["errors"]),
    ...mapGetters("auth", ["user"]),
    columns() {
      let columns = []
      let mid = Math.ceil(this.teamsLength / this.cols)
      for (let col = 0; col < this.cols; col++) {
        columns.push(this.teams.slice(col * mid, col * mid + mid))
      }
      return columns
    }
  },
  mounted() {
    this.$store.commit("setErrors", {});
  },
  created() {
    this.read();
  },
  methods: {

    async read() {
      await window.axios
        .get(process.env.MIX_API_URL + "users")
        .then((response) => {
          if (response.data != null) {
            this.users = {};
            response.data.users.forEach((user) => {
              if (user != null) {
                this.users[user.id] = user;
              }
            });
          }
        })
        .catch((error) => {
          console.log(error);
        });

      await window.axios
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
            this.teams[6] = new Team({name:"random", id:6, description:"haha"});
            this.teams[7] = new Team({name:"rando2", id:7, description:"haha2"});
          }
          this.loaded = true;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>

<style scoped>
.loader {
  border: 8px solid white;
  border-top: 8px solid #007bff;
  border-radius: 50%;
  width: 40px;
  height: 40px;
  animation: spin 2s linear infinite;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

.team-container {
  display: flex;
}
</style>