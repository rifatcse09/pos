<template>
  <div>
     <!-- Page Heading -->
     <h1 class="h3 mb-4 text-gray-800">Order Details</h1>
     <div class="row">
         <div class="col-lg-12">
        <!-- Dropdown Card Example -->
        <div class="card shadow mb-12">
          <!-- Card Header - Dropdown -->
          <div
            class="
              card-header
              py-3
              d-flex
              flex-row
              align-items-center
              justify-content-between
            "
          >
            <h6 class="m-0 font-weight-bold text-primary">
              Order Details
            </h6>

          </div>
          <!-- Card Body -->
          <div class="card-body">
            <div class="container-fluid">
                <div class="container">
                    <!-- Title -->
                    <div class="d-flex justify-content-between align-items-center py-3">
                        <h2 class="h5 mb-0"><a href="#" class="text-muted"></a> Invoice #{{orderInfo.invoice_id}}</h2>
                    </div>
                    <div class="d-flex justify-content-between align-items-center py-3">
                        <h1 class="h6 mb-0">Payment URL  <a  target="_blank" :href="orderInfo.payment_url" class="text-muted">{{orderInfo.payment_url}}</a>  </h1>
                    </div>

                    <!-- Main content -->
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Details -->
                            <div class="card mb-4">
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tfoot>
                                            <tr>
                                                <td colspan="2">Customer Name</td>
                                                <td class="text-end">{{orderInfo.customer_name}}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">Customer Email</td>
                                                <td class="text-end">{{orderInfo.customer_email}}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">Customer Email</td>
                                                <td class="text-end">{{orderInfo.customer_phone}}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">Address</td>
                                                <td class="text-end">{{orderInfo.customer_street+' '+orderInfo.customer_city+' '+orderInfo.customer_state}}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">Product</td>
                                                <td class="text-end">{{orderInfo.product_name}}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">Product Description</td>
                                                <td class="text-end">{{orderInfo.product_details}}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">Amount</td>
                                                <td class="text-end">{{orderInfo.amount}}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">Payment Status</td>
                                                <td class="text-end">{{orderInfo.payment_status}}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                      
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
export default {
    name: 'Details',
    data(){
        return {
            id: this.$route.params.id //this is the id from the browser
        }
    },

    computed: {
        ...mapGetters({
        orderInfo: "getOrderInfo",
        })
    },
    mounted() {
        this.getOrderInfo();
    },
    methods: {
        ...mapActions(["setOrderInfo"]),
        getOrderInfo() {
          this.$store.dispatch('setOrderInfo',this.id)
        },
    }

}
</script>
<style scoped>
body{
    background:#eee;
}
.card {
    box-shadow: 0 20px 27px 0 rgb(0 0 0 / 5%);
}
.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 0 solid rgba(0,0,0,.125);
    border-radius: 1rem;
}
.text-reset {
    --bs-text-opacity: 1;
    color: inherit!important;
}
a {
    color: #5465ff;
    text-decoration: none;
}
</style>