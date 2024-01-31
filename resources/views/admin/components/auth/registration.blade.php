@extends('admin.layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-10 center-screen">
                <div class="card animated fadeIn w-100 p-3">
                    <div class="card-body">
                        <h4>Sign Up</h4>
                        <hr/>
                        <div class="container-fluid m-0 p-0">
                            <div class="row m-0 p-0">
                                <div class="col-md-4 p-2">
                                    <label>Email Address</label>
                                    <input id="email" placeholder="User Email" class="form-control" type="email"/>
                                </div>
                                <div class="col-md-4 p-2">
                                    <label>First Name</label>
                                    <input id="firstName" placeholder="First Name" class="form-control" type="text"/>
                                </div>
                                <div class="col-md-4 p-2">
                                    <label>Last Name</label>
                                    <input id="lastName" placeholder="Last Name" class="form-control" type="text"/>
                                </div>
                                <div class="col-md-4 p-2">
                                    <label>Password</label>
                                    <input id="password" placeholder="User Password" class="form-control" type="password"/>
                                </div>
                            </div>
                            <div class="row m-0 p-0">
                                <div class="col-md-4 p-2">
                                    <button onclick="onRegistration()" class="btn mt-3 w-100  bg-gradient-primary">Complete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        async function onRegistration() {
            let postBody={
                "first_name":document.getElementById("firstName").value,
                "last_name":document.getElementById("lastName").value,
                "email":document.getElementById("email").value,
                "password":document.getElementById("password").value
            }
            showLoader()
            let response=await axios.post("/user_registration",postBody);
            hideLoader()

            if(response.status===200 && response.data.status==="success"){
                successToast(response.data.message)
                window.location.href="/login"
            }else{
                errorToast(response.data.message)

            }
        }


    </script>
@endsection


