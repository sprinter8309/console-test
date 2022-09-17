<?php

namespace Console\Command;

use Console\Command\CommandParams;

/**
 * Интерфейс для реализации паттерна Команда
 *
 * @author Oleg Pyatin
 */
interface Command
{
    /**
     * Основной метод команды
     *
     * @param  CommandParams  DTO-объект запроса
     * @return  int  Код выполнения команды
     */
    public function execute(CommandParams $params): int;
}
