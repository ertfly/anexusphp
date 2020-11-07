<?php

namespace AnexusPHP\Setup\Setup;

use AnexusPHP\Interfaces\Anx\AnxInterface;
use AnexusPHP\Setup\Anx;
use Exception;
use AnexusPHP\Core\Database;

class BizEntity extends Anx implements AnxInterface
{
    public function __construct($param, $option)
    {
        $this->run($param, $option);
    }

    public function run(array $params = [], array $option = []): void
    {
        try {
            if (!is_writable(PATH_ROOT)) {
                throw new Exception("");
            }

            if (!file_exists(PATH_LOGS . 'start_execution')) {
                throw new Exception('Please start the application', 1);
            }

            if (!isset($params['-b']) || trim($params['-b'] == '')) {
                throw new Exception('Error: param -b [business-name] is required', 1);
            }

            if (!isset($params['-bm']) || trim($params['-bm'] == '')) {
                throw new Exception('Error: param -bm [business_module-name] is required', 1);
            }

            if (!isset($params['-e']) || trim($params['-e'] == '')) {
                throw new Exception('Error: param -e [business_entity-name] is required', 1);
            }

            $biz = ucwords($params['-b']);
            $bizModule = ucwords($params['-bm']);
            $bizEntity = ucwords($params['-e']);

            if (!is_dir(PATH_ROOT . 'src' . DS . $biz)) {
                throw new Exception("The '{$biz}' business doesn't exist", 1);
            }

            if (!is_dir(PATH_ROOT . 'src' . DS . $biz . DS . $bizModule)) {
                throw new Exception("The '{$bizModule}' module doesn't exist", 1);
            }

            $arr = explode('_', $bizEntity);
            $bizEntity = '';
            foreach ($arr as $partialName) {
                $bizEntity .= ucfirst($partialName);
            }

            if (is_dir(PATH_ROOT . 'src' . DS . $biz . DS . $bizModule . DS . 'Entity' . DS . $bizEntity . 'Entity.php')) {
                throw new Exception("The '{$bizEntity}' business entity already exists", 1);
            }

            $files = [
                PATH_ROOT . 'src' . DS . $biz . DS . $bizModule . DS . 'Entity' . DS . $bizEntity . 'Entity.php' => $this->generateEntityFile($params),
                PATH_ROOT . 'src' . DS . $biz . DS . $bizModule . DS . 'Repository' . DS . $bizEntity . 'Repository.php' => $this->generateRepositoryFile($params),
                PATH_ROOT . 'src' . DS . $biz . DS . $bizModule . DS . 'Rule' . DS . $bizEntity . 'Rule.php' => $this->generateRuleFile($params)
            ];

            echo "\033[0;37m";

            foreach ($files as $key => $value) {
                $this->file_force_contents($key, $value);
            }
        } catch (Exception $e) {
            exit(chr(10) . $e->getMessage() . "\033[0m" . chr(10));
        }
    }

