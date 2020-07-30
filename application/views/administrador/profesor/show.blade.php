@extends('blades/index')

@section('title', ' Listado de profesores')

@section('content')
<link rel="stylesheet" href="{{base_url()}}assets/components/plugins/datatables.net-bs4/css/dataTables.bootstrap4.css">
<link rel="stylesheet" href="{{base_url()}}assets/components/plugins/datatables.net-bs4/css/responsive.dataTables.min.css">
<div class="card">
    <div class="card-body">
        <h2 class="card-title text-center">Listado de profesores</h2>
        <h4 class="card-title text-center"><code>Edutek E-learning</code></h4>
        <div class="table-responsive m-t-40">
            <div id="table_principal" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="dataTables_length" id="myTable_length">
                            <label>Show
                                <select name="myTable_length" aria-controls="myTable" class="form-control form-control-sm" >
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                                entries
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div id="myTable_filter" class="dataTables_filter">
                            <label>
                                Search:<input type="search" class="form-control form-control-sm" placeholder="" aria-controls="myTable" />
                            </label>
                        </div>
                    </div>
                </div>
              <div class="row">
                <div class="col-sm-12">
                  <table
                    id="myTable"
                    class="table table-bordered table-striped dataTable no-footer"
                    role="grid"
                    aria-describedby="myTable_info"
                  >
                    <thead>
                      <tr role="row">
                        <th
                          class="sorting_asc"
                          tabindex="0"
                          aria-controls="myTable"
                          rowspan="1"
                          colspan="1"
                          aria-sort="ascending"
                          aria-label="Name: activate to sort column descending"
                          style="width: 128px;"
                        >
                          Name
                        </th>
                        <th
                          class="sorting"
                          tabindex="0"
                          aria-controls="myTable"
                          rowspan="1"
                          colspan="1"
                          aria-label="Position: activate to sort column ascending"
                          style="width: 216px;"
                        >
                          Position
                        </th>
                        <th
                          class="sorting"
                          tabindex="0"
                          aria-controls="myTable"
                          rowspan="1"
                          colspan="1"
                          aria-label="Office: activate to sort column ascending"
                          style="width: 92px;"
                        >
                          Office
                        </th>
                        <th
                          class="sorting"
                          tabindex="0"
                          aria-controls="myTable"
                          rowspan="1"
                          colspan="1"
                          aria-label="Age: activate to sort column ascending"
                          style="width: 32px;"
                        >
                          Age
                        </th>
                        <th
                          class="sorting"
                          tabindex="0"
                          aria-controls="myTable"
                          rowspan="1"
                          colspan="1"
                          aria-label="Start date: activate to sort column ascending"
                          style="width: 78px;"
                        >
                          Start date
                        </th>
                        <th
                          class="sorting"
                          tabindex="0"
                          aria-controls="myTable"
                          rowspan="1"
                          colspan="1"
                          aria-label="Salary: activate to sort column ascending"
                          style="width: 61px;"
                        >
                          Salary
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr role="row" class="odd">
                        <td class="sorting_1">Airi Satou</td>
                        <td>Accountant</td>
                        <td>Tokyo</td>
                        <td>33</td>
                        <td>2008/11/28</td>
                        <td>$162,700</td>
                      </tr>
                      <tr role="row" class="even">
                        <td class="sorting_1">Angelica Ramos</td>
                        <td>Chief Executive Officer (CEO)</td>
                        <td>London</td>
                        <td>47</td>
                        <td>2009/10/09</td>
                        <td>$1,200,000</td>
                      </tr>
                      <tr role="row" class="odd">
                        <td class="sorting_1">Ashton Cox</td>
                        <td>Junior Technical Author</td>
                        <td>San Francisco</td>
                        <td>66</td>
                        <td>2009/01/12</td>
                        <td>$86,000</td>
                      </tr>
                      <tr role="row" class="even">
                        <td class="sorting_1">Bradley Greer</td>
                        <td>Software Engineer</td>
                        <td>London</td>
                        <td>41</td>
                        <td>2012/10/13</td>
                        <td>$132,000</td>
                      </tr>
                      <tr role="row" class="odd">
                        <td class="sorting_1">Brenden Wagner</td>
                        <td>Software Engineer</td>
                        <td>San Francisco</td>
                        <td>28</td>
                        <td>2011/06/07</td>
                        <td>$206,850</td>
                      </tr>
                      <tr role="row" class="even">
                        <td class="sorting_1">Brielle Williamson</td>
                        <td>Integration Specialist</td>
                        <td>New York</td>
                        <td>61</td>
                        <td>2012/12/02</td>
                        <td>$372,000</td>
                      </tr>
                      <tr role="row" class="odd">
                        <td class="sorting_1">Bruno Nash</td>
                        <td>Software Engineer</td>
                        <td>London</td>
                        <td>38</td>
                        <td>2011/05/03</td>
                        <td>$163,500</td>
                      </tr>
                      <tr role="row" class="even">
                        <td class="sorting_1">Caesar Vance</td>
                        <td>Pre-Sales Support</td>
                        <td>New York</td>
                        <td>21</td>
                        <td>2011/12/12</td>
                        <td>$106,450</td>
                      </tr>
                      <tr role="row" class="odd">
                        <td class="sorting_1">Cara Stevens</td>
                        <td>Sales Assistant</td>
                        <td>New York</td>
                        <td>46</td>
                        <td>2011/12/06</td>
                        <td>$145,600</td>
                      </tr>
                      <tr role="row" class="even">
                        <td class="sorting_1">Cedric Kelly</td>
                        <td>Senior Javascript Developer</td>
                        <td>Edinburgh</td>
                        <td>22</td>
                        <td>2012/03/29</td>
                        <td>$433,060</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12 col-md-5">
                  <div
                    class="dataTables_info"
                    id="myTable_info"
                    role="status"
                    aria-live="polite"
                  >
                    Showing 1 to 10 of 57 entries
                  </div>
                </div>
                <div class="col-sm-12 col-md-7">
                  <div
                    class="dataTables_paginate paging_simple_numbers"
                    id="myTable_paginate"
                  >
                    <ul class="pagination">
                      <li
                        class="paginate_button page-item previous disabled"
                        id="myTable_previous"
                      >
                        <a
                          href="#"
                          aria-controls="myTable"
                          data-dt-idx="0"
                          tabindex="0"
                          class="page-link"
                          >Previous</a
                        >
                      </li>
                      <li class="paginate_button page-item active">
                        <a
                          href="#"
                          aria-controls="myTable"
                          data-dt-idx="1"
                          tabindex="0"
                          class="page-link"
                          >1</a
                        >
                      </li>
                      <li class="paginate_button page-item">
                        <a
                          href="#"
                          aria-controls="myTable"
                          data-dt-idx="2"
                          tabindex="0"
                          class="page-link"
                          >2</a
                        >
                      </li>
                      <li class="paginate_button page-item">
                        <a
                          href="#"
                          aria-controls="myTable"
                          data-dt-idx="3"
                          tabindex="0"
                          class="page-link"
                          >3</a
                        >
                      </li>
                      <li class="paginate_button page-item">
                        <a
                          href="#"
                          aria-controls="myTable"
                          data-dt-idx="4"
                          tabindex="0"
                          class="page-link"
                          >4</a
                        >
                      </li>
                      <li class="paginate_button page-item">
                        <a
                          href="#"
                          aria-controls="myTable"
                          data-dt-idx="5"
                          tabindex="0"
                          class="page-link"
                          >5</a
                        >
                      </li>
                      <li class="paginate_button page-item">
                        <a
                          href="#"
                          aria-controls="myTable"
                          data-dt-idx="6"
                          tabindex="0"
                          class="page-link"
                          >6</a
                        >
                      </li>
                      <li class="paginate_button page-item next" id="myTable_next">
                        <a
                          href="#"
                          aria-controls="myTable"
                          data-dt-idx="7"
                          tabindex="0"
                          class="page-link"
                          >Next</a
                        >
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
          



        <div class="table-responsive">
            <table class="table full-color-table full-inverse-table hover-table" id="table_principal">
                <thead>
                    <tr>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Email</th>
                        <th class="text-nowrap">Acciones</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($list as $item)
                    <tr>
                        <td>{{ $item->nombre_profesor}}</td>
                        <td>{{ $item->apellido_profesor }}</td>
                        <td>{{ $item->email_profesor }}</td>
                        <td class="text-nowrap">
                            <a href="{{ base_url() }}profesor/edit/{{ $item->id }}" data-toggle="tooltip" data-original-title="Editar datos" style="font-size:20px;"> <i class="mdi mdi-account-edit text-megna"></i></a> |
                            <a href="#" class="resetpassword" id="{{ $item->id }}" data-toggle="tooltip" data-original-title="Reset password"><i class="fas fa-sync-alt"></i></a> |
                            <a href="#" class="reenviarpassword" id="{{ $item->id }}" data-toggle="tooltip" data-original-title="Reenviar email"><i class="fas fa-reply-all text-warning"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="{{base_url()}}assets/components/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{base_url()}}assets/components/plugins/datatables.net-bs4/js/dataTables.responsive.min.js"></script>
