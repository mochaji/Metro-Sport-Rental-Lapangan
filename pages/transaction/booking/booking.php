<?php 
    $query_customer = mysqli_query($connect,"SELECT * from customers where deleted_at is null");
    $query_field = mysqli_query($connect,"SELECT * from fields where deleted_at is null");
    $query_payment_method = mysqli_query($connect,"SELECT * from payment_methods where deleted_at is null");
?>
<header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
<style>
.pignose-calendar {
    font-family: 'Lato', 'Open Sans', sans-serif;
    font-size: 14px !important;
    margin-right: 0px;
    margin-left: 0px;
    width: 100%;
    border: 0px;
    box-shadow: none;
    border-radius: 0.7rem;
}

.pignose-calendar-top{
    border: 0px;
    box-shadow: none !important;
    border-radius: 0.7rem;
    background-color: #fff !important;
    border-bottom: #dedede;
}

.box {
    text-align: center;
}

.language-calender .pignose-calender {
    margin-top: .4em !important;
}

.input-calendar {
    display: block;
    width: 100%;
    max-width: 360px;
    margin: 0 auto;
    height: 3.2em;
    line-height: 3.2em;
    font: inherit;
    padding: 0 1.2em;
    border: 1px solid #d8d8d8;
    box-shadow: 0 4px 12px rgba(0, 0, 0, .25);
    -o-box-shadow: 0 4px 12px rgba(0, 0, 0, .25);
    -moz-box-shadow: 0 4px 12px rgba(0, 0, 0, .25);
    -webkit-box-shadow: 0 4px 12px rgba(0, 0, 0, .25);
}

.btn-calendar {
    display: block;
    text-align: center;
    width: 100%;
    max-width: 360px;
    height: 3.2em;
    line-height: 3.2em;
    background-color: #52555a;
    margin: 0 auto;
    font-weight: 600;
    color: #ffffff !important;
    text-decoration: none !important;
    box-shadow: 0 4px 12px rgba(0, 0, 0, .25);
    -o-box-shadow: 0 4px 12px rgba(0, 0, 0, .25);
    -moz-box-shadow: 0 4px 12px rgba(0, 0, 0, .25);
    -webkit-box-shadow: 0 4px 12px rgba(0, 0, 0, .25);
}

.btn-calendar:hover {
    background-color: #5a6268;
}

