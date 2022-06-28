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
                    <td>{{$cloth->price}}</td>
                    <td>{{$cloth->description}}</td>
                    <td>{{$cloth->quantity}}</td>
                    <td>{{$cloth->image}}</td>
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
            <form action="javascript:void(0)" id="addEditClothForm" name="addEditClothesForm" class="form-horizontal" method="POST">
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
                    <input type="file" class="form-control" name="image" id="image">
                </div>
                </div>

                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary" id="btn-save" value="addNewClothes">Save changes
                    </button>
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

        var id = $(this).data('id');

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
        var id = $(this).data('id');

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

            var id = $("#id").val();
            var name = $('#name').val();
            var category = $('#category').val();
            var price = $('#price').val();
            var description = $('#description').val();
            var quantity = $('#quantity').val();
            var image = $('#image').val();

            $("#btn-save").html('Please Wait...');
            $("#btn-save").attr("disabled", true);

        // ajax
        $.ajax({
            type:"POST",
            url: "{{ url('add-update-clothes') }}",
            data: {
                id: id,
                name: name,
                category: category,
                price: price,
                description: description,
                quantity: quantity,
                image: image,
            },
            dataType: 'json',
            success: function(res){
                window.location.reload();
            $("#btn-save").html('Submit');
            $("#btn-save").attr("disabled", false);
            }
        });

    });

});
</script>
</body>
</html>