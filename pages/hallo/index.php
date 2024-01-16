<header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3><?php echo $menu ?></h3>
                            <p class="text-subtitle text-muted"><?php echo $description ?></p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item active"><a href="<?php echo $menu_link ?>"><?php echo $menu ?></a></li>
                                    <!-- <li class="breadcrumb-item active" aria-current="page"><?php echo $submenu ?></li> -->
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
                                            <th>Column</th>
                                            <th>Column</th>
                                            <th>Column</th>
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
                            <form class="form form-horizontal">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>Field Name</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="field_name" class="form-control form-control-sm"
                                                            name="field_name" placeholder="Field Name">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Price</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="number" id="price" class="form-control form-control-sm"
                                                            name="price" placeholder="0">
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
                                                    <div class="col-md-4">
                                                        <label>Additional Picture</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input class="form-control form-control-sm" id="formFileSm" name="picture" type="file">

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
                            <button type="button" class="btn btn-primary ml-1"
                                data-bs-dismiss="modal">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Save</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

<script>
    //list data goes here.
    //example url : app/master/Fields.php?f_name=get_all_fields
    $.ajax({
        url : "look at example",
        type : "GET",
        success : function(result){
            $("#tbody-field").html(result);
        }
    })

    $("#add").click(function(){
        modalShow('add');
    })

    // function to show modal
    function modalShow(mtd){
        var title;
        if (mtd=="add") {
            title = "Add New Field";
        }else{
            title = "Edit field";
        }
        $(".modal-title").html(title);
        $("#field-modal").modal('toggle');
    }




</script>
