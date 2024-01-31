<div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Create Category</h6>
            </div>
            <div class="modal-body">
                <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Post Title *</label>
                                <input type="text" class="form-control" id="post-title">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label">Post Description *</label>
                                <input type="text" class="form-control" id="post-description">
                            </div>
                            <label class="form-label">Product Image *</label>
                            <input oninput="newLmg.src=window.URL.createObjectURL(this.files[0])" type="file" class="form-control" id="post-image">

                            <div class="col-12 p-1">
                                <label class="form-label">Post Status *</label>
                                <select class="form-select" id="post-status">
                                    <option value="0">Active</option>
                                    <option value="1">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="Save()" id="save-btn" class="btn bg-gradient-success" >Save</button>
            </div>
        </div>
    </div>
</div>


<script>
    async function Save() {
        try
        {
            let postTitle=document.getElementById('post-title').value
            let postDescription=document.getElementById('post-description').value
            let postImage=document.getElementById('post-image').files[0]
            let postStatus=document.getElementById('post-status').value

            document.getElementById('modal-close').click();

            let formData = new FormData();
            formData.append('title',postTitle);
            formData.append('body',postDescription);
            formData.append('image',postImage);
            formData.append('status',postStatus);

           const config = {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    Authorization:getToken()
                }
            }
            showLoader()
            let res=await axios.post('/create_post',formData,config);
            hideLoader()

            if(res.data['status']==="success"){
                successToast(res.data['message']);
                document.getElementById('save-form').reset();
                await getList();
            }
        }
        catch (e) {
            unauthorized(e.response.status)
        }
    }
</script>
