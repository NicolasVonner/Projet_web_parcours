<?php

namespace Projet_Web_parcours\Assets\enums\request;

abstract class Operator
{
    public const EQUAL = "=";
    public const DIFFERENT = "<>";
    public const INFERIOR = "<";
    public const INFERIOR_OR_EQUAL = "<=";
    public const SUPERIOR = ">";
    public const SUPERIOR_OR_EQUAL = ">=";
    public const IN = "IN";
    public const OR = "OR";
};