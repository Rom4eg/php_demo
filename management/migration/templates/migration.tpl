<?php
use \management\migration;

/** Migration class.
 *
 * Used for modifying tables schema and data.
 *
 * List of "Do not":
 * 1. don't ignore "backward" function.
 * 2. don't mix schema modification and data modification.
 *
 * @codeCoverageIgnore
 */
class Migration_{$name} extends migration\BaseMigration{ldelim}

    /** Entry point for "migrate" command.
     *
     */
    protected function forward(){ldelim}

    {rdelim}

    /** Entry point for "rollback" command.
     *
     */
    protected function backward(){ldelim}

    {rdelim}
{rdelim}
