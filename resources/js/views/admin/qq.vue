     // columns: [
      //   { label: "ID", field: "id"},
      //   { label: "Invocie", field: "invoice_id"},
      //   { label: "Name", field: "customer_name"},
      //   { label: "amount", field: "amount"},
      // ],

          <tr>
                            <!-- <th
                              v-for="(column, index) in columns"
                                :key="index"                             
                                class="text-nowrap"
                            >{{ column.name }}
                            </th> -->
                            <th>Id</th>
                            <th>Invocie</th>
                        </tr>

                          <table class="table table-bordered display" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    
                    </thead>
                    <!-- <tbody> -->
                        <!-- <tr v-for="(item, index) in orders.data" :key="index">
                            <td  v-for="(column, index) in columns"
                                :key="index"                             
                                class="text-nowrap"
                            >{{ item[column.field]}}</td>
                            
                        </tr> -->
                    <!-- </tbody> -->
                </table>

                            <!-- <a class="toggle-vis custome"
                              v-for="(column, index) in columns"
                                :key="index" 
                                :data-column="index"                            
                            >{{ column.label }}
                            </a> -->
            <!-- Toggle column: <a class="toggle-vis" data-column="0">Name</a> - <a class="toggle-vis" data-column="1">Position</a> - <a class="toggle-vis" data-column="2">Office</a> - <a class="toggle-vis" data-column="3">Age</a> - <a class="toggle-vis" data-column="4">Start date</a> - <a class="toggle-vis" data-column="5">Salary</a> -->