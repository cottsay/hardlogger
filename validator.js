function clearDupeDisplay(e)
{
    $('.dupe_message_display').html('');
}

function dupeCheck(e)
{
    var target = $(this);

    $.ajax({
        url: 'query.php',
        data: 'call=' + $(this).val() + '&get_id&get_logged&logged&order=logged&max=1&rev&event_id=' + HLEventID,
        dataType: 'json',
        cache: false,
    })
    .done(function(data)
    {
        if (data.length > 0)
        {
            target.css('background-color', '#FFFF00');

            e.data.commons.bitmask |= (1 << e.data.bit);

            $('.dupe_message_display').html('ALREADY WORKED AT ' + data[0].LoggedAt);
        }
        else
        {
            target.css('background-color', '#00FF00');

            e.data.commons.bitmask &= ~(1 << e.data.bit);
        }

        e.data.commons.submitter.prop('disabled', (!e.data.commons.override.is(':checked')) && e.data.commons.bitmask);

        return false; // keeps the page from not refreshing 
    })
    .fail(function()
    {
        target.css('background-color', '#FFFFFF');

        e.data.commons.bitmask &= ~(1 << e.data.bit);

        e.data.commons.submitter.prop('disabled', (!e.data.commons.override.is(':checked')) && e.data.commons.bitmask);

        return false; // keeps the page from not refreshing 
    });
}

function verifyFrequency(freq)
{
    if (freq.length < 1)
    {
        return null;
    }

    if (!$.isNumeric(freq))
    {
        return false;
    }

    if (freq < 3500 || (freq > 4000 && freq < 7000) || (freq > 7300 && freq < 14000) || (freq > 14350 && freq < 21000) || (freq > 21450 && freq < 28000) || freq > 29700)
    {
        return false;
    }

    return true;
}

function verifySerial(serial)
{
    if (serial.length < 1)
    {
        return null;
    }

    if (!$.isNumeric(serial))
    {
        return false;
    }

    if (serial == 0)
    {
        return false;
    }

    return true;
}

function verifyPrecedence(prec)
{
    if (prec.length < 1)
    {
        return null;
    }

    if (/^[ABMQSUabmqsu]$/.test(prec))
    {
        return true;
    }

    return false;
}

function verifyCallsign(call)
{
    if (call.length < 1)
    {
        return null;
    }

    call = call.toUpperCase();

    if (/^[KNW]\d[ABCDEFGHIJKLMNOPQRSTUVWXYZ]{2}$/.test(call) ||                                                       // Group A (1x2)
        /^[KNW]\d[ABCDEFGHIJKLMNOPQRSTUVWYZ]$/.test(call) ||                                                           // Event (1x1)
        /^[A][ABCDEFGHIJKL]\d[ABCDEFGHIJKLMNOPQRSTUVWXYZ]{1,2}$/.test(call) ||                                         // Group A (2x1, 2x2) (beginning with A)
        /^[KNW][ABCDEFGHIJKLMNOPQRSTUVWXYZ]\d[ABCDEFGHIJKLMNOPQRSTUVWXYZ]{1,2}$/.test(call) ||                         // Group A (2x1) (beginning with K,N,W), Group B (2x2)
        /^[KNW]\d[ABCDEFGHIJKLMNOPQRSTUVWXYZ]{3}$/.test(call) ||                                                       // Group C (1x3)
        /^[KW][ABCDEFGHIJKLMNOPQRSTUVWXYZ]\d[ABCDEFGHIJKLMNOPQRSTUVWXYZ]{3}$/.test(call) ||                            // Group D (2x3)
        /^(CB||CF||CH||CI||CJ||CK||V[ABCDEFG]||VO||VX||VY||X[JKLMNO])\d[ABCDEFGHIJKLMNOPQRSTUVWXYZ]{2,3}$/.test(call)) // Canada
    {
        return true;
    }

    return false;
}

function verifyCheck(check)
{
    if (check.length < 1)
    {
        return null;
    }

    if (/^[\d]{2}$/.test(check))
    {
        return true;
    }

    return false;
}

function verifySection(section)
{
    if (section.length < 1)
    {
        return null;
    }

    section = section.toUpperCase();

    if (/^(CT||EMA||ME||NH||RI||VT||WMA||ENY||NLI||NNJ||NNY||SNJ||WNY||DE||EPA||MDC||WPA||AL||GA||KY||NC||NFL||SC||SFL||WCF||TN||VA||PR||VI||AR||LA||MS||NM||NTX||OK||STX||WTX||EB||LAX||ORG||SB||SCV||SDG||SF||SJV||SV||PAC||AZ||EWA||ID||MT||NV||OR||UT||WWA||WY||AK||MI||OH||WV||IL||IN||WI||CO||IA||KS||MN||MO||NE||ND||SD||MAR||NL||QC||GTA||ONE||ONN||ONS||MB||SK||AB||BC||NT)$/.test(section))
    {
        return true;
    }

    return false;
}

function verifyTimestamp(stamp)
{
    if (stamp.length < 1)
    {
        return null;
    }

    if ((stamp == 'NOW()') || (/^[\d]{4}-[\d]{2}-[\d]{2} [\d]{2}:[\d]{2}:[\d]{2}$/.test(stamp) && Date.parse(stamp.replace(' ', 'T'))))
    {
        return true;
    }

    return false;
}

