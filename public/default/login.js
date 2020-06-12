function getUserQuery(token) {
    const tokenElement = document.createElement('textarea')
    const $left = document.querySelector('.left')

    tokenElement.textContent = 'BEARER ' + token

    $left.insertAdjacentElement('afterend', tokenElement)

    $.ajax('/api/user', {'type': 'POST'}).done( data => {
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
        }

    }
}

checkUser()

$(document).on('click', '#login', event => {
    event.preventDefault()
    $.ajax('/auth_token',{
        'data': JSON.stringify({ email: $('#email').val(), password: $('#password').val() }),
        'type': 'POST',
        'processData': false,
        'contentType': 'application/json'
    })
        .done(data => getUserQuery(data.token))
        .fail(xhr => {
            const response = JSON.parse(xhr.responseText)

            if (response.message) {
                alert(response.message + ` ( ${response.code} )`)
            }
        })
})
