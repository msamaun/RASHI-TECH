@extends('admin.layouts.sidenav-layout')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card animated fadeIn w-100 p-3">
                    <div class="card-body">
                        <h4>User Profile</h4>
                        <hr/>
                        <div class="container-fluid m-0 p-0">
                            <div class="row m-0 p-0">
                                <div class="col-12 p-2">
                                    <label>Email Address</label>
                                    <input readonly id="email" placeholder="User Email" class="form-control" type="email"/>
                                </div>
                                <div class="col-12 p-2">
                                    <label>First Name</label>
                                    <input id="firstName" placeholder="First Name" class="form-control" type="text"/>
                                </div>
                                <div class="col-12 p-2">
                                    <label>Last Name</label>
                                    <input id="lastName" placeholder="Last Name" class="form-control" type="text"/>
                                </div>
                                <div class="col-12 p-2">
                                    <label>Mobile Number</label>
                                    <input id="mobile" placeholder="Mobile" class="form-control" type="mobile"/>
                                </div>


                            </div>
                            <div class="row m-0 p-0">
                                <div class="col-md-4 p-2">
                                    <button onclick="onUpdate()" class="btn mt-3 w-100  bg-gradient-primary">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        getProfile();
        async function getProfile(){
            try{
                let res = await axios.get('/user_profile',HeaderToken());
                document.getElementById('email').value=res.data.email;
                document.getElementById('firstName').value=res.data.first_name;
                document.getElementById('lastName').value=res.data.last_name;
                document.getElementById('mobile').value=res.data.mobile;
                document.getElementById('profileImage').src=res.data.image;

            }
            catch(e){
                unauthorized(e.response)
            }
        }

        async function onUpdate(){
            let PostData = {
                first_name:document.getElementById('firstName').value,
                last_name:document.getElementById('lastName').value,
                mobile:document.getElementById('mobile').value,
            };



            showLoader()
            let res = await axios.post('/user_update_profile',PostData,HeaderToken());
            if(res.data['status']==="success"){
                successToast(res.data['message']);
                getProfile();
            }
            else{
                errorToast(res.data['message']);

            }
            await getProfile();
            hideLoader()

        }

        async function onLogout() {
            showLoader();
            try {
                await axios.post('/logout', {}, HeaderToken());
                successToast("Logout successful");
                // Redirect or perform other actions after logout
            } catch (error) {
                console.error("Logout error:", error);
                errorToast("Error during logout");
            } finally {
                hideLoader();
            }
        }

    </script>
@endsection



