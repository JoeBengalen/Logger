<?php

namespace JoeBengalen\Logger\Handler;

class PdoHandler extends AbstractHandler
{
    protected $pdo;
    protected $options;

    public function __construct(\PDO $pdo, array $options = [])
    {
        $this->pdo = $pdo;

        $this->options = array_merge([
            'table'           => 'logs',
            'column.datetime' => 'datetime',
            'column.level'    => 'level',
            'column.message'  => 'message',
            'column.context'  => 'context'
        ], $options);
    }

    public function __invoke($level, $message, array $context = [])
    {
        $sql = "INSERT INTO {$this->options['table']} ({$this->options['column.datetime']}, {$this->options['column.level']}, {$this->options['column.message']}, {$this->options['column.context']}) VALUES (NOW(), ?, ?, ?)";
        $sth = $this->pdo->prepare($sql);

        $interpolatedMessage = $this->interpolate($message, $context);

        if (isset($context['exception']) && $context['exception'] instanceof \Exception) {
            $interpolatedMessage .= " " . (string) $context['exception'];
            unset($context['exception']);
        }

        $sth->execute([
            $level,
            $interpolatedMessage,
            json_encode($context)
        ]);
    }
}