INSERT INTO templates 
(
    id, 
    slug, 
    title, 
    template
) 
VALUES 
(
    '2bd21112-b9b8-4b9e-9706-adc6c4c7414e', 
    'resetPassword', 
    'Сброс пароля', 
    'Здравствуйте, {{ user.username }}
    Вы запроси ссылку на сброс пароля.
    Ваша ссылка: {{ scBaseUrl() }}{{ scLink(''UserResetPasswordByToken'', {token: userResetToken.token}) }}

    Если это были не вы, то проигнорируйте это сообщение

    {{ userResetToken.token }}'
);
