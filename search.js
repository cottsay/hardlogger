function searchQSOs()
{
    var searchcrit = $(this);
    var search = searchcrit.val();
    var searchres = $('#searchresult');

    if (search.length == 0)
    {
        searchcrit.css('backgroundColor', '#FFFFFF');
        searchres.html("Search Ready.");

        return;
    }
    else if (search.trim().length < 2)
    {
        searchcrit.css('backgroundColor', '#FFFF00');
        searchres.html("Search Ready.");

        return;
    }

    $.ajax({
        url: 'query.php',
        data: 'all_events&get_event&get_id&get_status&get_freq&get_serial&get_prec&get_call&get_check&get_section&get_logged&no_void&order=created&rev&search=' + $(this).val(),
        dataType: 'json',
    })
    .done(function(data)
    {
        if (data.length < 1)
        {
            searchcrit.css('backgroundColor', '#FF0000');
            searchres.empty();

            return false;
        }

        searchcrit.css('backgroundColor', '#00FF00');
        searchres.html("<table>");

        for (var i in data)
        {
            var tdclass = "resulttd";
            var tdbuttons = "";

            if (data[i].EventID != HLEventID)
            {
                tdclass += " greyed";
                tdbuttons += "<button type=\"button\" disabled=\"disabled\">Void</button>";
                tdbuttons += " <button type=\"button\" disabled=\"disabled\">Edit</button>";
            }
            else
            {
                tdbuttons += "<button type=\"button\" onclick=\"confirmVoidQSO(" + data[i].id + ")\">Void</button>";
                tdbuttons += " <button type=\"button\" onclick=\"editQSO(" + data[i].id + ")\">Edit</button>";

                if (data[i].Status < 1)
                {
                    tdbuttons += " (in queue)";
                }
            }

            searchres.append("<tr><td class=\"" + tdclass + " freq_cell\">" + data[i].Frequency + "</td><td class=\"" + tdclass + " serial_cell\">" + (data[i].Serial == null ? "" : data[i].Serial) + "</td><td class=\"" + tdclass + " prec_cell\">" + data[i].Precedence + "</td><td class=\"" + tdclass + " call_cell\">" + data[i].Callsign + "</td><td class=\"" + tdclass + " check_cell\">" + (data[i].CheckNum.length < 2 ? "0" : "") + data[i].CheckNum + "</td><td class=\"" + tdclass + " section_cell\">" + data[i].Section + "</td><td class=\"" + tdclass + " stamp_cell\">" + (data[i].LoggedAt == null ? "" : data[i].LoggedAt) + "</td><td class=\"" + tdclass + "\">" + tdbuttons + "</td></tr>");
        }

        searchres.append("</table>");

        return false; // keeps the page from not refreshing 
    });
}

$(document).ready(function()
{
    var searchcrit = $('#searchcriteria');

    searchcrit.on('input onpropertychange', searchQSOs);
    searchcrit.watermark('Search value (callsign, frequency or section)');
    searchcrit.focus();

    // In case there is already a value here
    searchcrit.trigger('onpropertychange');
});

