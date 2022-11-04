<template>
  <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Create Order</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                       
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="alert alert-danger alert-dismissable" v-if="errors.length">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                      <b class="input--error">Please check the fields:</b>
                                      <ul>
                                        <li class="input--error" v-for="error in errors" :key="error">{{ error }}</li>
                                      </ul>
                                    </div>
                                    <div v-if="success" class="alert alert-success alert-dismissable">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                         <span>{{success_message}}</span>
                                    </div>
                                    <form role="form" @submit="onSubmit">
                                        <div class="form-group">
                                          <label for="customerName">Customer Name</label>
                                          <input class="form-control"  type="text" v-model="form.customer_name">
                                        </div>
                                        <div class="form-group">
                                          <label for="customerEmail">Customer Email</label>
                                          <input class="form-control"  type="email" v-model="form.customer_email">
                                        </div>
                                        <div class="form-group">
                                          <label for="customerEmail">Customer Phone</label>
                                          <input class="form-control"  type="text" v-model="form.customer_phone">
                                        </div>
                                        <div class="form-group">
                                          <label for="customerEmail">Customer Street</label>
                                          <input class="form-control"  type="text" v-model="form.customer_street">
                                        </div>
                                        <div class="form-group">
                                          <label for="customerEmail">Customer City</label>
                                          <input class="form-control"  type="text" v-model="form.customer_city">
                                        </div>
                                        <div class="form-group">
                                          <label for="customerEmail">Customer State</label>
                                          <input class="form-control"  type="text" v-model="form.customer_state">
                                        </div>
                                        <div class="form-group">
                                          <label for="customerEmail">Customer Zipcode</label>
                                          <input class="form-control"  type="text" v-model="form.customer_zipcode">
                                        </div>
                                                                                <div class="form-group">
                                        <label>Country</label>
                                          <select class="form-control" v-model="form.customer_country">
                                            <option value="">Select Country</option>
                                              <option
                                                v-for="(country, index) in listCountry"
                                                :value="country.id"
                                                :key="index"
                                              >
                                                {{ country.name }}
                                              </option>
                                          </select>
                                        </div>
                                        <div class="form-group">
                                          <label for="customerEmail">Product Name</label>
                                          <input class="form-control"  type="text" v-model="form.product_name">
                                        </div>
                                        <div class="form-group">
                                          <label for="customerEmail">Product Description</label>
                                          <textarea class="form-control"  v-model="form.product_description">
                                          </textarea>
                                        </div>
 
                                         <div class="form-group">
                                            <label for="disabledSelect">Amount</label>
                                            <input class="form-control" id="disabledInput" type="text" placeholder="0.00" v-model="form.amount">
                                        </div>
                                                    
                                        <button type="submit" class="btn btn-primary" :disabled="isActive">Save</button>
                                        <button type="reset" class="btn btn-secondary" @click="onReset">Reset</button>
                                    </form>
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
</template>

<script>

import { mapGetters } from 'vuex'
  export default {
    data() {
      return {
        errors: [],
        form: {
          customer_name: '',
          customer_email: '',
          customer_phone: '',
          customer_street: '',
          customer_city: '',
          customer_state: '',
          customer_zipcode: '',
          customer_country: '',
          product_name: '',
          product_description: '',
          amount: "",
        },
        listCountry: [
          { id: 'BGD', name: 'Bangladesh' },
        ],

        isActive:false,
        show: true,
        listUser: [],
        senderId: null,
        success_message:"",
        success:false
      }
    },
      computed: {
        ...mapGetters(['user'])
    },
    mounted() {
      this.setUser()
    },
    methods: {

      setUser(){
        this.senderId = this.user.id;
      },

      onSubmit(event) {
        event.preventDefault();
        this.isActive = true;
    
        this.errors = [];

        if (!this.form.customer_name) {
          this.errors.push('Please entry customer name');
        }
        if (!this.form.customer_email) {
          this.errors.push('Please entry customer email');
        }
        if (!this.form.customer_phone) {
          this.errors.push('Please entry customer phone');
        }
        if (!this.form.customer_street) {
          this.errors.push('Please entry customer street');
        }
        if (!this.form.customer_city) {
          this.errors.push('Please entry customer city');
        }
        if (!this.form.customer_state) {
          this.errors.push('Please entry customer state');
        }
        if (!this.form.customer_zipcode) {
          this.errors.push('Please entry customer zipcode');
        }
        if (!this.form.customer_country) {
          this.errors.push('Please entry customer country');
        }
        if (!this.form.product_name) {
          this.errors.push('Please entry product name');
        }
        if (!this.form.product_description) {
          this.errors.push('Please entry product description');
        }
        if (!this.form.amount) {
          this.errors.push('Please entry amount');
        }
        if (this.form.amount <= 0) {
          this.errors.push('Amount must be greater then 0');
        }

        if (this.errors.length) {
          this.isActive = false;
          return;
        }

        let data = {
          'customer_name':this.form.customer_name,
          'customer_email':this.form.customer_email,
          'customer_phone':this.form.customer_phone,
          'customer_street':this.form.customer_street,
          'customer_city':this.form.customer_city,
          'customer_state':this.form.customer_state,
          'customer_zipcode':this.form.customer_zipcode,
          'customer_country':this.form.customer_country,
          'product_name':this.form.product_name,
          'product_description':this.form.product_description,
          'amount':this.form.amount,
        }
        console.log(data)
        this.createOrder(data, event);
    
      },

      onReset(event) {
        event.preventDefault()
        console.log('sare')
        // Reset our form values
        this.form.customer_name = ""
        this.form.customer_email = ""
        this.form.customer_phone = ""
        this.form.customer_street = ""
        this.form.customer_city = ""
        this.form.customer_state = ""
        this.form.customer_zipcode = ""
        this.form.customer_country= ""
        this.form.product_name = ""
        this.form.product_description = ""
    
        // Trick to reset/clear native browser form validation state
        this.show = false
        this.$nextTick(() => {
          this.show = true
        })
      },

      async createOrder(data , event) {        
        try {
            const response = await axios.post("create-order", data);
            this.success_message = 'Order Create succesfull.'
            this.success = true;
          } catch (error) {
            console.log(error)
          }
          this.isActive = false;
          this.onReset(event);
      },
    }
  }
</script>
<style scoped>
  .input--error{
    color:red;
  }
</style>