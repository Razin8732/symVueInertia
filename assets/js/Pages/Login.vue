<template>
  <div>
    <div class="row">
      <div class="col-12">
        <!-- <ul v-if="errors">
          <li v-for="error in errors" :key="error">{{ error }}</li>
        </ul> -->
        <!-- <textarea name="" id="" cols="30" rows="10" v-html="errors"></textarea> -->
      </div>
      <div class="col-md-3 m-auto mt-3">
        <main class="form-signin">
          <form>
            <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

            <div class="form-floating">
              <input
                type="email"
                class="form-control mt-3"
                id="floatingInput"
                placeholder="name@example.com"
                v-model="email"
              />
              <label for="floatingInput">Email address</label>
            </div>
            <div class="form-floating">
              <input
                type="password"
                class="form-control mt-3"
                id="floatingPassword"
                placeholder="Password"
                v-model="password"
              />
              <label for="floatingPassword">Password</label>
            </div>

            <button
              class="w-100 btn btn-lg btn-primary mt-3"
              type="button"
              @click="handleLogin"
            >
              Sign in
            </button>
            <p class="mt-5 mb-3 text-muted">© 2017–2021</p>
          </form>
        </main>
      </div>
    </div>
  </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue'

export default {
  metaInfo: { title: 'Dashboard' },
  data() {
    return {
      email: '',
      password: '',
    }
  },
  props: {
    errors: Object,
  },
  components: {
    Link,
  },

  methods: {
    handleLogin() {
      this.$inertia.post(this.route('app.login'), {
        email: this.email,
        password: this.password,
      })
    },
  },
  watch: {
    errors: {
      handler(errors) {
        if (errors) {
          Object.keys(errors).forEach((key) => {
            toastr.error(errors[key], key)
          })
        }
      },
      deep: true,
    },
  },
}
</script>
