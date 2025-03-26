<?php
$fileUrl = url("exit_clearance/$storePath");
?>
<div class="modal fade" id="exitClearancePDFViewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary-700">
                <h5 class="modal-title">Exit Clearance</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <iframe id='pdf-js-viewer' src="" title='webviewer' frameborder='0' width='100%'
                    height='600'>
                </iframe>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        const url = "{{ asset('plugin/js/pdfjs-3.9.179-dist/web/viewer.html?file=') }}";
        const clearance_id = "{{ $id }}";
        const src = "{{ $fileUrl }}";
        const iframe = document.getElementById('pdf-js-viewer');
        iframe.onload = () => {
            iframe.contentWindow.PDFViewerApplication.open({
                url: src,
                originalUrl: `exit_clearance_${clearance_id}.pdf`,
            });
        }
        iframe.src = `${url}`;
    });
</script>
