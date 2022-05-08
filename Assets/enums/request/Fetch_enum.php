<?php

namespace Projet_Web_parcours\Assets\enums\request;

use \PDO;

abstract class Fetch
{
    public const _DEFAULT = "PDO::FETCH_DEFAULT";
    public const _COLUMN = "PDO::FETCH_COLUMN";
    public const _CLASS = 8; //PDO::FETCH_CLASS
    public const _FUNC = "PDO::FETCH_FUNC";
    public const _GROUP = "PDO::FETCH_GROUP";
    public const _ASSOC = 2; //PDO::FETCH_ASSOC

};