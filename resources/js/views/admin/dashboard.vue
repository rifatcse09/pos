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
        <div>
          <div class="note">Toggle bellow column for ADD/Remove :</div>
          <a
            class="toggle-vis custome"
            v-for="(column, index) in columns"
            :key="index"
            :data-column="index"
            >{{ column.label }}
          </a>
        </div>
        <div class="table-responsive">
          <table
            class="table table-bordered display"
            id="dataTable"
            width="100%"
            cellspacing="0"
          >
            <thead>
              <tr>
                <th>Id</th>
                <th>Invoice</th>
                <th>Customer Name</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Id</th>
                <th>Invoice</th>
                <th>Customer Name</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import "datatables.net-dt/js/dataTables.dataTables";
import "datatables.net-dt/css/jquery.dataTables.min.css";
import "datatables.net-buttons";
import "datatables.net-buttons/js/buttons.html5.js";
import "datatables.net-buttons/js/buttons.print.js";
import pdfMake from "pdfmake/build/pdfmake";
import pdfFonts from "pdfmake/build/vfs_fonts";

export default {
  name: "Dashboard",
  data() {
    return {
      mostConversion: "",
      totalConverted: "",
      thirdHighestAmount: "",
      wallet: "",
      mostConversionUser: "",
      columns: [
        { label: "ID" },
        { label: "Invoice" },
        { label: "Customer Name" },
      ],
    };
  },

  mounted() {
    pdfMake.vfs = pdfFonts.pdfMake.vfs;
    // Setup - add a text input to each footer cell
    $("#dataTable thead tr")
      .clone(true)
      .addClass("filters")
      .appendTo("#dataTable thead");

    var buttonCommon = {
      exportOptions: {
        format: {
          body: function (data, row, column, node) {
            return data;
          },
        },
      },
    };

    let table = $("#dataTable").DataTable({
      //scrollY: '200px',
      paging: true,
      orderCellsTop: true,
      fixedHeader: true,
      dom: "Bfrtip",
      processing: true,
      serverSide: true,
      info: true, // control table information display field
      stateSave: true, //restore table state on page reload,
      ajax: {
        url: "http://127.0.0.1:8000/api/orders",
        dataSrc: "data",
        type: "GET",
        crossDomain: true,
        beforeSend: function (xhr) {
          xhr.setRequestHeader(
            "Authorization",
            "Bearer " + localStorage.getItem("token")
          );
        },
      },
      columns: [
        { data: "id", field: "id" },
        { data: "invoice_id", field: "invoice_id" },
        { data: "customer_name", field: "customer_name" },
      ],
      initComplete: function () {
        var api = this.api();

        // For each column
        api
          .columns()
          .eq(0)
          .each(function (colIdx) {
            // Set the header cell to contain the input element
            var cell = $(".filters th").eq(
              $(api.column(colIdx).header()).index()
            );
            var title = $(cell).text();
            $(cell).html('<input type="text" placeholder="' + title + '" />');

            // On every keypress in this input
            $(
              "input",
              $(".filters th").eq($(api.column(colIdx).header()).index())
            )
              .off("keyup change")
              .on("change", function (e) {
                // Get the search value
                $(this).attr("title", $(this).val());
                var regexr = "({search})"; //$(this).parents('th').find('select').val();

                var cursorPosition = this.selectionStart;
                // Search the column for that value
                api
                  .column(colIdx)
                  .search(
                    this.value != ""
                      ? regexr.replace("{search}", "(((" + this.value + ")))")
                      : "",
                    this.value != "",
                    this.value == ""
                  )
                  .draw();
              })
              .on("keyup", function (e) {
                e.stopPropagation();

                $(this).trigger("change");
                $(this)
                  .focus()[0]
                  .setSelectionRange(cursorPosition, cursorPosition);
              });
          });
      },
      buttons: [
        $.extend(false, {}, buttonCommon, {
          extend: "csvHtml5",
        }),
        $.extend(true, {}, buttonCommon, {
          extend: "excelHtml5",
        }),
        $.extend(true, {}, buttonCommon, {
          extend: "pdfHtml5",
        }),
      ],
    });

    $("a.toggle-vis").on("click", function (e) {
      e.preventDefault();

      // Get the column API object
      var column = table.column($(this).attr("data-column"));

      // Toggle the visibility
      column.visible(!column.visible());
    });
  },

};
</script>
<style scoped>
.custome {
  font-size: 20px;
  padding-right: 5px;
  font-weight: bold;
}
.note {
  color: red;
}
</style>
