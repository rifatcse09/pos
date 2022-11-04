<template>
  <div>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Order List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th
                              v-for="(column, index) in columns"
                                :key="index"                             
                                class="text-nowrap"
                            >{{ column.label }}
                            </th>
                            <th class="text-nowrap table-right-sticky-col text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in orders.data" :key="index">
                            <td  v-for="(column, index) in columns"
                                :key="index"                             
                                class="text-nowrap"
                            >{{ item[column.field]}}</td>
                            <td class="table-right-sticky-col">
                              <div class="inner-sticky">
                                 <button
                                  v-if="item['payment_status'] == 'PAID'?false:true"
                                  type="submit"
                                  class="btn btn-primary btn-user btn-block"
                                  @click.prevent="onSwitchClick(item.invoice_id,item.amount)"
                                >
                               
                                 Switch
                                </button>
                                 <button
                                  type="button"
                                  class="btn btn-info btn-user btn-block"
                                  @click.prevent="onDetailsClick(item.id)"
                                >
                                 Details
                                </button>
                              </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import "datatables.net-dt/js/dataTables.dataTables"
import "datatables.net-dt/css/jquery.dataTables.min.css"
export default {
  name: "Dashboard",
  data() {
    return {
      mostConversion: "",
      totalConverted: "",
      thirdHighestAmount: "",
      wallet: "",
      mostConversionUser:"",
      columns: [
        { label: "ID", field: "id"},
        { label: "Invocie", field: "invoice_id"},
        { label: "Name", field: "customer_name"},
        { label: "amount", field: "amount"},
        { label: "status", field: "payment_status"},
      ],
    };
  },
  computed: {
    ...mapGetters({
       orders: "getOrders",
    })
  },
  mounted() {
    this.getOrders();
    $('#dataTable').DataTable();
  },

  methods: {
     ...mapActions(["getOrderList","setStatus"]),
     getOrders(){
      this.$store.dispatch('getOrderList')
     },
     onDetailsClick: function(id) {
        const url = `${this.$route.path}/details/${id}`;
        this.$router.push(url);
    },
      onSwitchClick: function(invoice, amount) {
      this.$store.dispatch('setStatus',{invoice, amount})
        $("#taxlist")
            .DataTable()
            .clear()
            .destroy();
      this.getOrders();
      $('#dataTable').DataTable();
    },
  }
  
};
</script>
