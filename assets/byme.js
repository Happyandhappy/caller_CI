/**
 * Created by raulinoneto on 27/02/17.
 */
$(document).ready(function () {
    $(".maskreal").maskMoney();
    if (sessionStorage.getItem("call_log_alert")) {
        var html = sessionStorage.getItem("call_log_alert");

    }
    $('.btsnd').on('click touchstart',function (e) {
        e.preventDefault()
        sendT()
    })
});

$('.btsnd').on('click touchstart touch',function (e) {
    e.preventDefault()
    sendT()
});

$('.btsnd').on('click touchstart touch',function (e) {
    e.preventDefault()
    sendT()
});


function sendT(){
    $.get('https://www.callertech.com/index.php/base/send_email_call', {
            'uri': $(this).data('tid'),
            'from': $(this).data('from'),
            'to': $(this).data('to'),
            'name': $(this).data('name'),
            'date': $(this).data('date'),
            'request_sid': $(this).data('requestsid'),
        },
        function (data) {
            var result = JSON.parse(data);
            if (result.status == 'success') {
                var html = '<div class="alert alert-success" style="width:auto">' +
                    '<button class="close" data-dismiss="alert">x</button>' +
                    '<p>Email with the record\'s transcriptions was sent</p> ' +
                    '</div>';
            } else {
                var html = '<div class="note note-danger alert"><span class="close" data-dismiss="alert">×</span> ' +
                    '<div class="row p-20"><h4> Your Fund is not enough!</h4>' +
                    '<p class="f-s-16" style="font-size: 12px;"> Your account funds are low and we have suspended your' +
                    'account, please add a minimum of $100 to reactivate it</p> ' +
                    '<p> Please Add Funds </p> ' +
                    '<p> ' +
                    '<form class="form-inline" name="frm_payment" id="frm_payment" method="post" action="https://www.callertech.com/index.php/payment/topup_payment"' +
                    'onSubmit="return validate_amt();"> ' +
                    '<div class="form-group m-r-10"><input type="text" class="form-control" name="topup_amount_100"' +
                    'id="topup_amount_100" value="100" required' +
                    'placeholder="Enter amount" disabled><input type="hidden"' +
                    'class="form-control"' +
                    'name="topup_amount"' +
                    'id="topup_amount"' +
                    'value="100"' +
                    'required' +
                    'placeholder="Enter amount"> ' +
                    '</div> ' +
                    '<input type="submit" class="btn btn-sm btn-primary m-r-5" name="pay_submit" id="pay_submit"' +
                    'value="Pay"></form> ' +
                    '</p></div> ' +
                    '</div>';
            }
            swal("Success!", "You was received an email with the transcriptions", "success")
            $('#alert-btn').empty();
            $('#alert-btn').prepend(html);
//                    sessionStorage.setItem("call_log_alert", html);
//                    location.reload();

        }
    )
}