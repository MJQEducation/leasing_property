<div class="modal fade" id="mvlformModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mvlFormLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="" id="mvlform">
                    <div class="form-group row">
                        <label for="abbreviation" class="col-sm-4 col-form-label">Abbreviation</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="abbreviation" name='abbreviation'
                                autocomplete="off" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="nameEn" class="col-sm-4 col-form-label">Name En</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="name_en" name='name_en'
                                autocomplete="off" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="nameKh" class="col-sm-4 col-form-label">Name Kh</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="name_kh" name='name_kh'
                                autocomplete="off" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="type" class="col-sm-4 col-form-label">Type</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="type" name='type'>

                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="parent_mvl" class="col-sm-4 col-form-label">Parent MVL</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="parent_mvl" name='parent_mvl'>

                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="ordinal" class="col-sm-4 col-form-label">Ordinal</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="ordinal" name='ordinal'
                                onkeypress='return event.charCode >= 48 && event.charCode <= 57' autocomplete="off" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="value" class="col-sm-4 col-form-label">Value</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="value" name='value'
                                autocomplete="off" />
                        </div>
                    </div>

                    <input type="hidden" class="form-control" id="id" name='id' />
                    <br /><br />
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="saveMVL()">Save</button>
            </div>
        </div>
    </div>
</div>
