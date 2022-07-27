<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shop</title>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css' />
  <link rel='stylesheet'
    href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css' />
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.css" />

</head>
<!-- add new product modal start -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="POST" id="add_product_form" enctype="multipart/form-data">
        @csrf
        <div class="modal-body p-4 bg-light">
          <div class="row">
            <div class="col-lg">
              <label for="name">Name</label>
              <input type="text" name="name" id="name" class="form-control" placeholder="Name" required>
            </div>
            <div class="col-lg">
              <label for="category">Category</label>
              <input type="text" name="category" id="category" class="form-control" placeholder="Category" required>
            </div>
          </div>
          <div class="my-2">
            <label for="price">Price</label>
            <input type="number" name="price" id="category" class="form-control" placeholder="Price" required>
          </div>
          <div class="my-2">
            <label for="description">Description</label>
            <input type="text" name="description" id="description" class="form-control" placeholder="Description" required>
          </div>
          <div class="my-2">
            <label for="quantity">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="form-control" placeholder="Quantity" required>
          </div>
          <div class="my-2">
            <label for="image">Select Image</label>
            <input type="file" name="image" id="image" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" id="add_product_btn" class="btn btn-primary">Add Product</button>
        </div>
      </form>
    </div>
  </div>
</div>
 <!-- add new product modal end  -->

 <!-- edit product modal start  -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="POST" id="edit_product_form" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="clo_id" id="clo_id">
        <input type="hidden" name="clo_image" id="clo_image">
        <div class="modal-body p-4 bg-light">
          <div class="row">
            <div class="col-lg">
              <label for="name">Name</label>
              <input type="text" name="name" id="name" class="form-control" placeholder="Name" required>
            </div>
            <div class="col-lg">
              <label for="category">Category</label>
              <input type="text" name="category" id="category" class="form-control" placeholder="Category" required>
            </div>
          </div>
          <div class="my-2">
            <label for="price">Price</label>
            <input type="number" name="price" id="price" class="form-control" placeholder="Price" required>
          </div>
          <div class="my-2">
            <label for="description">Description</label>
            <input type="text" name="description" id="description" class="form-control" placeholder="Description" required>
          </div>
          <div class="my-2">
            <label for="quantity">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="form-control" placeholder="Quantity" required>
          </div>
          <div class="my-2">
            <label for="image">Select Image</label>
            <input type="file" name="image" id="image" class="form-control">
          </div>
          <div class="mt-2" id="image">

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" id="edit_product_btn" class="btn btn-success">Update Product</button>
        </div>
      </form>
    </div>
  </div>
</div>
 <!-- edit product modal end  -->


 
<body class="bg-light">
  <div class="container">
    <div class="row my-5">
      <div class="col-lg-12">
        <div class="card shadow">
          <div class="card-header bg-danger d-flex justify-content-between align-items-center">
            <h3 class="text-light">Manage Product</h3>
            <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addProductModal"><i
                class="bi-plus-circle me-2"></i>Add New Product</button>
          </div>
          <div class="card-body" id="show_all_products">
            <h1 class="text-center text-secondary my-5">Loading...</h1>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.bundle.min.js'></script>
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    $(function() {

      // add new product ajax request
      $("#add_product_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#add_product_btn").text('Adding...');
        $.ajax({
          url: '{{ route('store') }}',
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
            if (response.status == 200) {
              Swal.fire(
                'Added!',
                'Product Added Successfully!',
                'success'
              )
              fetchAllProducts();
            }
            $("#add_product_btn").text('Add Product');
            $("#add_product_form")[0].reset();
            $("#addProductModal").modal('hide');
          }
        });
      });

      // edit product ajax request
      $(document).on('click', '.editIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
          url: '{{ route('edit') }}',
          method: 'get',
          data: {
            id: id,
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            // $("#clo_id").val(id);
            // $("#clo_image").val(response.image);
            // $("#name").val(response.name);
            // $("#category").val(response.category);
            $("#price").val(response.price);
            $("#description").val(response.description);
            $("#quantity").val(response.quantity);
            $("#image").html(
             
              `<img src="storage/images/${response.image}" width="100" >`);
         
          }
        });
      });

      // update product ajax request
      $("#edit_product_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
  
          $('#name').val(data.name);
          
        $("#edit_product_btn").text('Updating...');
        $.ajax({
          url: '{{ route('update') }}',
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
        

            if (response.status == 200) {
              Swal.fire(
                'Updated!',
                'Product Updated Successfully!',
                'success'
              )
              fetchAllProducts();
            }
            $("#edit_product_btn").text('Update Product');
            $("#edit_product_form")[0].reset();
            $("#editProductModal").modal('hide');
          }
        });
      });

      // delete product ajax request
      $(document).on('click', '.deleteIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        let csrf = '{{ csrf_token() }}';
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: '{{ route('delete') }}',
              method: 'delete',
              data: {
                id: id,
                _token: csrf
              },
              success: function(response) {
                console.log(response);
                Swal.fire(
                  'Deleted!',
                  'Your file has been deleted.',
                  'success'
                )
                fetchAllProducts();
              }
            });
          }
        })
      });

      // fetch all products ajax request
      fetchAllProducts();

      function fetchAllProducts() {
        $.ajax({
          url: '{{ route('fetchAll') }}',
          method: 'get',
          success: function(response) {
            $("#show_all_products").html(response);
            $("table").DataTable({
              order: [0, 'desc']
            });
          }
        });
      }
    });
  </script>
</body>

</html>