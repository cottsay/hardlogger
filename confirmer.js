function refreshContactNum(e)
{
    var contactNum = $(this);

    $.ajax({
        url: 'query.php',
        data: 'get_num&no_queued&order=num&max=1&rev&event_id=' + HLEventID,
        dataType: 'json',
        cache: false,
    })
    .done(function(data)
    {
        var next_id = 1;

        if (data.length > 0)
        {
            next_id = parseInt(data[0].ContactNumber) + 1;
        }

        contactNum.val(next_id);
        contactNum.trigger('onpropertychange');

        return false; // keeps the page from not refreshing 
    });
}

function bindContactNum()
{
    $(this).on('refreshContactNum', refreshContactNum);
}

$(document).ready(function()
{
    var contactNum = $('#newqso_confirmed').find("input[type='text'][name='num']");

    bindContactNum.call(contactNum);

    setInterval(function()
    {
        contactNum.trigger('refreshContactNum');
    }, 4000);

    contactNum.trigger('refreshContactNum');
});

