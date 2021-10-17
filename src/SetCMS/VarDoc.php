<?php

namespace SetCMS;

interface VarDoc
{

    public const PREFIX_METHOD = '@setcms-request-method-';
    public const RESPONSE_HTML = '@setcms-response-content-html';
    public const RESPONSE_JSON = '@setcms-response-content-json';
    public const NEED_AUTH = '@setcms-need-auth';
    public const NEED_NOAUTH = '@setcms-need-not-auth';
    public const REQUIRED = '@setcms-required';
    public const TYPE_DATETIME = '@setcms-type-datetime';
    public const TYPE_INT = '@setcms-type-int';
    public const TYPE_STRING = '@setcms-type-string';
    public const TYPE_FLOAT = '@setcms-type-float';
    public const TYPE_BOOL = '@setcms-type-bool';
    public const WRAPPER_JSON_NONE = '@setcms-wrapper-json-none';
    public const CSRF_PROTECT_DISABLED = '@setcms-csrf-protect-disabled';
    public const RESPONSE_WITH_HEADERS = '@setcms-response-with-headers';

}
