function clearValues()
{
    $(this).find("input[name='original_id']").val('');
    if (!$(this).find("input[name='num']").prop('readonly'))
    {
        $(this).find("input[name='num']").val('');
    }
    $(this).find("input[name='freq']").val('');
    $(this).find("input[name='serial']").val('');
    $(this).find("input[name='prec']").val('');
    $(this).find("input[name='call']").val('');
    $(this).find("input[name='check']").val('');
    $(this).find("input[name='section']").val('');
    $(this).find("input[name='validation_override']").attr('checked', false);

    $(this).trigger('forceValidation');

    $('#selectable_queue').find('tr.selectable').css('backgroundColor', '#FFFFFF');
}

function clearCallback(e)
{
    var p = e.data;

    clearValues.call(p);

    p.find("input[name='freq']").focus();
}

function submitNewQSO(e)
{
    $.fancybox.showLoading();
    $.fancybox.close();

    e.preventDefault();

    var data = {}

    if ($(this).find("input[name='original_id']").length)
    {
        data.original_id = $(this).find("input[name='original_id']").val();
    }

    if ($(this).find("input[name='num']").length && !$(this).find("input[name='num']").is(':disabled'))
    {
        data.num = $(this).find("input[name='num']").val();
    }

    data.freq = $(this).find("input[name='freq']").val();

    if (!$(this).find("input[name='serial']").is(':disabled'))
    {
        data.serial = $(this).find("input[name='serial']").val();
    }

    data.prec = $(this).find("input[name='prec']").val();
    data.call = $(this).find("input[name='call']").val();
    data.check = $(this).find("input[name='check']").val();
    data.section = $(this).find("input[name='section']").val();
    data.status = $(this).find("input[name='status']").val();

    if ($(this).find("input[name='stamp']").length)
    {
        data.stamp = $(this).find("input[name='stamp']").val();
    }

    var qsoForm = $(this)

    $.ajax({
        type: 'POST',
        url: $(this).prop('action'),
        data: data,
        cache: false,
    })
    .done(function()
    {
        var newresult = $("#newresult");

        newresult.find("#newresultclose").on('click', function()
        {
            $.fancybox.close();

            return false;
        });

        newresult.find("#newresulttd").html("QSO Added Successfully");

        $.fancybox(newresult, {
            helpers : {
                overlay : {
                    locked : false
                }
            },
            afterClose : function()
            {
                qsoForm.find("input[name='freq']").focus();
            }
        });

        clearValues.call(qsoForm);

        newresult.find("#newresultclose").focus();

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
        var newresult = $("#newresult");

        newresult.find("#newresultclose").on('click', function()
        {
            $.fancybox.close();

            return false;
        });

        newresult.find("#newresulttd").html("Failed to add QSO:<br>" + jqXHR.responseText);

        $.fancybox(newresult, {
            helpers : {
                overlay : {
                    locked : false
                }
            }
        });

        newresult.find("#newresultclose").focus();
    });
}

function bindNewQSO()
{
    var clearButton = $(this).find("input[type='button'][name='clear']");
    var qsoForm = $(this).find('.qsoform');

    qsoForm.on('submit', submitNewQSO);
    clearButton.attr('alt', 'Clear all values and re-focus the first field');
    clearButton.on('click', $(this), clearCallback);
}

$(document).ready(function()
{
    bindNewQSO.call($('#newqso_queued'));
    bindNewQSO.call($('#newqso_confirmed'));
});

