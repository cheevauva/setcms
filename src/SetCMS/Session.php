<?php

namespace SetCMS;

class Session
{

    private bool $isStarted = false;

    public function start(): void
    {
        if ($this->isStarted) {
            return;
        }

        $this->isStarted = session_start();
    }

    public function get(string $name)
    {
        $this->start();

        return $_SESSION[$name] ?? null;
    }

    public function set(string $name, $value)
    {
        $this->start();
        
        $_SESSION[$name] = $value;
    }

}
