<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between ">
                    <div class="align-items-center col">
                        <h4>Post List</h4>
                    </div>
                    <div class="align-items-center col">
                        <button data-bs-toggle="modal" data-bs-target="#create-modal" class="float-end btn m-0 bg-gradient-primary">Create</button>
                    </div>
                </div>
                <hr class="bg-secondary"/>
                <div class="card col-3 ">

                     <label for="search">Start Date</label>
                      <input type="date" id="FormDate" class="form-control"/>


                      <label for="search">Start Date</label>
                      <input type="date" id="ToDate" class="form-control"/>

                    <button onclick="postFilter()" class="btn mt-3 bg-gradient-primary">Download</button>
                </div>
                <div class="table-responsive">
                    <table class="table" id="tableData">
                        <thead>
                        <tr class="bg-light">
                            <th>No</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody id="tableList">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    getList();

    async function getList() {

        try {
            showLoader();
            let res=await axios.get("/posts_list",HeaderToken());
            hideLoader();


            let tableList=$("#tableList");
            let tableData=$("#tableData");

            tableData.DataTable().destroy();
            tableList.empty();


            res.data['data'].forEach(function (item,index) {
                let row=`<tr>
                    <td>${index+1}</td>
                    <td><img class="w-25" src="${item['image']}"/></td>
                    <td>${item['title'].substring(0,10)+'...'}</td>
                    <td>${item['body'].substring(0,60)+'...'}</td>
                    <td><span class="badge bg-${item['status'] == 0 ? 'success' : 'danger'}">${item['status'] == 0 ? 'Active' : 'Inactive'}</span></td>
                    <td>
                        <button data-id="${item['id']}" class="btn editBtn btn-sm btn-outline-success">Edit</button>
                        <button data-id="${item['id']}" class="btn deleteBtn btn-sm btn-outline-danger">Delete</button>
                    </td>
                 </tr>`
                tableList.append(row)
            })

            $('.editBtn').on('click', async function () {
                let id= $(this).data('id');
                await FillUpUpdateForm(id)
                $("#update-modal").modal('show');
            })

            $('.deleteBtn').on('click',function () {
                let id= $(this).data('id');
                $("#delete-modal").modal('show');
                $("#deleteID").val(id);
            })

            new DataTable('#tableData',{
                order:[[0,'desc']],
                lengthMenu:[5,10,15,20,30]
            });

        }
        catch (e) {
            unauthorized(e)
        }

    }
    async function postFilter() {
        let FormDate = document.getElementById('FormDate').value;
        let ToDate = document.getElementById('ToDate').value;

        if(FormDate === 0 || ToDate === 0){
            errorToast('Please Select Date');
        }
        else{
            let response = await axios.get(`/post_filter/${FormDate}/${ToDate}`,HeaderToken());

            let tableList=$("#tableList");
            let tableData=$("#tableData");

            tableData.DataTable().destroy();
            tableList.empty();


            response.data.data['post'].forEach(function (item,index) {
                let data=`<tr>
                    <td>${index+1}</td>
                    <td><img class="w-25" src="${item['image']}"/></td>
                    <td>${item['title'].substring(0,10)+'...'}</td>
                    <td>${item['body'].substring(0,60)+'...'}</td>
                    <td><span class="badge bg-${item['status'] == 0 ? 'success' : 'danger'}">${item['status'] == 0 ? 'Active' : 'Inactive'}</span></td>
                    <td>
                        <button data-id="${item['id']}" class="btn editBtn btn-sm btn-outline-success">Edit</button>
                        <button data-id="${item['id']}" class="btn deleteBtn btn-sm btn-outline-danger">Delete</button>
                    </td>
                 </tr>`
                tableList.append(data)
            })




        }
    }


</script>

