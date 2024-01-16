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
                            <p class="text-subtitle text-muted">Data Field </p>
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
                            <h4 class="card-title float-start">List Field</h4>
                            <button id="add" class="btn btn-sm btn-outline-primary float-end">+</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Field Name</th>
                                            <th>Note</th>
                                            <th>Price</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody-field">

                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <div class="modal fade text-left modal-borderless" id="field-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
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
                            <form class="form form-horizontal" id="form-field">
                            <input type="hidden" id="id_field" name="id_field"/>
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>Field Name</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="field_name" class="form-control form-control-sm"
                                                            name="field_name" placeholder="Field Name" onchange="checkLength(this, 'Field Name', 20); checkSpecialCharacter(this)">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Price</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="number" id="price" class="form-control form-control-sm"
                                                            name="price" placeholder="0" onchange="checkLength(this, 'Price', 11)">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Notes</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <div class="form-floating">
                                                            <textarea class="form-control form-control-sm" id="note" name="note" row="5" placeholder="Leave a comment here"
                                                                id="floatingTextarea"></textarea>
                                                            <label for="floatingTextarea">Note</label>
                                                        </div>                                                    
                                                    </div>
                                                    <!-- <div class="col-md-4">
                                                        <label>Additional Picture</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input class="form-control form-control-sm" id="formFileSm" name="picture" type="file">

                                                    </div> -->
                                                </div>
                                            </div>
                                        </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="button" id="save-field" class="btn btn-primary ml-1"
                                data-bs-dismiss="modal">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Save</span>
                            </button>
                            <button type="button" id="update-field" class="btn btn-primary ml-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Update</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

<script>
    $(function(){
        getFields();
    })

    function getFields(){
        $.ajax({
            url : "app/master/Fields.php?f_name=get_all_fields",
            type : "GET",
            success : function(result){
                $("#tbody-field").html(result);
            }
        })
    }

    $("#add").click(function(){
        modalShow('add');
    })

    $("#save-field").click(function(){
        saveField();
    })

    $("#update-field").click(function(){
        updateField();
    })

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

    function modalShow(mtd){
        var title;
        if (mtd=="add") {
            title = "Add New Field";
            $("input").val('');
            $("textarea").val('');
            $("select").val('');
            $("#save-field").show();
            $("#update-field").hide();
        }else{
            title = "Edit Field";
            $("#save-field").hide();
            $("#update-field").show();
        }
        $(".modal-title").html(title);
        $("#field-modal").modal('toggle');
    }

    function saveField(){
        $.ajax({
            url : "app/master/Fields.php?f_name=store",
            type : "POST",
            data :  $("#form-field").serialize(),
            dataType : "JSON",
            success : function(result){
                $("#field-modal").modal('hide');
                getFields();
            }
        })
    }

    function updateField(id){
        $.ajax({
            url : "app/master/Fields.php?f_name=update",
            type : "POST",
            data :  $("#form-field").serialize(),
            dataType : "JSON",
            success : function(result){
                $("#field-modal").modal('hide');
                getFields();
            }
        })
    }

    function deleteField(id){
        var confirm = window.confirm("Are you sure want to delete this?");
        if (confirm) {
            $.ajax({
            url : "app/master/Fields.php?f_name=delete",
            type : "GET",
            data :  {
                id_field : id
            },
            dataType : "JSON",
            success : function(result){
                getFields();
            }
        })
        }
    }
    

    function getFieldbyId(id){
        $.ajax({
            url : "app/master/Fields.php?f_name=get_field_by_id",
            type : "GET",
            data : {
                data : id,
            },
            dataType : "JSON",
            success : function(result){
                $("#id_field").val(result.id_field);
                $("#field_name").val(result.field_name);
                $("#price").val(result.price);
                $("#note").val(result.note);

                modalShow('edit');
            }
        })
    }



</script>
