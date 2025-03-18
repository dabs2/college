<?php

namespace College\Ddcollege\Model;

use Exception;
use PDO;
use PDOException;

class database
{

    private $db_host = "localhost";
    private $db_name = "ddcollege";
    private $db_user = "root";
    private $db_password = "";
    private $connection;

    public function __construct()
    {
        try {
            $dsn = "mysql:host={$this->db_host};dbname={$this->db_name}";
            $this->connection = new PDO($dsn, $this->db_user, $this->db_password);
            // Set PDO attributes if needed (optional)
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function datefilter($fromdate = null, $todate = null)
    {
        if ($fromdate == null && $todate == null) {
            $fromdate = date("Y-m-01");
            $todate = date("Y-m-d");
            return array($fromdate, $todate);
        }
        return array($fromdate, $todate);
    }

    public function insert($table_name, $arr = array(), $where = null)
    {
        try {
            if ($this->istableexist($table_name)) {
                $table_column = implode(",", array_keys($arr));
                $count = count(array_keys($arr));
                $table_values = implode(', ', array_fill(0, $count, '?'));
                $array_values = array_values($arr);
                $insert_data = "INSERT INTO $table_name ($table_column) VALUES ($table_values)";
//                echo $insert_data;
                if ($where != null) {
                    $insert_data .= " WHERE" . " " . $where;
                }
                $insert = $this->connection->prepare($insert_data);
                if ($insert->execute($array_values)) {
                    return true;
                } else {
                    return false;
                }
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            if ($e->getCode() == 23000) {
                $message = "Error Adding or Updating there is some Duplicate Entry";
            }

            ?>
            <div class="fixed top-0 right-0 m-4" id="notification-card">
                <div class="bg-red-500 text-white p-4 rounded shadow-md">
                    <div class="flex items-center justify-between">
                        <p class="font-bold">Error!</p>
                        <button
                                onclick="document.getElementById('notification-card').style.display='none'"
                                class="text-white hover:text-gray-300 focus:outline-none text-2xl"
                        >
                            &times;
                        </button>
                    </div>
                    <p><?= $message; ?></p>
                </div>

                <script>
                    // Function to close the notification after 3 seconds
                    function closeNotification() {
                        setTimeout(function () {
                            document.getElementById('notification-card').style.display = 'none';
                        }, 3000); // 3000 milliseconds = 3 seconds
                    }

                    // Call the function when the page loads (if you want the notification to close automatically)
                    document.addEventListener('DOMContentLoaded', closeNotification);
                </script>
            </div>

            <?php

        }
        return false;
    }

    //Can further be use after//
    private function istableexist($table_name)
    {
        try {
            $showtablequery = "SHOW TABLES FROM $this->db_name LIKE '%$table_name%'";
            $check_table = $this->connection->prepare($showtablequery);
            if ($check_table->execute()) {
                $rowCount = $check_table->rowCount();
                if ($rowCount > 0) {
                    return true;
                }
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        return false;
    }

    public function update_database($table_name, $arr = array(), $where = null)
    {
        try {
            if ($this->istableexist($table_name)) {
                $empty_arr = array();
                foreach ($arr as $key => $value) {
                    $empty_arr[] = $key . "=" . "?";
                }
                $empty_arr = implode(",", $empty_arr);
                $update_table = "UPDATE $table_name SET $empty_arr";
                if ($where != null) {
                    $update_table .= " WHERE" . " " . $where;
                }
//                echo $update_table;
                $updatequery = $this->connection->prepare($update_table);
                if ($updatequery->execute(array_values($arr))) {
                    return true;
                }
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        return false;
    }

    public function viewdata($table_name, $asterick = null, $where = null,
                             $order = null, $limit = null, $fromdate = null, $todate = null, $datecolumn = null, $join = null)
    {
        try {
            if ($this->istableexist($table_name)) {
                if ($asterick == null) {
                    $asterick = "*";
                }
                $selectquery = "SELECT $asterick FROM `$table_name`";

                if ($join != null) {
                    $selectquery .= " INNER JOIN " . $join;
                }

                if ($where != null) {
                    $selectquery .= " WHERE" . " " . $where;
                }

                if ($datecolumn != null) {
                    $date = (new database())->datefilter($fromdate, $todate);

                    if ($where == null) {
                        $selectquery = $selectquery . " WHERE " . $datecolumn . ">=" . "'$date[0]'" . " AND " . $datecolumn . "<=" . "'$date[1]'";
                    } else {
                        $selectquery = $selectquery . "AND " . $datecolumn . ">=" . "'$date[0]'" . " AND " . $datecolumn . "<=" . "'$date[1]'";

                    }
                }
//                if ($offset != null) {
//                    $selectquery .= "OFFSET" . " " . $offset;
//                }

                if ($order != null) {
                    $selectquery .= " ORDER BY" . " " . $order;
                }

                if ($limit != null) {
                    if (isset($_GET['page'])) {
                        $page = $_GET['page'];
                    } else {
                        $page = 1;
                    }
                    $offset = ($page - 1) * $limit;
                    $selectquery .= " LIMIT $offset,$limit";
                }

//                echo $selectquery;
                $select = $this->connection->query($selectquery);
                $store = $select->fetchAll();

                if ($store) {
                    return $store;
                }
            }
        } catch
        (Exception $e) {
            echo $e->getMessage();
        }
        return false;
    }

    public function deletedata($table_name, $where = null)
    {
        try {
            if ($this->istableexist($table_name) && $where != null) {
                $deletquery = "DELETE FROM $table_name WHERE $where";
                $delete = $this->connection->prepare($deletquery);
                if ($delete->execute()) {
                    return true;
                }
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        return false;
    }

    public function deleteall($table_name)
    {
        try {
            if ($this->istableexist($table_name)) {
                $deleteall = "DELETE FROM $table_name";
                $deletecompletely = $this->connection->prepare($deleteall);
                if ($deletecompletely->execute()) {
                    return true;
                }
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        return false;
    }

    public function is_table_empty($tablename): bool
    {
        $data = $this->viewdata($tablename);
        if (empty($data)) {
            return true;
        }
        return false;
    }


//SELECT COUNT(Status) as count FROM `leaverequests` WHERE employee_id = 39 and Status = "Pending";
    public function counts($table_name, $asterick = null, $where = null)
    {
        try {
            if ($asterick == null) {
                $asterick = "*";
            }

            $selectquery = "SELECT $asterick FROM `$table_name`";

            if ($where != null) {
                $selectquery .= " WHERE" . " " . $where;
            }

            $select = $this->connection->prepare($selectquery);
            if ($select->execute()) {
                return $select->fetchAll();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        return false;
    }

    public function get_month_name($date)
    {
        return date("F", strtotime($date));
    }

    public
    function table_header($name, $showheader = null)
    {

        $table_header = '<th class="text-center">' . $name . '</th>';
        if ($showheader) {
            return $table_header;
        }
        return false;
    }

    function callFunction($obj, $methodName, ...$args)
    {
        if (empty($args)) {
            $args = null;
        }

        if (method_exists($obj, $methodName)) {
            if ($args != null) {
                // Call the method dynamically with arguments
                return $obj->$methodName(...$args);
            }
            return $obj->$methodName();
        } else {
            echo "Method '$methodName' does not exist in the object.";
            return null;
        }
    }

}