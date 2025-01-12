@extends('manager.layout')
@section('page_title','Manager Panel')
@section('mealsheet','active')
@section('content')

<div class="row mt-3 mb-0 mx-2 ">
    <div class="col-sm-3 my-2">
        <h5 class="mt-0">Meal Info : {{$data->cur_year}} - {{$data->cur_month}} - {{$data->cur_section}} </h5>
        <a href="https://youtu.be/OsLo20KXg8o?t=775" target="_blank">  Tutorial</a>
    </div>

    <div class="col-sm-1 my-2">
        <form action="{{url('pdf/meal_chart')}}" method="POST" enctype="multipart/form-data">
            {!! csrf_field() !!}
            <div class="d-grid gap-3 d-flex justify-content-end">
                <select class="form-control sm" name="section" id="section" aria-label="Default select example" required>
                    <option value="">Select Section </option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                </select>
            </div>
    </div>

    <div class="col-sm-2 my-2">
        <div class="d-grid gap-3 d-flex justify-content-end">
            <input type="month" name="month" class="form-control" value="" required>
        </div>
    </div>

    <div class="col-sm-2 my-2">
        <div class="d-grid gap-3 d-flex justify-content-start">
            <button type="submit" name="search" class="btn btn-primary">Monthly Meal Sheet </button>
        </div>
    </div>

    @if(manager_info()['role']=='admin')
    <div class="col-sm-2 my-2">
        <div class="d-grid gap-3 d-flex justify-content-start">
            <a   class="btn btn-info"  onclick="return confirm('Are you sure you want to Meal On Using Previous  month Last meal On?')" 
					     href="{{url('/manager/mealon_update')}}"> Meal On using Last Meal On</a> 
        </div>
    </div>

     <div class="col-sm-2 my-2">
         <div class="d-grid gap-3 d-flex justify-content-start">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEmployeeModalday">Day Wise Meal Update</button>
         </div>
     </div>

       @endif

    </form>


</div>



<div class="row mt-3 mb-0 mx-2 shadow p-2">
    <div class="col-sm-2 my-2">
        <form action="{{url('pdf/daily_sheet')}}" method="POST" enctype="multipart/form-data">
            <input type="month" name="month" class="form-control" value="{{ date('Y-n',strtotime($data->cur_date)) }}" required>
    </div>

    <div class="col-sm-1 my-2">
        {!! csrf_field() !!}
        <div class="d-grid gap-3 d-flex justify-content-end">
            <select class="form-control" name="status" id="status" aria-label="Default select example" required>
                <option value="1">ON</option>
                <option value="0">OFF</option>
            </select>
        </div>
    </div>

    <div class="col-sm-1 my-2">
        <div class="d-grid gap-3 d-flex justify-content-end">
            <select class="form-control" name="section" id="section" aria-label="Default select example" required>
                @if($data->cur_section=="A")
                   <option value="A" selected >A</option>
                   <option value="B">B</option>
                 @else
                    <option value="A">A</option>
                    <option value="B" selected>B</option>
                 @endif
            </select>
        </div>
    </div>

    <div class="col-sm-2 my-2">
        <div class="d-grid gap-3 d-flex justify-content-end">
            <select class="form-control" name="type" id="type" aria-label="Default select example" required>
                <option value="">Select Type </option>
                <option value="b">Breakfast</option>
                <option value="l">Lunch</option>
                <option value="d">Dinner</option>
            </select>
        </div>
    </div>

    <div class="col-sm-2 my-2">
        <div class="d-grid gap-3 d-flex justify-content-end">
            <select class="form-control" name="page_type" id="page_type" aria-label="Default select example" required>
                <option value="cardName">Card with Name</option>
                <option value="card">Only Card </option>
            </select>
        </div>
    </div>


    <div class="col-sm-2 my-2">
        <input type="date" name="milloff_date" class="form-control" value="" required>
    </div>

    <div class="col-sm-2 my-2">
        <div class="d-grid gap-3 d-flex justify-content-start">
            <button type="submit" name="search" class="btn btn-primary">Daily Meal Sheet </button>
        </div>
    </div>
    </form>



    @if(Session::has('success'))
          <div class="alert alert-success"> {{Session::get('success')}}</div>
    @endif

    @if(Session::has('fail'))
         <div class="alert alert-danger"> {{Session::get('fail')}}</div>
    @endif

</div>




<div class="row p-2">
    <div class="col-md-9">
        <div id="success_message"></div>
        @if(session('status'))
        <h5 class="alert alert-success">{{ session('status')}} </h5>
        @endif
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <input type="text" name="search" id="search" placeholder="Enter Search " class="form-control form-control-sm" autocomplete="off" />
        </div>
    </div>
