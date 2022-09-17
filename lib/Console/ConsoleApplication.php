<?php

namespace Console;

use Exception;
use Console\Input\InputParser;
use Console\Command\CommandLoader;
use Console\Command\CommandParams;

/**
 * Класс организующий логику консольного приложения
 *
 * @author Oleg Pyatin
 */
class ConsoleApplication
{
    public function __construct(protected CommandLoader $command_loader, 
                                protected InputParser $input_parser)
    {

    }
    
    /**
     * Основная функция приложения обеспечивающая организацию всей логики
     *
     * @return  int  Код результата (если все завершилось правильно будет 0)
     * @throws Exception  Случай когда возникла ошибка в команде
     */
    public function run(): int
    {
        if ($this->input_parser->checkSimpleLaunch()) {
            return $this->command_loader->getAllCommandsInfo();
        }
        
        $command_params = $this->input_parser->parseConsoleRequest();
        
        if ($this->checkHelpCondition($command_params)) {
            $command = $this->command_loader->getHelpCommand($command_params->command_name);
        } else {
            $command = $this->command_loader->get($command_params->command_name);
        }
        
        try {
            $exit_code = $command->execute($command_params);
        } catch (\Throwable $exc) {
            throw new Exception("Execution of command has gotten with error." . PHP_EOL . $exc->getMessage());
        }
        
        return $exit_code;
    }
    
    /**
     * Функция проверки наличия аргумента для вывода информации о команде
     *
     * @param  CommandParams  DTO-объект с данными запроса
     * @return  bool  Результат проверки
     */
    public function checkHelpCondition(CommandParams $command_params): bool
    {
        if (in_array('help', $command_params->arguments)) {
            return true;
        } else {
            return false;
        }
    }
}
