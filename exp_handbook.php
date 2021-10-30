<?php
ini_set("display_errors", 1);
error_reporting(-1);

require_once "config.php";

$conn = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE) or die("Unable to connect to host!");
mysqli_query($conn, "SET NAMES 'utf8'");
mysqli_query($conn, "SET CHARACTER SET 'utf8'");
$locales = ['ru' => 'ru-ru', 'ua' => 'ua-uk', 'en' => 'en-gb'];


function getLanguages($conn)
{
    $res = mysqli_query($conn, "SELECT * FROM " . DB_PREFIX . "language") or die("Languages unavailable");
    $results = [];
    while ($r = mysqli_fetch_assoc($res)) {
        $row = [];
        foreach ($r as $key => $value) {
            $row[mb_strtolower($key)] = $value;
        }
        $results[] = $row;
    }
    return $results;
}

function dump(...$args)
{
    print "<pre>";
    foreach ($args as $arg) {
        var_export($arg);
    }
    print "</pre>";
}

if (isset($_GET['name'])) {
    $results = [];
    switch ($handbook = filter_input(INPUT_GET, 'name')) {
        case "all_attributes":
            // Form excel  http://sz.ua/exp_handbook.php?name=all_attributes&output=csv&format=ms
            $langs = getLanguages($conn);
            $lNix = array_flip(array_column($langs, "language_id"));

            $query = [];
            $fields = [];
            $orders = [];
            $where = ['1'];
            $fields[] = "ag.attribute_group_id group_id";
            $fields[] = "att.attribute_id attr_id";
            $query[] = "LEFT JOIN " . DB_PREFIX . "attribute att ON 1";
            $query[] = "LEFT JOIN " . DB_PREFIX . "attribute_group ag ON ag.attribute_group_id = att.attribute_group_id";
            foreach ($lNix as $lid => $linx) {
                /** Product attribute values */
                $query[] = "
                    LEFT JOIN " . DB_PREFIX . "product_attribute pat{$linx} 
                    ON pat{$linx}.product_id = p.product_id 
                    AND att.attribute_id = pat{$linx}.attribute_id
                    AND pat{$linx}.language_id = {$lid}
                ";
                /** Attributes */
                $query[] = "
                    LEFT JOIN " . DB_PREFIX . "attribute_description atd{$linx} 
                    ON atd{$linx}.attribute_id = att.attribute_id
                    AND atd{$linx}.language_id = pat{$linx}.language_id";
                /** Groups */
                $query[] = "
                    LEFT JOIN " . DB_PREFIX . "attribute_group_description agd{$linx} 
                    ON agd{$linx}.attribute_group_id = ag.attribute_group_id 
                    AND agd{$linx}.language_id = pat{$linx}.language_id";

                $fields[] = "agd{$linx}.name as group_name_{$langs[$linx]["name"]}";
                $fields[] = "atd{$linx}.name as name_{$langs[$linx]["name"]}";
                $fields[] = "pat{$linx}.text as value_{$langs[$linx]["name"]}";
//                $where[] = "pat{$linx}.text IS NOT NULL";
            }
            $orders = array_merge(["LENGTH(ag.sort_order) ASC", "ag.sort_order ASC"], $orders);

            array_unshift($query, "SELECT DISTINCTROW " . join(", ", $fields) . " FROM " . DB_PREFIX . "product p");
            $query = join(" ", $query) . "
                WHERE " . join(" AND ", $where) . "
                ORDER BY " . join(", ", $orders);
            if (isset($_GET["limit"])) {
                $query .= " LIMIT ".$_GET["limit"];
            }


            $res = mysqli_query($conn, $query) or die("attributes query failed");
            while ($r = mysqli_fetch_assoc($res)) {
                $results[] = $r;
            }
            break;
        case "payment_code":
            $files = [];
            foreach (glob(DIR_APPLICATION . 'controller/{extension/payment,payment}/*.php', GLOB_BRACE) as $path) {
                $files[explode('.', array_reverse(explode("/", $path))[0])[0]] = $path;
            }
            $query = "SELECT * FROM `" . DB_PREFIX . "extension` WHERE `type` = 'payment' ORDER BY code";
            if ($res = mysqli_query($conn, $query)) {
                while ($row = mysqli_fetch_array($res)) {
                    $result = [
                        'id' => $row['code'],
                    ];
                    foreach ($locales as $locale => $lang) {
                        $lngf = DIR_APPLICATION . "language/{$lang}/extension/payment/{$row['code']}.php";
                        $_ = [];
                        if (is_file($lngf)) {
                            include $lngf;
                        }
                        $result[$lang] = $_['text_title'] ?? '';
                    }

                    $results[] = $result;
                }
            }
            break;
        default:
            print "Undefined handbook name";
            exit;
    }
    switch ($_GET['output'] ?? null) {
        case 'csv':
            $format = $_GET['format'] ?? false;
            $separator = ",";
            if ($format === "ms") {
                $separator = ";";
            }
            $csv = [];
            $csv[] = implode($separator, array_keys($results[0]));
            foreach ($results as $result) {
                $csv[] = implode($separator, array_values($result));
            }
            $csv = implode("\n",$csv);
//            print "<pre>";
//            print $csv;
//            exit;
            header("Content-Type: text/csv");
		    header('Expires: 0');
		    header('Cache-Control: must-revalidate');
		    header('Pragma: public');
		    header("Content-Length: ".mb_strlen($csv));
            header('Content-Disposition: attachment; filename=attributes.csv');
            if ($format === "ms") {
                $csv = mb_convert_encoding($csv, "windows-1251");
            }
			echo ($csv);
            exit;

        case "xml";
        default:
            header("Content-Type: text/xml");
            echo('<?xml version="1.0"?>');
            echo("<{$handbook}>");
            foreach ($results as $result) {
                echo("<item>");
                foreach ($result as $key => $value) {
                    echo("<{$key}>{$value}</{$key}>");
                }
                echo("</item>");
            }
            echo("</{$handbook}>");
            exit;
    }
}
