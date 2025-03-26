<div class="modal fade" id="layoutresetPasswordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="layoutresetPasswordLabel">Change My Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="" id="layoutresetPasswordform">
                    @csrf
                    <!--create token-->
                    <div class="form-group row">
                        <label for="password" class="col-sm-4 col-form-label">Current Password</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="currentpassword" name='currentpassword'
                                autocomplete="off" required />

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-sm-4 col-form-label">New Password</label>
                        <div class="col-sm-8">
                            <input onkeyup="passwordCheck(event)" type="password" class="form-control" id="newpassword"
                                name='newpassword' autocomplete="off" required />
                            <span class="badge badge-danger badge-pill" id='StrengthDisp'>Weak</span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                        class="ni ni-close"></i>&nbsp;CLOSE</button>
                <button type="button" class="btn btn-primary" onclick="layoutresetPassword()"><i
                        class="fal fa-save"></i>&nbsp;SAVE</button>
            </div>
        </div>
    </div>
</div>

<script>
    var layoutresetPassword = () => {
        let currentpassword = $("#layoutresetPasswordform #currentpassword").val();
        let newpassword = $("#layoutresetPasswordform #newpassword").val();

        //Strong patern
        let strongPassword = new RegExp('(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{8,})');

        //Medium patern
        let mediumPassword = new RegExp(
            '((?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{6,}))|((?=.*[a-z])(?=.*[A-Z])(?=.*[^A-Za-z0-9])(?=.{8,}))'
        );


        if (!(mediumPassword.test(newpassword) || strongPassword.test(newpassword))) {
            Msg("Password must have 6 character and sign, Must pass (Medium Patern)", "error");
            return;
        }

        if (currentpassword == "") {
            Msg("Current Password is Require!!", "error");
            return;
        }

        if (newpassword == "") {
            Msg("New Password is Require!!", "error");
            return;
        }

        console.log(newpassword);

        $.ajax({
            url: "{{ url('api/resetPassword') }}",
            type: "POST",
            data: {
                _token: formToken,
                currentpassword: currentpassword,
                newpassword: newpassword,
            },
            beforeSend: function(xhr) {
                blockagePage('Please Wait...');
                xhr.setRequestHeader('Authorization', 'Bearer ' + AuthToken);
            },
            success: function(response) {
                if (response.result == "error") {
                    sweetToast(response.msg, response.result);
                    unblockagePage();
                    return;
                }

                sweetToast(response.msg, response.result);
                $("#layoutresetPasswordModal").modal("hide");

                unblockagePage();
            },
            error: function(e) {
                if (e.status = 401) //unauthenticate not login
                {
                    Msg('Error While Reset Password', 'error');
                }

                unblockagePage();
            }
        });
    }

    var passwordCheck = (event) => {
        let password = event.target.value;
        let strengthBadge = document.getElementById('StrengthDisp');
        let strongPassword = new RegExp('(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{8,})');
        let mediumPassword = new RegExp(
            '((?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{6,}))|((?=.*[a-z])(?=.*[A-Z])(?=.*[^A-Za-z0-9])(?=.{8,}))'
        );

        while (strengthBadge.classList.length > 0) {
            strengthBadge.classList.remove(strengthBadge.classList.item(0));
        }

        if (strongPassword.test(password)) {
            strengthBadge.classList.add("badge");
            strengthBadge.classList.add("badge-primary");
            strengthBadge.classList.add("badge-pill");
            strengthBadge.textContent = 'Strong';
        } else if (mediumPassword.test(password)) {
            strengthBadge.classList.add("badge");
            strengthBadge.classList.add("badge-info");
            strengthBadge.classList.add("badge-pill");
            strengthBadge.textContent = 'Medium';
        } else {
            strengthBadge.classList.add("badge");
            strengthBadge.classList.add("badge-danger");
            strengthBadge.classList.add("badge-pill");
            strengthBadge.textContent = 'Weak';
        }
    }
</script>
