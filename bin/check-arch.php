<?php

if ($argc < 2) {
    echo "Usage: php check_architecture.php <src_dir>\n";
    exit(1);
}

$root = realpath($argv[1]);

$violations = [];

$rii = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($root)
);

foreach ($rii as $file) {
    if (!$file->isFile() || $file->getExtension() !== 'php') {
        continue;
    }

    $path = $file->getPathname();
    $code = file_get_contents($path);
    $tokens = token_get_all($code);

    $class = null;
    $publicMethods = [];
    $currentMethod = null;
    $returnsArray = false;
    $returnsValue = false;
    $uses = [];

    for ($i = 0; $i < count($tokens); $i++) {
        $t = $tokens[$i];

        if (is_array($t)) {
            [$type, $value] = $t;

            if ($type === T_CLASS) {
                $class = trim($tokens[$i + 2][1] ?? '');
            }

            if ($type === T_USE) {
                $uses[] = collectUse($tokens, $i);
            }

            if ($type === T_FUNCTION) {
                $name = trim($tokens[$i + 2][1] ?? '');
                $visibility = findVisibility($tokens, $i);
                if ($visibility === 'public') {
                    $publicMethods[] = $name;
                }
                $currentMethod = $name;
            }

        }
    }

    if (!$class) {
        continue;
    }

    // ---- RULES ----

    if (isUnit($class)) {
        if ($publicMethods !== ['serve']) {
            $violations[] = "$path: Unit must have only public serve()";
        }
    }

    if (isDao($class)) {
        foreach ($uses as $use) {
            if (str_contains($use, 'Servitor') || str_contains($use, 'Mediator')) {
                $violations[] = "$path: DAO must not use Servitor/Mediator ($use)";
            }
        }
    }

    if (isServitor($class)) {
        foreach ($uses as $use) {
            if (str_contains($use, 'Mapper')) {
                $violations[] = "$path: Servitor must not use Mapper ($use)";
            }
        }
    }
    
    if (isMapper($class)) {
        foreach ($uses as $use) {
            if (str_contains($use, 'DAO') || str_contains($use, 'Servant')) {
                $violations[] = "$path: Mapper must not use DAO/Servant ($use)";
            }
        }
    }
    
    if ($returnsArray) {
        $violations[] = "$path: Returning arrays is forbidden";
    }

    if ($returnsValue) {
        $violations[] = "$path: Returning values is forbidden (serve(): void)";
    }
}

// ---- OUTPUT ----

if ($violations) {
    echo "ARCHITECTURE VIOLATIONS:\n\n";
    foreach ($violations as $v) {
        echo " - $v\n";
    }
    exit(1);
}

echo "OK: Architecture is clean\n";

// ---- HELPERS ----

function isUnit(string $class): bool
{
    return isDao($class) || isMapper($class) || isServitor($class);
}

function isDao(string $class): bool
{
    return str_contains($class, 'Dao');
}

function isServitor(string $class): bool
{
    return str_contains($class, 'Servitor');
}

function isMapper(string $class): bool
{
    return str_contains($class, 'Mapper');
}

function findVisibility(array $tokens, int $i): string
{
    for ($j = $i - 1; $j >= 0; $j--) {
        if (!is_array($tokens[$j])) continue;
        if ($tokens[$j][0] === T_PUBLIC) return 'public';
        if ($tokens[$j][0] === T_PROTECTED) return 'protected';
        if ($tokens[$j][0] === T_PRIVATE) return 'private';
    }
    return 'public';
}

function nextNonWhitespace(array $tokens, int $i)
{
    for (; $i < count($tokens); $i++) {
        if (is_array($tokens[$i]) && $tokens[$i][0] === T_WHITESPACE) continue;
        return is_array($tokens[$i]) ? $tokens[$i][1] : $tokens[$i];
    }
    return null;
}

function collectUse(array $tokens, int &$i): string
{
    $use = '';
    for ($j = $i + 1; $j < count($tokens); $j++) {
        if ($tokens[$j] === ';') break;
        if (is_array($tokens[$j])) {
            $use .= $tokens[$j][1];
        }
    }
    return trim($use);
}
