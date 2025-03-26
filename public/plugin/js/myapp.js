//const { property } = require("lodash");

function Msg(message, icon) {
    //info warning error success
    toastr.options = {
        closeButton: false,
        debug: false,
        newestOnTop: true,
        progressBar: true,
        positionClass: "toast-top-right",
        preventDuplicates: true,
        onclick: null,
        showDuration: 300,
        hideDuration: 100,
        timeOut: 5000,
        extendedTimeOut: 1000,
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut",
    };
    toastr[icon](message);
}

function sweetToast(message, icon) {
    //https://sweetalert2.github.io/#download
    const Toast = Swal.mixin({
        toast: true,
        position: "top",
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener("mouseenter", Swal.stopTimer);
            toast.addEventListener("mouseleave", Swal.resumeTimer);
        },
    });

    Toast.fire({
        icon: icon,
        title: message,
    });
}

String.prototype.toProperCase = function () {
    return this.replace(/\w\S*/g, function (txt) {
        return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
    });
};

function formValidation(formName) {
    var isValid = true;

    var formcontrol = $("#" + formName + " .form-control");
    $("#" + formName + " .form-control").removeClass("is-invalid");

    for (var i = 0; i < formcontrol.length; i++) {
        var element = $("#" + formName + " #" + formcontrol[i].id);
        if (
            typeof element.attr("validate-attribute") !== "undefined" &&
            element.attr("validate-attribute") !== false
        ) {
            var json = JSON.parse(element.attr("validate-attribute"));
            if (json.required == "true") {
                if (element.val() == "" || element.val() == null) {
                    element.addClass("is-invalid");
                    isValid = false;

                    console.log(element);
                }
            }
        }
    }

    return isValid;
}

const initMVLSelect2 = async (
    element,
    valuefield,
    diplayfield,
    parentModal,
    mvlType,
    url
) => {
    /*
    element = jquery select tag
    valuefield = field in json that support to go to value of option in our case could be id or nameEn
    valuefield = field in json that support to go to display in option
    parentModal = incase our element is a child in a modal
    mvlType = Type of MVL
    url = this project i create "{{ url('api/social/getSelectList') }}"
    */
    await $.ajax({
        url: url,
        type: "POST",
        data: {
            _token: formToken,
            mvlType: mvlType,
        },
        beforeSend: function (xhr) {
            blockagePage("Loading...");
            xhr.setRequestHeader("Authorization", "Bearer " + AuthToken);
        },
        success: function (response) {
            if (response.result == "error") {
                sweetToast(response.msg, response.result);
                return;
            }
            jsonData = response.data;

            var result = [];

            for (var i = 0; i < jsonData.length; i++) {
                result.push({
                    id: jsonData[i][valuefield],
                    text: jsonData[i][diplayfield],
                });
            }

            if (element.hasClass("select2-hidden-accessible")) {
                element.empty();
                if (parentModal == null) {
                    element.select2("destroy").select2({ data: result });
                } else {
                    element
                        .select2("destroy")
                        .select2({ data: result, dropdownParent: parentModal });
                }

                element.val("").trigger("change");
            } else {
                if (parentModal == null) {
                    element.select2({ data: result });
                } else {
                    element.select2({
                        data: result,
                        dropdownParent: parentModal,
                    });
                }
                element.val("").trigger("change");
            }

            unblockagePage();
        },
        error: function (e) {
            if ((e.status = 401)) {
                //unauthenticate not login
                Msg("Login is Required", "error");
            }

            unblockagePage();
        },
    });
};

function resizeImage(base64Str, maxWidth = 400, maxHeight = 350) {
    return new Promise((resolve) => {
        let img = new Image();
        img.src = base64Str;
        img.onload = () => {
            let canvas = document.createElement("canvas");
            const MAX_WIDTH = maxWidth;
            const MAX_HEIGHT = maxHeight;
            let width = img.width;
            let height = img.height;

            if (width > height) {
                if (width > MAX_WIDTH) {
                    height *= MAX_WIDTH / width;
                    width = MAX_WIDTH;
                }
            } else {
                if (height > MAX_HEIGHT) {
                    width *= MAX_HEIGHT / height;
                    height = MAX_HEIGHT;
                }
            }
            canvas.width = width;
            canvas.height = height;
            let ctx = canvas.getContext("2d");
            ctx.drawImage(img, 0, 0, width, height);
            resolve(canvas.toDataURL());
        };
    });
}

