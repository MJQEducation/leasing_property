<div class="col-xl-12">
    <div id="panel-1" class="panel">
        <div class="panel-hdr">
            <h2>
                Exit <span class="fw-300"><i>List</i></span>
            </h2>
            <div class="panel-toolbar">
                <button class="btn btn-primary btn-sm waves-effect waves-themed" onclick="pushDeactivate()">Push to
                    Deactivate</button>
            </div>
        </div>
        <div class="panel-container show">
            <div class="panel-content">
                <!-- datatable start -->
                <table id="exitClearanceList" class="table table-bordered table-hover table-striped w-100"
                    style="font-size: 12px;border:1px solid #eee;">

                    <thead>
                        <tr>
                            <th style="text-align:center!important">Id</th>
                            <!--0-->
                            <th style="text-align:center!important">Hired Date</th>
                            <!--1-->
                            <th style="text-align:center!important">Last Date</th>
                            <!--2-->
                            <th style="text-align:center!important">Card ID</th>
                            <!--3-->
                            <th style="text-align:center!important">Name</th>
                            <!--4-->
                            <th style="text-align:center!important">Position</th>
                            <!--5-->
                            <th style="text-align:center!important">Department</th>
                            <!--6-->
                            <th style="text-align:center!important">Status</th>
                            <!--7-->
                            <th style="text-align:center!important">Action</th>
                            <!--8-->
                        </tr>
                    </thead>
                    <tbody style="border:1px solid #eee;"></tbody>
                </table>
                <!-- datatable end -->
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(async function() {

    });

    var pushDeactivate = async () => {
        let data = await sendAsyncData('{{ url('api/pushexit/pushDeactivate') }}', {}, false);

        console.log(data)
    }
</script>
