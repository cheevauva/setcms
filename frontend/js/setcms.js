jQuery().ready(function () {
    function altMessage(message, title) {
        var $uncatchetMessage;

        $uncatchetMessage = $('#setcms-uncatched-message');
        $uncatchetMessage.find('.toast-body').text(message);
        $uncatchetMessage.find('.toast-header .me-auto').text(title ? title : 'Сообщение');

        return (new bootstrap.Toast($uncatchetMessage.get(0))).show();
    }

    var handlers = {
        login: function (data) {
            if (data.result) {
                setCookie('X-CSRF-Token', data.data.session, {
                    secure: true,
                    "max-age": 3600 * 24 * 365
                });
            }
        }
    };

    function setCookie(name, value, options = {}) {

        options = {
            path: '/',
            // при необходимости добавьте другие значения по умолчанию
            ...options
        };

        if (options.expires instanceof Date) {
            options.expires = options.expires.toUTCString();
        }

        let updatedCookie = encodeURIComponent(name) + "=" + encodeURIComponent(value);

        for (let optionKey in options) {
            updatedCookie += "; " + optionKey;
            let optionValue = options[optionKey];
            if (optionValue !== true) {
                updatedCookie += "=" + optionValue;
            }
        }

        document.cookie = updatedCookie;
    }

    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2)
            return parts.pop().split(';').shift();
    }

    function setObjectProperty(object, path, value) {
        const parts = path.split('.');
        const limit = parts.length - 1;
        for (let i = 0; i < limit; ++i) {
            const key = parts[i];
            object = object[key] ?? (object[key] = {});
        }
        const key = parts[limit];
        object[key] = value;
    }


    $('.setcms-captcha').each(function (index, el) {
        var $captcha = $(el);
        var $image = $captcha.find('.setcms-captcha-image');
        var $captchaId = $captcha.find('.setcms-captcha-captcha-id');
        var $captchaSolvedText = $captcha.find('.setcms-captcha-solvedtext');

        $captchaSolvedText.on('keyup', function () {
            $captchaSolvedText.removeClass('is-valid').removeClass('is-invalid');
            $captchaSolvedText.parent().find('.invalid-feedback').text();

            var solvedText = $captchaSolvedText.val();
            if (solvedText.length === 7) {
                $.ajax($captchaId.attr('setcms-action') + '?id=' + $captchaId.val() + '&solvedText=' + solvedText).done(function (data) {
                    if (!data.result) {
                        $captchaSolvedText.addClass('is-invalid');
                        $captchaSolvedText.parent().find('.invalid-feedback').text(data.messages[0].message);
                    } else {
                        $captchaSolvedText.addClass('is-valid');
                    }
                });
            }
        });

        $image.on('click', function () {
            $.ajax($image.attr('setcms-action')).done(function (data) {
                console.log(data);
                $captchaId.val(data.data.id.uuid);
                $image.attr('src', 'data:image/png;base64,' + data.data.content);
                $captchaSolvedText.val('');
                $captchaSolvedText.removeClass('is-valid').removeClass('is-invalid');
                $captchaSolvedText.parent().find('.invalid-feedback').text();
            });
        });

        $image.trigger('click');
    });


    $('.setcms-form .setcms-submit-button').on('click', function () {
        var $form;

        $form = $(this).closest('form');
        $form.find('.invalid-feedback').text('');
        $form.find('.is-invalid').removeClass('is-invalid');
        var formData = new FormData($form.get(0));
        var object = {};
        formData.forEach(function (value, key) {
            setObjectProperty(object, key, value);
        });
        $.ajax({
            url: $form.attr('setcms-action'),
            data: JSON.stringify(object),
            headers: {
                'X-CSRF-Token': getCookie('X-CSRF-Token'),
                'Content-type': "application/json; charset=utf-8",
                Accept: "application/json; charset=utf-8",
            },
            processData: false,
            contentType: false,
            type: $form.attr('setcms-method') || 'POST',
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

                if ($form.attr('setcms-handler')) {
                    handlers[$form.attr('setcms-handler')](data);
                }

                if (data.result && $form.attr('setcms-redirect')) {
                    String.prototype.interpolate = function (params) {
                        const names = Object.keys(params);
                        const vals = Object.values(params);
                        return new Function(...names, `return \`${this}\`;`)(...vals);
                    };

                    window.location.href = $form.attr('setcms-redirect').interpolate(data.data);
                    return;
                }


                $.each(data.messages, function (index, msg) {
                    var message = msg[0] || null;
                    var field = msg[1] || null;

                    if (field) {
                        var $field;

                        $field = $form.find('[name="' + field + '"]');
                        $field.addClass('is-invalid');
                        $field.parent().find('.invalid-feedback').text(!$field.is(':hidden') ? message : field + ': ' + message);
                    } else {
                        altMessage(message);
                    }
                });
            }
        });
    });
});