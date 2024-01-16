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
                            <p class="text-subtitle text-muted"><?php echo $description ?></p>
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
                            <h4 class="card-title float-start">List Menu</h4>
                            <button id="add" class="btn btn-sm btn-outline-primary float-end">+</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Menu Name</th>
                                            <th>Description</th>
                                            <th>Link</th>
                                            <th>Path</th>
                                            <th>Icon</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody-menu">

                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <div class="modal fade text-left modal-borderless" id="menu-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
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
                            <form class="form form-horizontal" id="form-menu">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>Menu Name</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="menu_name" class="form-control form-control-sm"
                                                            name="menu_name" placeholder="Menu Name">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Menu Description</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <div class="form-floating">
                                                            <textarea class="form-control form-control-sm" id="menu_description" name="menu_description" row="5" placeholder="Leave a comment here"
                                                                id="floatingTextarea"></textarea>
                                                            <label for="floatingTextarea">Description</label>
                                                        </div>                                                    
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Path</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="path" class="form-control form-control-sm"
                                                            name="path" placeholder="path">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Link</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="link" class="form-control form-control-sm"
                                                            name="link" placeholder="index.php?menu=" value="index.php?menu=">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Icon</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="icon" class="form-control form-control-sm"
                                                            name="icon" placeholder="icon">
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
                            <button type="button" class="btn btn-primary ml-1" onclick="store()"
                                data-bs-dismiss="modal">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Save</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

<script>
    $.ajax({
        url : "app/setting/Menus.php?f_name=get_all_menus",
        type : "GET",
        success : function(result){
            $("#tbody-menu").html(result);
        }
    })

    $("#add").click(function(){
        modalShow('add');
    })

    $("#path").blur(function(){
        var path = $(this).val();
        $("#link").val('index.php?menu='+path);
    })

    function modalShow(mtd){
        var title;
        if (mtd=="add") {
            title = "Add New Menu";
            $("input").val('');
            $("textarea").html('');
            $("select").val('');
        }else{
            title = "Edit Menu";
        }
        $(".modal-title").html(title);
        $("#menu-modal").modal('toggle');
    }

    function getMenubyId(id){
        $.ajax({
            url : "app/setting/Menus.php?f_name=get_menu_by_id",
            type : "GET",
            data : {
                data : id,
            },
            dataType : "JSON",
            success : function(result){
                $("#menu_name").val(result.menu_name);
                $("#menu_description").val(result.menu_description);
                $("#link").val(result.link);
                $("#path").val(result.path);
                $("#icon").val(result.icon);

                modalShow('edit');
            }
        })
    }

    function store(){
        $.ajax({
            url : "app/setting/Menus.php?f_name=store",
            type : "POST",
            data : $("#form-menu").serialize(),
            dataType : "JSON",
            success : function(result){
                window.location.reload();
            }
        })
    }



</script>
