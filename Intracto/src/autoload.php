<?php
/**
 * Autoloads intracto classes, please use this structure to facilitate easy loading:
 *
 * - Command: shell commands, still need to be manually registered in command_autoload.php and executed by console.php
 * - Controllers: silex mountable controllers
 * - Service: generic services
 * - Form: formbuilder forms (Symfony form component)
 * - Model: IntractoModel entities
 * - Repository: IntractoRepository repositories
 */


spl_autoload_register(
    function ($class) {
        $class = str_replace('\\', '/', $class);
        $class = ltrim($class, 'Intracto/');
        @include $class . '.php';
        if (strpos($class, "Command") > 0) {
            include 'Command/' . $class . '.php';
        } elseif (strpos($class, "Controller") > 0) {
            include 'Controllers/' . $class . '.php';
        } elseif (strpos($class, "Form") > 0) {
            include 'Form/' . $class . '.php';
        } elseif (strpos($class, "Constraint") > 0) {
            include 'Constraints/' . $class . '.php';
        } elseif (strpos($class, "Model") > 0) {
            include 'Model/' . $class . '.php';
        } elseif (strpos($class, "Repository") > 0) {
            include 'Repository/' . $class . '.php';
        } elseif (strpos($class, "Service") > 0) {
            include 'Service/' . $class . '.php';
        }
    }
);