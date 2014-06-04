<?php
/**
 * Created by PhpStorm.
 * User: jan.decavele
 * Date: 4/11/14
 * Time: 3:16 PM
 */

namespace Intracto\Repository;


use Doctrine\DBAL\Connection;
use Silex\Application;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Class IntractoRepository
 *
 * Implements basic orm functionality in synergy with @IntractoModel - entities
 * - persist
 * - flush
 * - remove
 * - clear
 *
 * @package Intracto\Repository
 */
class IntractoRepository
{
    protected $persistanceCache = "";

    /**
     * @var $db Connection
     */
    protected $db;

    function __construct(Application $app)
    {
        $this->db = $app['db'];
    }

    public function fetchAll($q, $params = array())
    {
        return $this->db->fetchAll($q, $params);
    }

    public function executeQuery($q)
    {
        return $this->db->exec($q);
    }

    public function flush()
    {
        $this->executeQuery($this->persistanceCache);
        $this->clear();
    }

    public function getSQL()
    {
        return $this->persistanceCache;
    }

    public function clear()
    {
        $this->persistanceCache = "";
    }

    public function remove($id, $table)
    {
        $prePersistanceCache = "REMOVE FROM " . $table . " WHERE id = $id";
        $this->persistanceCache .= $prePersistanceCache . ";";
    }

    public function persist($data, $table)
    {
        $data = array_filter($data);
        if (isset($data['`id`'])) {
            $prePersistanceCache = "UPDATE " . $table . " SET ";
            foreach ($data as $dataKey => $dataValue) {
                if ($dataKey !== '`id`') {
                    $prePersistanceCache .= $dataKey . " = '" . $dataValue . "',";
                }
            }
            $prePersistanceCache = rtrim($prePersistanceCache, ',');
            $prePersistanceCache .= " WHERE id = " . $data['`id`'];
            $this->persistanceCache .= $prePersistanceCache . ";";

        } else {
            $dataKeys = array_keys($data);
            $prePersistanceCache = "INSERT INTO " . $table . " (" . implode(',', $dataKeys) . ") VALUES (";
            foreach ($data as $dataKey => $dataValue) {
                if ($dataKey !== '`id`') {
                    $prePersistanceCache .= "'" . addslashes($dataValue) . "',";
                }
            }
            $prePersistanceCache = rtrim($prePersistanceCache, ',');
            $prePersistanceCache .= ")";
            $this->persistanceCache .= $prePersistanceCache . ";";
        }
    }

    protected function modelToFK($modelobject)
    {
        if (count($modelobject::getForeignKeys())) {
            $alertation = "";
            $index = 0;
            foreach ($modelobject::getForeignKeys() as $foreignKeyline) {
                $index++;
                $alertation .= "ALTER TABLE `" . $modelobject::getModelName() . "` ";
                $alertation .= "ADD CONSTRAINT `" . $modelobject::getModelName(
                    ) . "_ibfk_$index` FOREIGN KEY (`" . $foreignKeyline[0] . "`) REFERENCES `" . $foreignKeyline[1] . "` (`" . $foreignKeyline[2] . "`)";
            }
            try {
                $this->db->exec($alertation);

            } catch (\Exception $e) {
                $message = "Query \" " . $alertation . " \" failed with message " . $e->getMessage() . "\n\n\n";
                print $message;
                error_log($message);
            }
        }
    }

    protected function modelToDB($modelobject)
    {
        $modelFields = $modelobject::getFields();
        $fieldsConcatinated = "";
        foreach ($modelFields as $modelField) {
            $fieldsConcatinated .= $modelField[0] . " " . $modelField[1] . ", ";
        }
        $tableQuery = "CREATE TABLE IF NOT EXISTS `" . $modelobject::getModelName() . "` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        $fieldsConcatinated
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
        ";

        try {
            $this->db->exec($tableQuery);
        } catch (\Exception $e) {
            $message = "Query \" " . $tableQuery . " \" failed with message " . $e->getMessage() . "\n\n\n";
            print $message;
            error_log($message);
        }

    }

} 