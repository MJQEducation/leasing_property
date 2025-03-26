<div class="modal fade" id="userFormModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userFormLabel">New User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="" id="userForm">
                    @csrf
                    <!--create token-->
                    <div class="form-group row">
                        <label for="card_id" class="col-sm-4 col-form-label">Card ID</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="card_id" name='card_id'
                                autocomplete="off" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-sm-4 col-form-label">Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="name" name='name'
                                autocomplete="off" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="username" class="col-sm-4 col-form-label">User Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="username" name='username'
                                autocomplete="off" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="position" class="col-sm-4 col-form-label">Position</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="position" name='position' autocomplete="off"
                                maxlength="99" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-sm-4 col-form-label">Email</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="email" name='email'
                                autocomplete="off" />
                        </div>
                    </div>

                    <input type="hidden" class="form-control" id="id" name='id' />
                    <br /><br />
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="saveUser()">Save</button>
            </div>
        </div>
    </div>
</div>
