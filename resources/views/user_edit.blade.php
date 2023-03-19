
<div class="modal fade" id="userEditModal" tabindex="-1" aria-labelledby="userEditModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="userEditModalLabel">Customer edit</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        
        <form data-control="user-update-form">
            @csrf
            <input type="hidden" id="id" name="id" value="{{$user->id ?? ""}}">
        <div class="modal-body">
            <div class="mb-3">
                <label for="name" class="col-form-label">Name:</label>
                <input type="text" class="form-control" id="name" value="{{$user->name ?? ""}}">
            </div>
            <div class="mb-3">
                <label for="email" class="col-form-label">Email:</label>
                <input type="email" class="form-control" id="email" value="{{$user->email ?? ""}}">
            </div>
            <div class="mb-3">
                   
                    <input type="radio" id="gender_male" name="gender" value="0">Male               
            </div>
            <div class="mb-3">
                    
                    <input type="radio" id="gender_female" name="gender" value="1">Female
                
            </div>
            <div class="mb-3">
                <label for="address" class="col-form-label">Address:</label>
                <textarea class="form-control" id="address">{{$user->address ?? ""}}</textarea>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" data-control="update-user-button" class="btn btn-primary">Save changes</button>
        </div>
    </form>
      </div>
    </div>
  </div>