</style>
            <div class="page-heading">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3><?php echo $submenu ?></h3>
                            <p class="text-subtitle text-muted">Data Reservation </p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?php echo $menu_link ?>"><?php echo $menu ?></a></li>
                                    <li class="breadcrumb-item active" aria-current="page"><?php echo $submenu ?></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <section class="section">
                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <div class="calendar"></div>
                        </div>
                        <div class="col-md-8 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title float-start">Reservation List</h4>
                                    <button id="add" class="btn btn-sm btn-outline-primary float-end">+</button>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Start</th>
                                                    <th>End</th>
                                                    <th>Field</th>
                                                    <th>Customer</th>
                                                    <th>Status</th>
                                                    <th>#</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody-booking">

                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <div class="modal fade text-left modal-borderless" id="reservation-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary" id="modal-header">
                            <h5 class="modal-title white" id="myModalLabel1">Basic Modal</h5>
                            <button type="button" class="close rounded-pill"
                                data-bs-dismiss="modal" aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="form form-horizontal" id="form-reservation">
                                <div class="row" id="card-field">
                                    <h4>Select Field</h4>
                                <?php while($r = mysqli_fetch_array($query_field)) {
                                    
                                    ?>
                                    <div class="col-md-4">
                                        <div class="card">
                                            <img class="card-img-top" src="assets/images/samples/<?php echo $r['id_field'] ?>.png" alt="Card image cap">
                                            <div class="card-body">
                                                <h5 class="card-title"><?php echo $r['field_name'] ?></h5>
                                                <p class="card-text"><?php echo $r['note'].'<br>IDR '.$r['price'].' /hour' ?></p>
                                                <a href="#" class="btn btn-primary" onclick="bookField(<?php echo $r['id_field'] ?>)">Book Now!</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                </div>
                                            <div class="form-body" id="book-field">
                                                <div class="row">
                                                    <div class="col-md-4">      
                                                        <div class="card mb-0">
                                                            <div class="card-body">
                                                                <h5 class="card-title" id="selected_field_name"></h5>
                                                                <p class="card-text" id="selected_field_note"><?php echo $r['note'].'<br>IDR '.$r['price'].' /jam' ?></p>
                                                                <input type="hidden" name="field" id="selected_id_field"/>
                                                                <input type="hidden" name="price_per_hour" id="price_per_hour"/>
                                                                <button type="button" id="change" class="btn btn-sm btn-primary"><i class="fa fa-angle-double-left"></i> Change</button>
                                                            </div>
                                                        </div>                                                    
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="row">
                                                            <input type="hidden" id="id_booking" name="id_booking" />
                                                            <div class="col-md-4">
                                                                <label>Customer Name</label>
                                                            </div>
                                                            <div class="col-md-8 form-group">
                                                                <div class="input-group input-group-sm">
                                                                    <select class="form-control form-control-sm " id="customer" name="customer">
                                                                        <option value="">Select Customer</option>
                                                                        <?php
                                                                            while ($cust = mysqli_fetch_array($query_customer)) {
                                                                        ?>
                                                                        <option value="<?= $cust['customer_code']?>"><?= $cust['customer_name'] ?></option>
                                                                        <?php
                                                                            }
                                                                        ?>
                                                                    </select>

                                                                    <a class="btn btn-outline-secondary" type="button" target="_blank" href="index.php?pageload=customers"
                                                                        id="button-addon2">+</a>
                                                                </div>

                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>Reservation Date</label>
                                                            </div>
                                                            <div class="col-md-8 form-group">
                                                                <input type="date" id="date" class="form-control form-control-sm"
                                                                    name="date" min="<?php echo date('Y-m-d') ?>" value="<?php echo date('Y-m-d') ?>">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>Hours</label>
                                                            </div>
                                                            <div class="col-md-8 form-group">
                                                                <input type="number" value=1 id="hour" class="form-control form-control-sm"
                                                                    name="hour">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>Start</label>
                                                            </div>
                                                            <div class="col-md-8 form-group">
                                                                <input type="time" id="start" class="form-control form-control-sm"
                                                                    name="start">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>End</label>
                                                            </div>
                                                            <div class="col-md-8 form-group">
                                                                <input type="time" id="end" readonly="readonly" class="form-control form-control-sm"
                                                                    name="end">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>Total Price</label>
                                                            </div>
                                                            <div class="col-md-8 form-group">
                                                                <input type="number" id="total" readonly="readonly" class="form-control form-control-sm"
                                                                    name="total">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>Down Payment</label>
                                                            </div>
                                                            <div class="col-md-8 form-group">
                                                                <input type="number" id="dp" class="form-control form-control-sm"
                                                                    name="dp">
                                                            </div>
                                                            <div class="col-md-4 payment">
                                                                <label>To be Paid</label>
                                                            </div>
                                                            <div class="col-md-8 form-group payment">
                                                                <input type="number" id="tobepaid" class="form-control form-control-sm"
                                                                    name="tobepaid">
                                                            </div>
                                                            <div class="col-md-4 payment">
                                                                <label>Paid</label>
                                                            </div>
                                                            <div class="col-md-8 form-group payment">
                                                                <input type="number" id="paid" class="form-control form-control-sm"
                                                                    name="paid">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>Payment Method</label>
                                                            </div>
                                                            <div class="col-md-8 form-group">
                                                                <select class="form-control form-control-sm" name="payment_method" id="payment_method">
                                                                    <option value="">Select Payment Method</option>
                                                                    <?php while($pm = mysqli_fetch_array($query_payment_method)) {?>
                                                                    <option value="<?php echo $pm['id_payment_method'] ?>"><?php echo $pm['payment_method'] ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="button" id="save-reservation" class="btn btn-primary ml-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Save</span>
                            </button>
                            <button type="button" id="update-reservation" class="btn btn-primary ml-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Update</span>
                            </button>
                            <button type="button" id="pay-reservation" class="btn btn-primary ml-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Pay</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

<script>
    var cal_date = ''
    $(function(){
        var d = new Date(),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) 
            month = '0' + month;
        if (day.length < 2) 
            day = '0' + day;

        today = [year, month, day].join('-');
        cal_date = today;
        getReservations(today);
    })

    var d = new Date(),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) 
            month = '0' + month;
        if (day.length < 2) 
            day = '0' + day;

        today = [year, month, day].join('-');

    $('.calendar').pignoseCalendar({
        select: onSelectHandler
    }); 

    $("#dp").change(function(){
        var total = parseFloat($("#total").val());
        var dp = parseFloat($(this).val());
            if (dp > total) {
                alert("Down Payment can't be higher than total");
                $(this).val(total);
            }
    })

    $("#paid").change(function(){
        var tobepaid = parseFloat($("#tobepaid").val());
        var paid = parseFloat($("#paid").val()); 
        // alert(paid);
        if (paid > tobepaid) {
                alert("Payment can't be higher than the rest");
                $(this).val(tobepaid);
            }
    })

    function onSelectHandler(date, context) {
            /**
             * @date is an array which be included dates(clicked date at first index)
             * @context is an object which stored calendar interal data.
             * @context.calendar is a root element reference.
             * @context.calendar is a calendar element reference.
             * @context.storage.activeDates is all toggled data, If you use toggle type calendar.
             * @context.storage.events is all events associated to this date
             */

            var $element = context.element;
            var $calendar = context.calendar;
            var $box = $element.siblings('.box').show();
            var text = '';

            if (date[0] !== null) {
                text += date[0].format('YYYY-MM-DD');
            }

            if (date[0] !== null && date[1] !== null) {
                text += ' ~ ';
            }
            else if (date[0] === null && date[1] == null) {
                text += 'nothing';
            }

            if (date[1] !== null) {
                text += date[1].format('YYYY-MM-DD');
            }

            var d = new Date(),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

            if (month.length < 2) 
                month = '0' + month;
            if (day.length < 2) 
                day = '0' + day;

            today = [year, month, day].join('-');

            if (text < today) {
                $("#add").hide();
            }else{
                $("#add").show();
            }

            cal_date = text;

            getReservations(text);
        }

    function getReservations(date){
        $.ajax({
            url : "app/transaction/Booking.php?f_name=get_all_booking",
            type : "GET",
            data : {
                date : date
            },
            success : function(result){
                $("#tbody-booking").html(result);
            }
        });
    }

    $("#add").click(function(){
        modalShow('add',0,cal_date);
    })

    $("#save-reservation").click(function(){
        if(checkValue()){
            saveReservation();
        };
    })

    $("#update-reservation").click(function(){
        if (checkValue()) {
            updateReservation(); 
        }
    })

    $("#pay-reservation").click(function(){
        if (checkValue()) {
            payReservation(); 
        }
    })

    $("#change").click(function(){
        $("#book-field").slideUp();
        $("#card-field").slideDown();
    })

    function modalShow(mtd, status, date=''){
        var title;
        $("input").attr('disabled',false);
        $("textarea").attr('disabled',false);
        $("select").attr('disabled',false);
        $("#change").attr('disabled',false);
        $("#pay-reservation").hide();
        $(".payment").hide();
        console.log(status);
        if (mtd=="add") {
            title = "New Reservation";
            $("input").val('');
            $("textarea").val('');
            $("select").val('');
            $("#date").val(date);
            $("#paid").val(0);
            $("#tobepaid").val(0);
            $("#save-reservation").show();
            $("#update-reservation").hide();
            $("#book-field").hide();
            $("#card-field").show();
            $("#id_booking").val(0);

            
        }else if(mtd=="edit"){
            title = "Edit Reservation";
            $("#save-reservation").hide();
            $("#update-reservation").show();
            $("#book-field").show();
            $("#card-field").hide();
            $("#paid").val(0);
            $("#tobepaid").val(0);
           
        }else{
            title = "View Reservation";
            $("#save-reservation").hide();
            $("#pay-reservation").show();
            $("#update-reservation").hide();
            $("#book-field").show();
            $("#card-field").hide();
            $("input").attr('disabled',true);
            $("textarea").attr('disabled',true);
            $("select").attr('disabled',true);
            $("#change").attr('disabled',true);
            $("#paid").attr('disabled', false);
            $("#payment_method").attr('disabled', false);
            $("#tobepaid").attr('disabled', true);
            $(".payment").show();
            $("#id_booking").attr('disabled', false);
            if (status=='Paid Off' || status=='Canceled') {
                $("#payment_method").attr('disabled', true);
                $("#paid").attr('disabled', true);
                $("#pay-reservation").hide();
            }

        }
        $(".modal-title").html(title);
        $("#reservation-modal").modal('toggle');
    }

    $("#start").on('blur',function(){
        getTotalPrice();
    });

    $("#hour").on('blur',function(){
        getTotalPrice();
    });

    function getTotalPrice(){
        var hour = $("#hour").val();
        var start = $("#start").val();
        var price = $("#price_per_hour").val();
        if (hour == '') {
            alert("Please fill this input first");
            $("#hour").focus();
        }else{
            var digit = start.split(':');
            var jam = digit[0];
            var menit = digit[1];
            jam = parseFloat(jam) + parseFloat(hour);
            if (jam > 23) {
                alert("Sory we are close on 23.00 pm");
                $("#start").val('').focus();
                $("#end").val('');
            }else{
                if (jam == 23 && menit > 0) {
                    alert("Sory we are close on 23.00 pm");
                    $("#start").val('').focus();
                    $("#end").val('');
                }else{
                    var end = jam + ":" + menit;
                    var total = price*hour;
                    $("#end").val(end);
                    $("#total").val(total);
                }
            }
        }
    }

    function getReservationById(id,view){
        $.ajax({
            url : "app/transaction/Booking.php?f_name=get_reservation_by_id",
            type : "GET",
            data : {
                data : id,
            },
            dataType : "JSON",
            success : function(result){
                $("#id_booking").val(result.id_booking);
                $("#customer").val(result.customer_code);
                $("#date").val(result.booking_date);
                $("#hour").val(result.hour);
                var start = result.start_time.toString().split(" ");
                var end = result.end_time.toString().split(" ");
                $("#start").val(start[1]);
                $("#end").val(end[1]);
                $("#total").val(result.total);
                $("#dp").val(result.dp);
                $("#payment_method").val(result.payment_method);
                $("#tobepaid").val(result.tobepaid);
                $("#paid").val(result.tobepaid);
                getSelectedField(result.id_field);

                if (view==1) {
                    modalShow('view',result.status);
                    console.log(result.status);
                }else{
                    modalShow('edit',result.status);
                }
            }
        })
    }

    function saveReservation(){
        $.ajax({
            url : "app/transaction/Booking.php?f_name=store",
            type : "POST",
            data :  $("#form-reservation").serialize(),
            dataType : "JSON",
            success : function(result){
                $("#reservation-modal").modal('hide');
                getReservations(result.date);
            }
        })
    }

    function updateReservation(id){
        $.ajax({
            url : "app/transaction/Booking.php?f_name=update",
            type : "POST",
            data :  $("#form-reservation").serialize(),
            dataType : "JSON",
            success : function(result){
                $("#reservation-modal").modal('hide');
                getReservations(result.date);
            }
        })
    }

    function payReservation(){
        $.ajax({
            url : "app/transaction/Booking.php?f_name=pay",
            type : "POST",
            data :  $("#form-reservation").serialize(),
            dataType : "JSON",
            success : function(result){
                $("#reservation-modal").modal('hide');
                getReservations(result.date);
            }
        })
    }

    function deleteReservation(id){
        var confirm = window.confirm("DP cannot be refund. Are you sure want to cancel this?");
        if (confirm) {
            $.ajax({
            url : "app/transaction/Booking.php?f_name=delete",
            type : "GET",
            data :  {
                id_booking : id
            },
            dataType : "JSON",
            success : function(result){
                getReservations(today);
            }
        })
        }
    }

    function bookField(id){
        $("#book-field").show();
        $("#card-field").slideUp();
        $("#save-reservation").show();
        getSelectedField(id)
    }

    function getSelectedField(id){
        $.ajax({
            url : "app/transaction/Booking.php?f_name=get_selected_field",
            type : "GET",
            data :  {
                id_field : id
            },
            dataType : "JSON",
            success : function(result){
                $("#selected_field_name").html(result.field_name);
                $("#selected_field_note").html(result.note+'<br>IDR '+result.price+' /hour');
                $("#selected_id_field").val(result.id_field);
                $("#price_per_hour").val(result.price);
            }
        })
    }

    function checkValue(){
        data = $('#form-reservation').serialize();
        valid = true;
        array = data.split('&');
        for (let index = 0; index < array.length; index++) {
            input = array[index].split('=');
            name = input[0];
            value = input[1];
                
            if (value == '') {
                alert("Please fill all this input");
                valid = false;
                break;
            }
        }

        return valid

    }



</script>
