<?php
$fileUrl = url("exit_clearance/$storePath");
?>
<div class="modal fade" id="exitClearanceApprovalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary-700">
                <h5 class="modal-title">Lease Management</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <iframe id='exitClearancePDFView' src="" title='webviewer' frameborder='0' width='100%'
                    height='600'>
                </iframe>
            </div>
            <div class="modal-header bg-primary-700">
                <div class="row w-100" style="display:flex;flex-direction:row;justify-content:flex-end;">
                    <button onclick="exitClearanceApprove({{ $signature_id }})" type="button" class="btn btn-success">
                        {{ $action }}
                    </button>

                    &nbsp;&nbsp;
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        const url = "{{ asset('plugin/js/pdfjs-3.9.179-dist/web/viewer.html?file=') }}";
        const clearance_id = "{{ $exit_id }}";
        const src = "{{ $fileUrl }}";
        const iframe = document.getElementById('exitClearancePDFView');
        iframe.onload = () => {
            iframe.contentWindow.PDFViewerApplication.open({
                url: src,
                originalUrl: `exit_clearance_${clearance_id}.pdf`,
            });
        }
        iframe.src = `${url}`;
    });

    var exitClearanceApprove = async (signatureId) => {
        let result = await conditionSWAlert("Do you want to {{ $action }} this clearance", "question",
            "Yes {{ $action }}!");
        if (!result) {
            return;
        }

        blockagePage("{{ $action }} ...");

        let postData = {
            signatureId,
            action: "{{ $action }}",
            exit_id: {{ $exit_id }},
        }

        let response = await sendAsyncData("{{ url('api/Social/saveApprove') }}", postData, true);

        getMyNotification();

        $("#exitClearanceApprovalModal").modal('hide');

        unblockagePage();
    }
</script>
