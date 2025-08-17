<?php
require_once(RUTA_PROYECTO . "/class/Conexion.php");
require_once(RUTA_PROYECTO . "/class/Tables/BDT_interface.php");

abstract class BDT_Tablas implements BDT_Interface
{

    public const INNER = 'INNER';

    public const OTHER_PREDICATE = 'OTHER_PREDICATE';

    public const LEFT = 'LEFT';

    public static $schema;

    public static $tableName;

    public static $primaryKey;

    public static  $tableAs;

    /**
     * Obtiene el nombre de la tabla asociada a la clase.
     *
     * @return string - Nombre de la tabla asociada a la clase.
     *
     * @example
     * ```php
     * // Ejemplo de uso para obtener el nombre de la tabla asociada a la clase
     * $tableName = MiClase::getTableName();
     * // $tableName contendrá el nombre de la tabla asociada a la clase MiClase.
     * ```
     */
    public static function getTableName()
    {
        return static::$tableName;
    }

    /**
     * Realiza una consulta en la base de datos utilizando una tabla específica y predicados opcionales.
     *
     * @param Array $predicado Un arreglo opcional que contiene los predicados para filtrar los resultados.
     *
     * @return PDOStatement|false Un objeto PDOStatement que contiene los resultados de la consulta o false en caso de error.
     * @throws Exception Si ocurre un error al preparar la consulta.
     */
    public static function Select(
        array $predicado    = [],
        string $campos      = '*',
        string $groupBy     = '',
        string $orderBy     = '',
        string $limit       = ''
    ) {
        $conexionPDO = Conexion::newConnection('PDO');
        $where = '';

        $campos ??= '*';

        if (!empty($predicado)) {
            $where = "WHERE ";
            foreach ($predicado as $clave => $valor) {
                if ($clave === self::OTHER_PREDICATE) {
                    $where .= " {$valor} AND ";
                } else {
                    $where .= $clave . " = " . self::formatValor($valor) . " AND ";
                }
            }
            $where = substr($where, 0, -5);
        }

        try {
            $consulta = "SELECT $campos FROM " . static::$schema . "." . static::$tableName . " {$where} {$groupBy} {$orderBy} {$limit}";
            $stmt = $conexionPDO->prepare($consulta);

            if ($stmt) {

                $stmt->execute();

                return $stmt;
            } else {
                throw new Exception("Error al preparar la consulta.");
            }
        } catch (PDOException  $e) {
            echo "Excepción capturada: " . $e->getMessage();
            return null;
        }
    }

    public static function Insert(array $datos): ?int
    {
        global $conexionPDO;

        if (is_null($conexionPDO)) {
            $conexionPDO = Conexion::newConnection('PDO');
        }

        $campos   = implode(", ", array_keys($datos));
        $valores  = implode("', '", array_values($datos));
        $consulta = "INSERT INTO " . static::$schema . "." . static::$tableName . " ({$campos}) VALUES ('{$valores}')";

        try {
            $stmt = $conexionPDO->prepare($consulta);
            $stmt->execute();
            return $conexionPDO->lastInsertId();
        } catch (PDOException  $e) {
            echo "Excepción capturada: " . $e->getMessage();
            return null;
        }
    }

    public static function Update(array $datos, array $predicado): bool
    {
        global $conexionPDO;
        if (is_null($conexionPDO)) {
            $conexionPDO = Conexion::newConnection('PDO');
        }

        $sets = '';

        foreach ($datos as $clave => $valor) {
            $sets .= $clave . "='{$valor}', ";
        }

        $sets = substr($sets, 0, -2);
        $where = '';

        foreach ($predicado as $clave => $valor) {
            if ($clave === self::OTHER_PREDICATE) {
                $where .= " {$valor} AND ";
            } else {
                $where .= $clave . " = '{$valor}' AND ";
            }
        }

        $where = substr($where, 0, -5);
        $consulta = " UPDATE " . static::$schema . "." . static::$tableName . " SET {$sets} WHERE {$where}";

        try {
            $stmt = $conexionPDO->prepare($consulta);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException  $e) {
            echo "Excepción capturada: " . $e->getMessage();
            return false;
        }
    }

    public static function Delete(array $predicado): bool
    {
        global $conexionPDO;

        if (is_null($conexionPDO)) {
            $conexionPDO = Conexion::newConnection('PDO');
        }

        $where = '';

        foreach ($predicado as $clave => $valor) {
            if ($clave === self::OTHER_PREDICATE) {
                $where .= "{$valor} AND ";
            } else {
                $where .= $clave . " = '{$valor}' AND ";
            }
        }

        $where = substr($where, 0, -5);
        $consulta = "DELETE FROM " . static::$schema . "." . static::$tableName . " WHERE {$where}";

        try {
            $stmt = $conexionPDO->prepare($consulta);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException  $e) {
            echo "Excepción capturada: " . $e->getMessage();
            return false;
        }
    }