</div>


<div class="table-responsive">
    <div class="x_content">
        <table id="employee_data" class="table table-bordered table-hover">
            <thead>
                <tr style="background:whitesmoke;">
                    <th width="8%" class="sorting" data-sorting_type="asc" data-column_name="card_id" style="cursor: pointer">
                        <span id="card_id_icon"><i class="fas fa-sort-amount-up-alt"></i></span> Card
                    </th>
                    <th width="15%"> Registration/ Seat No</th>
                    <th width="15%"> Pre section last meal</th>
                    <th width="15%"> Pre section Meeting Status </th>
                    <th width="15%" colspan="3"><span class="dotvalue"> </span>Meal1 {{ $data->date1 }}</th>
                    <th width="15%" colspan="3"><span class="dotvalue"> </span>Meal2 {{ $data->date2 }} </th>
                    <th width="15%" colspan="3"><span class="dotvalue"> </span>Meal3 {{ $data->date3 }} </th>
                    <th width="15%" colspan="3"><span class="dotvalue"> </span>Meal4 {{ $data->date4 }}</th>
                    <th width="15%" colspan="3"><span class="dotvalue"> </span>Meal5 {{ $data->date5 }} </th>
                    <th width="15%"><span class="dotvalue"> </span> Edit</th>
                    <th width="15%" colspan="3"><span class="dotvalue"> </span>Meal6 {{ $data->date6 }} </th>
                    <th width="15%" colspan="3"><span class="dotvalue"> </span>Meal7 {{ $data->date7 }}</th>
                    <th width="15%" colspan="3"><span class="dotvalue"> </span>Meal8 {{ $data->date8 }} </th>
                    <th width="15%" colspan="3"><span class="dotvalue"> </span>Meal9 {{ $data->date9 }} </th>
                    <th width="15%" colspan="3"><span class="dotvalue"> </span>Meal10 {{ $data->date10 }} </th>
                    <th width="15%" colspan="3"><span class="dotvalue"> </span>Meal11 {{ $data->date11 }}</th>
                    <th width="15%" colspan="3"><span class="dotvalue"> </span>Meal12 {{ $data->date12 }} </th>
                    <th width="15%" colspan="3"><span class="dotvalue"> </span>Meal13 {{ $data->date13 }} </th>
                    <th width="15%" colspan="3"><span class="dotvalue"> </span>Meal14 {{ $data->date14 }}</th>
                    <th width="15%" colspan="3"><span class="dotvalue"> </span>Meal15 {{ $data->date15 }} </th>
                    <th width="15%" colspan="3"><span class="dotvalue"> </span>Meal16 {{ $data->date16 }} </th>
                    <th width="15%" colspan="3"><span class="dotvalue"> </span>Meal17 {{ $data->date17 }}</th>
                    <th width="15%" colspan="3"><span class="dotvalue"> </span>Meal18 {{ $data->date18 }} </th>
                    <th width="15%" colspan="3"><span class="dotvalue"> </span>Meal19 {{ $data->date19 }} </th>
                    <th width="15%" colspan="3"><span class="dotvalue"> </span>Meal20 {{ $data->date20 }} </th>
                    <th width="15%" colspan="3"><span class="dotvalue"> </span>Meal21 {{ $data->date21 }}</th>
                    <th width="15%" colspan="3"><span class="dotvalue"> </span>Meal22 {{ $data->date22 }} </th>
                    <th width="15%" colspan="3"><span class="dotvalue"> </span>Meal23 {{ $data->date23 }} </th>
                    <th width="15%" colspan="3"><span class="dotvalue"> </span>Meal24 {{ $data->date24 }}</th>
                    <th width="15%" colspan="3"><span class="dotvalue"> </span>Meal25 {{ $data->date25 }} </th>
                    <th width="15%" colspan="3"><span class="dotvalue"> </span>Meal26 {{ $data->date26 }} </th>
                    <th width="15%" colspan="3"><span class="dotvalue"> </span>Meal27 {{ $data->date27 }}</th>
                    <th width="15%" colspan="3"><span class="dotvalue"> </span>Meal28 {{ $data->date28 }} </th>
                    <th width="15%" colspan="3"><span class="dotvalue"> </span>Meal29 {{ $data->date29 }} </th>
                    <th width="15%" colspan="3"><span class="dotvalue"> </span>Meal30 {{ $data->date30 }} </th>
                    <th width="15%" colspan="3"><span class="dotvalue"> </span>Meal31 {{ $data->date31 }} </th>

                    <th width="15%"><span class="dotvalue"> </span> Feast Day</th>
                    <th width="15%"><span class="dotvalue"> </span> Meeting Present </th>
                 
                </tr>
                <tr style="background:whitesmoke;">

                    <th width="15%"> </th>
                    <th width="15%"> </th>
                    <th width="15%"> </th>
                    <th width="15%"> </th>
                    <th width="15%"><span class="dotvalue"> </span> B </th>
                    <th width="15%"><span class="dotvalue"> </span> L </th>
                    <th width="15%"><span class="dotvalue"> </span> D </th>

                    <th width="15%"><span class="dotvalue"> </span> B </th>
                    <th width="15%"><span class="dotvalue"> </span> L </th>
                    <th width="15%"><span class="dotvalue"> </span> D </th>

                    <th width="15%"><span class="dotvalue"> </span> B </th>
                    <th width="15%"><span class="dotvalue"> </span> L </th>
                    <th width="15%"><span class="dotvalue"> </span> D </th>

                    <th width="15%"><span class="dotvalue"> </span> B </th>
                    <th width="15%"><span class="dotvalue"> </span> L </th>
                    <th width="15%"><span class="dotvalue"> </span> D </th>

                    <th width="15%"><span class="dotvalue"> </span> B </th>
                    <th width="15%"><span class="dotvalue"> </span> L </th>
                    <th width="15%"><span class="dotvalue"> </span> D </th>

                    <th width="15%"><span class="dotvalue"> </span> </th>


                    <th width="15%"><span class="dotvalue"> </span> B </th>
                    <th width="15%"><span class="dotvalue"> </span> L </th>
                    <th width="15%"><span class="dotvalue"> </span> D </th>

                    <th width="15%"><span class="dotvalue"> </span> B </th>
                    <th width="15%"><span class="dotvalue"> </span> L </th>
                    <th width="15%"><span class="dotvalue"> </span> D </th>

                    <th width="15%"><span class="dotvalue"> </span> B </th>
                    <th width="15%"><span class="dotvalue"> </span> L </th>
                    <th width="15%"><span class="dotvalue"> </span> D </th>

                    <th width="15%"><span class="dotvalue"> </span> B </th>
                    <th width="15%"><span class="dotvalue"> </span> L </th>
                    <th width="15%"><span class="dotvalue"> </span> D </th>

                    <th width="15%"><span class="dotvalue"> </span> B </th>
                    <th width="15%"><span class="dotvalue"> </span> L </th>
                    <th width="15%"><span class="dotvalue"> </span> D </th>

                    <th width="15%"><span class="dotvalue"> </span> B </th>
                    <th width="15%"><span class="dotvalue"> </span> L </th>
                    <th width="15%"><span class="dotvalue"> </span> D </th>

                    <th width="15%"><span class="dotvalue"> </span> B </th>
                    <th width="15%"><span class="dotvalue"> </span> L </th>
                    <th width="15%"><span class="dotvalue"> </span> D </th>

                    <th width="15%"><span class="dotvalue"> </span> B </th>
                    <th width="15%"><span class="dotvalue"> </span> L </th>
                    <th width="15%"><span class="dotvalue"> </span> D </th>

                    <th width="15%"><span class="dotvalue"> </span> B </th>
                    <th width="15%"><span class="dotvalue"> </span> L </th>
                    <th width="15%"><span class="dotvalue"> </span> D </th>

                    <th width="15%"><span class="dotvalue"> </span> B </th>
                    <th width="15%"><span class="dotvalue"> </span> L </th>
                    <th width="15%"><span class="dotvalue"> </span> D </th>

                    <th width="15%"><span class="dotvalue"> </span> B </th>
                    <th width="15%"><span class="dotvalue"> </span> L </th>
                    <th width="15%"><span class="dotvalue"> </span> D </th>

                    <th width="15%"><span class="dotvalue"> </span> B </th>
                    <th width="15%"><span class="dotvalue"> </span> L </th>
                    <th width="15%"><span class="dotvalue"> </span> D </th>

                    <th width="15%"><span class="dotvalue"> </span> B </th>
                    <th width="15%"><span class="dotvalue"> </span> L </th>
                    <th width="15%"><span class="dotvalue"> </span> D </th>

                    <th width="15%"><span class="dotvalue"> </span> B </th>
                    <th width="15%"><span class="dotvalue"> </span> L </th>
                    <th width="15%"><span class="dotvalue"> </span> D </th>

                    <th width="15%"><span class="dotvalue"> </span> B </th>
                    <th width="15%"><span class="dotvalue"> </span> L </th>
                    <th width="15%"><span class="dotvalue"> </span> D </th>

                    <th width="15%"><span class="dotvalue"> </span> B </th>
                    <th width="15%"><span class="dotvalue"> </span> L </th>
                    <th width="15%"><span class="dotvalue"> </span> D </th>

                    <th width="15%"><span class="dotvalue"> </span> B </th>
                    <th width="15%"><span class="dotvalue"> </span> L </th>
                    <th width="15%"><span class="dotvalue"> </span> D </th>


                    <th width="15%"><span class="dotvalue"> </span> B </th>
                    <th width="15%"><span class="dotvalue"> </span> L </th>
                    <th width="15%"><span class="dotvalue"> </span> D </th>

                    <th width="15%"><span class="dotvalue"> </span> B </th>
                    <th width="15%"><span class="dotvalue"> </span> L </th>
                    <th width="15%"><span class="dotvalue"> </span> D </th>


                    <th width="15%"><span class="dotvalue"> </span> B </th>
                    <th width="15%"><span class="dotvalue"> </span> L </th>
                    <th width="15%"><span class="dotvalue"> </span> D </th>


                    <th width="15%"><span class="dotvalue"> </span> B </th>
                    <th width="15%"><span class="dotvalue"> </span> L </th>
                    <th width="15%"><span class="dotvalue"> </span> D </th>


                    <th width="15%"><span class="dotvalue"> </span> B </th>
                    <th width="15%"><span class="dotvalue"> </span> L </th>
                    <th width="15%"><span class="dotvalue"> </span> D </th>


                    <th width="15%"><span class="dotvalue"> </span> B </th>
                    <th width="15%"><span class="dotvalue"> </span> L </th>
                    <th width="15%"><span class="dotvalue"> </span> D </th>


                    <th width="15%"><span class="dotvalue"> </span> B </th>
                    <th width="15%"><span class="dotvalue"> </span> L </th>
                    <th width="15%"><span class="dotvalue"> </span> D </th>

                    <th width="15%"><span class="dotvalue"> </span> B </th>
                    <th width="15%"><span class="dotvalue"> </span> L </th>
                    <th width="15%"><span class="dotvalue"> </span> D </th>


                    <th width="15%"><span class="dotvalue"> </span> B </th>
                    <th width="15%"><span class="dotvalue"> </span> L </th>
                    <th width="15%"><span class="dotvalue"> </span> D </th>

                    <th width="15%"><span class="dotvalue"> </span> Feast Day</th>
                    <th width="15%"><span class="dotvalue"> </span> Meeting Present</th>
                   

                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
        <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
        <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="registration" />
        <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />

    </div>