function verifyAndUpdate(e)
{
    if (e.data.preVerify)
    {
        e.data.preVerify.call($(this), e);
    }

    switch (e.data.verifier($(this).val()))
    {
    case true:
        if (e.data.alternatePositive)
        {
            e.data.alternatePositive.call($(this), e);

            return true;
        }

        $(this).css('background-color', '#00FF00');

        e.data.commons.bitmask &= ~(1 << e.data.bit);

        break;
    case false:
        $(this).css('background-color', '#FF0000');

        if ($(this).is(':enabled'))
        {
            e.data.commons.bitmask |= (1 << e.data.bit);
        }

        //alert(e.data.commons.bitmask);

        break;
    case null:
        $(this).css('backgroundColor', '#FFFFFF');

        if ($(this).is(':enabled'))
        {
            e.data.commons.bitmask |= (1 << e.data.bit);
        }

        break;
    }

    e.data.commons.submitter.prop('disabled', (!e.data.commons.override.is(':checked')) && e.data.commons.bitmask);

    return true;
}

function verifyOverride(e)
{
    e.data.submitter.prop('disabled', (!$(this).is(':checked')) && (e.data.bitmask));
}

function forceValidation(e)
{
    e.data.commons.bitmask = 0;

    $(this).find("input[name='num']").trigger('onpropertychange');
    $(this).find("input[name='freq']").trigger('onpropertychange');
    $(this).find("input[name='serial']").trigger('onpropertychange');
    $(this).find("input[name='prec']").trigger('onpropertychange');
    $(this).find("input[name='call']").trigger('onpropertychange');
    $(this).find("input[name='check']").trigger('onpropertychange');
    $(this).find("input[name='section']").trigger('onpropertychange');
    $(this).find("input[name='stamp']").trigger('onpropertychange');
}

function bindValidator(callDupeCheck)
{
    var submitButton = $(this).find("input[type='submit']");
    var overrideCheck = $(this).find("input[name='validation_override']");
    var validationField = $(this).find("input[name='validation']");

    var numBox = $(this).find("input[name='num']");
    var freqBox = $(this).find("input[name='freq']");
    var serialBox = $(this).find("input[name='serial']");
    var precBox = $(this).find("input[name='prec']");
    var callBox = $(this).find("input[name='call']");
    var checkBox = $(this).find("input[name='check']");
    var sectionBox = $(this).find("input[name='section']");
    var stampBox = $(this).find("input[name='stamp']");

    var commons = {
        submitter: submitButton,
        bitmask: 0,
        override: overrideCheck,
    };

    overrideCheck.on('change', commons, verifyOverride);

    $(this).on('forceValidation', { commons: commons }, forceValidation);

    numBox.attr('alt', 'Your station\'s serial number for the QSO');
    numBox.on('input onpropertychange', { verifier: verifySerial, bit: 0, commons: commons }, verifyAndUpdate);
    freqBox.attr('alt', 'Frequency in Kilohertz');
    freqBox.on('input onpropertychange', { verifier: verifyFrequency, bit: 1, commons: commons }, verifyAndUpdate);
    serialBox.attr('alt', 'Station\'s reported serial number for the QSO');
    serialBox.on('input onpropertychange', { verifier: verifySerial, bit: 2, commons: commons }, verifyAndUpdate);
    precBox.attr('alt', 'Station\'s reported precedence');
    precBox.on('input onpropertychange', { verifier: verifyPrecedence, bit: 3, commons: commons }, verifyAndUpdate);
    callBox.attr('alt', 'Station\'s callsign');

    if (callDupeCheck)
    {
        callBox.on('input onpropertychange', { verifier: verifyCallsign, bit: 4, commons: commons, preVerify: clearDupeDisplay, alternatePositive: dupeCheck }, verifyAndUpdate);
    }
    else
    {
        callBox.on('input onpropertychange', { verifier: verifyCallsign, bit: 4, commons: commons }, verifyAndUpdate);
    }

    checkBox.attr('alt', 'Station\'s reported check value');
    checkBox.on('input onpropertychange', { verifier: verifyCheck, bit: 5, commons: commons }, verifyAndUpdate);
    sectionBox.attr('alt', 'Station\'s section identifier');
    sectionBox.on('input onpropertychange', { verifier: verifySection, bit: 6, commons: commons }, verifyAndUpdate);
    stampBox.attr('alt', 'Date and time at which the station was worked (YYYY-MM-DD HH:MM:SS)');
    stampBox.on('input onpropertychange', { verifier: verifyTimestamp, bit: 7, commons: commons }, verifyAndUpdate);

    $(this).find('.qsoform').attr('autocomplete', 'off');
}

$(document).ready(function()
{
    bindValidator.call($('#editor'), false);
    bindValidator.call($('#newqso_queued'), true);
    bindValidator.call($('#newqso_confirmed'), true);

    $('#editor').trigger('forceValidation');
    $('#newqso_queued').trigger('forceValidation');
    $('#newqso_confirmed').trigger('forceValidation');
});
