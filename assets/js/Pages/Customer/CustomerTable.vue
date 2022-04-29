<template>
  <div>
    <table class="table">
      <thead>
        <th>#</th>
        <th>Name</th>
        <th>Email</th>
        <th>Address</th>
        <th>Action</th>
      </thead>
      <tbody>
        <tr v-for="customer in customers.data" :key="customer.id">
          <td>{{ customer.id }}</td>
          <td>{{ customer.name }}</td>
          <td>{{ customer.email }}</td>
          <td>
            {{ customer.address }}, {{ customer.city }},{{ customer.state }},{{
              customer.address
            }}
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
        <tr v-if="customers.length == 0">
          <td colspan="5">No customers found.</td>
        </tr>
      </tbody>
    </table>
    <div>
      <nav aria-label="Page navigation example">
        <ul class="pagination">

        </ul>
      </nav>
    </div>
    <!-- <PaginationComponent
      :links="customers.links"
      @changePerPage="changePerPage"
    ></PaginationComponent> -->
  </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue'
import PaginationComponent from '../Shared/PaginationComponent'
export default {
  name: 'CustomerTable',
  metaInfo: { title: 'Customer' },
  components: {
    Link,
    PaginationComponent,
  },
  props: {
    customers: Array | Object,
    currentpage: Number | String,
  },
  data() {
    return {
      perpage: 5,
      numShown: 5,
      current: parseInt(this.currentpage),
    }
  },
  computed: {
    arrayLength() {
      return this.customers.links.length - 2 // -2 because of the next and previous buttons
    },
    pages() {
      const numShown = Math.min(this.numShown, this.customers.links.length)
      var start = this.current
      var max = this.customers.links.length - 2
      var end = this.current + (numShown - 1)
      if (end > max) {
        start = start - 3
        var diff = end - max
        end = end - diff
      }
      // console.log(this.customers.links.length)
      let final2 = []
      let temp
      temp = {
        label: 'First',
        url: this.customers.links[1].url,
        active: this.customers.links[1].active,
      }
      final2.push(temp)
      temp = {
        label: this.customers.links[0].label,
        url: this.customers.links[0].url,
        active: this.customers.links[0].active,
      }
      final2.push(temp)
      if (this.current != 1) {
        temp = {
          label: this.customers.links[this.current - 1].label,
          url: this.customers.links[this.current - 1].url,
          active: this.customers.links[this.current - 1].active,
        }
        final2.push(temp)
      }
      for (let i = start; i <= end; i++) {
        temp = {
          active: this.customers.links[i].active,
          label: this.customers.links[i].label,
          url: this.customers.links[i].url,
        }
        final2.push(temp)
      }
      temp = {
        active: this.customers.links[this.customers.links.length - 1].active,
        label: this.customers.links[this.customers.links.length - 1].label,
        url: this.customers.links[this.customers.links.length - 1].url,
      }
      final2.push(temp)
      return final2
    },
  },

  methods: {
  },
}
</script>