    /**
     * @param array $params [biz, module, entity]
     * @return string $fileAsString
     */
    protected function generateEntityFile($params)
    {
        $biz = ucwords($params['-b']);
        $bizModule = ucwords($params['-bm']);
        $bizEntity = $params['-e'];
        $table = strtolower($bizEntity);
        if (!$table) {
            throw new Exception('Informar o nome da conexao /conexao/tabela');
        }

        $db = Database::getInstance();

        $tableFields = array_values($db->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '$table' order by ordinal_position asc")->fetchAll());

        // if (!$tableFields) {
        //     throw new Exception("Error: table $table fields not found");
        // }

        $className = '';
        $arr = explode('_', $bizEntity);
        foreach ($arr as $partialName) {
            $className .= ucfirst($partialName);
        }
        $className .= 'Entity';

        $strHeader = '';
        $strHeader .= '<?php' . chr(10);
        // Definicao do namespace
        $strHeader .= chr(10) . 'namespace ' . $biz . '\\' . $bizModule . '\\Entity;' . chr(10);
        $strHeader .= chr(10) . 'use AnexusPHP\\Core\\DatabaseEntity;' . chr(10);

        $strClass = '';
        $strClass .= 'class ' . $className . ' extends DatabaseEntity {' . chr(10);
        $strAttributes = '';
        $strAttributes .= chr(9) . 'const TABLE = \'' .  $table . '\';' . chr(10);
        $strMethods = '';
        $strToArray = chr(9) . 'public function toArray(){' . chr(10) . chr(9) . chr(9) .  'return array(' . chr(10);
        foreach ($tableFields as $i => $field) {
            $fieldName = $field['column_name'];
            $attribute = '';
            $arr = explode('_', $fieldName);
            foreach ($arr as $partialName) {
                $attribute .= ucfirst($partialName);
            }
            $strAttributes .= chr(9) . 'private $' . $field['column_name'] . ';' . chr(10);
            $strMethods .= chr(9) . 'public function set' . $attribute . '($' . lcfirst($attribute) . '){' . chr(10) . chr(9) . chr(9) . '$this->' . $field['column_name'] . ' = $' . lcfirst($attribute) . ';' . chr(10) . chr(9) . chr(9) . 'return $this;' . chr(10) . chr(9) . '}' . chr(10);
            $strMethods .= chr(9) . 'public function get' . $attribute . '(){' . chr(10) . chr(9) . chr(9) . 'return $this->' . $field['column_name'] . ';' . chr(10) . chr(9) . '}' . chr(10);
            $strToArray .= '\'' . $field['column_name'] . '\' => $this->get' . $attribute . '()' . (($i + 1) < count($tableFields) ? ',' : '') . chr(10);
        }
        $strToArray .= chr(9) . chr(9) . ');' . chr(10) . chr(9) . '}';

        $strClass .= $strAttributes;
        $strClass .= $strMethods;
        $strClass .= $strToArray . chr(10);
        $strClass .= '}';

        return ($strHeader . chr(10) . $strClass);
    }

    /**
     * @param array $params [biz, module, entity]
     * @return string $repository
     */
    protected function generateRepositoryFile($params)
    {
        $biz = ucwords($params['-b']);
        $bizModule = ucwords($params['-bm']);
        $bizEntity = ucwords($params['-e']);

        $arr = explode('_', $bizEntity);
        $bizEntity = '';
        foreach ($arr as $partialName) {
            $bizEntity .= ucfirst($partialName);
        }

        $repository = $this->getTemplate('Repository' . DS . 'RepositoryTemplate', [
            '{{biz}}' => $biz,
            '{{biz_module}}' => $bizModule,
            '{{biz_entity}}' => $bizEntity
        ]);

        return $repository;
    }

    /**
     * @param array $params [biz, module, entity]
     * @return string $rule
     */
    protected function generateRuleFile($params)
    {
        $biz = ucwords($params['-b']);
        $bizModule = ucwords($params['-bm']);
        $bizEntity = ucwords($params['-e']);

        $arr = explode('_', $bizEntity);
        $bizEntity = '';
        foreach ($arr as $partialName) {
            $bizEntity .= ucfirst($partialName);
        }
        
        $rule = $this->getTemplate('Rule' . DS . 'RuleTemplate', [
            '{{biz}}' => $biz,
            '{{biz_module}}' => $bizModule,
            '{{biz_entity}}' => $bizEntity
        ]);

        return $rule;
    }

    public static function help()
    {
        echo "\033[0m" .  "    ___    _   ___  __" . "\033[0m" . chr(10);
        echo "\033[0m" .  "   /   |  / | / / |/ /" . "\033[0m" . chr(10);
        echo "\033[0m" .  "  / /| | /  |/ /|   / " . "\033[0m" . chr(10);
        echo "\033[0m" .  " / ___ |/ /|  //   |  " . "\033[0m" . chr(10);
        echo "\033[0m" .  "/_/  |_/_/ |_//_/|_|  " . "\033[0m" . chr(10);
        echo "\033[0m" .  "                      " . "\033[0m" . chr(10);

        echo "\033[1;33m" . "Usage:" . "\033[0m" . chr(10);
        echo "\tphp anx create-biz-entity [params]" . chr(10) . chr(10);

        echo "\033[1;33m" . "Params:" . "\033[0m" . chr(10);
        echo "\t-b [business-name]" . chr(10);
        echo "\t-bm [business-module-name]" . chr(10);
        echo "\t-e [business-entity-name]" . chr(10);
        echo "\t--help - See this helper" . chr(10);


        exit(chr(10));
    }
}
