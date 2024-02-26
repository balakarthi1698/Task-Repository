@include('header')

<div class="container">
    <h4>User Profile</h4>
    <form>
    <div class="form-group row">
        <label for="inputName" class="col-sm-2 col-form-label">Firstname</label>
        <div class="col-sm-8">
        <input type="text" class="form-control" id="inputName" placeholder="Name" value="{{$user->first_name}}">
        </div>
    </div>
    <div class="form-group row">
        <label for="inputDesc" class="col-sm-2 col-form-label">Lastname</label>
        <div class="col-sm-8">
        <input type="text" class="form-control" id="inputDesc" placeholder="Description" value="{{$user->last_name}}">
        </div>
    </div>
    <div class="form-group row">
        <label for="inputName" class="col-sm-2 col-form-label">Email</label>
        <div class="col-sm-8">
        <input type="text" class="form-control" id="inputName" placeholder="Name" value="{{$user->email}}">
        </div>
    </div>
    <div class="form-group row">
        <label for="inputName" class="col-sm-2 col-form-label">Password</label>
        <div class="col-sm-8">
        <input type="text" class="form-control" id="inputName">
        </div>
    </div>
    <div class="form-group row">
        <label for="inputName" class="col-sm-2 col-form-label">Gender</label>
        <div class="col-sm-8">
            <select id="gender" name="gender" class="form-control">
                <option selected value="">Choose...</option>
                <option @if($user->gender=='Male') selected @endif value="Male">Male</option>
                <option @if($user->gender=='Female') selected @endif value="Female">Female</option>
                <option @if($user->gender=='Transgender') selected @endif value="Transgender">Transgender</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="inputName" class="col-sm-2 col-form-label">Phone</label>
        <div class="col-sm-8">
        <input type="text" class="form-control" id="inputName" placeholder="Name" value="{{$user->phone}}">
        </div>
    </div>
    <div class="form-group row">
        <label for="inputName" class="col-sm-2 col-form-label">Address</label>
        <div class="col-sm-8">
        <input type="text" class="form-control" id="inputName" placeholder="Name" value="{{$user->address}}">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
        <button type="submit" class="btn btn-primary" disabled>Save</button>
        </div>
    </div>
    </form>
</div>
