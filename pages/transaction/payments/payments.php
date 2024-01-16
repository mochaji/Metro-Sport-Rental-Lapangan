<?php 
$sql = "SELECT * from payment_methods where deleted_at is null";
$query_field = mysqli_query($connect, $sql);

?>
<header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3><?php echo $submenu ?></h3>
                            <p class="text-subtitle text-muted">Data Payment </p>
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
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-3">
                                    <input class="form-control" type="date" id="first-date" value="<?php echo date("Y-m-01"); ?>"/>
                                </div>
                                <div class="col-md-3">
                                    <input class="form-control" type="date" id="last-date" value="<?php echo date("Y-m-d"); ?>"/>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-control" id="payment_method">
                                        <option value=""> -- Payment Method -- </option>
                                        <?php while($r = mysqli_fetch_array($query_field)){ ?>
                                            <option value="<?php echo $r['id_payment_method'] ?>"><?php echo $r['payment_method'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input class="form-control" type="text" id="search" placeholder="search"/>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>No Payment</th>
                                            <th>No Booking</th>
                                            <th>Payment date</th>
                                            <th>Customer</th>
                                            <th>Payment Method</th>
                                            <th>Payment</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody-payment">

                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            

<script>
    $(function(){
        getPayments();
    })

    $("#first-date").change(function(){
        getPayments();
    });

    $("#last-date").change(function(){
        getPayments();
    });

    $("#payment_method").change(function(){
        getPayments();
    });

    $("#search").blur(function(){
        getPayments();
    });

    function getPayments(){
        var firstDate = $("#first-date").val();
        var lastDate = $("#last-date").val();
        var payment_method = $("#payment_method").val();
        var search = $("#search").val();
        $.ajax({
            url : "app/transaction/Payments.php?f_name=get_all_payments",
            type : "GET",
            data : {
                first_date : firstDate,
                last_date : lastDate,
                payment_method : payment_method,
                search : search,
            },
            success : function(result){
                $("#tbody-payment").html(result);
            }
        });
    }


    function getcustomerbyId(id){
        $.ajax({
            url : "app/master/customers.php?f_name=get_customer_by_id",
            type : "GET",
            data : {
                data : id,
            },
            dataType : "JSON",
            success : function(result){
                $("#id_customer").val(result.id_customer);
                $("#customer_name").val(result.customer_name);
                $("#pic").val(result.pic);
                $("#email").val(result.email);
                $("#phone").val(result.phone);
                $("#address").val(result.address);

                modalShow('edit');
            }
        })
    }

    

    function deletePayment(id){
        var confirm = window.confirm("Are you sure want to delete this?");
        if (confirm) {
            $.ajax({
            url : "app/master/customers.php?f_name=delete",
            type : "GET",
            data :  {
                id_customer : id
            },
            dataType : "JSON",
            success : function(result){
                getPayments();
            }
        })
        }
    }



</script>
