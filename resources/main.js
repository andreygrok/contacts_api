$.fn.serializeObject = function () {
    var o = {};
    var a = this.serializeArray();
    $.each(a, function () {
        if (o[this.name]) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};

$(document).ready(function () {
    $('.add-row-btn').on('click', function () {
        $(".clone_form").clone().removeClass('clone_form').appendTo(".add_rows");
    });

    $('.sbmt').on('click', function () {
        var items = [];
        $('.form_create').each(function (index) {
            if (!$(this).hasClass('clone_form')) {
                items.push($(this).serializeObject());
            }
        });
        var source = $('.source').val();
        $.ajax({
            url: "/contacts/",
            type: "POST",
            data: {
                source_id: source,
                items: items
            },
            success: function (result) {
                $('.result_ok').html('');
                $('.result_err').html('');
                if (result.added) {
                    $('.result_ok').html(result.added + ' contacts added!');
                }
                if (result.errors) {
                    var errorsStr = '<h3>Errors:</h3>';
                    for (var i in result.errors) {
                        if (!result.errors.hasOwnProperty(i)) {
                            continue;
                        }
                        errorsStr += '<b>Candidate #' + i + '</b><br />';
                        if (result.errors[i].phone) {
                            errorsStr += result.errors[i].phone + '<br />';
                        }
                        if (result.errors[i].email) {
                            errorsStr += result.errors[i].email + '<br />';
                        }

                    }
                    $('.result_err').html(errorsStr);
                }
            }
        });
    })
});
