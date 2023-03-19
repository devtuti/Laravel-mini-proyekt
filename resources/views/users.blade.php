@extends('layouts.layouts')
@section('title')
    Users
@endsection

@section('css')
@endsection


@section('content')
    <div class="container">
        <div class="card">
            <h3 align="center">Users search</h3>
        </div><br>
        <div class="card-body">
            <input type="text" name="search" id="search" class="form-control" placeholder="Search"><br>

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal" data-bs-whatever="@getbootstrap">Add</button><br>
      
            <ul class="list-group list-group-flush" id="erorrs">

            </ul>
         

            <div class="table-responsive">
               {{-- demeli id clas yox data-control ile işlemeye öyreşsen zor --}}
                <h3 align="center">Total: <span data-control="total-records">{{$total ?? ""}}</span></h3>
                
                    <div data-control="user-table">
                        @include('user_table')
                    </div>
                    @isset($users)
                    {!! $users->links() !!}
        
                    @endisset
                    
            </div>

            <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addUserLabel">New customer</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            <form>
                @csrf
                <div class="modal-body">
                    
                    <div class="mb-3">
                        <label for="name" class="col-form-label">Name:</label>
                        <input type="text" class="form-control" id="name">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="col-form-label">Email:</label>
                        <input type="email" class="form-control" id="email">
                    </div>
                    <div class="mb-3">
                        <label for="gender" class="col-form-label">Gender:</label><br>
                        <input type="radio" id="gender" value="0">Male <br>
                        <input type="radio" id="gender" value="1">Female
                    </div>
                    <div class="mb-3">
                        <label for="address" class="col-form-label">Address:</label>
                        <textarea class="form-control" id="address"></textarea>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" data-control="add-user">User Add</button>
                </div>
                
                </div>
            </form>
            </div>
            </div>
            @include('user_edit')

        </div>
    </div>
    
@endsection

@section('js')

<script>
    


$(document).ready(function(){

      
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      //ADD USER

    const $addUser = $('#addUserModal');
      $(document).on('click','[data-control="add-user"]', function(){
           
            var data = {
                name:  $addUser.find('#name').val(),
                email: $addUser.find('#email').val(),
                gender:$addUser.find('#gender:checked').val(),
                address: $addUser.find('#address').val()
            }
    
            $.ajax({
                url: "{{route('user.post')}}",
                method: "POST",
                data:data,
                dataType:'json', 
                success:function(radd){
                    var err= ''
                    if(radd.success){
                        Swal.fire({
                            icon: 'success',
                            title: 'Good luck...',
                            text: radd.success
                            
                        })
                    }else{
                        $.each(radd.errors.name, function(key, message){
                                err = err + '<li class="alert alert-warning py-1">'+message+'</li>'
                            });
                            $.each(radd.errors.email, function(key, message){
                                err = err + '<li class="alert alert-warning py-1">'+message+'</li>'
                            });
                            $.each(radd.errors.gender, function(key, message){
                                err = err + '<li class="alert alert-warning py-1">'+message+'</li>'
                            });
                            $.each(radd.errors.address, function(key, message){
                                err = err + '<li class="alert alert-warning py-1">'+message+'</li>'
                            });
                        
                        $("#erorrs").html(err);
                    }
                    $addUser.modal('hide');
                    fetch_users();
                    //console.log(radd);
                }
                
            });
        });


        
         // LIST
        function fetch_users(query=''){
            $.ajax({
                url:"{{route('user_search.action')}}",
                method:'GET',
                data:{query:query},
                dataType: 'json',
                success:function(rsearch){

                    if(rsearch.blade !== undefined){
                        
                        $('[data-control="user-table"]').html(rsearch.blade);
             
                    }
                    if (rsearch.total !== undefined){
                        $('[data-control="total-records"]').html(rsearch.total)
                    }
                }
            });
        }

        //SEARCH

        $(document).on('keyup','#search', function(){
            var query = $(this).val();
            fetch_users(query);
        });


        // EDIT SHOW
        const $user_edit_modal = $('#userEditModal');

        $(document).on('click','[data-contr="user-edit"]'  , function(){
            // console.log("tuk tuk",$(this).data('id')); 
            $.ajax({
                url: "{{route('user.show')}}",
                type: 'GET',
                dataType: 'json',
                data: {user_id:$(this).data('id')},
                success: function(res){
                    //console.log(res);
                    if(res.user !== undefined){
                        $user_edit_modal.find('#id').val(res.user.id)
                        $user_edit_modal.find('#name').val(res.user.name)
                        $user_edit_modal.find('#email').val(res.user.email)
                        $user_edit_modal.find('#address').val(res.user.address)
                        if ( res.user.gender == 1) 
                            $user_edit_modal.find('#gender_female').attr('checked',true)
                        else
                            $user_edit_modal.find('#gender_male').attr('checked',true)
                       
                    }
                    $user_edit_modal.modal('show')
                }
            });
        })
        

        // UPDATE
        $(document).on('click','[data-control="update-user-button"]'  , function(){
                //console.log("tok tuk", $user_edit_modal.find('#name').val());
                var data = {
                    name:$user_edit_modal.find('#name').val(),
                    email:$user_edit_modal.find('#email').val(),
                    gender:$user_edit_modal.find('input:radio:checked').val(),
                    address:$user_edit_modal.find('#address').val(),
                    id:$user_edit_modal.find('#id').val(),
                
                }
               
            $.ajax({
                url: "{{route('user.update')}}",
                method: "POST",
                data:data,
                dataType:'json', 
                success:function(response){
                    var err= ''
                    $user_edit_modal.modal('hide')
                    if(response.success){
                        Swal.fire({
                        icon: 'success',
                        title: 'Good luck...',
                        text: response.success
                        
                                })
                    }else{
                       
                            $.each(response.errors.name, function(key, message){
                                err = err + '<li class="alert alert-warning py-1">'+message+'</li>'
                            });
                            $.each(response.errors.email, function(key, message){
                                err = err + '<li class="alert alert-warning py-1">'+message+'</li>'
                            });
                            $.each(response.errors.gender, function(key, message){
                                err = err + '<li class="alert alert-warning py-1">'+message+'</li>'
                            });
                            $.each(response.errors.address, function(key, message){
                                err = err + '<li class="alert alert-warning py-1">'+message+'</li>'
                            });
                        
                        $("#erorrs").html(err);
                    }
                    
                    fetch_users();
                    //console.log(response.errors);
                }
                
            });
        })

        // DELETE

        $(document).on('click','[data-contr="user-del"]', function(){
            //console.log($(this).data('id'));
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to delete?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{route('user.del')}}",
                        type : 'GET',
                        dataType: 'json',
                        data: {user_id:$(this).data('id')},
                        success: function(res){
                           /* Swal.fire({
                                icon: 'success',
                                title: 'Good luck...',
                                text: res.success*/
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                )
                            fetch_users();
                        }
                    })
                    
                }
            })       
               
        })
    });
   
       
       
</script>
@endsection
