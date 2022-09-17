<?php

namespace Console\Input;

use Console\Command\CommandParams;

/**
 * Класс для выполнения парсинга входных консольных параметров
 *
 * @author Oleg Pyatin
 */
class InputParser
{
    /**
     * Метод проверки запуска приложения без конкретной команды (для вывода списка зарегистрированных)
     *
     * @return  bool  Результат проверки
     */
    public function checkSimpleLaunch(): bool
    {
        return match ($_SERVER['argc']) {
            1 => true,
            default => false
        };
    }
    
    /**
     * Метод для распарсивания данных входного запроса
     *
     * @return  CommandParams  DTO-объект с имнем команды и входными аргументами
     */
    public function parseConsoleRequest(): CommandParams
    {
        $argv = $_SERVER['argv'] ?? [];
        array_shift($argv);
        
        $command_params = new CommandParams();
        $command_params->command_name = array_shift($argv);
        $this->getInputArgumentsAndOptions($argv, $command_params);
        
        return $command_params;
    }
    
    /**
     * Функция проверки начал ли пользователь прохождение (рассматриваемого теста)
     *
     * @param  array  Общий список всех аргументов
     * @param  CommandParams  DTO-объект запроса который будет заполняться
     * @return  void  Результат работы будет в DTO-объекте
     */
    private function getInputArgumentsAndOptions(array $input_words, CommandParams $command_params): void
    {
        $array_length = count($input_words);
        $word_counter = 0;
        
        while ($word_counter < $array_length) {
            
            if ($single_argument = $this->checkSingleArgument($input_words[$word_counter])) {
                $command_params->arguments[] = $single_argument;
            }
            
            if ($complex_argument_part = $this->checkComplexArgumentPart($input_words[$word_counter])) {
                $command_params->arguments[] = $complex_argument_part;
            }
            
            if ($option_parts = $this->checkSingleAndComplexOption($input_words, $word_counter)) {
                $command_params->options += $option_parts;
                $word_counter += count($option_parts) - 1;
            }
            
            $word_counter++;
        }
    }
    
    /**
     * Проверка является ли полученный параметр одиночным аргументов (обрамленным в {})
     *
     * @param  string  Рассматриваемый параметр
     * @return  string|false  Результат проверки - одиночный аргумент или сигнал что это не он
     */
    private function checkSingleArgument(string $input_word): string|false
    {
        $check = preg_match('/^{([\.\w_-]+)}$/', $input_word, $matches);
        
        if ($check) {
            return $matches[1];
        } else {
            return false;
        }
    }
    
    /**
     * Проверка является ли полученный параметр частью множественного аргумента
     *
     * @param  string  Рассматриваемый параметр
     * @return  string|false  Результат проверки - текст аргумент или сигнал что параметр имеет другой характер
     */
    private function checkComplexArgumentPart(string $input_word): string|false
    {
        $check = preg_match('/^([^{]?[\.\w_-]+[^}]?)$/', $input_word, $matches);
        
        if ($check) {
            return $matches[1];
        } else {
            return false;
        }
    }
 
    /**
     * Проверка является ли полученный параметр одиночной опцией или имеющей несколько значений
     *     Если имеет характер множественный вариант, в дальнейшем индекс текущего элемента будет сдвинут на 
     *         размер этой опции
     *
     * @param  array  Все переданные параметры 
     * @param  int  Текущий индекс рассмотрения
     * @return  array|false  Результат проверки - опция со значениями или сигнал что параметр не опция
     */
    private function checkSingleAndComplexOption(array $input_words, int $current_index): array|false
    {
        $check_counter = $current_index;
        $array_length = count($input_words);
        $option_values = [];
        
        $check_is_param_option = preg_match('/^\[([\.\w_-]+)=([\.\w_-]+)\]$/', $input_words[$check_counter], $matches);
        
        if ($check_is_param_option) {
            
            $base_option_name = $matches[1];
            $check_counter++;
            $complex_option_suitable = true;
            $option_values[] = $matches[2];
            
            while (($check_counter < $array_length) && $complex_option_suitable) {
                
                $check_is_next_param_option = preg_match('/^\[([\.\w_-]+)=([\.\w_-]+)\]$/', $input_words[$check_counter], $matches);
                
                if ($check_is_next_param_option && $matches[1] === $base_option_name) {
                    $option_values[] = $matches[2];
                    $check_counter++;
                } else {
                    $complex_option_suitable = false;
                }
            }
            
            return [$base_option_name=>$option_values];
            
        } else {
            
            return false;
        }
    }
}
