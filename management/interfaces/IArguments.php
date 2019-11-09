<?php
namespace management\interfaces;


interface IArguments{
    /**
     * Command getter
     * @return string
     */
    public function getCommand(): string;

    /**
    * Arguments getter
    * @return string
    */
    public function getArguments(): array;
}
