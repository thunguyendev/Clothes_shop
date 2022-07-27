<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shop</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
   
</head>
<body>

<div class="container mt-2">

    <div class="row">

        <div class="col-md-12 card-header text-center font-weight-bold">
            <h2>Welcome Admin</h2>
        </div>
        <div class="col-md-12 mt-1 mb-2"><button type="button" id="addNewClothes" class="btn btn-success">Add</button></div>
        <div class="col-md-12">
            <table class="table">
                <thead>
                <tr>
                    <th>No</th>
                    <th scope="col">Name</th>
                    <th scope="col">Category</th>
                    <th scope="col">Price</th>
                    <th scope="col">Description</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Image</th>
                   
                </tr>
                </thead>
                <tbody> 
                <?php $no =1;?>
                @foreach($data as $cloth)
                <tr>
                    <td>{{$no}}</td>
                    <td>{{$cloth->name}}</td>
                    <td>{{$cloth->category}}</td>
                    <td>{{$cloth->price}}</td>s
                    <td>{{$cloth->description}}</td>
                    <td>{{$cloth->quantity}}</td>
                    <td><img src="public/products/' . $cloth->image . '" width="100" ></td>
                   
                    <td>
                        <a href="javascript:void(0)" class="btn btn-primary edit" data-id="{{ $cloth->_id }}">Edit</a>
                        <a href="javascript:void(0)" class="btn btn-primary delete" data-id="{{ $cloth->_id }}">Delete</a>
                    </td>
                </tr>
                <?php $no++;?>
                @endforeach
                </tbody>
            </table>
            </div>
        </div>        
</div>


<!-- boostrap model -->
    <div class="modal fade" id="ajax-clothes-model" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="ajaxClothesModel"></h4>
            </div>
        <div class="modal-body">
            <form action="javascript:void(0)" id="addEditClothForm" name="addEditClothesForm" class="form-horizontal" method="POST" enctype="multipart/form-data">
            @csrf  
                <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Clothes Name" value="" maxlength="50" required="">
                </div>
                </div>  

                <div class="form-group">
                    <label for="category" class="col-sm-2 control-label">Category</label>
                    <div class="col-sm-12">
                    <input type="text" class="form-control" id="category" name="category" placeholder="Enter Clothes Code" value="" maxlength="50" required="">
                    </div>
                </div>

                <div class="form-group">
                    <label for="price" class="col-sm-2 control-label">Price</label>
                    <div class="col-sm-12">
                        <input type="number" class="form-control" id="price" name="price" placeholder="Enter price" value="" required="">
                </div>

                <div class="form-group">
                    <label for="quantity" class="col-sm-2 control-label">Quantity</label>
                    <div class="col-sm-12">
                        <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Enter author Name" value="" required="">
                </div>

                <div class="form-group">
                    <label for="description" class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="description" name="description" placeholder="Enter author Name" value="" required="">
                </div>

                <div class=form-group>
                    <label for="image" class="col-sm-2 control-label" for="image">Image</label>
                    <div class="col-sm-12">
                    <input type='file' id="image" name='image' class="form-control">
                  
                    <div class='alert alert-danger mt-2 d-none text-danger' id="err_file"></div>
                </div>
                </div>

                <div class="col-sm-offset-2 col-sm-10">
                    <button type="button" class="btn btn-primary" id="btn-save" value="addNewClothes">Save changes</button>
                </div>
            </form>
            </div>
            <div class="modal-footer">
            
            </div>
        </div>
        </div>
    </div>
<!-- end bootstrap model -->


<script type="text/javascript">
    $(document).ready(function($){

    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#addNewClothes').click(function () {
        $('#addEditClothesForm').trigger("reset");
        $('#ajaxClothesModel').html("Add Clothes");
        $('#ajax-clothes-model').modal('show');
    });

    $('body').on('click', '.edit', function () {

        let id = $(this).data('id');

        // ajax
        $.ajax({
            type:"POST",
            url: "{{ url('edit-clothes') }}",
            data: { id: id },
            dataType: 'json',
            success: function(res){
                $('#ajaxClothesModel').html("Edit Clothes");
                $('#ajax-clothes-model').modal('show');
                $('#id').val(res.id);
                $('#name').val(res.name);
                $('#category').val(res.category);
                $('#price').val(res.price);
                $('#description').val(res.description);
                $('#quantity').val(res.quantity);
                $('#image').val(res.image);
            }
        });

    });



    $('body').on('click', '.delete', function () {
        if (confirm("Delete Record?") == true) {
        let id = $(this).data('id');

        // ajax
        $.ajax({
            type:"POST",
            url: "{{ url('delete-clothes') }}",
            data: { id: id },
            dataType: 'json',
            success: function(res){
                window.location.reload();
            }
        });
        }
    });

    $('body').on('click', '#btn-save', function (event) {

        let id = $("#id").val();
        let name = $('#name').val();
        let category = $('#category').val();
        let price = $('#price').val();
        let description = $('#description').val();
        let quantity = $('#quantity').val();
        // Get the selected file
        let image = $('#image')[0].files[0];

        let $thisBtn = $(this);
    
        $thisBtn.html('Please Wait...');
        $thisBtn.attr("disabled", true);

        let formData = new FormData();
        formData.append('id', id);
        formData.append('name', name);
        formData.append('category', category);
        formData.append('price', price);
        formData.append('description', description);
        formData.append('quantity', quantity);
        formData.append('image', image);
        // ajax
        $.ajax({
            type:"POST",
            url: "{{ url('add-update-clothes') }}",
            data: formData,
            contentType: false,
            processData: false,
            success: function(res){
             
                $thisBtn.html('Submit');
                $thisBtn.attr("disabled", false);
            }
        });

    });

});
</script>
</body>
</html>