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
                            <p class="text-subtitle text-muted">Data Customer </p>
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
                            <h4 class="card-title float-start">List Customer</h4>
                            <button id="add" class="btn btn-sm btn-outline-primary float-end">+</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Customer Code</th>
                                            <th>Customer Name</th>
                                            <th>PIC</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody-customer">

                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <div class="modal fade text-left modal-borderless" id="customer-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
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
                            <form class="form form-horizontal" id="form-customer">
                                <input type="hidden" id="id_customer" name="id_customer"/>
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>Customer Name</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="customer_name" class="form-control form-control-sm"
                                                            name="customer_name" placeholder="customer Name" onchange="checkLength(this, 'Customer Name', 50); checkSpecialCharacter(this)">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>PIC</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="pic" class="form-control form-control-sm"
                                                            name="pic" placeholder="pic name" onchange="checkLength(this, 'PIC name', 50); checkSpecialCharacter(this)">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Email</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="email" id="email" class="form-control form-control-sm"
                                                            name="email" placeholder="john@mail.com" onChange="checkLength(this, 'Email', 30); checkEmail(this)">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Phone</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="phone" class="form-control form-control-sm"
                                                            name="phone" placeholder="08290xxxxx" onChange="checkLength(this, 'Phone Number', 15); checkPhoneNumber(this)">
                                                    </div>
                                                    <input type="hidden" id="customer_code" class="form-control form-control-sm"
                                                            name="customer_code" value="CST-000">
                                                    <div class="col-md-4">
                                                        <label>Address</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <div class="form-floating">
                                                            <textarea class="form-control form-control-sm" id="address" name="address" row="5" placeholder="Address"
                                                                id="floatingTextarea"></textarea>
                                                            <label for="floatingTextarea">Address</label>
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
                            <button type="button" id="save-customer" class="btn btn-primary ml-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Save</span>
                            </button>
                            <button type="button" id="update-customer" class="btn btn-primary ml-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Update</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

<script>
    const token = "<?=$_SESSION['token'];?>";
    $(function(){
        getCustomers();
    })

    function getCustomers(){
        $.ajax({
            url : "app/master/Customers.php?f_name=get_all_customers",
            type : "GET",
            success : function(result){
                $("#tbody-customer").html(result);
            }
        });
    }

    $("#add").click(function(){
        modalShow('add');
    })

    $("#save-customer").click(function(){
        if (checkValue()) {
            saveCustomer();
        }
    })

    $("#update-customer").click(function(){
        if (checkValue()) {
            updateCustomer();
        }
    })

    // $("#customer_name,#pic").change(function(){
    //     var text = $(this).val();
    //     if (text.length > 50) {
    //         alert("This input should be less than 50 characters");
    //         $(this).val(text.substring(0,49));
    //     }
    // })

    function checkLength(th, name, length){
        var text = $(th).val();
        if (text.length > length) {
            alert(name + " should be less than "+length+" characters");
            length = length-1;
            $(th).val(text.substring(0,length));
        }
    }

    function checkSpecialCharacter(th){
        var text = $(th).val();
        var regex = new RegExp("^[a-zA-Z0-9.,/ $@()]+$");
        if (!regex.test(text)) {
            alert("This input cannot be contain special characters");  
            $(th).val('');  
        }

    }

    function checkEmail(th){
        email = $(th).val();
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        value = regex.test(email);
        if (!value) {
            alert("Email value is not valid!");
            $(th).val('');
        }
    }

    function checkPhoneNumber(th){
        phoneNumber = $(th).val();
        var regex = /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;
        value = regex.test(phoneNumber);
        if (!value) {
            alert("Phone Number value is not valid!");
            $(th).val('');
        }
    }

    function modalShow(mtd){
        var title;
        if (mtd=="add") {
            title = "Add New customer";
            $("input").val('');
            $("textarea").val('');
            $("#save-customer").show();
            $("#update-customer").hide();
        }else{
            title = "Edit customer";
            $("#save-customer").hide();
            $("#update-customer").show();
        }
        $(".modal-title").html(title);
        $("#customer-modal").modal('toggle');
    }

    function getcustomerbyId(id){
        $.ajax({
            url : "app/master/Customers.php?f_name=get_customer_by_id",
            type : "GET",
            data : {
                data : id,
                token : token
            },
            dataType : "JSON",
            success : function(result){
                $("#id_customer").val(result.id_customer);
                $("#customer_name").val(result.customer_name);
                $("#customer_code").val(result.customer_code);
                $("#pic").val(result.pic);
                $("#email").val(result.email);
                $("#phone").val(result.phone);
                $("#address").val(result.address);

                modalShow('edit');
            }
        })
    }

    function saveCustomer(){
        $.ajax({
            url : "app/master/Customers.php?f_name=store",
            type : "POST",
            data :  $("#form-customer").serialize(),
            dataType : "JSON",
            success : function(result){
                $("#customer-modal").modal('hide');
                getCustomers();
            }
        })
    }

    function updateCustomer(id){
        $.ajax({
            url : "app/master/Customers.php?f_name=update",
            type : "POST",
            data :  $("#form-customer").serialize(),
            dataType : "JSON",
            success : function(result){
                $("#customer-modal").modal('hide');
                getCustomers();
            }
        })
    }

    function deleteCustomer(id){
        var confirm = window.confirm("Are you sure want to delete this?");
        if (confirm) {
            $.ajax({
            url : "app/master/Customers.php?f_name=delete",
            type : "GET",
            data :  {
                id_customer : id
            },
            dataType : "JSON",
            success : function(result){
                getCustomers();
            }
        })
        }
    }

    function checkValue(){
        data = $('#form-customer').serialize();
        valid = true;
        array = data.split('&');
        for (let index = 0; index < array.length; index++) {
            input = array[index].split('=');
            name = input[0];
            value = input[1];
              
        }

        return valid

    }


</script>
