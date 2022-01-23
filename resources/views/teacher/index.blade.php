<!DOCTYPE html>
<html>
<head>
    <title>Laravel Jquery Ajax</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.js"
            integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
</head>
<body>
<div style="padding: 30px"></div>
<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <span>All Teacher</span>
                    <a class="btn btn-xs btn-info pull-right" id="addModal" style="margin-bottom: 5px">Add New</a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Description</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" required id="name" class="form-control" placeholder="Enter Your Name">
                    <small class="text-danger" id="nameError"></small>
                </div>
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="text" required id="email" class="form-control" placeholder="Enter Your Email">
                    <small class="text-danger" id="emailError"></small>
                </div>
                <div class="form-group">
                    <label for="">Phone</label>
                    <input type="text" required id="phone" class="form-control" placeholder="Enter Your Phone Number">
                    <small class="text-danger" id="phoneError"></small>
                </div>
                <div class="form-group">
                    <label for="">Description</label>
                    <textarea id="description" class="form-control" cols="" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <input type="hidden" id="id">
                    <button type="submit" class="btn btn-sm btn-primary" id="addBtn" onclick="addData()">Add</button>
                    <button type="submit" class="btn btn-sm btn-primary " id="updateBtn" onclick="updateData()">Update</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function (){
    $("#addModal").click(function (){
        $('#myModal').modal('show').find('.modal-title').text('Create Teacher');
        $('#addBtn').show();
        $('#updateBtn').hide();
        clearData();

    })
});
    $.ajaxSetup({
        headers:{
            'CSRF-TOKEN':$('name [name="csrf-token"]').attr('content')
        }
    })
function getData(){
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{ url ('teacher/create') }}",
            success:function (response){
                var data = '';
             $.each(response , function (key ,value ){
                data = data + "<tr>"
                data = data + "<td>"+value.id+"</td>"
                data = data + "<td>"+value.name+"</td>"
                data = data + "<td>"+value.email+"</td>"
                data = data + "<td>"+value.phone+"</td>"
                data = data + "<td>"+value.description+"</td>"
                data = data + "<td>"
                data = data + "<button class='btn btn-xs btn-info' onclick='editData("+value.id+")'>Edit</button>"
                data = data + "<button class='btn btn-xs btn-danger' onclick='deleteData("+value.id+")'>Delete</button>"
                data = data + "</td>"
                data = data + "</tr>"
             })
                $('tbody').html(data);
            }
        })
}
getData();
    function clearData(){
              $('#id').val('');
              $('#name').val('');
              $('#email').val('');
              $('#phone').val('');
              $('#description').val('');
    }
    function allData(){
        var id =          $('#id').val();
        var name =        $('#name').val();
        var email =       $('#email').val();
        var phone =       $('#phone').val();
        var description = $('#description').val();
        return {
                id: id,
                name: name,
                email: email,
                phone: phone,
                description: description,
                _token:"{{ csrf_token() }}",

        }

    }

    function addData(){
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{ route('teacher.store') }}",
            data: allData(),
            success:function(data){
                console.log('Created');
                getData();
                clearData();
                $('#myModal').modal('hide').find('.text-danger').html('');
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    type: 'success',
                    title: 'Data Added Successfully.',
                    showConfirmButton: false,
                    timer: 5000
                })

            },
            error:function (error){
                $('#nameError').text(error.responseJSON.errors.name);
                $('#emailError').text(error.responseJSON.errors.email);
                $('#phoneError').text(error.responseJSON.errors.phone);


            }
        })
    }
    function editData(id){
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{ url('/teacher/edit') }}"+'/'+id,
            success:function (data){
                $('#id').val(data.id);
                $('#name').val(data.name);
                $('#email').val(data.email);
                $('#phone').val(data.phone);
                $('#description').val(data.description);

                $('#myModal').modal('show').find('.modal-title').text('Teacher Update');
                $('#addBtn').hide();
                $('#updateBtn').show();

            }
        })
    }
    function updateData(){
        $.ajax({
            type: "POST",
            url: "{{ url('teacher/update') }}",
            dataType: "json",
            data: allData(),
            success:function(data){
                console.log(data);
                getData();
                clearData();
                $('#myModal').modal('hide').find('.text-danger').html('');
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    type: 'success',
                    title: 'Data Update Successfully.',
                    showConfirmButton: false,
                    timer: 5000
                })
            },
            error:function (error){
                $('#nameError').text(error.responseJSON.errors.name);
                $('#emailError').text(error.responseJSON.errors.email);
                $('#phoneError').text(error.responseJSON.errors.phone);


            }
        })
    }
    function deleteData(id){
        $.ajax({
            type: "DELETE",
            url: "{{ url('teacher/delete') }}"+'/'+id,
            dataType: "json",
            data: allData(),
            success:function (data){
            console.log(data);
                getData();
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    type: 'success',
                    title: 'Data Delete Successfully.',
                    showConfirmButton: false,
                    timer: 5000
                })
            }
        })
    }
</script>
</body>
</html>
