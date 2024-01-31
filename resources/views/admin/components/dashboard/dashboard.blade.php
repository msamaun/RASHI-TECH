@extends('admin.layouts.sidenav-layout')
@section('content')
    <div class="container-fluid">
        <div class="row "  >

            <div class="col-4  animated fadeIn p-2">
                <div class="card card-plain h-100 bg-white">
                    <div class="p-3">
                        <div class="row">
                            <div class="col-9 col-lg-8 col-md-8 col-sm-9">
                                <div>
                                    <h5 class="mb-0 text-capitalize font-weight-bold">
                                        <span id="post"></span>
                                    </h5>
                                    <p class="mb-0 text-sm bold">Total Post</p>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4 col-md-4 col-sm-3 text-end">
                                <div class="icon icon-shape bg-my-primary shadow float-end border-radius-md">
                                    <img class="w-100 " src="{{asset('images/posts.png')}}"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-4 animated fadeIn p-2">
                <div class="card card-plain h-100 bg-white">
                    <div class="p-3">
                        <div class="row">
                            <div class="col-9 col-lg-8 col-md-8 col-sm-9">
                                <div>
                                    <h5 class="mb-0 text-capitalize font-weight-bold">
                                        <span id="active"></span>
                                    </h5>
                                    <p class="mb-0 text-sm">Active Post</p>
                                </div>
                            </div>
                            <div class="col-3 col-lg-4 col-md-4 col-sm-3 text-end">
                                <div class="icon icon-shape bg-my-primary shadow float-end border-radius-md">
                                    <img class="w-100 " src="{{asset('images/active.png')}}"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-4 animated fadeIn p-2">
                <div class="card card-plain h-100 bg-white">
                    <div class="p-3">
                        <div class="row">
                            <div class="col-9 col-lg-8 col-md-8 col-sm-9">
                                <div>
                                    <h5 class="mb-0 text-capitalize font-weight-bold">
                                        <span id="inactive"></span>
                                    </h5>
                                    <p class="mb-0 text-sm">Inactive Post</p>
                                </div>
                            </div>
                            <div class="col-3 col-lg-4 col-md-4 col-sm-3 text-end">
                                <div class="icon icon-shape bg-my-primary float-end border-radius-md">
                                    <img class="w-100 " src="{{asset('images/inactive.png')}}"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>




    <script>
        getList();
        async function getList() {
            showLoader();
            let res=await axios.get('/dashboard_list',HeaderToken());

            document.getElementById('post').innerText=res.data['posts']
            document.getElementById('active').innerText=res.data['active']
            document.getElementById('inactive').innerText=res.data['inactive']


            hideLoader();
        }
    </script>
@endsection

