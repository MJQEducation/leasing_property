<div class="modal fade" id="exitClearanceCheckListRemarkBaseModal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary-700">
                <h5 class="modal-title">Remark</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="js-summernote" id="check_list_remark" data-check-list-id=''></div>
                {{-- <div class="mt-3">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="autoSave" checked="checked">
                        <label class="custom-control-label" for="autoSave">Autosave changes to LocalStorage <span
                                class="fw-300">(every 3 seconds)</span></label>
                    </div>
                </div> --}}

            </div>

            <div class="modal-header bg-primary-700">
                <div class="row w-100" style="display:flex;flex-direction:row;justify-content:flex-end;">
                    <button onclick="saveRemark()" type="button" class="btn btn-success">
                        Save
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
    // var autoSave = $('#autoSave');
    // var interval;
    // var timer = function() {
    //     interval = setInterval(function() {
    //         //start slide...
    //         if (autoSave.prop('checked'))
    //             saveToLocal();

    //         clearInterval(interval);
    //     }, 3000);
    // };

    // //save
    // var saveToLocal = function() {
    //     localStorage.setItem('summernoteData', $('#saveToLocal').summernote("code"));
    //     console.log("saved");
    // }

    // //delete
    // var removeFromLocal = function() {
    //     localStorage.removeItem("summernoteData");
    //     $('#saveToLocal').summernote('reset');
    // }

    $(document).ready(function() {
        //init default
        $('.js-summernote').summernote({
            height: 200,
            tabsize: 2,
            placeholder: "",
            dialogsFade: true,
            toolbar: [
                ['style', ['style']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
                ['table', ['table']],
                ['insert', ['link']], //['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            callbacks: {
                //restore from localStorage
                onInit: function(e) {
                    //$('.js-summernote').summernote("code", localStorage.getItem("summernoteData"));
                },
                // onChange: function(contents, $editable) {
                //     clearInterval(interval);
                //     timer();
                // }
            }
        });

        //load emojis
        $.ajax({
            url: 'https://api.github.com/emojis',
            async: false
        }).then(function(data) {
            window.emojis = Object.keys(data);
            window.emojiUrls = data;
        });

        //init emoji example
        $(".js-hint2emoji").summernote({
            height: 100,
            toolbar: false,
            placeholder: 'type starting with : and any alphabet',
            hint: {
                match: /:([\-+\w]+)$/,
                search: function(keyword, callback) {
                    callback($.grep(emojis, function(item) {
                        return item.indexOf(keyword) === 0;
                    }));
                },
                template: function(item) {
                    var content = emojiUrls[item];
                    return '<img src="' + content + '" width="20" /> :' + item + ':';
                },
                content: function(item) {
                    var url = emojiUrls[item];
                    if (url) {
                        return $('<img />').attr('src', url).css('width', 20)[0];
                    }
                    return '';
                }
            }
        });

        //init mentions example
        $(".js-hint2mention").summernote({
            height: 100,
            toolbar: false,
            placeholder: "type starting with @",
            hint: {
                mentions: ['jayden', 'sam', 'alvin', 'david'],
                match: /\B@(\w*)$/,
                search: function(keyword, callback) {
                    callback($.grep(this.mentions, function(item) {
                        return item.indexOf(keyword) == 0;
                    }));
                },
                content: function(item) {
                    return '@' + item;
                }
            }
        });

    });
</script>
