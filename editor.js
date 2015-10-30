function editQSO(qso_id)
{
    $.fancybox.showLoading();

    // Populate the form
    $.ajax({
        url: 'query.php',
        data: 'all_events&get_status&get_num&get_freq&get_serial&get_prec&get_call&get_check&get_section&get_logged&qso_id=' + qso_id,
        dataType: 'json',
    })
    .done(function(data)
    {
        // We should get exactly one result
        if (data.length != 1)
        {
            $.fancybox.hideLoading();

            alert('Failed to load qso info: got ' + data.length + ' results');

            return false;
        }

        var editor = $("#editor");

        // Populate current values
        if (data[0].Status == 0)
        {
            editor.find("input[name='num']").val('').prop('disabled', true);
        }
        else
        {
            editor.find("input[name='num']").val(data[0].ContactNumber).prop('disabled', false);
        }

        editor.find("input[name='freq']").val(data[0].Frequency);

        if (data[0].Status == 0)
        {
            editor.find("input[name='serial']").val('').prop('disabled', true);
        }
        else
        {
            editor.find("input[name='serial']").val(data[0].Serial).prop('disabled', false);
        }

        editor.find("input[name='prec']").val(data[0].Precedence);
        editor.find("input[name='call']").val(data[0].Callsign);
        editor.find("input[name='check']").val(data[0].CheckNum.length < 2 ? '0' + data[0].CheckNum : data[0].CheckNum);
        editor.find("input[name='section']").val(data[0].Section);

        if (data[0].Status == 0)
        {
            editor.find("input[name='stamp']").val('').prop('disabled', true);
        }
        else
        {
            editor.find("input[name='stamp']").val(data[0].LoggedAt).prop('disabled', false);
        }

        editor.find("input[name='qso_id']").val(qso_id);
        editor.find("input[name='validation_override']").prop('checked', false);

        // Validate the data
        forceValidation.call(editor);

        // Bind 'ESC' key while in form
        editor.keyup(function(e)
        {
            if (e.keyCode == 27)
            {
                $.fancybox.close();
            }

            return false;
        });

        // Display the form
        $.fancybox( editor, {
            helpers : {
                overlay : {
                    locked : false
                }
            }
        });

        // Initial focus in Frequency box
        editor.find("input[name='freq']").focus();

        return true;
    });
}

function submitEditQSO(e)
{
    $.fancybox.showLoading();
    $.fancybox.close();

    e.preventDefault();

    var data = {}
    data.qso_id = $(this).find("input[name='qso_id']").val();

    if (!$(this).find("input[name='num']").is(':disabled'))
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

    if (!$(this).find("input[name='stamp']").is(':disabled'))
    {
        data.stamp = $(this).find("input[name='stamp']").val();
    }

    $.ajax({
        type: 'POST',
        url: $(this).prop('action'),
        data: data,
    })
    .done(function()
    {
        var editresult = $("#editresult");

        editresult.find("#editresultclose").on('click', function()
        {
            $.fancybox.close();

            return false;
        });

        editresult.find("#editresulttd").html("QSO Edited Successfully");

        $.fancybox(editresult, {
            helpers : {
                overlay : {
                    locked : false
                }
            }
        });

        editresult.find("#editresultclose").focus();

        // Refresh any input fields so the lists refresh
        $("#searchcriteria").trigger('onpropertychange');
    })
    .fail(function(jqXHR, textStatus, errorThrown)
    {
        var editresult = $("#editresult");

        editresult.find("#editresultclose").on('click', function()
        {
            $.fancybox.close();

            return false;
        });

        editresult.find("#editresulttd").html("Failed to edit QSO:<br>" + jqXHR.responseText);

        $.fancybox(editresult, {
            helpers : {
                overlay : {
                    locked : false
                }
            }
        });

        editresult.find("#editresultclose").focus();
    });
}

function bindEditQSO()
{
    $(this).find('#qsoform').on('submit', submitEditQSO);
}

$(document).ready(function()
{
    bindEditQSO.call($('#editor'));
});