<script>
    $(function () {
  $("#myTable").DataTable();
  $(function () {
    var table = $("#example").DataTable({
      columnDefs: [
        {
          visible: false,
          targets: 2,
        },
      ],
      order: [[2, "asc"]],
      displayLength: 25,
      drawCallback: function (settings) {
        var api = this.api();
        var rows = api
          .rows({
            page: "current",
          })
          .nodes();
        var last = null;
        api
          .column(2, {
            page: "current",
          })
          .data()
          .each(function (group, i) {
            if (last !== group) {
              $(rows)
                .eq(i)
                .before(
                  '<tr class="group"><td colspan="5">' + group + "</td></tr>"
                );
              last = group;
            }
          });
      },
    });
    // Order by the grouping
    $("#example tbody").on("click", "tr.group", function () {
      var currentOrder = table.order()[0];
      if (currentOrder[0] === 2 && currentOrder[1] === "asc") {
        table.order([2, "desc"]).draw();
      } else {
        table.order([2, "asc"]).draw();
      }
    });
  });
});
$("#example23").DataTable({
  dom: "Bfrtip",
  buttons: ["copy", "csv", "excel", "pdf", "print"],
});
$("#config-table").DataTable({
  responsive: true,
});

</script>
<script type="text/javascript">
    var BASE_URL = "<?php echo base_url(); ?>";
    $(document).ready(function() {
        $('.resetpassword').click(function(e) {
            Swal.fire({
                title: '¿Restablecer password?',
                text: "Se establece el password al valor por defecto: 12345678",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: '¡Sí, restablecer!',
                confirmButtonClass: 'btn bg-megna text-white',
                cancelButtonClass: 'btn btn-inverse',
                cancelButtonText: 'Cancelar',
                buttonsStyling: false,
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: 'POST',
                        url: BASE_URL + 'profesor/reset',
                        data: {
                            'id': e.currentTarget.id
                        },
                        dataType: 'html',
                        success: function(data) {
                            if (data >= 1) {
                                Swal.fire({
                                    title: '¡Proceso completado!',
                                    text: 'Se ha completado el registro y se envío un correo con usuario y password para el ingreso a la plataforma',
                                    type: 'success'
                                });
                                //location.reload();
                            } else {
                                Swal.fire({
                                    title: 'Oops...',
                                    text: '¡Algo salió mal!, verifica que los datos esten ingresados',
                                    type: 'error'
                                });
                            }
                        }
                    });

                }
            })
        });
        $('.reenviarpassword').click(function(e) {
            Swal.fire({
                title: 'Reenviar password',
                text: "¿Deseas envíar el password de la cuenta por email?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: '¡Sí, evníar!',
                confirmButtonClass: 'btn bg-megna text-white',
                cancelButtonClass: 'btn btn-inverse',
                cancelButtonText: 'Cancelar',
                buttonsStyling: false,
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: 'POST',
                        url: BASE_URL + 'profesor/reenviar',
                        data: {
                            'id': e.currentTarget.id
                        },
                        dataType: 'html',
                        success: function(data) {
                            if (data == 1) {
                                Swal.fire({
                                    title: '¡Proceso completado!',
                                    text: 'Se ha completado el registro y se envío un correo con usuario y password para el ingreso a la plataforma',
                                    type: 'success'
                                });
                                //location.reload();
                            } else {
                                Swal.fire({
                                    title: 'Oops...',
                                    text: '¡Algo salió mal!, verifica que los datos esten ingresados',
                                    type: 'error'
                                });
                            }
                        }
                    });

                }
            })
        });
    });
</script>
@endsection