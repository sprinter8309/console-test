<?php

namespace app\commands;

use Console\Command\Command;
use Console\Command\CommandParams;

/**
 * Команда для форматированного отображения входных параметров
 *
 * @author Oleg Pyatin
 */
class DisplayCommand implements Command
{
    /**
     * Основная логика - вывод имени, аргументов и параметров входной команды
     *
     * @param  CommandParams  DTO-объект запроса
     * @return  int  Код выполнения команды
     */
    public function execute(CommandParams $command_params): int
    {
        echo "Called command: " . $command_params->command_name . PHP_EOL;
        
        echo PHP_EOL;
        
        echo "Arguments:".PHP_EOL;
        
        foreach ($command_params->arguments as $argument) {
            
            echo str_repeat(' ', 3) . '-' . str_repeat(' ', 2) . $argument . PHP_EOL;;
        }
        
        echo PHP_EOL;
        
        echo "Options:".PHP_EOL;
        
        foreach ($command_params->options as $option_name=>$option_values) {
            
            echo str_repeat(' ', 3) . '-' . str_repeat(' ', 2) . $option_name . PHP_EOL;
            
            foreach ($option_values as $option_value) {
                
                echo str_repeat(' ', 9) . '-' . str_repeat(' ', 2) . $option_value . PHP_EOL;
            }
        }
        
        return 0;
    }
}
