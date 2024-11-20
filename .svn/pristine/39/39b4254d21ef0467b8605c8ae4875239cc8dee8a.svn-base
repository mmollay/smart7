/*
 * Call Password 
 */
$(document).ready(function () {
    $("#button_generate_password").click(function () {
        $.post('inc/random_password.php', function (data) {
            $('#password').val(data);
        })
    })
});

function after_form_client(id) {
    if (id == 'empty_client_number') {
        $('#message').message({
            status: 'error', title: 'Kundennummer existiert bereits'
        });
        $('#client_number').focus();
    } else if (id == 'email_exists') {
        $('#message').message({
            status: 'error', title: 'Email bereits vergeben'
        });
        $('#email').focus();
    } else if (id == 'double_client_number') {
        $('#message').message({
            status: 'error', title: 'Kundennummer existiert bereits'
        });
        $('#client_number').focus();
    } else if (id == 'double_company_name') {
        $('#message').message({
            status: 'error', title: 'Firmenname existiert bereits'
        });
        $('#company_1').focus();
    } else {
        if (Number.isInteger(parseInt(id))) {
            $('#message').message({
                status: 'info', title: 'Kundendaten wurden gespeichert'
            });
            $('#modal_form').modal('hide');
            table_reload();
        } else {
            $('#message').message({
                status: 'error', title: 'Fehler im System' + id
            });
        }
    }
}