    public static function InsertOrUpdate(array $datos, array $predicado): bool
    {
        global $conexionPDO;

        if (is_null($conexionPDO)) {
            $conexionPDO = Conexion::newConnection('PDO');
        }

        $campos   = implode(", ", array_keys($datos));
        $valores  = implode("', '", array_values($datos));
        $consulta = "INSERT INTO " . static::$schema . "." . static::$tableName . " ({$campos}) VALUES ('{$valores}') ON DUPLICATE KEY UPDATE ";

        foreach ($datos as $clave => $valor) {
            $consulta .= $clave . "='{$valor}', ";
        }

        $consulta = substr($consulta, 0, -2);
        $where = '';

        foreach ($predicado as $clave => $valor) {
            $where .= $clave . "='{$valor}' AND ";
        }

        $where = substr($where, 0, -5);
        $consulta .= " WHERE {$where}";

        try {
            $stmt = $conexionPDO->prepare($consulta);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException  $e) {
            echo "Excepción capturada: " . $e->getMessage();
            return false;
        }
    }

    public static function deleteBeforeInsert(array $datos, array $predicado): bool
    {
        global $conexionPDO;

        if (is_null($conexionPDO)) {
            $conexionPDO = Conexion::newConnection('PDO');
        }

        $where = '';

        foreach ($predicado as $clave => $valor) {
            $where .= $clave . "='{$valor}' AND ";
        }

        $where = substr($where, 0, -5);
        $consulta = "DELETE FROM " . static::$schema . "." . static::$tableName . " WHERE {$where}";

        try {
            $stmt = $conexionPDO->prepare($consulta);
            $stmt->execute();
            return self::Insert($datos);
        } catch (PDOException  $e) {
            echo "Excepción capturada: " . $e->getMessage();
            return false;
        }
    }
    /**
     * Ejecuta una consulta SQL utilizando una conexión PDO y retorna los resultados.
     *
     * @param string $sql Consulta SQL a ejecutar.
     *
     * @return array|null Devuelve un array asociativo con los resultados de la consulta en caso de éxito. 
     *                    Retorna `null` en caso de una excepción.
     *
     * @throws PDOException Si ocurre algún error durante la preparación o ejecución de la consulta.
     */
    public static function ejecutarSQL(String $sql)
    {

        $conexionPDO = Conexion::newConnection('PDO');
        try {
            $stmt = $conexionPDO->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException  $e) {
            echo "Excepción capturada: " . $e->getMessage();
            return null;
        }
    }

    /**
     * Construye y ejecuta dinámicamente una consulta SQL con múltiples `JOIN`, predicados y opciones de ordenamiento.
     *
     * @param array  $predicado    Array de condiciones para el filtro `WHERE`. Las claves son los campos o operadores (`AND`, `OR`), y los valores son los valores de comparación.
     * @param string $campos       Campos a seleccionar en la consulta. Por defecto, selecciona todos los campos (`'*'`).
     * @param array  $clasesJoin   Array de clases que representan las tablas para realizar `JOIN`. Deben implementar `BDT_JoinImplements`.
     * @param string $joinString   Cláusula adicional para los `JOIN` (opcional).
     * @param string $groupBy      Cláusula de agrupamiento `GROUP BY` (opcional).
     * @param string $having       Cláusula de having `HAVING` (opcional).
     * @param string $orderBy      Cláusula de ordenamiento `ORDER BY` (opcional).
     * @param string $limit        Cláusula de limitación `LIMIT` (opcional).
     *
     * @return array|null Devuelve el resultado de la consulta SQL como un array. Retorna `null` en caso de excepción.
     *
     * @throws Exception Si la clase principal no extiende `BDT_Tablas` o las clases `JOIN` no implementan `BDT_JoinImplements`.
     */
    public static function SelectJoin(
        array $predicado,
        string $campos,
        array $clasesJoin,
        String $joinString = '',
        String $groupBy = '',
        String $having = '',
        String $orderBy = '',
        String $limit = ''
    ): array|null {

        try {
            $campos ??= '*';
            $predicado ??= [];
            $groupBy    =  !empty($groupBy) ? "GROUP BY " . $groupBy : "";
            $having     =  !empty($having) ? "HAVING " . $having : "";
            $orderBy    =  !empty($orderBy) ? "ORDER BY " . $orderBy : "";

            // Construir JOIN dinámico
            $joinClauses = '';
            foreach ($clasesJoin as $clase) {
                if (in_array($clase, class_implements(BDT_JoinImplements::class))) {
                    throw new Exception("Todas las clases Join en \$clasesJoin deben implmentar de BDT_JoinImplements.");
                }

                $joinKey    = $clase::getForeignKey();
                if (!empty($joinKey)) {
                    $conditionsJoin = [];
                    foreach ($joinKey as $onclave => $onvalor) {
                        if ($onclave === 'AND' || $onclave === 'OR') {
                            $conditionsJoin[] = "($onvalor)";
                        } else {
                            $asociacion = explode(" ", $onclave);
                            if (empty($asociacion[1])) {
                                $conditionsJoin[] = $onclave . " = " . $onvalor;
                            } else {
                                $conditionsJoin[] = $onclave . " " . $onvalor;
                            }
                        }
                    }
                    $On = "ON " . implode("\n AND ", $conditionsJoin);
                    $joinClauses .= "\n {$clase::getTypeJoin()} JOIN {$clase::$schema}.{$clase::$tableName} AS {$clase::$tableAs} {$On} \n";
                }
            }

            // Construir WHERE dinámico
            if (!empty($predicado)) {
                $conditions = [];
                foreach ($predicado as $clave => $valor) {
                    if ($clave === self::OTHER_PREDICATE) {
                        $conditions[] = " {$valor} ";
                    } elseif ($clave === 'AND' || $clave === 'OR') {
                        $conditions[] = "($valor)";
                    } else {
                        $asociacion = explode(" ", $clave);
                        if (empty($asociacion[1])) {
                            $conditions[] = $clave . " = " . self::formatValor($valor);
                        } else {
                            $conditions[] = $clave . " " . self::formatValor($valor);
                        }
                    }
                }
                $where = "\n WHERE " . implode("\n AND ", $conditions);
            }


            $consulta = "SELECT $campos FROM " . static::$schema . "." . static::$tableName . " AS " . static::$tableAs . " \n            
            {$joinClauses} \n
            {$joinString} \n
            {$where} \n
            {$groupBy} \n
            {$having} \n
            {$orderBy} \n
            {$limit} \n";
            return self::ejecutarSQL($consulta);
        } catch (PDOException  $e) {
            echo "Excepción capturada: " . $e->getMessage();
            return null;
        }
    }

