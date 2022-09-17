<?php

namespace Console\Command;

use Console\Command\Command;
use Console\Command\CommandParams;

/**
 * Вспомогательная команда для предоставления справочной информации о зарегистрированных в приложении командах
 *
 * @author Oleg Pyatin
 */
class HelpCommand implements Command
{
    public function __construct(public array $command_map)
    {
        
    }
    
    /**
     * Основная логика - вывод имени и описания запрашиваемой команды
     *
     * @param  CommandParams  DTO-объект запроса
     * @return  int  Код выполнения команды
     */
    public function execute(CommandParams $command_params): int
    {
        $command_description_info = $this->command_map[$command_params->command_name];
        
        echo "Command Name: " . $command_description_info["name"] . PHP_EOL;
        
        echo PHP_EOL;
        
        echo "Description: ". $command_description_info["description"] . PHP_EOL;
        
        return 0;
    }
}
