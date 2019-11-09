<?php
namespace management\migration;
require_once BASE_DIR.'/include/database/PDOMixin.php';

/**
 * Migration base class
 */
abstract class BaseMigration extends \PDOMixin{

    abstract protected function forward();
    abstract protected function backward();

    /**
     * Make query
     * @param  string $sql sql query
     * @param  array $data query params
     * @param  int $fetch_type PDO Fetch Constant
     * @param  boolean $silent_mode crash silently
     * @return mixed
     */
    final public function query($sql, array $data, $fetch_type=\PDO::FETCH_NAMED, $silent_mode=TRUE){
        return parent::query($sql, $data, $fetch_type, False);
    }

    /**
     * {@inheritDoc}
     * @return int
     */
    final public function run(): void{
        try{
            $this->query('START TRANSACTION', []);
            $this->forward();
            $this->query('COMMIT', []);
        } catch (\Exception $e){
            $this->query('ROLLBACK', []);
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * {@inheritDoc}
     * @return int
     */
    final public function revert(): void{
        try{
            $this->query('START TRANSACTION', []);
            $this->backward();
            $this->query('COMMIT', []);
        } catch (\Exception $e){
            $this->query('ROLLBACK', []);
            throw new \Exception($e->getMessage());
        }
    }
}