    /**
     * Obtiene el número de filas resultantes de una consulta en la base de datos.
     *
     * @param Array $predicado Un arreglo opcional de predicados para filtrar los resultados.
     *
     * @return int El número de filas resultantes de la consulta.
     */
    public static function numRows(array $predicado = [])
    {
        $consulta   = self::Select($predicado, static::$primaryKey);
        $numRecords = $consulta->rowCount();

        return $numRecords;
    }
    /**
     * Valida el tipo de un valor dado y ajusta su formato.
     *
     * - Si el valor es numérico o booleano, lo convierte a su formato numérico correspondiente.
     * - Si el valor no es numérico ni booleano, lo retorna como está.
     *
     * @param mixed $valor El valor a validar y ajustar.
     *
     * @return string Devuelve el valor convertido como cadena.
     */
    public static function formatValor($valor): string
    {
        if (is_numeric($valor) || is_bool($valor)) {
            $result = $valor + 0;;
        } else {
            $result = "'" . $valor . "'";
        }
        return $result;
    }

    /**
     * Ejecuta una consulta SQL que aplica `ROW_NUMBER()` con `PARTITION BY` para obtener un número limitado de registros por grupo.
     *
     * Esta función es útil cuando se requiere obtener, por ejemplo, los N últimos elementos por categoría, cliente, etc.
     *
     * @param int    $empresaId     ID de la empresa (usado como filtro principal).
     * @param array  $in            Array con los valores que serán utilizados en la cláusula `IN` para el campo de partición.
     * @param int    $limit         Número máximo de registros por grupo.
     * @param string $partitionBy   Campo por el cual se agruparán los resultados (para `PARTITION BY`).
     * @param string $campos        Campos a seleccionar (por defecto `*`).
     * @param string $orderBy       Cláusula de ordenamiento usada dentro del `ROW_NUMBER()` y en el resultado final.
     *
     * @return array|null           Array con los resultados si hay éxito, o `null` en caso de error.
     *
     * @throws PDOException         Si ocurre un error en la ejecución de la consulta.
     */
    public static function SelectLimitPerGroup(
        int $empresaId,
        string $inStr,
        int $limit,
        string $partitionBy,
        string $campos = '*',
        string $joinString = '',
        string $groupBy = '',
        string $orderBy = ''
    ): array|null {
        try {

            $consulta = "
                SELECT {$campos} FROM (
                    SELECT *,
                            ROW_NUMBER() OVER (PARTITION BY {$partitionBy} ORDER BY {$orderBy}) AS fila
                    FROM " . static::$schema . "." . static::$tableName . " AS " . static::$tableAs . "
                    {$joinString}
                    WHERE " . static::$tableAs . "_id_empresa = {$empresaId} AND {$partitionBy} IN ({$inStr})
                ) AS sub
                WHERE fila <= {$limit}
                {$groupBy}
                ORDER BY {$orderBy};
            ";

            return self::ejecutarSQL($consulta);
        } catch (PDOException $e) {
            echo "Excepción capturada: " . $e->getMessage();
            return null;
        }
    }
}
