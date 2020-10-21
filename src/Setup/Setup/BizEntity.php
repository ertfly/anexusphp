<?php

namespace AnexusPHP\Setup\Setup;

use AnexusPHP\Interfaces\Anx\AnxInterface;
use AnexusPHP\Setup\Anx;
use Exception;
use AnexusPHP\Core\Database;

class BizEntity extends Anx implements AnxInterface
{
    public function __construct($params)
    {
        $this->run($params);
    }

    public function run(array $params = []):void
    {
        try {
            if (!is_writable(PATH_ROOT)) {
                throw new Exception("");
            }

            if (!file_exists(PATH_LOGS . 'start_execution')) {
                throw new Exception('Please start the application', 1);
            }

            if (!isset($params[0]) || trim($params[0] == '')) {
                throw new Exception('Error: param #1 [business-name] is required', 1);
            }

            if (!isset($params[1]) || trim($params[1] == '')) {
                throw new Exception('Error: param #2 [business_module-name] is required', 1);
            }

            if (!isset($params[2]) || trim($params[2] == '')) {
                throw new Exception('Error: param #3 [business_entity-name] is required', 1);
            }

            $biz = ucwords($params[0]);
            $biz_module = ucwords($params[1]);
            $biz_entity = ucwords($params[2]);

            if (!is_dir(PATH_ROOT . 'src/' . $biz)) {
                 throw new Exception("The '{$biz}' business doesn't exist", 1);
            }

            if (!is_dir(PATH_ROOT . 'src/' . $biz . DS . $biz_module)) {
                throw new Exception("The '{$biz_module}' module doesn't exist", 1);
            }

            if (is_dir(PATH_ROOT . 'src/' . $biz_entity)) {
                throw new Exception("The '{$biz_entity}' business entity already exists", 1);
            }

            $files = [
                PATH_ROOT . 'src' . DS . $biz . DS . $biz_module . DS . $biz_entity . DS . 'Entity' . DS . $biz_entity.'Entity.php' => $this->generateEntityFile($params),
                PATH_ROOT . 'src' . DS . $biz . DS . $biz_module . DS . $biz_entity . DS . 'Repository' . DS . $biz_entity.'Repository.php' => $this->generateRepositoryFile($params),
                PATH_ROOT . 'src' . DS . $biz . DS . $biz_module . DS . $biz_entity . DS . 'Rule' . DS . $biz_entity.'Rule.php' => $this->generateRuleFile($params)
            ];

            echo "\033[0;37m";

            foreach ($files as $key => $value) {
                $this->file_force_contents($key, $value);
            }

        } catch (Exception $e) {
            exit(chr(10) . $e->getMessage() . chr(10));
        }
    }

    /**
     * @param array $params [biz, module, entity]
     * @return string $fileAsString
     */
    protected function generateEntityFile($params) {
        $biz = ucwords($params[0]);
        $biz_module = ucwords($params[1]);
        $table = $params[2];
        if (!$table) {
            throw new Exception('Informar o nome da conexao /conexao/tabela');
        }

        $db = Database::getInstance();

        $tableFields = array_values($db->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '$table' order by ordinal_position asc")->fetchAll());

        // if (!$tableFields) {
        //     throw new Exception("Error: table $table fields not found");
        // }

        $className = '';
        $arr = explode('_', $table);
        foreach ($arr as $partialName) {
            $className .= ucfirst($partialName);
        }
        $className .= 'Entity';

        $strHeader = '';
        $strHeader .= '<?php' . chr(10);
        // Definicao do namespace
        $strHeader .= chr(10) . 'namespace AnexusPHP\\'.$biz.'\\'.$biz_module.'\\'.ucwords($table).'\\Entity;' . chr(10);
        $strHeader .= chr(10) . 'use AnexusPHP\\Core\\DatabaseEntity;' . chr(10);

        $strClass = '';
        $strClass .= 'class ' . $className . ' extends DatabaseEntity {' . chr(10);
        $strAttributes = '';
        $strAttributes .= chr(9) . 'const TABLE = \'' .  $table . '\';' . chr(10);
        $strMethods = '';
        $strToArray = chr(9). 'public function toArray(){' . chr(10) . chr(9) . chr(9).  'return array(' . chr(10);
        foreach ($tableFields as $i => $field) {
            $fieldName = $field['column_name'];
            $attribute = '';
            $arr = explode('_', $fieldName);
            foreach ($arr as $partialName) {
                $attribute .= ucfirst($partialName);
            }
            $strAttributes .= chr(9) . 'private $' . $field['column_name'] . ';' . chr(10);
            $strMethods .= chr(9) . 'public function set' . $attribute . '($' . lcfirst($attribute) . '){' . chr(10) . chr(9) . chr(9) . '$this->' . $field['column_name'] . ' = $' . lcfirst($attribute) . ';' . chr(10) . chr(9) . chr(9) . 'return $this;' . chr(10) . chr(9) . '}' . chr(10);
            $strMethods .= chr(9) . 'public function get' . $attribute . '(){' . chr(10) . chr(9) . chr(9). 'return $this->' . $field['column_name'] . ';' . chr(10) . chr(9) . '}' . chr(10);
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
    protected function generateRepositoryFile($params) {
        $biz = ucwords($params[0]);
        $biz_module = ucwords($params[1]);
        $biz_entity = ucwords($params[2]);
        $repository = $this->getTemplate('Repository' . DS . 'RepositoryTemplate', [
            '{{biz}}' => $biz,
            '{{biz_module}}' => $biz_module,
            '{{biz_entity}}' => $biz_entity
        ]);

        return $repository;
    }

    /**
     * @param array $params [biz, module, entity]
     * @return string $rule
     */
    protected function generateRuleFile($params) {
        $biz = ucwords($params[0]);
        $biz_module = ucwords($params[1]);
        $biz_entity = ucwords($params[2]);
        $rule = $this->getTemplate('Rule' . DS . 'RuleTemplate', [
            '{{biz}}' => $biz,
            '{{biz_module}}' => $biz_module,
            '{{biz_entity}}' => $biz_entity
        ]);

        return $rule;
    }
}
