function getUserQuery(token) {
    $.ajax('/user', {
        'type': 'POST',
        'data': JSON.stringify({ token }),
    })
        .done( data => {
            window.user = data
            window.token = token

            $('#email, #password').val('')

            checkUser()
        })
        .fail(xhr => {
            const response = JSON.parse(xhr.responseText)

            if (response.message) {
                alert(response.message + ` ( ${response.code} )`)
            }
        })
}

function checkUser() {
    if (window.user) {
        $('.log-out').show()
        $('#name').text(window.user.name.split(' ')[0])
        console.log('Hey It is me', window.user.roles)
        if (window.user.roles.length) {
            $('.log-out p').show()
            $('#role').text(window.user.roles[0].split('_')[1])
        }
    }

    if (window.token) {
        const tokenElement = document.createElement('textarea')
        const $left = document.querySelector('.left')

        tokenElement.textContent = 'BEARER ' + token

        $left.insertAdjacentElement('afterend', tokenElement)
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
        .done(data => data.hasOwnProperty('token') && getUserQuery(data.token))
        .fail(xhr => {
            const response = JSON.parse(xhr.responseText)

            if (response.message) {
                alert(response.message + ` ( ${response.code} )`)
            }
        })
})
