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
        <a
          class="ml-3 text-sm btn btn-info ms-2"
          type="button"
          @click.prevent="reset"
        >
          Reset
        </a>
        <Link
          class="btn btn-primary ms-2"
          :href="this.route('customer.create')"
        >
          Create
        </Link>
        <div class="ms-auto d-flex flex-row">
          <span class="d-flex align-items-center" style="width: 5rem;">
            Per Page:
          </span>
          <select
            class="form-control w-50 ms-auto"
            name="perpage"
            id="perpage"
            v-model="form.perPage"
          >
            <option value="2">2</option>
            <option value="5" selected>5</option>
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="50">50</option>
            <option value="100">100</option>
          </select>
        </div>
      </div>

      <div class="col-md-11 m-auto mt-3">
        <paginate
          :page-count="this.linksFiltered.length - 2"
          :page-range="7"
          :force-page="form.page"
          :click-handler="handlePagination"
          :prev-text="'Prev'"
          :next-text="'Next'"
          :container-class="'pagination'"
          :page-class="'page-item'"
          :page-link-class="'page-link'"
          :next-class="'page-item'"
          :next-link-class="'page-link'"
          :prev-class="'page-item'"
          :prev-link-class="'page-link'"
        ></paginate>
      </div>
      <div class="col-md-11 m-auto mt-3">
        <CustomerTable
          :customers="this.customersFiltered"
          :currentpage="this.currentpage"
          @changePerPage="changePerPage"
        ></CustomerTable>
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
import Paginate from 'vuejs-paginate'
export default {
  name: 'CustomerIndex',
  metaInfo: { title: 'Customer' },
  components: {
    Link,
    CustomerTable,
    Paginate,
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
        page: this.currentpage,
      },
      customersFiltered: this.customers,
      linksFiltered: this.customers.links,
    }
  },
  watch: {
    form: {
      handler: throttle(function () {
        let query = pickBy(this.form)
        axios
          .get(this.route('customer.search'), {
            params: query,
          })
          .then((response) => {
            this.customersFiltered = response.data.customers
            this.linksFiltered = response.data.customers.links
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
    handlePagination(page) {
      this.form.page = page
    },
  },
}
</script>
