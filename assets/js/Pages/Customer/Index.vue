<template>
  <div>
    <div class="row">
      <div class="col-md-11 m-auto mt-3 d-flex flex-row">
        <h5 class="my-auto">Customers</h5>
      </div>
      <div class="col-md-11 m-auto mt-3 d-flex flex-row">
        <input
          type="text"
          class="form-control w-25"
          name="search"
          id=""
          v-model="form.search"
        />
        <a class="ml-3 text-sm" type="button" @click.prevent="reset">Reset</a>
        <Link
          class="btn btn-primary ms-auto"
          :href="this.route('customer.create')"
        >
          Create
        </Link>
      </div>

      <div class="col-md-11 m-auto mt-3">
        <CustomerTable
          :customers="this.customersFiltered"
          :currentpage="this.currentpage"
          @changePerPage="changePerPage"
        ></CustomerTable>
        <!-- <table class="table">
          <thead>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Address</th>
            <th>Action</th>
          </thead>
          <tbody>
            <tr v-for="customer in customers" :key="customer.id">
              <td>{{ customer.id }}</td>
              <td>{{ customer.name }}</td>
              <td>{{ customer.email }}</td>
              <td>
                {{ customer.address }}, {{ customer.city }},{{
                  customer.state
                }},{{ customer.address }}
              </td>
              <td>
                <Link
                  class="btn btn-primary text-white btn-sm"
                  :href="'/customer/edit/' + customer.id"
                >
                  <i class="fa fa-pencil"></i>
                </Link>
              </td>
            </tr>
          </tbody>
        </table> -->
      </div>
    </div>
  </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue'
import pickBy from 'lodash/pickBy'
import throttle from 'lodash/throttle'
import mapValues from 'lodash/mapValues'
import CustomerTable from './CustomerTable'
import axios from 'axios'
export default {
  name: 'CustomerIndex',
  metaInfo: { title: 'Customer' },
  components: {
    Link,
    CustomerTable,
  },
  props: {
    customers: Array | Object,
    search: String,
    currentpage: Number | String,
  },
  data() {
    return {
      form: {
        search: this.search,
        perPage: 5,
      },
      customersFiltered: this.customers,
    }
  },
  watch: {
    form: {
      handler: throttle(function () {
        let query = pickBy(this.form)
        // this.$inertia.get(
        //   this.route(
        //     'customer',
        //     Object.keys(query).length ? query : { search: '' },
        //   ),
        // )
        axios
          .get(this.route('customer.search'), {
            params: query,
          })
          .then((response) => {
            this.customersFiltered = response.data.customers
          })
      }, 500),
      deep: true,
    },
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null)
      this.$inertia.get(this.route('customer'))
    },
    changePerPage(perPage) {
      this.form.perPage = perPage
    },
  },
}
</script>