function displayPanelMenu() {
    //Disable unpermission Menu
    //In leftpanel view
    //1. Collect all link li which have access to attribute
    //2. Create json collection of permission of each link
    //3. Ajax to find if the current user have permission to these permission
    //4. After Ajax Response
    //5. Check if permission if false then display none to each data-access-to element corresponse to permission
    //6. Check link parent element if there is no drop-down available so we display none

    /*if (!appisGuardian) {
        $("#paymentportallink").prop('style', 'display:none');
    }*/

    //1. Collect all link li which have access to attribute
    var elements = $('[data-access-to!="parent"]');
    //1. Collect all link li which have access to attribute

    //2. Create json collection of permission of each link
    var permissiondata = [];
    for (var i = 0; i < elements.length; i++) {
        var accessto = elements[i].getAttribute("data-access-to");
        if (accessto != null) {
            permissiondata.push({ index: i, permission: accessto });
        }
    }
    //2. Create json collection of permission of each link

    //3. Ajax to find if the current user have permission to these permission
    $.ajax({
        url: appurladdress + "/api/social/isAccessible",
        type: "POST",
        data: {
            _token: formToken,
            permissiondata: permissiondata,
        },
        beforeSend: function (xhr) {
            blockagePage("Display Panel...");
            xhr.setRequestHeader("Authorization", "Bearer " + AuthToken);
        },
        success: function (response) {
            //4. After Ajax Response
            if (response.result == "error") {
                sweetToast(response.msg, response.result);
                return;
            }

            //5. Check if permission if false then display none to each data-access-to element corresponse to permission
            for (var i = 0; i < response.data.length; i++) {
                var coponent = $(
                    '[data-access-to="' + response.data[i].permission + '"]'
                );
                var isAccessible = response.data[i]["accessible"];

                for (var j = 0; j < coponent.length; j++) {
                    if (isAccessible == false)
                        coponent[j].style.display = "none";
                }
            }
            //5. Check if permission if false then display none to each data-access-to element corresponse to permission

            //6. Check link parent element if there is no drop-down available so we display none
            var parentli = $('[data-access-to="parent"]');
            for (var i = 0; i < parentli.length; i++) {
                var parent = $('[data-access-to="parent"]')[i];
                var displayli = parent.querySelectorAll(
                    'li:not([style*="display: none"])'
                );
                if (displayli.length == 0) {
                    parent.style.display = "none";
                }
            }
            //6. Check link parent element if there is no drop-down available so we display none

            unblockagePage();
            //4. After Ajax Response
        },
        error: function (e) {
            console.log(e);
            Msg("is Accessible check error", "error");
            unblockagePage();
        },
    });
    //3. Ajax to find if the current user have permission to these permission
}

function onlyDotsAndNumbers(txt, event) {
    var charCode = event.which ? event.which : event.keyCode;
    if (charCode == 46) {
        if (txt.value.indexOf(".") < 0) return true;
        else return false;
    }

    if (txt.value.indexOf(".") > 0) {
        var txtlen = txt.value.length;
        var dotpos = txt.value.indexOf(".");
        //Change the number here to allow more decimal points than 2
        if (txtlen - dotpos > 2) return false;
    }

    if (charCode > 31 && (charCode < 48 || charCode > 57)) return false;

    return true;
}

//Support Function
{
    var jsonToPropertiesString = (JsonBbject) => {
        //{id:1,name:'Rotha'} => "id='id' name='Rotha'

        const obj = JsonBbject;
        let str = "";

        for (const key in obj) {
            str =
                str +
                (key + "='" + obj[key].toString().replace("'", "") + "' ");
        }

        return str;
    };

    function delay(time) {
        return new Promise((resolve) => setTimeout(resolve, time));
    }

    var resizeDatatable = async (tableName) => {
        await delay(500);
        var table = $(`#${tableName}`).DataTable();
        $(`#${tableName}`).css("display", "table");
        table.columns.adjust().responsive.recalc();
    };

    var sendAsyncData = async (url, postData, showMessage) => {
        var data = await fetch(url, {
            method: "POST", // or 'PUT'
            headers: {
                "Content-Type": "application/json",
                Authorization: "Bearer " + AuthToken,
            },
            body: JSON.stringify(postData),
        })
            .then((response) => response.json())
            .then((response) => {
                //console.log(url, postData, response);

                if (response.result !== "error") {
                    if (showMessage && response.msg != "") {
                        Msg(response.msg, response.result);
                    }

                    console.log(response);
                    return response.data;
                } else {
                    console.log(response);

                    if (showMessage) {
                        Msg(response.msg, response.result);
                    }
                    return response.data;
                }
            })
            .catch((error) => {
                Msg("Error while post data", "error");
                console.log(error);
                return null;
            });

        return data;
    };

    var getAsyncView = async (url, postData) => {
        postData = { ...postData, _token: formToken };
        var view = await $.ajax({
            url: url,
            type: "POST",
            data: postData,
            beforeSend: function (xhr) {
                xhr.setRequestHeader("Authorization", "Bearer " + AuthToken);
            },
            success: function (response) {
                return response;
            },
            error: function (e) {
                Msg("error while get view", "error");
            },
        });

        return view;
    };

    var getAsyncData = async (url) => {
        var returnData = await fetch(url, {
            method: "GET", // or 'POST'
            headers: {
                "Content-Type": "application/json",
                Authorization: "Bearer " + AuthToken,
            },
        })
            .then((response) => response.json())
            .then((response) => {
                if (response.result !== "error") {
                    var data = response.data;
                    return data;
                } else {
                    sweetToast(response.msg, response.result);
                    return null;
                }
            })
            .catch((error) => {
                Msg("Error while get data", "error");
                console.log(error);
                return null;
            });

        return returnData;
    };

    var conditionSWAlert = async (message, icon, buttonText) => {
        var result = await Swal.fire({
            title: "Are you sure?",
            text: message,
            icon: icon,
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: buttonText,
        }).then((result) => {
            console.log(result.value);
            if (result.value) {
                return true;
            }

            return false;
        });

        return result;
    };

    function showDupes(arr) {
        return [
            ...new Set(
                arr.filter((elem, idx, arr) => arr.indexOf(elem) !== idx)
            ),
        ];
    }
}
//Support Function