</div>




<script>
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        fetch();

        function fetch() {
            $.ajax({
                type: 'GET',
                url: '/manager/mealsheet_fetch',
                datType: 'json',
                success: function(response) {
                    $('tbody').html('');
                    $('.x_content tbody').html(response);
                }
            });
        }






        function fetch_data(page, sort_type = "", sort_by = "", search = "") {
            $.ajax({
                url: "/manager/mealsheet/fetch_data?page=" + page + "&sortby=" + sort_by + "&sorttype=" + sort_type + "&search=" + search,
                success: function(data) {
                    $('tbody').html('');
                    $('.x_content tbody').html(data);
                }
            });
        }


        $(document).on('keyup', '#search', function() {
             var search = $('#search').val();
             var column_name = $('#hidden_column_name').val();
             var sort_type = $('#hidden_sort_type').val();
             var page = $('#hidden_page').val();
             fetch_data(page, sort_type, column_name, search);
        });


        $(document).on('click', '.pagin_link a', function(event) {
            event.preventDefault();
              var page = $(this).attr('href').split('page=')[1];
              var column_name = $('#hidden_column_name').val();
              var sort_type = $('#hidden_sort_type').val();
              var search = $('#search').val();
              fetch_data(page, sort_type, column_name, search);
        });


        $(document).on('click', '.sorting', function() {
            var column_name = $(this).data('column_name');
            var order_type = $(this).data('sorting_type');
            var reverse_order = '';
            if (order_type == 'asc') {
                $(this).data('sorting_type', 'desc');
                reverse_order = 'desc';
                $('#' + column_name + '_icon').html('<i class="fas fa-sort-amount-down"></i>');
            } else {
                $(this).data('sorting_type', 'asc');
                reverse_order = 'asc';
                $('#' + column_name + '_icon').html('<i class="fas fa-sort-amount-up-alt"></i>');
            }
            $('#hidden_column_name').val(column_name);
            $('#hidden_sort_type').val(reverse_order);
            var page = $('#hidden_page').val();
            var search = $('#search').val();
            fetch_data(page, reverse_order, column_name, search);
        });





        $(document).on('click', '.edit', function(e) {
            e.preventDefault();
            var view_id = $(this).val();
            //alert(edit_id)
            $('#EditModal').modal('show');
            $.ajax({
                type: 'GET',
                url: '/manager/mealsheet_view/' + view_id,
                success: function(response) {
                    console.log(response);
                    if (response.status == 404) {
                        $('#success_message').html("");
                        $('#success_message').addClass('alert alert-danger');
                        $('#success_message').text(response.message);
                    } else {
                        $('#id').val(response.value.id);
                        $('#card').val(response.value.card);
                        $('#registration').val(response.value.registration);

                        $('#b1').val(response.value.b1);
                        $('#b2').val(response.value.b2);
                        $('#b3').val(response.value.b3);
                        $('#b4').val(response.value.b4);
                        $('#b5').val(response.value.b5);
                        $('#b6').val(response.value.b6);
                        $('#b7').val(response.value.b7);
                        $('#b8').val(response.value.b8);
                        $('#b9').val(response.value.b9);
                        $('#b10').val(response.value.b10);
                        $('#b11').val(response.value.b11);
                        $('#b12').val(response.value.b12);
                        $('#b13').val(response.value.b13);
                        $('#b14').val(response.value.b14);
                        $('#b15').val(response.value.b15);
                        $('#b16').val(response.value.b16);
                        $('#b17').val(response.value.b17);
                        $('#b18').val(response.value.b18);
                        $('#b19').val(response.value.b19);
                        $('#b20').val(response.value.b20);
                        $('#b21').val(response.value.b21);
                        $('#b22').val(response.value.b22);
                        $('#b23').val(response.value.b23);
                        $('#b24').val(response.value.b24);
                        $('#b25').val(response.value.b25);
                        $('#b26').val(response.value.b26);
                        $('#b27').val(response.value.b27);
                        $('#b28').val(response.value.b28);
                        $('#b29').val(response.value.b29);
                        $('#b30').val(response.value.b30);
                        $('#b31').val(response.value.b31);

                        $('#l1').val(response.value.l1);
                        $('#l2').val(response.value.l2);
                        $('#l3').val(response.value.l3);
                        $('#l4').val(response.value.l4);
                        $('#l5').val(response.value.l5);
                        $('#l6').val(response.value.l6);
                        $('#l7').val(response.value.l7);
                        $('#l8').val(response.value.l8);
                        $('#l9').val(response.value.l9);
                        $('#l10').val(response.value.l10);
                        $('#l11').val(response.value.l11);
                        $('#l12').val(response.value.l12);
                        $('#l13').val(response.value.l13);
                        $('#l14').val(response.value.l14);
                        $('#l15').val(response.value.l15);
                        $('#l16').val(response.value.l16);
                        $('#l17').val(response.value.l17);
                        $('#l18').val(response.value.l18);
                        $('#l19').val(response.value.l19);
                        $('#l20').val(response.value.l20);
                        $('#l21').val(response.value.l21);
                        $('#l22').val(response.value.l22);
                        $('#l23').val(response.value.l23);
                        $('#l24').val(response.value.l24);
                        $('#l25').val(response.value.l25);
                        $('#l26').val(response.value.l26);
                        $('#l27').val(response.value.l27);
                        $('#l28').val(response.value.l28);
                        $('#l29').val(response.value.l29);
                        $('#l30').val(response.value.l30);
                        $('#l31').val(response.value.l31);

                        $('#d1').val(response.value.d1);
                        $('#d2').val(response.value.d2);
                        $('#d3').val(response.value.d3);
                        $('#d4').val(response.value.d4);
                        $('#d5').val(response.value.d5);
                        $('#d6').val(response.value.d6);
                        $('#d7').val(response.value.d7);
                        $('#d8').val(response.value.d8);
                        $('#d9').val(response.value.d9);
                        $('#d10').val(response.value.d10);
                        $('#d11').val(response.value.d11);
                        $('#d12').val(response.value.d12);
                        $('#d13').val(response.value.d13);
                        $('#d14').val(response.value.d14);
                        $('#d15').val(response.value.d15);
                        $('#d16').val(response.value.d16);
                        $('#d17').val(response.value.d17);
                        $('#d18').val(response.value.d18);
                        $('#d19').val(response.value.d19);
                        $('#d20').val(response.value.d20);
                        $('#d21').val(response.value.d21);
                        $('#d22').val(response.value.d22);
                        $('#d23').val(response.value.d23);
                        $('#d24').val(response.value.d24);
                        $('#d25').val(response.value.d25);
                        $('#d26').val(response.value.d26);
                        $('#d27').val(response.value.d27);
                        $('#d28').val(response.value.d28);
                        $('#d29').val(response.value.d29);
                        $('#d30').val(response.value.d30);
                        $('#d31').val(response.value.d31);

                        $('#date1').val(response.value.date1);
                        $('#date2').val(response.value.date2);
                        $('#date3').val(response.value.date3);
                        $('#date4').val(response.value.date4);
                        $('#date5').val(response.value.date5);
                        $('#date6').val(response.value.date6);
                        $('#date7').val(response.value.date7);
                        $('#date8').val(response.value.date8);
                        $('#date9').val(response.value.date9);
                        $('#date10').val(response.value.date10);
                        $('#date11').val(response.value.date11);
                        $('#date12').val(response.value.date12);
                        $('#date13').val(response.value.date13);
                        $('#date14').val(response.value.date14);
                        $('#date15').val(response.value.date15);
                        $('#date16').val(response.value.date16);
                        $('#date17').val(response.value.date17);
                        $('#date18').val(response.value.date18);
                        $('#date19').val(response.value.date19);
                        $('#date20').val(response.value.date20);
                        $('#date21').val(response.value.date21);
                        $('#date22').val(response.value.date22);
                        $('#date23').val(response.value.date23);
                        $('#date24').val(response.value.date24);
                        $('#date25').val(response.value.date25);
                        $('#date26').val(response.value.date26);
                        $('#date27').val(response.value.date27);
                        $('#date28').val(response.value.date28);
                        $('#date29').val(response.value.date29);
                        $('#date30').val(response.value.date30);
                        $('#date31').val(response.value.date31);

                        $('#dayfeast').val(response.value.dayfeast);
                        $('#pre_meeting_present').val(response.value.pre_meeting_present);
                        $('#meeting_present').val(response.value.meeting_present);

                    }
                }
            });
        });


        $(document).on('submit','#edit_form', function(e) {
            e.preventDefault();

            var edit_id = $('#edit_id').val();
            let editData = new FormData($('#edit_form')[0]);
            $.ajax({
                type: 'POST',
                url: '/manager/mealupdate',
                data: editData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('.loader').show();
                },
                success: function(response) {
                    console.log(response);
                    if (response.status == 400) {
                        $('.edit_err_dureg').text(response.validate_err.dureg);
                        $('.edit_err_email').text(response.validate_err.email);
                        $('.edit_err_phone').text(response.validate_err.phone);
                    } else {
                        $('#edit_form_errlist').html("");
                        $('#edit_form_errlist').addClass('d-none');
                        $('#success_message').html("");
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message)
                        $('#EditModal').modal('hide');
                        $('.edit_err_dureg').text("");
                        $('.edit_err_email').text("");
                        $('.edit_err_phone').text("");
                        fetch();
                    }
                    $('.loader').hide();
                }
            });
        });





    });
