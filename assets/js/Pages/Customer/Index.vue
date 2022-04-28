<template>
  <div>
    <div class="row">
      <div class="col-md-11 m-auto mt-3 d-flex flex-row">
        <h5 class="my-auto">Customers</h5>
      </div>
      <div class="col-md-11 m-auto mt-3 d-flex flex-row">
        <input type="text" class="form-control w-25" name="search" id="">
        <Link
          class="btn btn-primary ms-auto"
          :href="this.route('customer.create')"
        >
          Create
        </Link>
      </div>

      <div class="col-md-11 m-auto mt-3">
        <table class="table">
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
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue'

export default {
  name: 'CustomerIndex',
  metaInfo: { title: 'Customer' },
  components: {
    Link,
  },
  props: {
    customers: Array,
  },
}
</script>
