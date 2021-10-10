jQuery().ready(function () {
    function altMessage(message, title) {
        var $uncatchetMessage;

        $uncatchetMessage = $('#setcms-uncatched-message');
        $uncatchetMessage.find('.toast-body').text(message);
        $uncatchetMessage.find('.toast-header .me-auto').text(title ? title : 'Сообщение');

        return new bootstrap.Toast($uncatchetMessage.get(0)).show();
    }

    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2)
            return parts.pop().split(';').shift();
    }

    $('.setcms-form .setcms-submit-button').on('click', function () {
        var $form;

        $form = $(this).closest('form');
        $form.find('.invalid-feedback').text('');
        $form.find('.is-invalid').removeClass('is-invalid');

        $.ajax({
            url: $form.attr('action'),
            data: new FormData($form.get(0)),
            headers: {
                'X-CSRF-Token': getCookie('X-CSRF-Token'),
                Accept: "application/json; charset=utf-8",
            },
            processData: false,
            contentType: false,
            type: 'POST',
            dataType: 'text',
            error: function (ts) {
                var message;
                var data;

                try {
                    data = JSON.parse(ts.responseText);
                    if (data.messages && data.messages[0] && data.messages[0].message) {
                        message = data.messages[0].message;
                    }
                } catch (e) {
                    message = ts.responseText;
                }

                return altMessage(message, 'Ошибка');
            },
            success: function (data) {
                try {
                    data = JSON.parse(data);
                    console.log(data);
                } catch (e) {
                    console.log(data);
                    return altMessage(data);
                }

                if (data.success && $form.attr('setcms-redirect')) {
                    String.prototype.interpolate = function (params) {
                        const names = Object.keys(params);
                        const vals = Object.values(params);
                        return new Function(...names, `return \`${this}\`;`)(...vals);
                    }

                    window.location.href = $form.attr('setcms-redirect').interpolate(data.result);
                    return;
                }


                $.each(data.messages, function (index, message) {
                    if (message.field) {
                        var $field;

                        $field = $form.find('[name="' + message.field + '"]');
                        $field.addClass('is-invalid');
                        $field.parent().find('.invalid-feedback').text(message.message);
                    } else {
                        altMessage(message.message);
                    }
                });
            }
        });
    });
});