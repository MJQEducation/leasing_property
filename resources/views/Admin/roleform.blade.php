<div class="modal fade" id="roleformModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="roleFormLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="" id="roleform">
                    @csrf
                    <!--create token-->

                    <div class="form-group row">
                        <label for="name" class="col-sm-4 col-form-label">Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="name" name='name'
                                autocomplete="off" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="isAdmin" class="col-sm-4 col-form-label">isAdmin</label>
                        <div class="col-sm-8">
                            <label class="switch"><input type="checkbox" id="is_admin"><span
                                    class="slider round"></span></label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="description" class="col-sm-4 col-form-label">Description</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="description" name='description'
                                autocomplete="off" />
                        </div>
                    </div>

                    <input type="hidden" class="form-control" id="id" name='id' />
                    <br /><br />
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="saverole()">Save</button>
            </div>
        </div>
    </div>
</div>
