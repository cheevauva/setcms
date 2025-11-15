INSERT INTO templates 
(
    id, 
    entity_type, 
    date_created, 
    date_modified, 
    deleted, 
    slug, 
    title, 
    template
) 
VALUES 
(
    '2bd21112-b9b8-4b9e-9706-adc6c4c7414e', 
    'Module\Template\Entity\TemplateEntity', 
    '2025-08-24', 
    '2025-08-24', 
    false, 
    'resetPassword', 
    'Сброс пароля', 
    'Здравствуйте, {{ user.username }}
    Вы запроси ссылку на сброс пароля.
    Ваша ссылка: {{ scBaseUrl() }}{{ scLink(''UserResetPasswordByToken'', {token: userResetToken.token}) }}

    Если это были не вы, то проигнорируйте это сообщение

    {{ userResetToken.token }}'
);
