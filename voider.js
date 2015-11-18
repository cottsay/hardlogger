function confirmVoidQSO(qso_id)
{
    var voider = $("#voider");

    // Bind 'ESC' key while in form
    voider.on('keyup', function(e)
    {
        if (e.keyCode == 27)
        {
            $.fancybox.close();
        }

        return false;
    });

    voider.find("input[name='qso_id']").val(qso_id);

    // Bind to close the fancybox
    voider.find("#cancelvoid").on('click', function()
    {
        $.fancybox.close();

        return false;
    }).on('keyup', function(e)
    {
        if (e.which == 32)
        {
            $.fancybox.close();

            return false;
        }

        return true;
    });

    // Display the form
    $.fancybox(voider, {
        helpers : {
            overlay : {
                locked : false
            }
        }
    });

    // Initial focus is on Cancel
    voider.find("#cancelvoid").focus();

    return true;
}

function submitVoidQSO(e)
{
    $.fancybox.showLoading();
    $.fancybox.close();

    e.preventDefault();

    $.ajax({
        type: 'POST',
        url: $(this).prop('action'),
        data: { qso_id: $(this).find("input[name='qso_id']").val() },
        cache: false,
    })
    .done(function()
    {
        var voidresult = $("#voidresult");

        voidresult.find("#voidresultclose").on('click', function()
        {
            $.fancybox.close();

            return false;
        });

        voidresult.find("#voidresulttd").html("QSO Voided Successfully");

        $.fancybox(voidresult, {
            helpers : {
                overlay : {
                    locked : false
                }
            }
        });

        voidresult.find("#voidresultclose").focus();

        // Refresh any input fields so the lists refresh
        $("#searchcriteria").trigger('onpropertychange');
        $("#queue, #selectable_queue").trigger('refreshQueue');
        $('#editor').trigger('forceValidation');
        $('#newqso_queued').trigger('forceValidation');
        $('#newqso_confirmed').trigger('forceValidation');
        $('#newqso_confirmed').find("input[type='text'][name='num']").trigger('refreshContactNum');
    })
    .fail(function(jqXHR, textStatus, errorThrown)
    {
        var voidresult = $("#voidresult");

        voidresult.find("#voidresultclose").on('click', function()
        {
            $.fancybox.close();

            return false;
        });

        voidresult.find("#voidresulttd").html("Failed to void QSO:<br>" + jqXHR.responseText);

        $.fancybox(voidresult, {
            helpers : {
                overlay : {
                    locked : false
                }
            }
        });

        voidresult.find("#voidresultclose").focus();
    });
}

function bindVoidQSO()
{
    $(this).find('#voidform').on('submit', submitVoidQSO);
}

$(document).ready(function()
{
    bindVoidQSO.call($('#voider'));
});
