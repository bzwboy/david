<?php
/*
 * static 关键字
 * self 解析上下文
 * static 被调用的类
 */

abstract class DomainObject {
    public static function create() {
        //return new self(); // error
        return new static(); // right in php ver5.4/ver7
    }
}

class User extends DomainObject {
}

class Document extends DomainObject {
}

Document::create();

