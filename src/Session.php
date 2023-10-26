<?php declare(strict_types=1);

    namespace STDW\Session;

    use STDW\Contract\SessionInterface;
    use STDW\Contract\SessionHandlerInterface;


    class Session implements SessionInterface
    {
        public function __construct(SessionHandlerInterface $handler)
        {
            session_set_save_handler($handler, true);
        }


        public function start(): void
        {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
        }

        public function get(string $key, mixed $default = null): mixed
        {
            if ($this->exists($key)){
                return $_SESSION[$key];
            }

            return $default;
        }

        public function set(string $key, mixed $value): void
        {
            $_SESSION[$key] = $value;
        }

        public function exists(string $key): bool
        {
            return isset($_SESSION[$key]);
        }

        public function delete(string $key): void
        {
            if ($this->exists($key)) {
                unset($_SESSION[$key]);
            }
        }

        public function clear(): void
        {
            session_unset();
        }

        public function end(): void
        {
            if (session_status() === PHP_SESSION_ACTIVE) {
                session_destroy();
            }
        }
    }