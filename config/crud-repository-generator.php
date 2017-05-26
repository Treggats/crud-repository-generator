<?php

use Illuminate\Container\Container;
use Illuminate\Support\Str;

$appNamespace = Container::getInstance()->getNamespace();

return [
    'model_namespace' => Str::finish($appNamespace, '\\') . 'Models',
    'repository_namespace' => Str::finish($appNamespace, '\\') . 'Repositories\\Eloquent',
    'contract_namespace' => Str::finish($appNamespace, '\\') . 'Repositories\\Contracts',
];
