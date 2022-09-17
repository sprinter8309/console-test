<?php

namespace Console\Command;

use Exception;
use Console\Command\Command;
use Console\Command\HelpCommand;

/**
 * Класс организующий логику регистрации команд и предоставления информации о них
 *
 * @author Oleg Pyatin
 */
class CommandLoader
{
    public function __construct(protected array $command_map = []) 
    {
        
    }
    
    /**
     * Метод создания команды из списка зарегистрированных
     *
     * @param  string  Имя запрашиваемой команды
     * @return  Command  Объект новой команды для дальнейшего запуска
     * @throws Exception  Случай когда запрашивается команда вне списка
     */
    public function get(string $command_name): Command
    {
        if (array_key_exists($command_name, $this->command_map)) {
            return (new $this->command_map[$command_name]['class']);
        } else {
            throw new Exception("Using unknown command");
        }
    }
    
    /**
     * Метод вывода информации о зарегистрированных командах
     *
     * @return  int  Код выполнения
     */
    public function getAllCommandsInfo(): int
    {
        foreach ($this->command_map as $command_sign => $command_info) {
            
            echo '"'. $command_sign. '" - ' . $command_info["name"] . PHP_EOL;
            
            echo PHP_EOL;
            
            echo $command_info["description"] . PHP_EOL;
            
            echo PHP_EOL . PHP_EOL;
        }
        
        return 0;
    }
    
    /**
     * Метод получения вспомогательной команды для описания другой
     *
     * @return  HelpCommand  Объект вспомогательной команды
     */
    public function getHelpCommand(): HelpCommand
    {
        return new HelpCommand($this->command_map);
    }
}
