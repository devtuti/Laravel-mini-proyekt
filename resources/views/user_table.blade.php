@isset($users)
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Gender</th>
            <th>Address</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
    <tr>
        <td>{{$user->name ?? ""}}</td>
        <td>{{$user->email ?? ""}}</td>
        <td>
            @if($user->gender==0)
                Male
            @else
                Female
            @endif
        </td>
        <td>{{$user->address ?? ""}}</td>
        <td>
            
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-success" data-id="{{$user->id}}" data-contr="user-edit">
                Edit
            </button>
            <button type="button" class="btn btn-danger" data-id="{{$user->id}}" data-contr="user-del">
                Del
            </button>
            
        </td>
    </tr>
        @endforeach
    </tbody>
</table>

@endisset