</script>

{{-- edit employee modal start --}}
<div class="modal fade" id="EditModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="edit_form" enctype="multipart/form-data">
                <div class="modal-body p-4 bg-light">

                    <div class="row p-2">
                        <input type="hidden" name="id" id="id" value="">
                        <div class="col-sm-3">Card No</div>
                        <div class="col-sm-3"><input type="text" name="card" id="card" class="form-control" value="" readonly /></div>
                        <div class="col-sm-3">Reg/Seat No</div>
                        <div class="col-sm-3"><input type="text" name="registration" id="registration" class="form-control" value="" readonly /></div>
                    </div>


                    <div class="row p-2">
                         <div class="col-sm-3">Date </div>
                         <div class="col-sm-3">Breakfast </div>
                         <div class="col-sm-3">Lunch </div>
                         <div class="col-sm-3">Dinner </div>
                    </div>


                    <div class="row p-2">
                        <div class="col-sm-3"><input type="date" id="date1" class="form-control" value="" readonly /></div>
                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="b1" name="b1" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="l1" name="l1" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="d1" name="d1" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>
                    </div>


                    <div class="row p-2">
                        <div class="col-sm-3"><input type="date" id="date2" class="form-control" value="" readonly /></div>
                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="b2" name="b2" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="l2" name="l2" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="d2" name="d2" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>
                    </div>



                    <div class="row p-2">
                        <div class="col-sm-3"><input type="date" id="date3" class="form-control" value="" readonly /></div>
                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="b3" name="b3" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="l3" name="l3" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="d3" name="d3" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>
                    </div>




                    <div class="row p-2">
                        <div class="col-sm-3"><input type="date" id="date4" class="form-control" value="" readonly /></div>
                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="b4" name="b4" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="l4" name="l4" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="d4" name="d4" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>
                    </div>





                    <div class="row p-2">
                        <div class="col-sm-3"><input type="date" id="date5" class="form-control" value="" readonly /></div>
                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="b5" name="b5" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="l5" name="l5" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="d5" name="d5" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>
                    </div>



                    <div class="row p-2">
                        <div class="col-sm-3"><input type="date" id="date6" class="form-control" value="" readonly /></div>
                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="b6" name="b6" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="l6" name="l6" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="d6" name="d6" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>
                    </div>



                    <div class="row p-2">
                        <div class="col-sm-3"><input type="date" id="date7" class="form-control" value="" readonly /></div>
                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="b7" name="b7" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="l7" name="l7" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="d7" name="d7" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>
                    </div>



                    <div class="row p-2">
                        <div class="col-sm-3"><input type="date" id="date8" class="form-control" value="" readonly /></div>
                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="b8" name="b8" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="l8" name="l8" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="d8" name="d8" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>
                    </div>



                    <div class="row p-2">
                        <div class="col-sm-3"><input type="date" id="date9" class="form-control" value="" readonly /></div>
                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="b9" name="b9" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="l9" name="l9" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="d9" name="d9" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>
                    </div>



                    <div class="row p-2">
                        <div class="col-sm-3"><input type="date" id="date10" class="form-control" value="" readonly /></div>
                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="b10" name="b10" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="l10" name="l10" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="d10" name="d10" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>
                    </div>



                    <div class="row p-2">
                        <div class="col-sm-3"><input type="date" id="date11" class="form-control" value="" readonly /></div>
                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="b11" name="b11" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="l11" name="l11" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="d11" name="d11" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>
                    </div>



                    <div class="row p-2">
                        <div class="col-sm-3"><input type="date" id="date12" class="form-control" value="" readonly /></div>
                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="b12" name="b12" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="l12" name="l12" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="d12" name="d12" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>
                    </div>



                    <div class="row p-2">
                        <div class="col-sm-3"><input type="date" id="date13" class="form-control" value="" readonly /></div>
                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="b1" name="b13" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="l13" name="l13" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="d13" name="d13" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>
                    </div>



                    <div class="row p-2">
                        <div class="col-sm-3"><input type="date" id="date14" class="form-control" value="" readonly /></div>
                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="b14" name="b14" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="l14" name="l14" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="d14" name="d14" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>
                    </div>



                    <div class="row p-2">
                        <div class="col-sm-3"><input type="date" id="date15" class="form-control" value="" readonly /></div>
                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="b15" name="b15" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="l15" name="l15" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="d15" name="d15" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>
                    </div>



                    <div class="row p-2">
                        <div class="col-sm-3"><input type="date" id="date16" class="form-control" value="" readonly /></div>
                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="b16" name="b16" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="l16" name="l16" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="d16" name="d16" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>
                    </div>



                    <div class="row p-2">
                        <div class="col-sm-3"><input type="date" id="date17" class="form-control" value="" readonly /></div>
                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="b17" name="b17" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="l17" name="l17" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="d17" name="d17" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>
                    </div>



                    <div class="row p-2">
                        <div class="col-sm-3"><input type="date" id="date18" class="form-control" value="" readonly /></div>
                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="b18" name="b18" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="l18" name="l18" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="d18" name="d18" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>
                    </div>




                    <div class="row p-2">
                        <div class="col-sm-3"><input type="date" id="date19" class="form-control" value="" readonly /></div>
                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="b19" name="b19" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="l19" name="l19" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="d19" name="d19" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>
                    </div>




                    <div class="row p-2">
                        <div class="col-sm-3"><input type="date" id="date20" class="form-control" value="" readonly /></div>
                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="b20" name="b20" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="l20" name="l20" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="d20" name="d20" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>
                    </div>



                    <div class="row p-2">
                        <div class="col-sm-3"><input type="date" id="date21" class="form-control" value="" readonly /></div>
                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="b21" name="b21" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="l21" name="l21" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="d21" name="d21" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>
                    </div>




                    <div class="row p-2">
                        <div class="col-sm-3"><input type="date" id="date22" class="form-control" value="" readonly /></div>
                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="b22" name="b22" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="l22" name="l22" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="d22" name="d22" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>
                    </div>



                    <div class="row p-2">
                        <div class="col-sm-3"><input type="date" id="date23" class="form-control" value="" readonly /></div>
                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="b23" name="b23" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="l23" name="l23" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="d23" name="d23" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>
                    </div>



                    <div class="row p-2">
                        <div class="col-sm-3"><input type="date" id="date24" class="form-control" value="" readonly /></div>
                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="b24" name="b24" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="l24" name="l24" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="d24" name="d24" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>
                    </div>




                    <div class="row p-2">
                        <div class="col-sm-3"><input type="date" id="date25" class="form-control" value="" readonly /></div>
                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="b25" name="b25" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="l25" name="l25" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="d25" name="d25" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>
                    </div>




                    <div class="row p-2">
                        <div class="col-sm-3"><input type="date" id="date26" class="form-control" value="" readonly /></div>
                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="b26" name="b26" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="l26" name="l26" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="d26" name="d26" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>
                    </div>



                    <div class="row p-2">
                        <div class="col-sm-3"><input type="date" id="date27" class="form-control" value="" readonly /></div>
                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="b27" name="b27" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="l27" name="l27" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="d27" name="d27" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>
                    </div>



                    <div class="row p-2">
                        <div class="col-sm-3"><input type="date" id="date28" class="form-control" value="" readonly /></div>
                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="b28" name="b28" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="l28" name="l28" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="d28" name="d28" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>
                    </div>




                    <div class="row p-2">
                        <div class="col-sm-3"><input type="date" id="date29" class="form-control" value="" readonly /></div>
                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="b29" name="b29" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="l29" name="l29" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="d29" name="d29" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>
                    </div>




                    <div class="row p-2">
                        <div class="col-sm-3"><input type="date" id="date30" class="form-control" value="" readonly /></div>
                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="b30" name="b30" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="l30" name="l30" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="d30" name="d30" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>
                    </div>



                 <div class="row p-2">
                        <div class="col-sm-3"><input type="date" id="date31" class="form-control" value="" readonly /></div>
                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="b31" name="b31" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="l31" name="l31" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="d31" name="d31" aria-label="Default select example" required>
                                <option value="1">On</option>
                                <option value="0">Off</option>
                                <option value="9">Inactive</option>
                            </select>
                        </div>

                 </div>


                 <div class="row p-2">                       
                        <div class="col-sm-3">Pre Meeting Present</div>
                        <div class="col-sm-3">
                            <select class="form-control mb-2" id="pre_meeting_present" name="pre_meeting_present" aria-label="Default select example" required>
                                <option value="0">Presence</option>
                                <option value="1">Absence</option>
                            </select>
                        </div>

                       <div class="col-sm-3">Meeting Present</div>
                       <div class="col-sm-3">
                            <select class="form-control mb-2" id="meeting_present" name="meeting_present" aria-label="Default select example" required>
                               <option value="0">Presence</option>
                               <option value="1">Absence</option>   
                            </select>
                       </div>
                   </div>

                    <br>
                    <input type="submit" id="insert" value="Submit" class="btn btn-success" />
                    <div class="loader">
                        <img src="/images/abc.gif" alt="" style="width: 50px;height:50px;">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                </div>
            </form>
        </div>
    </div>
