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
                            <p class="text-subtitle text-muted">Data Payment Method </p>
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
                            <h4 class="card-title float-start">List Payment Method</h4>
                            <button id="add" class="btn btn-sm btn-outline-primary float-end">+</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Payment Method</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody-payment_method">

                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <div class="modal fade text-left modal-borderless" id="payment_method-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
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
                            <form class="form form-horizontal" id="form-payment_method">
                            <input type="hidden" id="id_payment_method" name="id_payment_method"/>
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>Payment Method Name</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="payment_method" class="form-control form-control-sm"
                                                            name="payment_method" placeholder="Payment Method Name">
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
                            <button type="button" id="save-payment_method" class="btn btn-primary ml-1"
                                data-bs-dismiss="modal">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Save</span>
                            </button>
                            <button type="button" id="update-payment_method" class="btn btn-primary ml-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Update</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

<script>
    $(function(){
        getPaymentMethods();
    })

    function getPaymentMethods(){
        $.ajax({
            url : "app/master/Payment_methods.php?f_name=get_all_payment_methods",
            type : "GET",
            success : function(result){
                $("#tbody-payment_method").html(result);
            }
        })
    }

    $("#add").click(function(){
        modalShow('add');
    })

    $("#save-payment_method").click(function(){
        savePaymentMethod();
    })

    $("#update-payment_method").click(function(){
        updatePaymentMethod();
    })

    function modalShow(mtd){
        var title;
        if (mtd=="add") {
            title = "Add New Payment Method";
            $("input").val('');
            $("textarea").val('');
            $("select").val('');
            $("#save-payment_method").show();
            $("#update-payment_method").hide();
        }else{
            title = "Edit Payment Method";
            $("#save-payment_method").hide();
            $("#update-payment_method").show();
        }
        $(".modal-title").html(title);
        $("#payment_method-modal").modal('toggle');
    }

    function savePaymentMethod(){
        $.ajax({
            url : "app/master/Payment_methods.php?f_name=store",
            type : "POST",
            data :  $("#form-payment_method").serialize(),
            dataType : "JSON",
            success : function(result){
                $("#payment_method-modal").modal('hide');
                getPaymentMethods();
            }
        })
    }

    function updatePaymentMethod(id){
        $.ajax({
            url : "app/master/Payment_methods.php?f_name=update",
            type : "POST",
            data :  $("#form-payment_method").serialize(),
            dataType : "JSON",
            success : function(result){
                $("#payment_method-modal").modal('hide');
                getPaymentMethods();
            }
        })
    }

    function deletePaymentMethod(id){
        var confirm = window.confirm("Are you sure want to delete this?");
        if (confirm) {
            $.ajax({
            url : "app/master/Payment_methods.php?f_name=delete",
            type : "GET",
            data :  {
                id_payment_method : id
            },
            dataType : "JSON",
            success : function(result){
                getPaymentMethods();
            }
        })
        }
    }
    

    function getPaymentMethodbyId(id){
        $.ajax({
            url : "app/master/Payment_methods.php?f_name=get_payment_method_by_id",
            type : "GET",
            data : {
                data : id,
            },
            dataType : "JSON",
            success : function(result){
                $("#id_payment_method").val(result.id_payment_method);
                $("#payment_method_name").val(result.payment_method_name);
                $("#price").val(result.price);
                $("#note").val(result.note);

                modalShow('edit');
            }
        })
    }



</script>
