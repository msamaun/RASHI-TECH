<div class="modal animated zoomIn" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Customer</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Post Title *</label>
                                <input type="text" class="form-control" id="postTitleUpdate">

                                <label class="form-label">Post Description *</label>
                                <input type="text" class="form-control" id="postDescriptionUpdate">

                                <br/>
                                <img class="w-15" id="oldLmg" src="{{asset('images/icon.svg')}}">
                                <br/>

                                <label class="form-label">Product Image *</label>
                                <input oninput="oldLmg.src=window.URL.createObjectURL(this.files[0])" type="file" class="form-control" id="productImageUpdate">

                                <label class="form-label">Status *</label>
                                <select class="form-select" id="status">
                                    <option value="0">Active</option>
                                    <option value="1">Inactive</option>
                                </select>

                                <input type="text" class="d-none" id="updateID">
                                <input type="text" class="d-none" id="oldImage">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="update-modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="Update()" id="update-btn" class="btn bg-gradient-success" >Update</button>
            </div>
        </div>
    </div>
</div>

<script>

    async function FillUpUpdateForm(id,filePath){
        document.getElementById("updateID").value = id;
        document.getElementById("oldImage").value = filePath;

        showLoader();
        const response = await axios.post("/post-by-id",{id:id},HeaderToken());
        hideLoader();

        document.getElementById("postTitleUpdate").value =response.data['data']['title'];
        document.getElementById("postDescriptionUpdate").value =response.data['data']['body'];
        document.getElementById("status").value =response.data['data']['status'];

    }

    async function Update()
    {
        let PostTitleUpdate=document.getElementById('postTitleUpdate').value
        let PostDescriptionUpdate=document.getElementById('postDescriptionUpdate').value
        let PostStatusUpdate=document.getElementById('status').value
        let PostImageUpdate=document.getElementById('productImageUpdate').files[0]

        let oldLmg=document.getElementById('updateID').value
        let oldImage=document.getElementById('oldImage').value
        document.getElementById('update-modal-close').click();

        let formData = new FormData();
        formData.append('title',PostTitleUpdate)
        formData.append('body',PostDescriptionUpdate)
        formData.append('status',PostStatusUpdate)
        formData.append('image',PostImageUpdate)
        formData.append('id',oldLmg)
        formData.append('file_path',oldImage)






        const config = {
            headers: {
                'content-type': 'multipart/form-data',
                Authorization:getToken()
            }
        }
        showLoader();
        let res = await axios.post("/update_post",formData,config)
        hideLoader();

        if (res.status === 200 && res.data === 1) {
            successToast("Product Update Successfully");
            document.getElementById('update-form').reset();
            await getList();
        }
        else {
            errorToast("Failed To Update Product");
        }

    }
</script>


