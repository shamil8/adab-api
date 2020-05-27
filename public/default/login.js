function getUserQuery(url) {
    $.ajax(url).done( data => {
        window.user = data
        $('#email, #password').val('')

        checkUser()
    })
}
function checkUser() {
    if (window.user) {
        $('.log-out').show()
        $('#name').text(window.user.name.split(' ')[0])

        if (window.user.role) {
            $('.log-out p').show()
            $('#role').text(window.user.role.split('_')[1])

            console.log(window.user)
        }

    }
}

checkUser()

$(document).on('click', '#login', event => {
    event.preventDefault()
    $.ajax('/login',{
        'data': JSON.stringify({ email: $('#email').val(), password: $('#password').val() }),
        'type': 'POST',
        'processData': false,
        'contentType': 'application/json'
    })
        .done( (data, status, jqXHR) => {
            getUserQuery(jqXHR.getResponseHeader('location'))
        })
        .fail(xhr => {
            let response = JSON.parse(xhr.responseText)

            if (response.error) {
                alert(response.error)
            }
        })
})
