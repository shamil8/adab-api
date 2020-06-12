function getUserQuery(token) {
    // $.ajax(url).done( data => {
    //     window.user = data
    //     $('#email, #password').val('')
    //
    //     checkUser()
    // })

    const tokenElement = document.createElement('p')
    const $session = document.querySelector('.session')

    tokenElement.textContent = token

    $session.insertAdjacentElement('afterend', tokenElement)
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
    $.ajax('/api/login_check',{
        'data': JSON.stringify({ email: $('#email').val(), password: $('#password').val() }),
        'type': 'POST',
        'processData': false,
        'contentType': 'application/json'
    })
        .done(data => getUserQuery(data.token))
        .fail(xhr => {
            const response = JSON.parse(xhr.responseText)

            if (response.error) {
                alert(response.error)
            }
        })
})
