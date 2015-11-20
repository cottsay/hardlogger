function selectQueuedQso(e)
{
    if ($(e.target).is("button"))
    {
        return true;
    }

    var target = $('#newqso_confirmed');
    var clicked_original_id = $(this).find("input[name='original_id']");
    var current_original_id = target.find("input[name='original_id']");

    if ($(e.target).is("input[name='original_id']"))
    {
        $(this).css('backgroundColor', '#00FF00');
    }
    else if (current_original_id.val() != clicked_original_id.val())
    {
        current_original_id.val(clicked_original_id.val());
        target.find("input[name='freq']").val($(this).find(".freq_cell").html());
        target.find("input[name='prec']").val($(this).find(".prec_cell").html());
        target.find("input[name='call']").val($(this).find(".call_cell").html());
        target.find("input[name='check']").val($(this).find(".check_cell").html());
        target.find("input[name='section']").val($(this).find(".section_cell").html());

        target.find("input[name='serial']").focus();

        $(this).css('backgroundColor', '#00FF00');
    }
    else
    {
        target.find("input[type='button'][name='clear']").trigger('click');

        target.find("input[name='freq']").focus();

        $(this).css('backgroundColor', '#FFFFFF');
    }

    target.trigger('forceValidation');

    return true;
}

function refreshQueue(e)
{
    var queue = $(this);

    $.ajax({
        url: 'query.php',
        data: 'get_id&get_freq&get_serial&get_prec&get_call&get_check&get_section&get_created&no_void&queued&order=created&event_id=' + HLEventID,
        dataType: 'json',
        cache: false,
    })
    .done(function(data)
    {
        if (data.length < 1)
        {
            queue.html("There are no queued QSOs.");

            return false;
        }

        var inner_html = "<table class=\"unittable\">";

        for (var i in data)
        {
            var tdclass = "resulttd";
            var tdbuttons = "";

            tdbuttons += "<button type=\"button\" onclick=\"confirmVoidQSO(" + data[i].id + ")\">Void</button>";
            tdbuttons += " <button type=\"button\" onclick=\"editQSO(" + data[i].id + ")\">Edit</button>";

            inner_html += "<tr class=\"selectable\"><td class=\"" + tdclass + " freq_cell\">" + data[i].Frequency + "</td><td class=\"" + tdclass + " serial_cell\"></td><td class=\"" + tdclass + " prec_cell\">" + data[i].Precedence + "</td><td class=\"" + tdclass + " call_cell\">" + data[i].Callsign + "</td><td class=\"" + tdclass + " check_cell\">" + (data[i].CheckNum.length < 2 ? "0" : "") + data[i].CheckNum + "</td><td class=\"" + tdclass + " section_cell\">" + data[i].Section + "</td><td class=\"" + tdclass + " stamp_cell\">" + data[i].CreatedAt + "</td><td class=\"" + tdclass + "\"><input name=\"original_id\" type=\"hidden\" value=\"" + data[i].id + "\">" + tdbuttons + "</td></tr>";
        }

        inner_html += "</table>";

        queue.html(inner_html);

        if (e.data)
        {
            queue.find("tr.selectable").on('click', selectQueuedQso);

             var original_id_current = $('#newqso_confirmed').find("input[name='original_id']");
             var original_id = original_id_current.val();

            queue.find("input[name='original_id'][value='" + original_id + "']").trigger('click');
        }


        return false; // keeps the page from not refreshing 
    });
}

function bindQueue(selectable)
{
    $(this).on('refreshQueue', selectable, refreshQueue);
}

$(document).ready(function()
{
    var queue = $('#queue');
    var selectable_queue = $('#selectable_queue');

    bindQueue.call(queue, false);
    bindQueue.call(selectable_queue, true);

    setInterval(function()
    {
        queue.trigger('refreshQueue');
        selectable_queue.trigger('refreshQueue');
    }, 4000);

    queue.trigger('refreshQueue');
    selectable_queue.trigger('refreshQueue');
});

