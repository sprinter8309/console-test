<?php

namespace Console\Command;

/**
 * Класс для DTO-объекта параметров запроса
 *
 * @author Oleg Pyatin
 */
class CommandParams
{
    public function __construct(public string $command_name = '', 
                                public array $arguments = [], 
                                public array $options = [])
    {

    }
}