</div>
{{-- edit employee modal end --}}




{{-- add new Student modal start --}}
<div class="modal fade" id="addEmployeeModalday" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Column Wise Meal Update</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" action="{{url('/manager/daywise_mealupdate')}}"  class="myform"  enctype="multipart/form-data" >
           {!! csrf_field() !!}

        <div class="modal-body p-4 bg-light">
          <ul class="alert alert-warning d-none" id="add_form_errlist"></ul>

               <label><b> Meal No</b></label><br>
               <input type="number" name="day" min="1"  max="31" class="form-control" required><br>

               <label><b>Meal Type  </b></label><br>
	             <select name ="meal_type" class="form-control" required>
				           <option   value="">Select one</option>
					       <option   value="b">Breakfast</option>	
                           <option   value="l">Lunch</option>	
                           <option   value="d">Dinner</option>							 
			     </select>	<br>

                    
               <label><b>Meal Status  </b></label><br>
	             <select name ="status" class="form-control" required>
				           <option   value="">Select one</option>
					       <option   value="1">On</option>	
                           <option   value="0">Off</option>	
                           <option   value="9">Inactive</option>							 
			     </select>	<br>  


     

                <p class="text-danger err_product"></p>



          <div class="loader">
            <img src="{{ asset('images/abc.gif') }}" alt="" style="width: 50px;height:50px;">
          </div><br>


          <input type="submit" value="Submit" id="submit" class=" btn btn-success" />

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

        </div>
      </form>
    </div>
  </div>
</div>

{{-- add new employee modal end --}}




@endsection