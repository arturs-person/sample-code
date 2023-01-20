<?php

namespace App\Views;

use App\Exceptions\ViewNotFoundException;
const TEMPLATE_BASE_DIR = 'base';

const TEMPLATE_FILE_TYPE = 'phtml';
const TEMPLATE_FILE_PAGE = TEMPLATE_PATH . '/' . TEMPLATE_BASE_DIR . '/' . 'page.' . TEMPLATE_FILE_TYPE;
const TEMPLATE_FILE_HEADER = TEMPLATE_PATH . '/' . TEMPLATE_BASE_DIR . '/' . 'header.' . TEMPLATE_FILE_TYPE;
const TEMPLATE_FILE_FOOTER= TEMPLATE_PATH . '/' . TEMPLATE_BASE_DIR . '/' . 'footer.' . TEMPLATE_FILE_TYPE;

class View
{
    protected string $templatePath;

    public function __construct(
        protected string $template,
        protected array $params = []
    ) {
        $this->templatePath = TEMPLATE_PATH . '/' . $this->template . '.' . TEMPLATE_FILE_TYPE;
    }

    public function getHeader()
    {
        include TEMPLATE_FILE_HEADER;
    }

    public function getContent()
    {
        if ($this->validateTemplate($this->templatePath)) {
            include $this->templatePath;
        }
    }

    protected function validateTemplate(string $path): bool
    {
        if (!file_exists($path)) {
            throw new ViewNotFoundException();
        }

        return true;
    }

    public function render(array $args = [], bool $raw = false): bool|string
    {
        ob_start();
        include TEMPLATE_FILE_PAGE;
        return ob_get_clean();
    }

    public static function make(string $template, array $params = [])
    {
        return new static ($template, $params);
    }

    public function __toString(): string
    {
        return $this->render();
    }
}