<template>
  <div>
    <div class="row">
      <div class="col-md-11 m-auto mt-3 d-flex flex-row">
        <h5 class="my-auto">
          Update Customers
          <span style="text-transform: capitalize;">{{ customer.name }}</span>
        </h5>

        <Link class="btn btn-primary ms-auto" :href="this.route('customer')">
          Go Back
        </Link>
      </div>

      <div class="col-md-11 m-auto mt-3">
        <form class="row" id="customer-form">
          <input type="hidden" name="id" v-model="form.id" />
          <div class="mb-3 col-md-6">
            <label for="name" class="form-label">
              Name
            </label>
            <input
              type="text"
              class="form-control"
              id="name"
              name="name"
              placeholder="Customer Name"
              v-model="form.name"
            />
          </div>
          <div class="mb-3 col-md-6">
            <label for="email" class="form-label">
              Email
            </label>
            <input
              type="email"
              class="form-control"
              id="email"
              name="email"
              placeholder="demo@email.com"
              v-model="form.email"
            />
          </div>
          <div class="mb-3 col-md-6">
            <label for="address" class="form-label">
              Address
            </label>
            <input
              type="text"
              class="form-control"
              name="address"
              id="address"
              placeholder="947 Pfeffer Union Suite 350"
              v-model="form.address"
            />
          </div>
          <div class="mb-3 col-md-6">
            <label for="city" class="form-label">
              City
            </label>
            <input
              type="text"
              class="form-control"
              id="city"
              name="city"
              placeholder="South Lilachester"
              v-model="form.city"
            />
          </div>
          <div class="mb-3 col-md-6">
            <label for="state" class="form-label">
              State
            </label>
            <input
              type="text"
              class="form-control"
              id="state"
              name="state"
              placeholder="Minnesota"
              v-model="form.state"
            />
          </div>
          <div class="mb-3 col-md-6">
            <label for="country" class="form-label">
              Country
            </label>
            <input
              type="text"
              class="form-control"
              id="country"
              name="country"
              placeholder="United States"
              v-model="form.country"
            />
          </div>

          <div class="my-3 col-md-12 text-center">
            <button
              class="btn btn-primary"
              type="submit"
              @click.prevent="handleCustomerUpdate"
            >
              Update
            </button>
          </div>
          <div class="my-3 col-md-12">
            <div
              class="alert alert-success flex-row"
              id="successMsg"
              style="display: none; cursor: pointer;"
              @click="closeMsg"
              title="Click to goto listing"
            >
            <div class="left"></div>
            <div class="right ms-auto"><i class="fa-solid fa-xmark"></i></div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue'
import axios from 'axios'
import validate from 'jquery-validation'

export default {
  name: 'CustomerEdit',
  metaInfo: { title: 'Customer' },
  components: {
    Link,
  },
  props: {
    customer: {
      type: Object | Array,
      required: true,
    },
  },
  data() {
    return {
      form: {
        id: this.customer.id,
        name: this.customer.name,
        email: this.customer.email,
        address: this.customer.address,
        city: this.customer.city,
        state: this.customer.state,
        country: this.customer.country,
      },
      successMsg: '',
    }
  },
  methods: {
    handleCustomerUpdate() {
      this.successMsg = ''
      $.each($.validator.methods, function (key, value) {
        $.validator.methods[key] = function () {
          if (arguments.length > 0) {
            arguments[0] = $.trim(arguments[0])
          }

          return value.apply(this, arguments)
        }
      })
      var rsp = $('#customer-form').validate({
        errorClass: 'text-danger',
        rules: {
          name: {
            required: true,
          },
          email: {
            required: true,
            email: true,
          },
          address: {
            required: true,
          },
          city: {
            required: true,
          },
          state: {
            required: true,
          },
          country: {
            required: true,
          },
        },
        messages: {
          name: {
            required: 'Please enter customer name',
          },
          email: {
            required: 'Please enter customer email',
            email: 'Please enter valid email',
          },
          address: {
            required: 'Please enter customer address',
          },
          city: {
            required: 'Please enter customer city',
          },
          state: {
            required: 'Please enter customer state',
          },
          country: {
            required: 'Please enter customer country',
          },
        },
        success: function (label, element) {
          label.parent().removeClass('error')
          label.remove()
        },
      })
      if ($('#customer-form').valid()) {
        axios
          .post(this.route('customer.update', this.form.id), this.form)
          .then(() => {
            this.successMsg = 'Customer Updated Successfully'
            $('#successMsg').removeClass('d-flex')
            $('#successMsg').addClass('d-flex')
            $('#successMsg .left').html(this.successMsg)
            $('#successMsg').slideDown()
          })
          .catch((error) => {
            console.log(error)
          })
      }
    },
    closeMsg() {
      $('#successMsg').slideUp();
      $('#successMsg').removeClass('d-flex')
      this.$inertia.get(this.route('customer'))
    },
  },
}
</script>
