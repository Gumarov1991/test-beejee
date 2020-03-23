jQuery(document).ready(function ($) {
//Вешаем обработчик на кнопку редактировать
    $('.edit-task').click(function (e) {
        e.preventDefault()

        let allEditBtn = $('.edit-task'),
            thisEditBtn = $(this),
            otherEditBtn = allEditBtn.not(thisEditBtn),
            cellAdmActions = $(this).parent(),
            id = thisEditBtn.attr('data-id'),
            cellForText = cellAdmActions.siblings('.task-text'),
            cellWidth = cellForText.width(),
            cellHeight = cellForText.height(),
            text = cellForText.html(),
            textarea = $('<textarea name="text" value="">'),
            saveBtn = $('<a class="save-task" href="#"">Сохранить</a><br>'),
            cancelBtn = $('<a class="cancel-task" href="#"">Отмена</a>'),
            inputReady = $('<input type="checkbox" name="is_ready">'),
            cellStatus = cellAdmActions.siblings('.col-status'),
            cellStatusHTML = cellStatus.html(),
            cellStatusIsready = cellStatus.children('.is-ready'),
            iconStatus = cellStatusIsready.children('i')



//Делаем другие кнопки редактировать неактивными
        otherEditBtn.addClass('disabled-link')

//Задаем значение, высоту и ширину для textarea
        textarea.val(text).width(cellWidth).height(cellHeight)
        cellForText.html(textarea)

//Прячем кнопку редактировать и добавляем сохранить
        thisEditBtn.hide()
        cellAdmActions.append(saveBtn).append(cancelBtn)

//Прячем иконку статуса выполнения и добавляем чекбокс для настройки
        if (iconStatus.hasClass('status-ready')) {
            inputReady.attr("checked", "checked");
        }
        iconStatus.hide();
        cellStatusIsready.append(inputReady)

//Вешаем обработчик на кнопку сохранить
        saveBtn.click(function (e) {
            e.preventDefault()

            otherEditBtn.removeClass('disabled-link')

            let isReady = inputReady.prop('checked') ? 1 : 0,
                data = {
                    'text': textarea.val(),
                    'is_ready': isReady
                }

            $.ajax({
                type: 'post',
                url: '/beejee/task/edit/' + id,
                data: data,
                dataType: 'json',
                success: function (data) {
                    if (data.status === 'ok') {
                        let task = data.data,
                            isReady = task.ready ? '<i class="fas fa-check status-ready"></i>' : '<i class="fas fa-times"></i>',
                            isEditByAdmin = task.is_edit_by_admin ? '<p class="is-edited">Отредактировано администратором</p>' : '',
                            htmlStatus = '<div class="is-ready">' +
                                '<p>Выполнено:</p>' + isReady +
                                '</div>' +
                                isEditByAdmin

                        cellForText.html(task.text)
                        cellStatus.html(htmlStatus)
                        saveBtn.remove()
                        cancelBtn.remove()
                        thisEditBtn.show()
                        Swal.fire({
                            icon: 'success',
                            title: data.message,
                        })
                    } else if (data.status === 'not_admin') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Ошибка!',
                            text: data.message,
                            onClose: function () {
                                window.location.href = '/beejee/'
                            }
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Ошибка!',
                            text: data.message
                        })
                    }
                }
            })
        })

//Вешаем обработчик на кнопку отмена
        cancelBtn.click(function (e) {
            e.preventDefault()

            otherEditBtn.removeClass('disabled-link')
            cellForText.html(text)
            cellStatus.html(cellStatusHTML)
            saveBtn.remove()
            cancelBtn.remove()
            thisEditBtn.show()

        })
    })

//Вешаем обработчик на кнопку добавить задачу
    $('#add-task input[type=submit]').click(function (e) {
        e.preventDefault();
        let data = $('#add-task form').serialize();

        $.ajax({
            type: 'post',
            url: '/beejee/task/add',
            data: data,
            dataType: 'json',
            success: function (data) {
                if (data.status === 'ok') {
                    Swal.fire({
                        icon: 'success',
                        title: data.message,
                        onClose: function () {
                            window.location.href = '/beejee/'
                        }
                    })
                } else {
                    let errors = data.data,
                        htmlErrors = '<ul style="text-align: left;">'

                    for (let key in errors) {
                        htmlErrors += '<li>' + errors[key] + '</li>'
                    }
                    htmlErrors += '</ul>'

                    Swal.fire({
                        icon: 'error',
                        title: 'Поля заполнены не верно',
                        html: htmlErrors
                    })
                }
            }
        })
    })

//Вешаем обработчик на кнопку login
    $('#login-form input[type=submit]').click(function (e) {
        e.preventDefault();
        let data = $('#login-form form').serialize();

        $.ajax({
            type: 'post',
            url: '/beejee/admin-login',
            data: data,
            dataType: 'json',
            success: function (data) {
                if (data.status === 'ok') {
                    Swal.fire({
                        icon: 'success',
                        title: data.message,
                        onClose: function () {
                            window.location.href = '/beejee/'
                        }
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ошибка',
                        text: data.message
                    })
                }
            }
        })
    })
});